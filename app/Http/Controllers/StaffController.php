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
        $selectedId = $request->query('selected_id');

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

        $priorityQueue = $priorityQuery->orderBy('queue_date')
            ->orderBy('queue_id')
            ->get();

        $normalQueue = $normalQuery->orderBy('queue_date')
            ->orderBy('queue_id')
            ->paginate(5, ['*'], 'normal_page')
            ->withQueryString();

        // Load details of the selected patient for verification preview
        $selectedPatient = null;
        if ($selectedId) {
            $selectedPatient = DB::table('inflow_general_particulars')
                ->where('inflow_record_id', $selectedId)
                ->first();
        } elseif ($priorityQueue->isNotEmpty()) {
            $selectedPatient = $priorityQueue->first();
        } elseif ($normalQueue->isNotEmpty()) {
            $selectedPatient = $normalQueue->first();
        }

        return view('staff.Patient_Verification', compact('priorityQueue', 'normalQueue', 'search', 'selectedPatient'));
    }

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

        // Provisional WHO category from the exposure types ticked (Bite -> III, Scratch -> II,
        // Lick -> I; II when none yet). The Health Worker confirms or changes it in Section VI.
        $exposureTypes = (array) $request->input('exposure_type', []);
        $category = in_array('Bite', $exposureTypes, true) ? 'III'
            : (in_array('Scratch', $exposureTypes, true) ? 'II'
            : (in_array('Lick', $exposureTypes, true) ? 'I' : 'II'));

        // Everything saves together; "Complete Encoding" is the hand-off to the Health Worker
        // (status 'Encoded' puts the case in their Clinical Encoding queue), drafts stay with Staff.
        return DB::transaction(function () use ($request, $inflow_record_id, $patient, $inflow, $isComplete, $category) {

        // Get or create the bite_cases record for this patient
        $biteCase = DB::table('bite_cases')->where('inflow_record_id', $inflow_record_id)->first();

        if (!$biteCase) {
            $caseNumber = DB::table('bite_cases')->where('patient_id', $patient->patient_id)->max('case_number') + 1;

            $biteCaseId = DB::table('bite_cases')->insertGetId([
                'patient_id'        => $patient->patient_id,
                'inflow_record_id'  => $inflow_record_id,
                'case_number'       => $caseNumber,
                'date_verified'     => now(),
                'barangay'          => $inflow->barangay ?? 'Unknown',
                'category'          => $category,
                'philhealth_status' => $patient->philhealth_member ? 'Member' : 'Non-member',
            ], 'bite_case_id');
        } else {
            $biteCaseId = $biteCase->bite_case_id;

            // Keep the provisional category current while Staff is still encoding, unless the
            // Health Worker has already set it in Section VI
            if (!DB::table('bite_section6_wound_description')->where('bite_case_id', $biteCaseId)->exists()) {
                DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update(['category' => $category]);
            }
        }
        
        // Section 3: Details of Exposure
        DB::table('bite_section3_exposure')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            [
                'animal_type'       => $request->input('animal_type'),
                'animal_type_other' => $request->input('animal_type_other'),
                'bite_date_time'    => $request->input('bite_date') . ($request->input('bite_time') ? ' ' . $request->input('bite_time') : ' 00:00:00'),
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
                'wound_washed'           => $request->input('wound_washed'),
                'wound_wash_other'       => $request->input('wound_wash_other'),
                'local_irritant_applied' => $request->has('local_irritant_applied') ? 1 : 0,
                'local_irritant_detail'  => $request->input('local_irritant_detail'),
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
                ->with('success', 'Case encoding completed and sent to the Health Worker for Clinical Encoding.');
        }

        return redirect()->route('staff.case-encoding', $inflow_record_id)
            ->with('success', 'Progress saved. You can continue later.');

        });
    }

    // Staff Dashboard (Queue Management)
    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        // 1. Stats Grid (Daily Stats)
        $totalRegistered = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', today())
            ->count();

        $verifiedCount = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', today())
            ->where('status', 'Verified')
            ->count();

        $pendingCount = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', today())
            ->where('status', 'Pending')
            ->count();

        // 2. Priority Queue
        $priorityQuery = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', today())
            ->where('status', 'Pending')
            ->where('queue_id', 'LIKE', 'P%');

        // 3. Normal Queue
        $normalQuery = DB::table('inflow_general_particulars')
            ->whereDate('queue_date', today())
            ->where('status', 'Pending')
            ->where('queue_id', 'LIKE', 'N%');

        // Search Filter
        if ($search) {
            $applySearch = function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('patient_name', 'LIKE', "%{$search}%")
                      ->orWhere('queue_id', 'LIKE', "%{$search}%")
                      ->orWhere('id_number', 'LIKE', "%{$search}%")
                      ->orWhere('barangay', 'LIKE', "%{$search}%");
                });
            };
            $priorityQuery->where($applySearch);
            $normalQuery->where($applySearch);
        }

        $priorityQueue = $priorityQuery->orderByRaw('CAST(SUBSTRING(queue_id, 2) AS UNSIGNED) ASC')->get();
        $normalQueue   = $normalQuery->orderByRaw('CAST(SUBSTRING(queue_id, 2) AS UNSIGNED) ASC')->get();

        return view('staff.dashboard', compact(
            'totalRegistered',
            'verifiedCount',
            'pendingCount',
            'priorityQueue',
            'normalQueue',
            'search'
        ));
    }

    public function callPatient(string $inflow_record_id)
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

        // I-insert sa patients master table kung wala pa
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


        return redirect()->route('staff.dashboard')
            ->with('success', "Patient {$inflow->patient_name} verified! Ticket removed from queue and ready for Case Encoding.");
            

    }

    // Patient Lookup & Records (Master Database View linked to Section 9 PEP Progress)
    public function patientLookup(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('patients')
            ->leftJoin('inflow_general_particulars', 'patients.inflow_record_id', '=', 'inflow_general_particulars.inflow_record_id')
            ->leftJoin('bite_cases', 'patients.patient_id', '=', 'bite_cases.patient_id')
            ->leftJoin('bite_section3_exposure', 'bite_cases.bite_case_id', '=', 'bite_section3_exposure.bite_case_id')
            ->leftJoin('bite_section9_progress_notes', 'bite_cases.bite_case_id', '=', 'bite_section9_progress_notes.bite_case_id')
            ->select(
                'patients.patient_id',
                'patients.patient_name',
                'patients.age',
                'patients.sex',
                'patients.date_registered',
                'patients.inflow_record_id',
                'patients.contact_num',
                'patients.id_number',
                'patients.civil_status',
                'patients.philhealth_member',
                DB::raw('COALESCE(MAX(bite_cases.barangay), MAX(inflow_general_particulars.barangay), "N/A") as barangay'),
                DB::raw('MAX(bite_cases.bite_case_id) as bite_case_id'),
                DB::raw('MAX(bite_cases.case_number) as case_number'),
                DB::raw('MAX(bite_cases.date_verified) as last_visit'),
                DB::raw('MAX(bite_cases.category) as exposure_category'),
                DB::raw('MAX(bite_section3_exposure.animal_type) as animal_type'),
                DB::raw('MAX(bite_section3_exposure.bite_date_time) as bite_date_time'),
                DB::raw('MAX(bite_section3_exposure.animal_fate) as animal_fate'),
                DB::raw('MAX(bite_section9_progress_notes.day3_notes) as day3_notes'),
                DB::raw('MAX(bite_section9_progress_notes.day7_notes) as day7_notes'),
                DB::raw('MAX(bite_section9_progress_notes.day28_notes) as day28_notes')
            )
            ->groupBy(
                'patients.patient_id',
                'patients.patient_name',
                'patients.age',
                'patients.sex',
                'patients.date_registered',
                'patients.inflow_record_id',
                'patients.contact_num',
                'patients.id_number',
                'patients.civil_status',
                'patients.philhealth_member'
            );

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('patients.patient_name', 'LIKE', "%{$search}%")
                  ->orWhere('patients.patient_id', 'LIKE', "%{$search}%")
                  ->orWhere('patients.id_number', 'LIKE', "%{$search}%")
                  ->orWhere('patients.contact_num', 'LIKE', "%{$search}%")
                  ->orWhere('inflow_general_particulars.barangay', 'LIKE', "%{$search}%")
                  ->orWhere('bite_cases.barangay', 'LIKE', "%{$search}%");
            });
        }

        $patients = $query->orderBy('patients.date_registered', 'desc')
            ->paginate(4)
            ->withQueryString();

        $patients->getCollection()->transform(function ($patient) {
            if (!$patient->bite_case_id) {
                $patient->pep_status = 'No Case';
                $patient->pep_badge = 'bg-slate-100 text-slate-500';
            } elseif (!empty($patient->day28_notes)) {
                $patient->pep_status = 'Completed';
                $patient->pep_badge = 'bg-emerald-100 text-emerald-800';
            } elseif (!empty($patient->day7_notes)) {
                $patient->pep_status = 'Yes (D28)';
                $patient->pep_badge = 'bg-purple-100 text-purple-800';
            } elseif (!empty($patient->day3_notes)) {
                $patient->pep_status = 'Yes (D7)';
                $patient->pep_badge = 'bg-[#ffdbc8] text-[#743500]';
            } else {
                $patient->pep_status = 'Yes (D0)';
                $patient->pep_badge = 'bg-[#ffdad6] text-[#93000a]';
            }

            return $patient;
        });

        $totalDatabasePatients = DB::table('patients')->count();

        return view('staff.Patient_Lookup', compact('patients', 'search', 'totalDatabasePatients'));
    }

    public function newDashboard()
{
    // 1. Stats para iti agdama nga aldaw (Today)
    $totalRegistered = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->count();

    $verifiedCount = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('status', 'Verified')
        ->count();

    $pendingCount = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('status', 'Pending')
        ->count();

    // 2. Breakdown ti Priority ken Normal
    $priorityCount = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('queue_id', 'LIKE', 'P%')
        ->count();

    $normalCount = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('queue_id', 'LIKE', 'N%')
        ->count();

    $encodedCount = DB::table('inflow_general_particulars')
        ->whereDate('queue_date', today())
        ->where('status', 'Encoded')
        ->count();

    return view('staff.newdashboard', compact(
        'totalRegistered',
        'verifiedCount',
        'pendingCount',
        'priorityCount',
        'normalCount',
        'encodedCount'
    ));
    }
}