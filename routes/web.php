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
Route::get('/staff/dashboard', function () {
    return view('staff.dashboard');
})->name('staff.dashboard');

Route::prefix('healthworker')->group(function () {
    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('healthworker.dashboard');
    })->name('healthworker.dashboard');

    // 2. Clinical Encoding (main wizard entry point, Sections VI-IX)
    Route::get('/clinical-encoding', function () {
        return view('healthworker.CE_VI');
    })->name('healthworker.clinical-encoding');

    // 2b. Clinical Encoding individual sections (kept accessible directly)
    Route::get('/clinical-encoding/section-vii', function () {
        return view('healthworker.CE_VII');
    })->name('healthworker.ce-vii');

    Route::get('/clinical-encoding/section-viii', function () {
        return view('healthworker.CE_VIII');
    })->name('healthworker.ce-viii');

    Route::get('/clinical-encoding/section-ix', function () {
        return view('healthworker.CE_IX');
    })->name('healthworker.ce-ix');

    // 3. Treatment Tracker
    Route::get('/treatment-tracker', function () {
        return view('healthworker.Treatment_Tracker');
    })->name('healthworker.treatment-tracker');

    // 4. Patient Database
    Route::get('/patient-database', function () {
        return view('healthworker.Patient_Lookup&DB');
    })->name('healthworker.patient-database');

    // 5. Compliance (PEP Compliance & SMS Logs)
    Route::get('/compliance', function () {
        return view('healthworker.PEP_Compliance_&_SMS_Logs');
    })->name('healthworker.compliance');
});

Route::get('/bhw/dashboard', function () {
    return view('bhw.dashboard');
})->name('bhw.dashboard');

Route::get('/patient/register', function () {
    return view('patient.New_Record_Registration');
})->name('patient.register');

Route::get('/patient/tracking-portal', function () {
    return view('patient.Tracking_Portal');
})->name('patient.tracking.portal');