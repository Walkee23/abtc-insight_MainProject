<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BhwController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/analytics', function () {
        return view('admin.V_and_A');
    })->name('admin.analytics');

    Route::get('/compliance', function () {
        return view('admin.pep_comp');
    })->name('admin.compliance');

    Route::get('/forecasting', function () {
        return view('admin.F_and_O');
    })->name('admin.forecasting');

    Route::get('/system-management', function () {
        return view('admin.USM');
    })->name('admin.usm');
});

// Staff Routes
Route::prefix('staff')->group(function () {
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/case-encoding', [StaffController::class, 'caseEncoding'])->name('staff.case-encoding');

    Route::get('/patient-lookup', function () {
        return view('staff.Patient_Lookup');
    })->name('staff.patient-lookup');

    Route::get('/patient-verification', [StaffController::class, 'patientVerification'])->name('staff.patient-verification');
    Route::post('/verify-attendance/{inflow_record_id}', [StaffController::class, 'verifyAttendance'])->name('staff.verify-attendance');
});

// Healthworker Routes
Route::prefix('healthworker')->group(function () {
    Route::get('/dashboard', function () {
        return view('healthworker.dashboard');
    })->name('healthworker.dashboard');

    Route::get('/clinical-encoding', function () {
        return view('healthworker.CE_VI');
    })->name('healthworker.clinical-encoding');

    Route::get('/clinical-encoding/section-vii', function () {
        return view('healthworker.CE_VII');
    })->name('healthworker.ce-vii');

    Route::get('/clinical-encoding/section-viii', function () {
        return view('healthworker.CE_VIII');
    })->name('healthworker.ce-viii');

    Route::get('/clinical-encoding/section-ix', function () {
        return view('healthworker.CE_IX');
    })->name('healthworker.ce-ix');

    Route::get('/treatment-tracker', function () {
        return view('healthworker.Treatment_Tracker');
    })->name('healthworker.treatment-tracker');

    Route::get('/patient-database', function () {
        return view('healthworker.Patient_Lookup&DB');
    })->name('healthworker.patient-database');

    Route::get('/compliance', function () {
        return view('healthworker.PEP_Compliance_&_SMS_Logs');
    })->name('healthworker.compliance');
});

// BHW Routes (referral dashboard, referral form, submission, print)
Route::get('/bhw/dashboard', [BhwController::class, 'dashboard'])->name('bhw.dashboard');

Route::get('/bhw/referral', function () {
    return view('bhw.referral_form');
})->name('bhw.referral');

Route::post('/bhw/referral/store', [BhwController::class, 'storeReferral'])->name('bhw.store');

Route::get('/bhw/referral/{id}/print', [BhwController::class, 'printReferral'])->name('bhw.print');

// Public Patient-Facing Pages
Route::get('/patient/register', function () {
    return view('patient.Patient_Registration_Dashboard');
})->name('patient.register');

Route::get('/patient/New_patient', function () {
    return view('patient.New_Record_Registration');
})->name('patient.new-patient');

Route::get('/patient/Returning_Patient', function () {
    return view('patient.Returning_Patient_Registration');
})->name('patient.returning-patient');

Route::get('/patient/tracking-portal', function () {
    return view('patient.Tracking_Portal');
})->name('patient.tracking.portal');

Route::get('/patient/queue/normal', function () {
    return view('patient.NQ_confirmation');
})->name('patient.queue.normal');

Route::get('/patient/queue/priority', function () {
    return view('patient.PQ_confirmation');
})->name('patient.queue.priority');

// Walk-in New Patient self-registration (Section I + II)
Route::post('/patient/new-submit', function (Request $request) {
    $isPriority = $request->input('priority_status') !== 'none';
    $prefix = $isPriority ? 'P' : 'N';
    $queueDate = now()->toDateString();

    // Count today's registrations with this prefix to build the next queue number (resets daily)
    $countToday = DB::table('inflow_general_particulars')
        ->where('queue_date', $queueDate)
        ->where('queue_id', 'LIKE', $prefix . '%')
        ->count();
    $queueId = $prefix . ($countToday + 1);

    // Section I: General Particulars
    $inflowRecordId = DB::table('inflow_general_particulars')->insertGetId([
        'queue_id' => $queueId,
        'queue_date' => $queueDate,
        'id_number' => $request->input('valid_id_number'),
        'patient_name' => $request->input('full_name'),
        'age' => $request->input('age'),
        'sex' => ucfirst($request->input('sex')),
        'date_of_birth' => $request->input('date_of_birth'),
        'civil_status' => ucfirst($request->input('civil_status')),
        'contact_num' => $request->input('contact_number'),
        'barangay' => $request->input('barangay_of_incidence'),
        'philhealth_member' => $request->input('philhealth_member') === 'yes' ? 1 : 0,
        'philhealth_name' => $request->input('philhealth_member_name'),
        'philhealth_dob' => $request->input('philhealth_member_dob'),
        'status' => 'Pending',
    ]);

    // Section II: Other Personal Data (illness/allergy history)
    DB::table('inflow_other_personal_data')->insert([
        'inflow_record_id' => $inflowRecordId,
        'illness_history' => $request->input('current_illnesses'),
        'allergy_history' => $request->input('known_allergies'),
    ]);

    return $isPriority
        ? view('patient.PQ_confirmation', ['queueNumber' => $queueId])
        : view('patient.NQ_confirmation', ['queueNumber' => $queueId]);
})->name('patient.new-submit');

// Returning Patient — search for an existing patient record
Route::get('/patient/search', [PatientController::class, 'search'])->name('patient.search');

// Returning Patient — handle the returning patient form submission
Route::post('/patient/submit-registration-returning', [PatientController::class, 'storeReturning'])->name('patient.submit.returning');

// New Patient (via BHW referral) — handle the form submission using the controller
Route::post('/patient/submit-registration', [PatientController::class, 'registerPatient'])->name('patient.submit');