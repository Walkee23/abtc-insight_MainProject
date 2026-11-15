<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $healthWorkersCount = DB::table('users')->where('role', 'Healthworker')->count();
        $internsCount = DB::table('users')->where('role', 'OJT')->orWhere('role', 'Intern')->count();
        $staffCount = DB::table('users')->where('role', 'Staff')->count();

        // 2. Active Sessions / Users List
        $activeUsers = DB::table('users')
            ->select('name', 'role', 'updated_at')
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get();

        // 3. System Activity Logs (Gikan sa audit/logs table o fallback)
        $systemLogs = DB::table('system_logs') 
            ->latest()
            ->limit(4)
            ->get();

        return view('admin.USM', compact(
            'healthWorkersCount', 
            'internsCount', 
            'staffCount', 
            'activeUsers',
            'systemLogs'
        ));
    }
        public function dashboard(\Illuminate\Http\Request $request)
    {
        // 1. Total Patients (Gidugang kini para dili ma-undefined sa compact)
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


       // 4. Top Incident Hotspots (Direkta sa inflow_general_particulars)
        $hotspots = DB::table('inflow_general_particulars')
            ->where('queue_date', '>=', now()->subDays(30))
            ->select('barangay', DB::raw('count(*) as total'))
            ->groupBy('barangay')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $maxBarangayTotal = $hotspots->max('total') ?: 1;

        // 5. Bite Categories & Filter (Monthly / Quarterly)
        $filter = $request->query('filter', 'monthly');
        $query = DB::table('bite_cases');

        if ($filter === 'monthly') {
            // I-filter karong bulana
            $query->whereMonth('date_verified', date('m'))
                ->whereYear('date_verified', date('Y'));
        } elseif ($filter === 'quarterly') {
            // I-filter karong quarter (Pananglitan: katapusang 3 ka bulan)
            $query->where('date_verified', '>=', now()->subMonths(3));
        }

        $totalBites = (clone $query)->count();
        $cat1 = (clone $query)->whereIn(DB::raw('UPPER(TRIM(category))'), ['I', '1', 'CAT I', 'CAT 1', 'CATEGORY I', 'CATEGORY 1'])->count();
        $cat2 = (clone $query)->whereIn(DB::raw('UPPER(TRIM(category))'), ['II', '2', 'CAT II', 'CAT 2', 'CATEGORY II', 'CATEGORY 2'])->count();
        $cat3 = (clone $query)->whereIn(DB::raw('UPPER(TRIM(category))'), ['III', '3', 'CAT III', 'CAT 3', 'CATEGORY III', 'CATEGORY 3'])->count();

        $cat1Pct = $totalBites > 0 ? round(($cat1 / $totalBites) * 100) : 0;
        $cat2Pct = $totalBites > 0 ? round(($cat2 / $totalBites) * 100) : 0;
        $cat3Pct = $totalBites > 0 ? round(($cat3 / $totalBites) * 100) : 0;

        // 6. Monthly Data para sa Forecasting Engine
        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $count = DB::table('inflow_general_particulars')
                ->whereYear('queue_date', date('Y'))
                ->whereMonth('queue_date', $m)
                ->count();
            $monthlyData[] = $count;
        }
        
        // Query the last 21 days of actual records grouped by date

        $dailyData = [];
        for ($i = 20; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = DB::table('inflow_general_particulars')
                ->whereDate('queue_date', $date)
                ->count();
            $dailyData[] = $count;
        }

        // 2. Query the last 12 weeks for the Weekly view forecasting engine
        $weeklyData = [];
        for ($w = 11; $w >= 0; $w--) {
            $startDate = now()->subWeeks($w)->startOfWeek()->toDateString();
            $endDate = now()->subWeeks($w)->endOfWeek()->toDateString();
            $count = DB::table('inflow_general_particulars')
                ->whereBetween('queue_date', [$startDate, $endDate])
                ->count();
            $weeklyData[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalPatients',
            'activePepCount',
            'verifiedToday',
            'hotspots',
            'totalBites',
            'cat1', 'cat2', 'cat3',
            'cat1Pct',
            'cat2Pct',
            'cat3Pct',
            'monthlyData',
            'dailyData',    // <--- Added here
            'weeklyData',
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