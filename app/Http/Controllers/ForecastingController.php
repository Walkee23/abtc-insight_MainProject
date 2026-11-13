<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Support\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
    /** Smoothing constants the sliders start at. */
    private const DEFAULTS = ['alpha' => 0.45, 'beta' => 0.12, 'gamma' => 0.30];

    /**
     * period => label, seasonal cycle length, forecast horizon, periods of history shown.
     * (Season: weekday pattern for daily, ~monthly cycle for weekly, yearly for monthly.)
     */
    private const PERIODS = [
        'daily' => ['label' => 'Daily', 'season' => 7, 'horizon' => 14, 'history' => 60, 'unit' => 'day'],
        'weekly' => ['label' => 'Weekly', 'season' => 4, 'horizon' => 8, 'history' => 26, 'unit' => 'week'],
        'monthly' => ['label' => 'Monthly', 'season' => 12, 'horizon' => 6, 'history' => 24, 'unit' => 'month'],
    ];

    // ------------------------------------------------------------------ page

    public function index(Request $request)
    {
        $period = array_key_exists($request->query('period'), self::PERIODS) ? $request->query('period') : 'monthly';
        $params = $this->params($request->query());

        $forecast = $this->forecast($period, $params);
        $outbreak = $this->outbreak();

        $saved = DB::table('forecasting')->count();
        $lastSaved = DB::table('forecasting')->max('generated_date');

        return view('admin.F_and_O', compact('period', 'params', 'forecast', 'outbreak', 'saved', 'lastSaved') + [
            'periods' => self::PERIODS,
            'defaults' => self::DEFAULTS,
        ]);
    }

    /** Stores the forecast currently shown (same period and smoothing constants) in `forecasting`. */
    public function save(Request $request)
    {
        $period = array_key_exists($request->input('period'), self::PERIODS) ? $request->input('period') : 'monthly';
        $params = $this->params($request->all());
        $forecast = $this->forecast($period, $params);

        if ($forecast['status'] !== 'ok') {
            return back()->with('error', 'Not enough data to save a forecast yet.');
        }

        $by = Auth::user()->username ?? 'Admin';
        $rows = [];
        foreach ($forecast['future'] as $point) {
            $rows[] = [
                'forecast_period' => self::PERIODS[$period]['label'],
                'forecast_date' => $point['date'],
                'predicted_cases' => (int) round($point['value']),
                'smoothing_constant' => $params['alpha'],
                'data_points_used' => $forecast['points'],
                'confidence_level' => $forecast['confidence'],
                'algorithm_used' => $forecast['method'],
                'generated_by' => $by,
                'generated_date' => now(),
            ];
        }
        DB::table('forecasting')->insert($rows);
        Audit::log('forecast_saved', 'Saved ' . count($rows) . ' ' . self::PERIODS[$period]['label'] . ' forecast rows (' . $forecast['method'] . ', alpha ' . $params['alpha'] . ')');

        return redirect()->route('admin.forecasting', ['period' => $period] + $this->paramQuery($params))
            ->with('success', count($rows) . ' ' . self::PERIODS[$period]['unit'] . ' forecasts saved.');
    }

    // ----------------------------------------------------------- forecasting

    private function params(array $input): array
    {
        $out = [];
        foreach (self::DEFAULTS as $key => $default) {
            $value = isset($input[$key]) && is_numeric($input[$key]) ? (float) $input[$key] : $default;
            $out[$key] = round(min(0.9, max(0.1, $value)), 2);
        }
        return $out;
    }

    /** Only the sliders that moved away from their defaults, for tidy URLs. */
    private function paramQuery(array $params): array
    {
        return array_filter($params, fn ($v, $k) => $v !== self::DEFAULTS[$k], ARRAY_FILTER_USE_BOTH);
    }

    private function today(): Carbon
    {
        return now('Asia/Manila')->startOfDay();
    }

    /**
     * Patient volume forecast. Volume = walk-in registrations per period
     * (inflow_general_particulars.queue_date). Only completed periods are fitted: today
     * and the current week/month are still filling up, so they are the first forecast step.
     */
    private function forecast(string $period, array $params): array
    {
        $cfg = self::PERIODS[$period];
        $today = $this->today();
        $first = DB::table('inflow_general_particulars')->min('queue_date');

        $base = ['status' => 'empty', 'period' => $period, 'cfg' => $cfg];
        if (!$first) {
            return $base;
        }

        $firstDate = Carbon::parse($first)->startOfDay();
        $currentStart = $this->bucketStart($today, $period);

        // completed periods from the first record up to (not including) the current one
        $starts = [];
        for ($d = $this->bucketStart($firstDate, $period); $d->lt($currentStart); $d = $this->next($d, $period)) {
            $starts[] = $d->copy();
        }
        $starts = array_slice($starts, -$cfg['history']);
        if (count($starts) < 3) {
            return array_merge($base, ['status' => 'short', 'points' => count($starts)]);
        }

        $counts = $this->countsPerBucket($period);
        $y = array_map(fn ($d) => (float) ($counts[$d->toDateString()] ?? 0), $starts);
        $n = count($y);

        $fit = $this->holtWinters($y, $cfg['season'], $params['alpha'], $params['beta'], $params['gamma']);
        $sigma = $fit['sigma'];

        $future = [];
        $step = $currentStart->copy();
        for ($h = 1; $h <= $cfg['horizon']; $h++) {
            $value = max(0, $fit['level'] + $h * $fit['trend']
                + ($fit['seasonal'] ? $fit['season'][($n - 1 + $h) % $cfg['season']] : 0));
            $half = 1.96 * $sigma * sqrt($h);
            $future[] = [
                'date' => $step->toDateString(),
                'label' => $this->label($step, $period),
                'value' => round($value, 2),
                'lower' => round(max(0, $value - $half), 2),
                'upper' => round($value + $half, 2),
            ];
            $step = $this->next($step, $period);
        }

        $spanDays = (int) $firstDate->diffInDays($today) + 1;
        $confidence = $spanDays >= 90 ? 'High' : ($spanDays >= 30 ? 'Moderate' : 'Low');

        $mape = $fit['mape'];
        $mapeLabel = $mape === null ? 'n/a' : ($mape < 10 ? 'Excellent' : ($mape < 20 ? 'Good' : ($mape < 50 ? 'Fair' : 'Poor')));

        return array_merge($base, [
            'status' => 'ok',
            'method' => $fit['seasonal'] ? 'Holt-Winters (additive)' : 'Holt Linear Trend',
            'seasonal' => $fit['seasonal'],
            'points' => $n,
            'span_days' => $spanDays,
            'confidence' => $confidence,
            'mape' => $mape === null ? null : round($mape, 1),
            'mape_label' => $mapeLabel,
            'history' => array_map(fn ($d, $v) => ['date' => $d->toDateString(), 'label' => $this->label($d, $period), 'value' => $v], $starts, $y),
            'future' => $future,
            'next_value' => $future[0]['value'],
            'total_horizon' => round(array_sum(array_column($future, 'value')), 1),
        ]);
    }

    /** Additive Holt-Winters; with less than two full seasons it falls back to Holt's linear trend. */
    private function holtWinters(array $y, int $m, float $a, float $b, float $g): array
    {
        $n = count($y);
        $seasonal = $n >= 2 * $m;

        if ($seasonal) {
            $level = array_sum(array_slice($y, 0, $m)) / $m;
            $trend = (array_sum(array_slice($y, $m, $m)) / $m - $level) / $m;
            $season = [];
            for ($i = 0; $i < $m; $i++) {
                $season[$i] = $y[$i] - $level;
            }
            $start = $m;
        } else {
            $level = $y[0];
            $trend = $y[1] - $y[0];
            $season = array_fill(0, $m, 0.0);
            $start = 1;
        }

        $errors = [];
        $pct = [];
        for ($t = $start; $t < $n; $t++) {
            $s = $seasonal ? $season[$t % $m] : 0.0;
            $pred = $level + $trend + $s;
            $errors[] = $y[$t] - $pred;
            if ($y[$t] > 0) {
                $pct[] = abs($y[$t] - $pred) / $y[$t] * 100;
            }

            $previous = $level;
            $level = $a * ($y[$t] - $s) + (1 - $a) * ($level + $trend);
            $trend = $b * ($level - $previous) + (1 - $b) * $trend;
            if ($seasonal) {
                $season[$t % $m] = $g * ($y[$t] - $level) + (1 - $g) * $s;
            }
        }

        return [
            'level' => $level,
            'trend' => $trend,
            'season' => $season,
            'seasonal' => $seasonal,
            'sigma' => count($errors) > 1 ? sqrt(array_sum(array_map(fn ($e) => $e * $e, $errors)) / count($errors)) : 0.0,
            'mape' => $pct ? array_sum($pct) / count($pct) : null,
        ];
    }

    private function bucketStart(Carbon $date, string $period): Carbon
    {
        return match ($period) {
            'weekly' => $date->copy()->startOfWeek(Carbon::MONDAY),
            'monthly' => $date->copy()->startOfMonth(),
            default => $date->copy()->startOfDay(),
        };
    }

    private function next(Carbon $date, string $period): Carbon
    {
        return match ($period) {
            'weekly' => $date->copy()->addWeek(),
            'monthly' => $date->copy()->addMonthNoOverflow()->startOfMonth(),
            default => $date->copy()->addDay(),
        };
    }

    private function label(Carbon $date, string $period): string
    {
        return $period === 'monthly' ? $date->format('M Y') : $date->format('M d');
    }

    /** Registrations per bucket start date (Y-m-d). */
    private function countsPerBucket(string $period): array
    {
        $counts = [];
        foreach (DB::table('inflow_general_particulars')->selectRaw('queue_date as d, count(*) as c')->groupBy('queue_date')->get() as $row) {
            $key = $this->bucketStart(Carbon::parse($row->d), $period)->toDateString();
            $counts[$key] = ($counts[$key] ?? 0) + $row->c;
        }
        return $counts;
    }

    // -------------------------------------------------------------- outbreak

    /**
     * Outbreak detection per barangay (registrations by barangay of incidence).
     * Current = cases in the last 7 days. Baseline = the average 7-day count over the
     * 4 weeks before that. A barangay is
     *   Spike: 3+ current cases and more than double its baseline (and above baseline + 2 SD),
     *          or 3+ cases where it normally has none;
     *   Watch: 2+ current cases and at least 1.5x its baseline (or new activity), not a spike.
     */
    private function outbreak(): array
    {
        $today = $this->today();
        $currentFrom = $today->copy()->subDays(6);
        $baselineFrom = $today->copy()->subDays(34);

        $rows = DB::table('inflow_general_particulars')
            ->whereBetween('queue_date', [$baselineFrom->toDateString(), $today->toDateString()])
            ->get(['barangay', 'queue_date']);

        $by = [];
        foreach ($rows as $r) {
            $date = Carbon::parse($r->queue_date)->startOfDay();
            // window 0 = last 7 days, 1..4 = the four weeks before it
            $window = $date->gte($currentFrom) ? 0 : (int) (1 + floor(($date->diffInDays($currentFrom) - 1) / 7));
            $by[$r->barangay][$window] = ($by[$r->barangay][$window] ?? 0) + 1;
        }

        $list = [];
        foreach ($by as $name => $windows) {
            $current = $windows[0] ?? 0;
            $past = [];
            for ($w = 1; $w <= 4; $w++) {
                $past[] = $windows[$w] ?? 0;
            }
            $baseline = array_sum($past) / 4;
            $std = sqrt(array_sum(array_map(fn ($v) => ($v - $baseline) ** 2, $past)) / 4);

            if ($current >= 3 && ($baseline == 0 || ($current > 2 * $baseline && $current > $baseline + 2 * $std))) {
                $level = 'spike';
            } elseif ($current >= 2 && ($baseline == 0 || $current >= 1.5 * $baseline)) {
                $level = 'watch';
            } else {
                $level = 'normal';
            }

            $list[] = (object) [
                'name' => $name ?: 'Unknown',
                'current' => $current,
                'baseline' => round($baseline, 1),
                'deviation' => $baseline > 0 ? (int) round(($current - $baseline) / $baseline * 100) : null,
                'level' => $level,
            ];
        }

        usort($list, fn ($a, $b) => [['spike' => 0, 'watch' => 1, 'normal' => 2][$a->level], -$a->current]
            <=> [['spike' => 0, 'watch' => 1, 'normal' => 2][$b->level], -$b->current]);

        return [
            'monitored' => $this->barangayCount(),
            'with_cases' => count($list),
            'spikes' => count(array_filter($list, fn ($b) => $b->level === 'spike')),
            'watch' => count(array_filter($list, fn ($b) => $b->level === 'watch')),
            'list' => $list,
            'from' => $currentFrom->format('M d'),
            'to' => $today->format('M d'),
        ];
    }

    private function barangayCount(): int
    {
        $file = public_path('geojson/cebu_city_barangays.geojson');
        if (is_file($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (!empty($data['features'])) {
                return count($data['features']);
            }
        }
        return 80;
    }
}
