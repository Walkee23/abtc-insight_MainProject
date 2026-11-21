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

    // 3. Completed PEP Today: cases finalized as Completed whose last recorded dose is dated today.
    // (There is no "completed at" column, so the last dose date is the closest signal.)
    $completedToday = DB::table('bite_cases as bc')
        ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
        ->where('bc.outcome', 'Completed')
        ->whereRaw('COALESCE(s7.day28_date, s7.day7_date, s7.day3_date, s7.day0_date) = ?', [today()->toDateString()])
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

   public function compliance()
    {
        // 1. PEP Completion Rate: every PEP course on record (Day 0 given) is scanned in the database.
        // A course is completed when ALL of its scheduled doses have a recorded date (App\Support\PepSchedule):
        //   Primary, IM route:  Day 0, Day 3, Day 7, Day 14 and Day 28  (5 dates)
        //   Primary, ID route:  Day 0, Day 3, Day 7 and Day 28  (4 dates; also records with no route, e.g. imports)
        //   Booster:            Day 0 and Day 3                 (2 dates)
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

        // 2. SMS Success Rate gikan sa 'sms' table (Base sa status = 'Sent' o 'Delivered' batok sa total)
        $totalSms = DB::table('sms')->count();
        $sentSms = DB::table('sms')->whereIn('status', ['Sent', 'Delivered'])->count();
        $smsSuccessRate = $totalSms > 0 ? round(($sentSms / $totalSms) * 100, 1) : 100.0;

        // 3. Pending Reminders gikan sa 'sms' table kung asa ang status kay 'Pending'
        $pendingReminders = DB::table('sms')->where('status', 'Pending')->count();

        // 4. Late Follow-ups gikan sa 'sms' table kung asa ang sms_type kay naghisgot og late follow-up
        $lateFollowUps = DB::table('sms')
            ->where('sms_type', 'like', '%Late Follow-up%')
            ->count();

        return view('admin.pep_comp', compact(
            'pepCompletionRate',
            'totalCourses',
            'completedCourses',
            'completedPrimary',
            'completedBooster',
            'completedPatients',
            'smsSuccessRate',
            'pendingReminders',
            'lateFollowUps'
        ));
    }

}