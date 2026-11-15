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
    // 1. Role-based User Counts
    $healthWorkersCount = DB::table('users')->where('role', 'Health Worker')->count();
    $internsCount       = DB::table('users')->whereIn('role', ['OJT', 'Intern'])->count();
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
        'internsCount',
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

    // 2. Active PEP Courses
    $activePepCount = DB::table('inflow_general_particulars')
        ->where('status', '!=', 'Completed')
        ->count();

    // 3. Verified Cases Today
    $verifiedToday = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('status', 'Verified')
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

    // 5. Bite Categories (monthly / quarterly) gamit ang queue_date
    $filter = $request->query('filter', 'monthly');
    if (!in_array($filter, ['monthly', 'quarterly'])) {
        $filter = 'monthly';
    }

    $query = DB::table('bite_cases')
        ->join('inflow_general_particulars', 'bite_cases.inflow_record_id', '=', 'inflow_general_particulars.inflow_record_id');

    if ($filter === 'monthly') {
        $query->whereBetween('inflow_general_particulars.queue_date', [
            now()->startOfMonth()->toDateString(),
            now()->endOfMonth()->toDateString(),
        ]);
    } else {
        $query->whereBetween('inflow_general_particulars.queue_date', [
            now()->startOfQuarter()->toDateString(),
            now()->endOfQuarter()->toDateString(),
        ]);
    }

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
        'activePepCount',
        'verifiedToday',
        'hotspots',
        'hotspotRange',
        'totalBites',
        'cat1', 'cat2', 'cat3',
        'cat1Pct', 'cat2Pct', 'cat3Pct',
        'filter'
    ));
}

   public function compliance()
    {
        // 1. PEP Completion Rate gikan sa inflow_general_particulars
        $totalCourses = DB::table('inflow_general_particulars')->count();
        $completedCourses = DB::table('inflow_general_particulars')->where('status', 'Completed')->count();
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
            'smsSuccessRate',
            'pendingReminders',
            'lateFollowUps'
        ));
    }

}