<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Patient Verification page — show Pending walk-ins split into Priority/Normal queues
    public function patientVerification(Request $request)
    {
        $search = $request->input('search');

    $priorityQuery = DB::table('inflow_general_particulars')
        ->where('status', 'Pending')
        ->where('queue_id', 'LIKE', 'P%');

    $normalQuery = DB::table('inflow_general_particulars')
        ->where('status', 'Pending')
        ->where('queue_id', 'LIKE', 'N%');

    if ($search) {
        $applySearch = function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'LIKE', "%{$search}%")
                  ->orWhere('queue_id', $search)
                  ->orWhere('id_number', $search)
                  ->orWhere('inflow_record_id', $search);
            });
        };
        $priorityQuery->where($applySearch);
        $normalQuery->where($applySearch);
    }

    $priorityQueue = $priorityQuery->orderBy('queue_date')->orderBy('queue_id')->get();
    $normalQueue = $normalQuery->orderBy('queue_date')->orderBy('queue_id')->paginate(5, ['*'], 'normal_page')
    ->withQueryString();

    return view('staff.Patient_Verification', compact('priorityQueue', 'normalQueue', 'search'));
}
    // Verify Attendance & Transfer — flips a Pending record to Verified
   public function verifyAttendance(string $inflow_record_id)
{
    $inflow = DB::table('inflow_general_particulars')
        ->where('inflow_record_id', $inflow_record_id)
        ->first();

    if (!$inflow) {
        return back()->withErrors(['error' => 'Record not found.']);
    }

    // Generate patient_id: CEB-[registration date]-[date of birth]-[sequence]
    $regDate = \Carbon\Carbon::parse($inflow->reg_date)->format('Ymd');
    $dob = \Carbon\Carbon::parse($inflow->date_of_birth)->format('Ymd');

    $countSameDay = DB::table('patients')
        ->where('patient_id', 'LIKE', "CEB-{$regDate}-{$dob}-%")
        ->count();
    $sequence = str_pad($countSameDay + 1, 3, '0', STR_PAD_LEFT);
    $patientId = "CEB-{$regDate}-{$dob}-{$sequence}";

    // Only insert if this inflow record hasn't already been transferred
    $existing = DB::table('patients')->where('inflow_record_id', $inflow_record_id)->first();

    if (!$existing) {
        $otherData = DB::table('inflow_other_personal_data')
            ->where('inflow_record_id', $inflow_record_id)
            ->first();

        DB::table('patients')->insert([
            'patient_id'         => $patientId,
            'inflow_record_id'   => $inflow_record_id,
            'date_registered'    => now(),
            'patient_name'       => $inflow->patient_name,
            'age'                => $inflow->age,
            'sex'                => $inflow->sex,
            'date_of_birth'      => $inflow->date_of_birth,
            'civil_status'       => $inflow->civil_status,
            'contact_num'        => $inflow->contact_num,
            'id_number'          => $inflow->id_number,
            'philhealth_member'  => $inflow->philhealth_member,
            'philhealth_name'    => $inflow->philhealth_name,
            'philhealth_dob'     => $inflow->philhealth_dob,
            'illness_history'    => $otherData->illness_history ?? null,
            'allergy_history'    => $otherData->allergy_history ?? null,
        ]);
    }

    DB::table('inflow_general_particulars')
        ->where('inflow_record_id', $inflow_record_id)
        ->update(['status' => 'Verified']);

    return redirect()->route('staff.patient-verification')
        ->with('success', 'Patient verified and moved to Case Encoding.');
}
    // Case Encoding page — show Verified records awaiting encoding
    public function caseEncoding(Request $request, $inflow_record_id = null)
{
$search = $request->input('search');

$query = DB::table('inflow_general_particulars')
    ->join('patients', 'inflow_general_particulars.inflow_record_id', '=', 'patients.inflow_record_id')
    ->where('inflow_general_particulars.status', 'Verified')
    ->select('inflow_general_particulars.*', 'patients.patient_id');

if ($search) {
    $query->where(function ($q) use ($search) {
        $q->where('inflow_general_particulars.patient_name', 'LIKE', "%{$search}%")
          ->orWhere('patients.patient_id', 'LIKE', "%{$search}%")
          ->orWhere('inflow_general_particulars.inflow_record_id', $search);
    });
}

$verifiedQueue = $query->orderBy('inflow_general_particulars.queue_date')->get();

    $selectedPatient = null;

    if ($inflow_record_id) {
        $selectedPatient = $verifiedQueue->firstWhere('inflow_record_id', $inflow_record_id);
    } elseif ($verifiedQueue->isNotEmpty()) {
        $selectedPatient = $verifiedQueue->first();
    }

    return view('staff.Case_Encoding', compact('verifiedQueue', 'selectedPatient', 'search'));
    }

public function storeCaseEncoding(Request $request, string $inflow_record_id)
{
    $patient = DB::table('patients')->where('inflow_record_id', $inflow_record_id)->first();

        if (!$patient) {
        return back()->withErrors(['error' => 'Patient record not found. Please verify attendance first.']);
    }

    $isComplete = $request->input('action') === 'complete';

    if ($isComplete && $request->input('prev_arv_given') === '1') {
        $hasDoseDate = $request->filled('dose1_date') || $request->filled('dose2_date') || $request->filled('dose3_date') || $request->filled('booster_date');
        if (!$hasDoseDate) {
            return back()->withErrors(['error' => 'Please provide at least one dose date since "Previously Vaccinated" is set to Yes.'])->withInput();
        }
    }

    $inflow = DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->first();

    $inflow = DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->first();

    // Get or create the bite_cases record for this patient
    $biteCase = DB::table('bite_cases')->where('inflow_record_id', $inflow_record_id)->first();

    if (!$biteCase) {
        $caseNumber = DB::table('bite_cases')->max('case_number') + 1;

        $biteCaseId = DB::table('bite_cases')->insertGetId([
            'patient_id'        => $patient->patient_id,
            'inflow_record_id'  => $inflow_record_id,
            'case_number'       => $caseNumber,
            'date_verified'     => now(),
            'barangay'          => $inflow->barangay ?? 'Unknown',
            'category'          => 'Cat II', // placeholder - no form field for this yet
            'philhealth_status' => $patient->philhealth_member ? 'Member' : 'Non-member',
        ], 'bite_case_id');
    } else {
        $biteCaseId = $biteCase->bite_case_id;
    }

    // Section 3: Details of Exposure
    DB::table('bite_section3_exposure')->updateOrInsert(
        ['bite_case_id' => $biteCaseId],
        [
            'animal_type'       => $request->input('animal_type'),
            'animal_type_other' => $request->input('animal_type_other'),
            'bite_date_time'    => $request->input('bite_date_time'),
            'animal_vax_status' => $request->input('animal_vax_status'),
            'animal_vax_date'   => $request->input('animal_vax_date') ?: null,
            'animal_fate'       => $request->input('fate'),
            'obs_14_days'       => $request->input('obs_14_days') ?: null,
            'exposure_type'     => implode(', ', $request->input('exposure_type', [])),
            'is_provoked'       => $request->input('provoked'),
            'is_leashed'        => $request->input('leash'),
            'has_gate'          => $request->input('gate'),
            'circumstances'     => $request->input('circumstances'),
        ]
    );

    // Section 4: Local Wound Treatment
    DB::table('bite_section4_wound_treatment')->updateOrInsert(
        ['bite_case_id' => $biteCaseId],
        [
            'wound_washed'          => implode(', ', $request->input('wound_washed', [])),
            'wound_wash_other'      => $request->input('wound_wash_other'),
            'local_irritant_applied'=> $request->has('local_irritant_applied') ? 1 : 0,
            'local_irritant_detail' => $request->input('local_irritant_detail'),
        ]
    );

    // Section 5: Previous Anti-Rabies Treatment
    $doses = array_filter([
        'dose1'   => $request->input('dose1_date'),
        'dose2'   => $request->input('dose2_date'),
        'dose3'   => $request->input('dose3_date'),
        'booster' => $request->input('booster_date'),
    ]);

    
    DB::table('bite_section5_prior_arv')->updateOrInsert(
        ['bite_case_id' => $biteCaseId],
        [
            'prev_arv_given' => $request->input('prev_arv_given'),
            'prev_arv_dates' => json_encode($doses),
        ]
    );

        if ($isComplete) {
        DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->update(['status' => 'Encoded']);

        return redirect()->route('staff.case-encoding')
            ->with('success', 'Case encoding completed and saved successfully.');
    }

    return redirect()->route('staff.case-encoding', $inflow_record_id)
        ->with('success', 'Progress saved. You can continue later.');
    }
}
