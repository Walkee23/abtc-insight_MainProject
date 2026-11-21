<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Support\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class ForecastingController extends Controller
{
    /** Damping of the trend: far-off days drift back towards the weekly pattern instead of climbing forever. */
    private const PHI = 0.95;

    /**
     * Smoothing constants the sliders start at. Over a 6-week window these already weight the latest
     * days most (alpha 0.3 halves a day's weight every ~2 days). They were picked by backtesting on the
     * 2025 data: heavier alpha/beta made the next-14-day forecasts worse, not better.
     */
    private const DEFAULTS = ['alpha' => 0.30, 'beta' => 0.10, 'gamma' => 0.10];

    /** The model learns from this many days (6 weeks) before the as-of date. */
    private const TRAIN_DAYS = 42;

    /** period => label and how far ahead to forecast (in periods, and the days that covers). */
    private const PERIODS = [
        'daily' => ['label' => 'Daily', 'horizon' => 14, 'horizon_days' => 14, 'unit' => 'day'],
        'weekly' => ['label' => 'Weekly', 'horizon' => 8, 'horizon_days' => 63, 'unit' => 'week'],
        'monthly' => ['label' => 'Monthly', 'horizon' => 6, 'horizon_days' => 190, 'unit' => 'month'],
    ];

    // ------------------------------------------------------------------ page

    public function index(Request $request)
    {
        $period = array_key_exists($request->query('period'), self::PERIODS) ? $request->query('period') : 'monthly';
        $params = $this->params($request->query());
        $asOf = $this->asOf($request->query('asof'));

        $forecast = $this->forecast($period, $params, $asOf);
        $outbreak = $this->outbreak();

        $saved = DB::table('forecasting')->count();
        $lastSaved = DB::table('forecasting')->max('generated_date');

        return view('admin.F_and_O', compact('period', 'params', 'asOf', 'forecast', 'outbreak', 'saved', 'lastSaved') + [
            'periods' => self::PERIODS,
            'defaults' => self::DEFAULTS,
            'trainWeeks' => self::TRAIN_DAYS / 7,
            'today' => $this->today(),
        ]);
    }

    /** Stores the forecast currently shown (same period, date and smoothing constants) in `forecasting`. */
    public function save(Request $request)
    {
        $period = array_key_exists($request->input('period'), self::PERIODS) ? $request->input('period') : 'monthly';
        $params = $this->params($request->all());
        $asOf = $this->asOf($request->input('asof'));
        $forecast = $this->forecast($period, $params, $asOf);

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
                'algorithm_used' => $forecast['algorithm'],
                'generated_by' => $by,
                'generated_date' => now(),
            ];
        }
        DB::table('forecasting')->insert($rows);
        Audit::log('forecast_saved', 'Saved ' . count($rows) . ' ' . self::PERIODS[$period]['label'] . ' forecast rows as of ' . $asOf->toDateString() . ' (' . $forecast['algorithm'] . ', alpha ' . $params['alpha'] . ')');

        return redirect()->route('admin.forecasting', ['period' => $period] + $this->paramQuery($params) + $this->asOfQuery($asOf))
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
        return array_filter($params, fn($v, $k) => $v !== self::DEFAULTS[$k], ARRAY_FILTER_USE_BOTH);
    }

    private function today(): Carbon
    {
        return now('Asia/Manila')->startOfDay();
    }

    /** The date the forecast starts from (default today, never in the future). */
    private function asOf(mixed $value): Carbon
    {
        $today = $this->today();
        try {
            $date = $value ? Carbon::parse((string) $value, 'Asia/Manila')->startOfDay() : $today;
        } catch (\Throwable $e) {
            return $today;
        }
        return $date->gt($today) ? $today : $date;
    }

    /** Only the as-of date when it is not today, for tidy URLs. */
    private function asOfQuery(Carbon $asOf): array
    {
        return $asOf->isSameDay($this->today()) ? [] : ['asof' => $asOf->toDateString()];
    }

    /**
     * Patient volume forecast. Volume = daily inflow summaries (daily_inflow_summary) + today's live registrations.
     *
     * The model learns only from the 6 weeks (42 days) of daily counts before the as-of date, so
     * the most recent days carry the weight: Holt-Winters exponential smoothing with a weekly
     * (weekday) season, and a high alpha so the level follows the latest days. Weekly and monthly
     * views add up the daily forecasts. The chart still shows every earlier period for context.
     */
    private function forecast(string $period, array $params, Carbon $asOf): array
    {
        $cfg = self::PERIODS[$period];
        $daily = $this->dailyCounts();

        $base = ['status' => 'empty', 'period' => $period, 'cfg' => $cfg, 'as_of' => $asOf];
        if (empty($daily)) {
            return $base;
        }

        $firstDate = Carbon::parse(min(array_keys($daily)), 'Asia/Manila')->startOfDay();

        // training window: the 6 weeks before the as-of date (less if the data starts later)
        $trainStart = $firstDate->gt($asOf->copy()->subDays(self::TRAIN_DAYS)) ? $firstDate->copy() : $asOf->copy()->subDays(self::TRAIN_DAYS);
        $trainDays = $trainStart->lt($asOf) ? (int) $trainStart->diffInDays($asOf) : 0;
        if ($trainDays < 3) {
            return array_merge($base, ['status' => 'short', 'points' => $trainDays]);
        }

        $y = [];
        for ($d = $trainStart->copy(); $d->lt($asOf); $d->addDay()) {
            $y[] = (float) ($daily[$d->toDateString()] ?? 0);
        }
        $n = count($y);

        // The numbers come from the Python engine (python/forecast.py, statsmodels Holt-Winters).
        // If Python cannot run, the page falls back to the same model written in PHP and says so.
        $python = $this->pythonForecast($y, $trainStart, $params);
        $engine = 'PHP built-in fallback (Python was not available)';
        $pythonOk = $python !== null;

        // daily forecasts from the as-of day; the trend is damped so far-off days stay realistic
        $days = [];
        if ($pythonOk) {
            $fit = ['seasonal' => $python['seasonal'], 'sigma' => $python['sigma'], 'mape' => $python['mape']];
            $engine = $python['engine'];
            $values = $python['values'];
        } else {
            $fit = $this->holtWinters($y, 7, $params['alpha'], $params['beta'], $params['gamma']);
            $values = [];
            $trendSum = 0.0;
            for ($h = 1; $h <= $cfg['horizon_days']; $h++) {
                $trendSum += self::PHI ** $h;
                $values[] = max(0, $fit['level'] + $trendSum * $fit['trend'] + ($fit['seasonal'] ? $fit['season'][($n - 1 + $h) % 7] : 0));
            }
        }
        for ($h = 1; $h <= $cfg['horizon_days']; $h++) {
            $days[] = ['date' => $asOf->copy()->addDays($h - 1), 'value' => (float) $values[$h - 1], 'half' => 1.96 * $fit['sigma'] * sqrt($h)];
        }

        $future = [];
        if ($period === 'daily') {
            foreach (array_slice($days, 0, $cfg['horizon']) as $day) {
                $future[] = $this->point($day['date'], $period, $day['value'], $day['half']);
            }
        } else {
            // weekly / monthly: add up the daily forecasts per period; the part of the first period
            // that is already over counts as the actual registrations
            $buckets = [];
            foreach ($days as $day) {
                $key = $this->bucketStart($day['date'], $period)->toDateString();
                $buckets[$key]['sum'] = ($buckets[$key]['sum'] ?? 0) + $day['value'];
                $buckets[$key]['var'] = ($buckets[$key]['var'] ?? 0) + $day['half'] ** 2;
            }
            foreach (array_slice($buckets, 0, $cfg['horizon'], true) as $key => $b) {
                $start = Carbon::parse($key, 'Asia/Manila')->startOfDay();
                $actualSoFar = 0;
                for ($d = $start->copy(); $d->lt($asOf); $d->addDay()) {
                    $actualSoFar += $daily[$d->toDateString()] ?? 0;
                }
                $future[] = $this->point($start, $period, $actualSoFar + $b['sum'], sqrt($b['var']));
            }
        }

        // every completed period before the as-of period, for the chart
        $asOfStart = $this->bucketStart($asOf, $period);
        $perBucket = [];
        foreach ($daily as $date => $count) {
            $key = $this->bucketStart(Carbon::parse($date, 'Asia/Manila'), $period)->toDateString();
            $perBucket[$key] = ($perBucket[$key] ?? 0) + $count;
        }
        $history = [];
        for ($d = $this->bucketStart($firstDate, $period); $d->lt($asOfStart); $d = $this->next($d, $period)) {
            $history[] = ['date' => $d->toDateString(), 'label' => $this->label($d, $period), 'value' => (float) ($perBucket[$d->toDateString()] ?? 0)];
        }

        $spanDays = (int) $firstDate->diffInDays($asOf) + 1;
        $confidence = $spanDays >= 90 ? 'High' : ($spanDays >= 30 ? 'Moderate' : 'Low');

        $mape = $fit['mape'];
        $mapeLabel = $mape === null ? 'n/a' : ($mape < 10 ? 'Excellent' : ($mape < 20 ? 'Good' : ($mape < 50 ? 'Fair' : 'Poor')));

        return array_merge($base, [
            'status' => 'ok',
            'method' => $fit['seasonal'] ? 'Holt-Winters (additive)' : 'Holt Linear Trend',
            'engine' => $engine,
            'python' => $pythonOk,
            'algorithm' => ($fit['seasonal'] ? 'Holt-Winters (additive)' : 'Holt Linear Trend') . ($pythonOk ? ' · Python statsmodels' : ' · PHP fallback'),
            'seasonal' => $fit['seasonal'],
            'points' => $n,
            'span_days' => $spanDays,
            'confidence' => $confidence,
            'mape' => $mape === null ? null : round($mape, 1),
            'mape_label' => $mapeLabel,
            'history' => $history,
            // how many chart periods the training window covers (none for months: 6 weeks is under 2 months)
            'window' => match ($period) {
                'daily' => $n,
                'weekly' => intdiv($n, 7),
                default => 0
            },
            'window_start' => $trainStart->toDateString(),
            'future' => $future,
            'next_value' => $future[0]['value'],
            'total_horizon' => (int) array_sum(array_column($future, 'value')),
        ]);
    }

    private function point(Carbon $date, string $period, float $value, float $half): array
    {
        return [
            'date' => $date->toDateString(),
            'label' => $this->label($date, $period),
            // whole patients: a forecast of 91.3 people reads as 91
            'value' => (int) round($value),
            'lower' => (int) round(max(0, $value - $half)),
            'upper' => (int) round($value + $half),
        ];
    }

    /**
     * Runs python/forecast.py (statsmodels Holt-Winters) on the training window and returns its JSON
     * answer (the forecast for every day up to the longest horizon, plus the error figures), or null when
     * Python cannot be run - the caller then falls back to the PHP version below.
     *
     * The answer is cached for a day under a key made of the exact input, so the same window and sliders
     * (and the Daily / Weekly / Monthly tabs, which share one run) do not start Python again, while any
     * new data or moved slider gives a new key and a fresh run.
     */
    private function pythonForecast(array $y, Carbon $start, array $params): ?array
    {
        $script = base_path('python/forecast.py');
        if (!is_file($script)) {
            return null;
        }

        $input = json_encode([
            'y' => $y,
            'start' => $start->toDateString(),
            'alpha' => $params['alpha'],
            'beta' => $params['beta'],
            'gamma' => $params['gamma'],
            'phi' => self::PHI,
            'season' => 7,
            'horizon' => max(array_column(self::PERIODS, 'horizon_days')),
        ]);
        $key = 'forecast.python.' . sha1($input . '|' . filemtime($script));

        try {
            return Cache::remember($key, now()->addDay(), function () use ($script, $input) {
                $configured = config('services.python.bin');
                // PYTHON_BIN in .env wins; otherwise the usual names are tried in turn
                $candidates = $configured ? [[$configured]] : [['python'], ['python3'], ['py', '-3']];

                foreach ($candidates as $command) {
                    $result = Process::path(base_path())
                        ->env([
                            'PYTHONIOENCODING' => 'utf-8',
                            'APPDATA' => getenv('APPDATA') ?: '',
                            'USERPROFILE' => getenv('USERPROFILE') ?: '',
                        ])
                        ->timeout(60)
                        ->input($input)
                        ->run([...$command, $script]);

                    $data = json_decode($result->output(), true);
                    if (!is_array($data)) {
                        Log::warning('Forecasting Python raw failure', [
                            'cmd' => $command,
                            'exit' => $result->exitCode(),
                            'out' => $result->output(),
                            'err' => $result->errorOutput(),
                        ]);
                        continue;
                    }
                    if (empty($data['ok'])) {
                        throw new \RuntimeException($data['error'] ?? 'The Python script reported an error.');
                    }
                    return $data;
                }
                throw new \RuntimeException('No working Python with statsmodels was found. Set PYTHON_BIN in .env.');
            });
        } catch (\Throwable $e) {
            Log::warning('Forecasting: the Python engine could not be used, falling back to PHP - ' . $e->getMessage());
            return null;
        }
    }

    /** Additive Holt-Winters; with less than two full seasons it falls back to Holt's linear trend. */
    private function holtWinters(array $y, int $m, float $a, float $b, float $g): array
    {
        $n = count($y);
        $seasonal = $n >= 2 * $m;

        if ($seasonal) {
            // start values from every complete season (not just the first), so one odd week
            // doesn't set the weekday pattern: level = first season's mean, trend = change of
            // the season means, seasonal index = average gap of each weekday from its season's mean
            $seasons = intdiv($n, $m);
            $means = [];
            for ($k = 0; $k < $seasons; $k++) {
                $means[$k] = array_sum(array_slice($y, $k * $m, $m)) / $m;
            }
            $level = $means[0];
            $trend = ($means[$seasons - 1] - $means[0]) / (($seasons - 1) * $m);
            $season = [];
            for ($i = 0; $i < $m; $i++) {
                $gaps = 0.0;
                for ($k = 0; $k < $seasons; $k++) {
                    $gaps += $y[$k * $m + $i] - $means[$k];
                }
                $season[$i] = $gaps / $seasons;
            }
            $start = 0;
        } else {
            $level = $y[0];
            $trend = $y[1] - $y[0];
            $season = array_fill(0, $m, 0.0);
            $start = 1;
        }

        $errors = [];
        $absError = 0.0;
        $actualSum = 0.0;
        for ($t = $start; $t < $n; $t++) {
            $s = $seasonal ? $season[$t % $m] : 0.0;
            $pred = $level + $trend + $s;
            // the first season only settles the start values, so it is left out of the error figures
            if ($t >= ($seasonal ? $m : 1)) {
                $errors[] = $y[$t] - $pred;
                $absError += abs($y[$t] - $pred);
                $actualSum += $y[$t];
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
            'sigma' => count($errors) > 1 ? sqrt(array_sum(array_map(fn($e) => $e * $e, $errors)) / count($errors)) : 0.0,
            // weighted absolute % error: total miss / total actual. A plain MAPE explodes on the
            // near-empty weekend days, where one patient off is a huge percentage.
            'mape' => $actualSum > 0 ? $absError / $actualSum * 100 : null,
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

    /** Registrations per day (Y-m-d => count). */
    private function dailyCounts(): array
    {
        $today = Carbon::today('Asia/Manila')->toDateString();

        // 1. Completed days from daily_inflow_summary
        $counts = DB::table('daily_inflow_summary')
            ->where('inflow_date', '<', $today)
            ->pluck('total_patients', 'inflow_date') // or 'total_verified' if you only want verified patients
            ->map(fn($v) => (int) $v)
            ->all();

        // 2. Live count for today (not yet snapshotted at midnight)
        $todayCount = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', $today)
            ->count();

        if ($todayCount > 0) {
            $counts[$today] = $todayCount;
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
            ->whereIn('status', ['Verified', 'Encoded'])
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
            $std = sqrt(array_sum(array_map(fn($v) => ($v - $baseline) ** 2, $past)) / 4);

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

        usort($list, fn($a, $b) => [['spike' => 0, 'watch' => 1, 'normal' => 2][$a->level], -$a->current]
            <=> [['spike' => 0, 'watch' => 1, 'normal' => 2][$b->level], -$b->current]);

        return [
            'monitored' => $this->barangayCount(),
            'with_cases' => count($list),
            'spikes' => count(array_filter($list, fn($b) => $b->level === 'spike')),
            'watch' => count(array_filter($list, fn($b) => $b->level === 'watch')),
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
