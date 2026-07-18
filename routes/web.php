<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome_portal');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role Dashboards
Route::prefix('admin')->group(function () {
    // 1. Main Overview (Dashboard)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // 2. Analytics (V_and_A)
    Route::get('/analytics', function () {
        return view('admin.V_and_A');
    })->name('admin.analytics');

    // 3. PEP Compliance & SMS Logs (pep_comp)
    Route::get('/compliance', function () {
        return view('admin.pep_comp');
    })->name('admin.compliance');

    // 4. Forecasting & Outbreak Detection (F_and_O)
    Route::get('/forecasting', function () {
        return view('admin.F_and_O');
    })->name('admin.forecasting');

    // 5. User & System Management (USM)
    Route::get('/system-management', function () {
        return view('admin.USM');
    })->name('admin.usm');
});

// Other Role Fallbacks
// Staff Routes
Route::prefix('staff')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/case-encoding', function () {
        return view('staff.Case_Encoding');
    })->name('staff.case-encoding');

    Route::get('/patient-lookup', function () {
        return view('staff.Patient_Lookup');
    })->name('staff.patient-lookup');

    Route::get('/patient-verification', function () {
        return view('staff.Patient_Verification');
    })->name('staff.patient-verification');
});

Route::get('/healthworker/dashboard', function () {
    return view('healthworker.dashboard');
})->name('healthworker.dashboard');

Route::get('/bhw/dashboard', function () {
    return view('bhw.dashboard');
})->name('bhw.dashboard');

