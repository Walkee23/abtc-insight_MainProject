<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOWriter;

class AdminController extends Controller
{
    public function systemManagement()
{
    // Catch up on an auto-backup that was due while no scheduler was running
    try {
        \App\Support\DatabaseBackup::runIfDue();
    } catch (\Throwable $e) {
        // the page must still open
    }

    // 1. Role-based User Counts
    $healthWorkersCount = DB::table('users')->where('role', 'Health Worker')->count();
    $bhwCount = DB::table('users')->where('role', 'BHW')->count();
    $staffCount         = DB::table('users')->where('role', 'Staff')->count();

    // 2. Users list
    $users = DB::table('users')->orderByDesc('created_at')->get();

    // Recently active (base sa last_login)
    $activeUsers = DB::table('users')
        ->select('full_name', 'role', 'last_login')
        ->whereNotNull('last_login')
        ->orderByDesc('last_login')
        ->limit(5)
        ->get();

    // 3. System logs (safe kung wala ang table o ang created_at)
    $systemLogs = collect();
    if (Schema::hasTable('system_logs')) {
        $logQuery = DB::table('system_logs');
        if (Schema::hasColumn('system_logs', 'created_at')) {
            $logQuery->orderByDesc('created_at');
        }
        $systemLogs = $logQuery->limit(4)->get();
    }

    return view('admin.USM', compact(
        'healthWorkersCount',
        'bhwCount',   
        'staffCount',
        'users',
        'activeUsers',
        'systemLogs'
    ));
}

       public function dashboard(\Illuminate\Http\Request $request)
{
    // 1. Total Registered Patients
    $totalPatients = DB::table('patients')->count();

    // 2. Ongoing PEP Courses: PEP started (Day 0 given) and the case has no outcome yet.
    // Same rule as the Health Worker dashboard: the outcome stays NULL until the course ends.
    $ongoingPepCount = DB::table('bite_cases as bc')
        ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
        ->whereNull('bc.outcome')
        ->whereNotNull('s7.day0_date')
        ->count();

    // 3. Completed PEP Today: courses whose every dose is recorded (the schedule depends on the route: IM Day 0, 3, 7, 14;
    // ID Day 0, 3, 7, 28; Booster Day 0, 3) and whose last dose (Day 14 for IM, Day 28 for ID, Day 3 for a Booster) is dated today.
    // (There is no "completed at" column, so the last dose date is the closest signal.)
    $completedToday = DB::table('bite_cases as bc')
        ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
        ->whereRaw('(' . \App\Support\PepSchedule::completeSql('s7') . ')')
        ->whereRaw("DATE(CASE WHEN s7.dose_type = 'Booster' THEN s7.day3_date WHEN s7.route = 'IM' THEN s7.day14_date ELSE s7.day28_date END) = ?", [today()->toDateString()])
        ->count();

    // 4. Top Incident Hotspots (30 o 90 ka adlaw)
    $hotspotRange = in_array((int) $request->query('range'), [30, 90]) ? (int) $request->query('range') : 30;

    $hotspots = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', '>=', now()->subDays($hotspotRange)->toDateString())
        ->whereNotNull('barangay')
        ->where('barangay', '!=', '')
        ->select('barangay', DB::raw('count(*) as total'))
        ->groupBy('barangay')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

    // 5. Bite Categories for a chosen year and month / quarter / whole year (by queue_date)
    $filter = $request->query('filter', 'monthly');
    if (!in_array($filter, ['monthly', 'quarterly', 'yearly'], true)) {
        $filter = 'monthly';
    }

    $baseQuery = fn () => DB::table('bite_cases')
        ->join('inflow_general_particulars', 'bite_cases.inflow_record_id', '=', 'inflow_general_particulars.inflow_record_id');

    // years that have cases, plus the current year, newest first
    $biteYears = $baseQuery()
        ->whereNotNull('inflow_general_particulars.queue_date')
        ->selectRaw('DISTINCT YEAR(inflow_general_particulars.queue_date) as y')
        ->pluck('y')->map(fn ($y) => (int) $y)->push(now()->year)->unique()->sortDesc()->values()->all();

    $periodOf = fn (Carbon $d) => $filter === 'quarterly' ? (int) ceil($d->month / 3) : $d->month;
    $periodMax = $filter === 'quarterly' ? 4 : 12;

    $biteYear = (int) $request->query('year', now()->year);
    if (!in_array($biteYear, $biteYears, true)) {
        $biteYear = now()->year;
    }
    $bitePeriod = (int) $request->query('period', 0);
    if ($bitePeriod < 1 || $bitePeriod > $periodMax) {
        $bitePeriod = $periodOf(now());
    }

    // start / end of the chosen period
    $rangeOf = function () use (&$filter, &$biteYear, &$bitePeriod) {
        if ($filter === 'yearly') {
            return [Carbon::create($biteYear, 1, 1), Carbon::create($biteYear, 12, 31)];
        }
        $from = $filter === 'quarterly'
            ? Carbon::create($biteYear, ($bitePeriod - 1) * 3 + 1, 1)
            : Carbon::create($biteYear, $bitePeriod, 1);
        return [$from->copy()->startOfMonth(), $from->copy()->addMonths($filter === 'quarterly' ? 2 : 0)->endOfMonth()];
    };
    [$biteFrom, $biteTo] = $rangeOf();

    // Opening the dashboard with no choice made and nothing recorded in the current period:
    // show the latest period that has data instead of an empty chart
    if (!$request->hasAny(['filter', 'year', 'period'])
        && !$baseQuery()->whereBetween('inflow_general_particulars.queue_date', [$biteFrom->toDateString(), $biteTo->toDateString()])->exists()) {
        $latest = $baseQuery()->max('inflow_general_particulars.queue_date');
        if ($latest) {
            $latest = Carbon::parse($latest);
            $biteYear = $latest->year;
            $bitePeriod = $periodOf($latest);
            [$biteFrom, $biteTo] = $rangeOf();
        }
    }

    $periodLabel = match ($filter) {
        'yearly'    => (string) $biteYear,
        'quarterly' => 'Q' . $bitePeriod . ' ' . $biteYear,
        default     => Carbon::create($biteYear, $bitePeriod, 1)->format('F Y'),
    };

    $query = $baseQuery()->whereBetween('inflow_general_particulars.queue_date', [$biteFrom->toDateString(), $biteTo->toDateString()]);

    $catExpr = 'UPPER(TRIM(bite_cases.category))';

    $totalBites = (clone $query)->count();
    $cat1 = (clone $query)->whereIn(DB::raw($catExpr), ['I', '1', 'CAT I', 'CAT 1', 'CATEGORY I', 'CATEGORY 1'])->count();
    $cat2 = (clone $query)->whereIn(DB::raw($catExpr), ['II', '2', 'CAT II', 'CAT 2', 'CATEGORY II', 'CATEGORY 2'])->count();
    $cat3 = (clone $query)->whereIn(DB::raw($catExpr), ['III', '3', 'CAT III', 'CAT 3', 'CATEGORY III', 'CATEGORY 3'])->count();

    $cat1Pct = $totalBites > 0 ? round(($cat1 / $totalBites) * 100) : 0;
    $cat2Pct = $totalBites > 0 ? round(($cat2 / $totalBites) * 100) : 0;
    $cat3Pct = $totalBites > 0 ? round(($cat3 / $totalBites) * 100) : 0;

    return view('admin.dashboard', compact(
        'totalPatients',
        'ongoingPepCount',
        'completedToday',
        'hotspots',
        'hotspotRange',
        'totalBites',
        'cat1', 'cat2', 'cat3',
        'cat1Pct', 'cat2Pct', 'cat3Pct',
        'filter',
        'biteYear', 'bitePeriod', 'biteYears', 'periodLabel'
    ));
}

   public function compliance(Request $request)
    {
        // ---------- 1. Stat cards (unchanged logic) ----------
        $complete = \App\Support\PepSchedule::completeSql('s7');
        $pep = DB::table('bite_cases as bc')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            ->selectRaw("COUNT(*) as courses,
                         COALESCE(SUM(({$complete})), 0) as completed,
                         COALESCE(SUM(s7.dose_type = 'Booster' AND ({$complete})), 0) as completed_booster,
                         COUNT(DISTINCT CASE WHEN ({$complete}) THEN bc.patient_id END) as completed_patients")
            ->first();
        $totalCourses = (int) $pep->courses;
        $completedCourses = (int) $pep->completed;
        $completedBooster = (int) $pep->completed_booster;
        $completedPrimary = $completedCourses - $completedBooster;
        $completedPatients = (int) $pep->completed_patients;
        $pepCompletionRate = $totalCourses > 0 ? round(($completedCourses / $totalCourses) * 100, 1) : 0.0;

        $totalSms = DB::table('sms')->count();
        $sentSms = DB::table('sms')->whereIn('status', ['Sent', 'Delivered'])->count();
        $smsSuccessRate = $totalSms > 0 ? round(($sentSms / $totalSms) * 100, 1) : 100.0;

        $pendingReminders = DB::table('sms')->where('status', 'Pending')->count();

        $lateFollowUps = DB::table('sms')
            ->where('sms_type', 'like', '%Late Follow-up%')
            ->count();

        // ---------- 2. Filters ----------
        [$from, $to] = $this->complianceDates($request);
        $pepStatus = $this->complianceOption($request->query('pep_status'), ['Pending', 'Completed On Time', 'Completed Late', 'Missed']);
        $smsStatus = $this->complianceOption($request->query('sms_status'), ['Sent', 'Failed', 'Pending']);
        $pepLimit = max(10, min(200, (int) $request->query('pep_limit', 10)));
        $smsLimit = max(10, min(200, (int) $request->query('sms_limit', 10)));

        // ---------- 3. PEP Compliance Tracking table (dose_schedule) ----------
        // fetch one extra row to know if a "Load More" button is needed
        $pepRows = $this->compliancePepQuery($from, $to, $pepStatus)->limit($pepLimit + 1)->get();
        $pepHasMore = $pepRows->count() > $pepLimit;
        $pepRows = $pepRows->take($pepLimit);

        // ---------- 4. SMS Outreach Logs (sms) ----------
        $smsRows = $this->complianceSmsQuery($from, $to, $smsStatus)->limit($smsLimit + 1)->get();
        $smsHasMore = $smsRows->count() > $smsLimit;
        $smsRows = $smsRows->take($smsLimit);

        // ---------- 5. Compliance Performance by Barangay ----------
        // Same "completed" rule as the stat card, grouped by the barangay on the bite case.
        $barangayStats = DB::table('bite_cases as bc')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            ->whereNotNull('bc.barangay')
            ->where('bc.barangay', '!=', '')
            ->selectRaw("bc.barangay as name, COUNT(*) as courses, COALESCE(SUM(({$complete})), 0) as completed")
            ->groupBy('bc.barangay')
            ->get()
            ->map(function ($b) {
                $b->rate = $b->courses > 0 ? round(($b->completed / $b->courses) * 100, 1) : 0.0;
                return $b;
            })
            ->sortByDesc('rate')
            ->values();
        // show the 3 best and the 3 that need action when there are more than 6
        if ($barangayStats->count() > 6) {
            $barangayStats = $barangayStats->take(3)->concat($barangayStats->slice(-3))->values();
        }

        return view('admin.pep_comp', compact(
            'pepCompletionRate',
            'totalCourses',
            'completedCourses',
            'completedPrimary',
            'completedBooster',
            'completedPatients',
            'smsSuccessRate',
            'pendingReminders',
            'lateFollowUps',
            'from', 'to', 'pepStatus', 'smsStatus', 'pepLimit', 'smsLimit',
            'pepRows', 'pepHasMore', 'smsRows', 'smsHasMore',
            'barangayStats'
        ));
    }

    /** CSV download for the Export Logs button: ?type=sms (default) or ?type=pep, honouring the date filter. */
    public function complianceExport(Request $request)
    {
        [$from, $to] = $this->complianceDates($request);
        $type = $request->query('type') === 'pep' ? 'pep' : 'sms';
        $filename = ($type === 'pep' ? 'pep_compliance_' : 'sms_logs_') . now()->format('Ymd_His') . '.csv';

        // stop spreadsheet apps from running a cell that starts with = + - @ as a formula
        $safe = fn ($v) => is_string($v) && $v !== '' && in_array($v[0], ['=', '+', '-', '@'], true) ? "'" . $v : $v;

        return new StreamedResponse(function () use ($type, $from, $to, $safe) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel reads it correctly

            if ($type === 'pep') {
                fputcsv($out, ['Patient', 'Barangay', 'Dose', 'Scheduled Date', 'Actual Date', 'Status']);
                foreach ($this->compliancePepQuery($from, $to, null)->cursor() as $r) {
                    fputcsv($out, [$safe($r->patient_name), $safe($r->barangay), $r->dose_label, $r->sched_date, $r->actual_date, $r->status]);
                }
            } else {
                fputcsv($out, ['Sent At', 'Patient', 'Phone', 'Type', 'Dose', 'Status', 'Message', 'Error']);
                foreach ($this->complianceSmsQuery($from, $to, null)->cursor() as $r) {
                    fputcsv($out, [$r->send_date, $safe($r->patient_name), $safe($r->contact_num), $r->sms_type, $r->dose_label, $r->status, $safe($r->message), $safe($r->error_detail)]);
                }
            }
            fclose($out);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function compliancePepQuery(?string $from, ?string $to, ?string $status)
    {
        return DB::table('dose_schedule as ds')
            ->join('patients as p', 'p.patient_id', '=', 'ds.patient_id')
            ->join('bite_cases as bc', 'bc.bite_case_id', '=', 'ds.bite_case_id')
            ->select('ds.sched_id', 'p.patient_name', 'bc.barangay', 'ds.dose_label', 'ds.sched_date', 'ds.actual_date', 'ds.status')
            ->when($from, fn ($q) => $q->whereDate('ds.sched_date', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('ds.sched_date', '<=', $to))
            ->when($status, fn ($q) => $q->where('ds.status', $status))
            ->orderByDesc('ds.sched_date')
            ->orderByDesc('ds.sched_id');
    }

    private function complianceSmsQuery(?string $from, ?string $to, ?string $status)
    {
        return DB::table('sms as s')
            ->leftJoin('patients as p', 'p.patient_id', '=', 's.patient_id')
            ->select('s.sms_id', 's.contact_num', 's.sms_type', 's.dose_label', 's.message', 's.send_date', 's.status', 's.error_detail', 'p.patient_name')
            ->when($from, fn ($q) => $q->whereDate('s.send_date', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('s.send_date', '<=', $to))
            ->when($status, fn ($q) => $status === 'Sent'
                ? $q->whereIn('s.status', ['Sent', 'Delivered'])
                : $q->where('s.status', $status))
            ->orderByDesc('s.send_date')
            ->orderByDesc('s.sms_id');
    }

    private function complianceDates(Request $request): array
    {
        $parse = function ($v) {
            try {
                return $v ? Carbon::createFromFormat('Y-m-d', $v)->toDateString() : null;
            } catch (\Throwable $e) {
                return null;
            }
        };
        $from = $parse($request->query('from'));
        $to = $parse($request->query('to'));
        if ($from && $to && $from > $to) {
            [$from, $to] = [$to, $from];
        }
        return [$from, $to];
    }

    private function complianceOption($value, array $allowed): ?string
    {
        return in_array($value, $allowed, true) ? $value : null;
    }

}