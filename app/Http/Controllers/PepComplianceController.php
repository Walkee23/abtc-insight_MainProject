<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PepComplianceController extends Controller
{
    /**
     * PEP Compliance.
     *
     * Doses are worked out from Section VII (bite_section7_immunization): the Day 0 date
     * sets the schedule (Primary: D0/D3/D7/D28, Booster: D0/D3) and each recorded day date
     * is the actual dose.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = in_array($request->query('status'), ['pending', 'missed', 'completed'], true)
            ? $request->query('status') : 'all';

        // "mine" (default): the cards and table cover only the doses of the cases assigned to
        // the logged-in health worker; "all" is the whole facility, read-only
        $scope = $request->query('scope') === 'all' ? 'all' : 'mine';

        // Everything below is computed by the database. The doses of tens of thousands of cases are
        // never loaded into PHP at once: only the 10 rows of the current page are.
        $doses = fn () => $this->doses($scope === 'mine');

        // --- Summary cards --------------------------------------------------
        $tomorrow = $this->today()->copy()->addDay()->toDateString();
        $agg = $doses()->selectRaw(
            "COALESCE(SUM(x.status LIKE 'Completed%'), 0) as completed,
             COALESCE(SUM(x.status = 'Completed On Time'), 0) as on_time,
             COALESCE(SUM(x.status = 'Missed'), 0) as missed,
             COALESCE(SUM(x.status = 'Pending' AND x.scheduled <= ?), 0) as due_soon",
            [$tomorrow]
        )->first();
        $completed = (int) $agg->completed;
        $onTime = (int) $agg->on_time;
        $missed = (int) $agg->missed;

        $stats = [
            'completion' => ($completed + $missed) > 0 ? round($completed / ($completed + $missed) * 100, 1) : null,
            'on_time_pct' => $completed > 0 ? (int) round($onTime / $completed * 100) : null,
            'missed' => $missed,
            'due_soon' => (int) $agg->due_soon,
        ];

        // --- Tracking table: needs-attention first ---------------------------
        $rows = $doses();
        if ($status === 'pending') {
            $rows->where('x.status', 'Pending');
        } elseif ($status === 'missed') {
            $rows->where('x.status', 'Missed');
        } elseif ($status === 'completed') {
            $rows->where('x.status', 'like', 'Completed%');
        }
        foreach (preg_split('/\s+/', mb_strtolower($search), -1, PREG_SPLIT_NO_EMPTY) as $term) {
            $rows->whereRaw(
                "LOWER(CONCAT_WS(' ', x.patient_name, x.patient_id, CONCAT('Dose ', x.dose_no, ' (D', x.day_no, ')'), x.label, x.barangay)) LIKE ?",
                ['%' . addcslashes($term, '%_\\') . '%']
            );
        }
        $rank = "CASE x.status WHEN 'Missed' THEN 0 WHEN 'Pending' THEN 1 ELSE 2 END";
        $tracking = $rows
            ->orderByRaw($rank)
            ->orderByRaw("CASE WHEN {$rank} < 2 THEN x.scheduled END ASC")
            ->orderByRaw("CASE WHEN {$rank} = 2 THEN x.scheduled END DESC")
            ->orderBy('x.bite_case_id')
            ->orderBy('x.day_no')
            ->paginate(10)
            ->withQueryString();

        $tracking->getCollection()->transform(function ($d) {
            $d->scheduled = Carbon::parse($d->scheduled)->startOfDay();
            $d->actual = $d->actual ? Carbon::parse($d->actual)->startOfDay() : null;
            $d->dose_label = 'Dose ' . $d->dose_no . ' (D' . $d->day_no . ')';
            $d->mine = Auth::id() !== null && (int) $d->assigned_health_worker_id === (int) Auth::id();
            return $d;
        });

        // --- Performance by barangay (completed vs. completed + missed) ------
        // Always facility-wide: comparing barangays only makes sense across every case
        // It scans every dose of every case, so it is worked out once and kept for 10 minutes.
        $groups = Cache::remember('pep.barangay-performance.' . $this->today()->toDateString(), 600, function () {
            return $this->doses(false)->groupBy('x.barangay')
                ->selectRaw("x.barangay, SUM(x.status LIKE 'Completed%') as done, SUM(x.status = 'Missed') as miss")
                ->get()->map(fn ($g) => ['barangay' => $g->barangay, 'done' => (int) $g->done, 'miss' => (int) $g->miss])->all();
        });
        $byBarangay = [];
        foreach ($groups as $g) {
            $name = $g['barangay'] ?: 'Unknown';
            $byBarangay[$name]['done'] = ($byBarangay[$name]['done'] ?? 0) + $g['done'];
            $byBarangay[$name]['miss'] = ($byBarangay[$name]['miss'] ?? 0) + $g['miss'];
        }
        $barangays = collect($byBarangay)->map(function ($g, $name) {
            return (object) [
                'name' => $name,
                'pct' => ($g['done'] + $g['miss']) > 0 ? (int) round($g['done'] / ($g['done'] + $g['miss']) * 100) : null,
                'doses' => $g['done'] + $g['miss'],
            ];
        })->filter(fn ($b) => $b->pct !== null)->sortByDesc('pct')->values()->take(12);

        return view('healthworker.PEP_Compliance_&_SMS_Logs', compact(
            'stats', 'tracking', 'barangays', 'search', 'status', 'scope'
        ));
    }

    /** Compliance report as CSV: the same scope as the page (mine by default, or all). */
    public function export(Request $request)
    {
        $mine = $request->query('scope') !== 'all';

        return response()->streamDownload(function () use ($mine) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Patient Name', 'Patient ID', 'Barangay', 'Case No.', 'Dose', 'Label', 'Scheduled Date', 'Actual Date', 'Status']);

            // Rows are streamed one at a time from the database (unbuffered), so a facility-wide
            // report of 100,000+ doses never has to fit in memory.
            $pdo = DB::connection()->getPdo();
            $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
            try {
                $query = $this->doses($mine)
                    ->orderBy('x.patient_name')->orderBy('x.scheduled')->orderBy('x.bite_case_id')->orderBy('x.day_no');
                foreach ($query->cursor() as $d) {
                    fputcsv($out, [
                        $d->patient_name, $d->patient_id, $d->barangay, $d->case_number,
                        'Dose ' . $d->dose_no . ' (D' . $d->day_no . ')', $d->label,
                        $d->scheduled, $d->actual ?? '', $d->status,
                    ]);
                }
            } finally {
                $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            }
            fclose($out);
        }, 'pep-compliance-report-' . $this->today()->toDateString() . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function today(): Carbon
    {
        return now('Asia/Manila')->startOfDay();
    }

    /**
     * Every scheduled dose of every case that has a Day 0 date, as a query (alias "x") with the
     * dose's scheduled date, actual date and status worked out in SQL:
     * Completed On Time / Completed Late / Missed / Pending.
     *
     * Schedule: Primary D0/D3/D7/D28 (4 doses), Booster D0/D3 (2 doses). Dose numbers follow
     * that order. $mine limits it to the cases assigned to the logged-in health worker.
     */
    private function doses(bool $mine)
    {
        // a health worker's own scope is applied inside every slice, so only their cases are ever read
        $owner = $mine ? (Auth::id() ?? 0) : null;

        $slot = function (int $day, string $doseNo, string $only = '') use ($owner) {
            $q = DB::table('bite_cases as bc')
                ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
                ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
                ->whereNotNull('s7.day0_date')
                ->select('bc.bite_case_id', 'bc.case_number', 'bc.category', 'bc.barangay', 'bc.assigned_health_worker_id',
                    'p.patient_id', 'p.patient_name', 's7.dose_type', 's7.day0_date as day0')
                ->selectRaw("{$day} as day_no, {$doseNo} as dose_no, s7.day{$day}_date as actual");
            if ($only !== '') {
                $q->whereRaw($only);
            }
            if ($owner !== null) {
                $q->where('bc.assigned_health_worker_id', $owner);
            }
            return $q;
        };
        $primary = "(s7.dose_type IS NULL OR s7.dose_type <> 'Booster')";

        $union = $slot(0, '1')
            ->unionAll($slot(3, '2'))
            ->unionAll($slot(7, '3', $primary))
            ->unionAll($slot(28, '4', $primary));

        $today = DB::getPdo()->quote($this->today()->toDateString());
        $scheduled = 'DATE(DATE_ADD(d.day0, INTERVAL d.day_no DAY))';

        $withStatus = DB::query()->fromSub($union, 'd')->selectRaw(
            "d.*, {$scheduled} as scheduled,
             CASE WHEN d.actual IS NOT NULL THEN (CASE WHEN d.actual <= {$scheduled} THEN 'Completed On Time' ELSE 'Completed Late' END)
                  WHEN {$scheduled} < {$today} THEN 'Missed' ELSE 'Pending' END as status,
             CASE WHEN d.category = 'III' THEN 'High Risk' WHEN d.dose_type = 'Booster' THEN 'Booster' ELSE 'Standard' END as label"
        );

        return DB::query()->fromSub($withStatus, 'x');
    }
}
