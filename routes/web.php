<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
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

// Public Patient-Facing Pages
Route::prefix('patient')->group(function () {
    // 1. Registration choice screen (New vs Returning Patient)
    Route::get('/register', function () {
        return view('patient.Patient_Registration_Dashboard');
    })->name('patient.register');

    // 2. New Patient registration form
    Route::get('/new-patient', function () {
        return view('patient.New_Record_Registration');
    })->name('patient.new-patient');

    // 3. Returning Patient — report a new bite incident using an existing record
    Route::get('/returning-patient', function () {
        return view('patient.Returning_Patient_Registration');
    })->name('patient.returning-patient');

    // 4. Tracking portal — look up an existing record by Tracking ID + DOB
    Route::get('/tracking', function () {
        return view('patient.Tracking_Portal');
    })->name('patient.tracking.portal');

    // 4b. Handle tracking portal search (no real lookup yet — shows the demo record page)
    Route::post('/tracking/search', function (Request $request) {
        return view('patient.Track_Record');
    })->name('patient.track.submit');

    // 5. Handle walk-in self-registration: Section I + Section II per the manuscript's schema
    Route::post('/submit', function (Request $request) {
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
    })->name('patient.submit');
});