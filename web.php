<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome_portal');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Role Dashboards
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
});

Route::get('/healthworker/dashboard', function () {
    return view('healthworker.dashboard');
});

Route::get('/bhw/dashboard', function () {
    return view('bhw.dashboard');
});

Route::get('/patient/register', function () {
    return view('patient.New_Record_Registration');
})->name('patient.register');

Route::get('/patient/tracking-portal', function () {
    return view('patient.Tracking_Portal');
})->name('patient.tracking.portal');

Route::get('/healthworker/dashboard', function () {
    // 1. Clinical Priority Queue
    $priorityQueue = DB::table('inflow_general_particulars')
        ->orderBy('inflow_record_id', 'desc')
        ->take(10)
        ->get();

    // 2. Pending Encoding Count
    $pendingEncodingCount = DB::table('inflow_general_particulars')
        ->where('status', 'Pending')
        ->count();

    // 3. Active Cases (tanang inflows karong adlawa)
    $activePepCount = DB::table('inflow_general_particulars')->count();
    $todayActiveCount = DB::table('inflow_general_particulars')
        ->whereDate('reg_date', today())
        ->count();

    // 4. Today's Verified Cases & Compliance
    $verifiedTodayCount = DB::table('inflow_general_particulars')
        ->where('status', 'Verified')
        ->whereDate('reg_date', today())
        ->count();

    $totalToday = DB::table('inflow_general_particulars')
        ->whereDate('reg_date', today())
        ->count();

    $complianceRate = $totalToday > 0 
        ? round(($verifiedTodayCount / $totalToday) * 100) 
        : 100;

    return view('healthworker.dashboard', compact(
        'priorityQueue',
        'pendingEncodingCount',
        'activePepCount',
        'todayActiveCount',
        'verifiedTodayCount',
        'complianceRate'
    ));
});