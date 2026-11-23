<?php

namespace App\Http\Controllers;

use App\Support\Audit;
use App\Support\PepSchedule;
use App\Support\PhilhealthStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffController extends Controller
{
    /** The results Staff can record for a PhilHealth check (inflow_general_particulars.philhealth_verification). */
    public const PHILHEALTH_RESULTS = ['Verified', 'Not a Member', 'Expired'];

    /**
     * The PhilHealth flag stored on the patient: the patient said "member" AND Staff did not find them to be a
     * non-member or expired.
     */
    private function philhealthFlag(object $inflow): int
    {
        $checked = $inflow->philhealth_verification ?? null;

        return ($inflow->philhealth_member && !in_array($checked, ['Not a Member', 'Expired'], true)) ? 1 : 0;
    }


    // ------------------------------------------------------------------------------------------------------------
    // One Patient ID per person
    // ------------------------------------------------------------------------------------------------------------

    /** The words of a name that identify a person: lower case, no accents or punctuation, initials left out. */
    private function nameWords(?string $name): array
    {
        $words = preg_split('/[^a-z0-9]+/', strtolower(\Illuminate\Support\Str::ascii((string) $name)), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_values(array_unique(array_filter($words, fn ($w) => strlen($w) >= 2)));
        sort($words);

        return $words;
    }

    /**
     * The patient who already has a Patient ID: same date of birth AND the same name (word for word, in any order,
     * ignoring initials). If an old duplicate exists, the oldest record (the original ID) wins.
     */
    private function existingPatient(?string $name, $dob): ?object
    {
        $words = $this->nameWords($name);
        if (count($words) < 2 || empty($dob)) {
            return null;   // too little to tell people apart safely: a new patient
        }

        return DB::table('patients')
            ->whereDate('date_of_birth', \Carbon\Carbon::parse($dob)->toDateString())
            ->orderBy('date_registered')
            ->get()
            ->first(fn ($p) => $this->nameWords($p->patient_name) === $words);
    }

    /**
     * Registers a verified walk-in with its patient and links the two (inflow_general_particulars.patient_id).
     *
     * A person who registers again for a NEW bite keeps their Patient ID: the existing patient is reused (and its
     * contact details refreshed), and only a new bite case is created later in Case Encoding (case #2, #3, ...), so the
     * earlier cases and their doses are never touched or mixed in. Anyone else gets a new Patient ID.
     *
     * $p keys: name, dob, age, sex, civil_status, contact_num, id_number, philhealth (flag), philhealth_name,
     * philhealth_dob, illness, allergy. A null value is "not known here" and never overwrites what is on file.
     *
     * @return array{0:string,1:bool,2:int} [patient_id, was an existing patient, the case number this visit will get]
     */
    private function registerPatient(string $inflowId, array $p): array
    {
        $existing = $this->existingPatient($p['name'], $p['dob']);

        if ($existing) {
            $patientId = $existing->patient_id;
            $refresh = array_filter([
                'age'               => $p['age'] ?? null,
                'civil_status'      => $p['civil_status'] ?? null,
                'contact_num'       => $p['contact_num'] ?? null,
                'id_number'         => $p['id_number'] ?? null,
                'philhealth_member' => $p['philhealth'] ?? null,
                'philhealth_name'   => $p['philhealth_name'] ?? null,
                'philhealth_dob'    => $p['philhealth_dob'] ?? null,
                'illness_history'   => $p['illness'] ?? null,
                'allergy_history'   => $p['allergy'] ?? null,
            ], fn ($v) => $v !== null);
            if ($refresh) {
                DB::table('patients')->where('patient_id', $patientId)->update($refresh);
            }
        } else {
            $regDate = now()->format('Ymd');
            $dob = \Carbon\Carbon::parse($p['dob'])->format('Ymd');
            $count = DB::table('patients')->where('patient_id', 'LIKE', "CEB-{$regDate}-{$dob}-%")->count();
            $patientId = "CEB-{$regDate}-{$dob}-" . str_pad((string) ($count + 1), 3, '0', STR_PAD_LEFT);

            DB::table('patients')->insert([
                'patient_id'        => $patientId,
                'inflow_record_id'  => $inflowId,
                'date_registered'   => now(),
                'patient_name'      => $p['name'],
                'age'               => $p['age'] ?? null,
                'sex'               => $p['sex'] ?? null,
                'date_of_birth'     => $p['dob'],
                'civil_status'      => $p['civil_status'] ?? null,
                'contact_num'       => $p['contact_num'] ?? null,
                'id_number'         => $p['id_number'] ?? null,
                'philhealth_member' => $p['philhealth'] ?? 0,
                'philhealth_name'   => $p['philhealth_name'] ?? null,
                'philhealth_dob'    => $p['philhealth_dob'] ?? null,
                'illness_history'   => $p['illness'] ?? null,
                'allergy_history'   => $p['allergy'] ?? null,
            ]);
        }

        DB::table('inflow_general_particulars')->where('inflow_record_id', $inflowId)->update(['patient_id' => $patientId]);
        $caseNumber = (int) DB::table('bite_cases')->where('patient_id', $patientId)->max('case_number') + 1;

        return [$patientId, (bool) $existing, $caseNumber];
    }

    /** The message Staff sees after verifying: a returning patient is called out, and the visit is a NEW case. */
    private function verifiedMessage(string $patientId, bool $existing, int $caseNumber, string $tail): string
    {
        return $existing
            ? "Existing patient found: {$patientId} keeps the same Patient ID. This visit will be saved as a NEW case (#{$caseNumber}); the earlier cases are not changed. {$tail}"
            : $tail;
    }

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

        // BHW referrals still waiting for the patient to arrive (listed in their own section of the page)
        $bhwReferrals = DB::table('bhw_referral_info')
            ->leftJoin('bhw_referral_exposure', 'bhw_referral_info.referral_id', '=', 'bhw_referral_exposure.referral_id')
            ->where('bhw_referral_info.status', 'Pending')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('bhw_referral_info.patient_name', 'LIKE', "%{$search}%")
                        ->orWhere('bhw_referral_info.reference_no', 'LIKE', "%{$search}%");
                });
            })
            ->select('bhw_referral_info.*', 'bhw_referral_exposure.exposure_category')
            ->orderBy('bhw_referral_info.submitted_at')
            ->get();

        return view('staff.Patient_Verification', compact('priorityQueue', 'normalQueue', 'search', 'selectedPatient', 'bhwReferrals'));
    }

    /**
     * "Verify Attendance & Transfer" on a pending BHW referral: the referred patient is at the
     * counter, so Staff skip the self-registration queue. The walk-in record is created already
     * Verified (carrying the referral code, which Case Encoding uses to link the bite case), the
     * permanent patients row is created, and the referral is marked Received so the code cannot
     * be used a second time. The bite case itself is created later, in Case Encoding.
     */
    public function verifyBhwReferral(int $referral_id)
    {
        return DB::transaction(function () use ($referral_id) {
            $referral = DB::table('bhw_referral_info')
                ->where('referral_id', $referral_id)
                ->where('status', 'Pending')
                ->lockForUpdate()
                ->first();

            if (!$referral) {
                return back()->withErrors(['error' => 'Referral not found or already processed.']);
            }

            $isPriority = !in_array(strtolower((string) ($referral->priority_status ?? 'none')), ['', 'none'], true);
            $prefix = $isPriority ? 'P' : 'N';
            $queueDate = now()->toDateString();

            $maxSeq = DB::table('inflow_general_particulars')
                ->where('queue_date', $queueDate)
                ->where('queue_id', 'LIKE', $prefix . '%')
                ->lockForUpdate()
                ->selectRaw('MAX(CAST(SUBSTRING(queue_id, 2) AS UNSIGNED)) as m')
                ->value('m');
            $queueId = $prefix . ((int) $maxSeq + 1);

            $inflowId = DB::table('inflow_general_particulars')->insertGetId([
                'queue_id'          => $queueId,
                'queue_date'        => $queueDate,
                'bhw_referral_id'   => $referral->reference_no,
                'patient_name'      => $referral->patient_name,
                'age'               => $referral->age,
                'sex'               => ucfirst(strtolower((string) $referral->gender)),
                'date_of_birth'     => $referral->date_of_birth,
                'civil_status'      => $referral->civil_status,
                'contact_num'       => $referral->contact_num,
                'barangay'          => $referral->patient_barangay,
                'philhealth_member' => 0,
                'reg_date'          => now(),
                'status'            => 'Verified',
            ], 'inflow_record_id');

            // the referral does not say anything about PhilHealth, so an existing patient's PhilHealth is left as it is
            [$patientId, $returning, $caseNumber] = $this->registerPatient((string) $inflowId, [
                'name'         => $referral->patient_name,
                'dob'          => $referral->date_of_birth,
                'age'          => $referral->age,
                'sex'          => ucfirst(strtolower((string) $referral->gender)),
                'civil_status' => $referral->civil_status,
                'contact_num'  => $referral->contact_num,
            ]);

            DB::table('bhw_referral_info')
                ->where('referral_id', $referral->referral_id)
                ->update(['status' => 'Received', 'updated_at' => now()]);

            return redirect()->route('staff.patient-verification')
                ->with('success', $this->verifiedMessage($patientId, $returning, $caseNumber, 'Referral verified. The patient is now in Case Encoding.'));
        });
    }

    public function verifyAttendance(string $inflow_record_id)
    {
        $inflow = DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->first();

        if (!$inflow) {
            return back()->withErrors(['error' => 'Record not found.']);
        }

        // Only link this registration to a patient once (a second click must not register it again)
        $returning = false;
        $caseNumber = 1;
        $patientId = $inflow->patient_id;
        if (!$patientId) {
            $otherData = DB::table('inflow_other_personal_data')
                ->where('inflow_record_id', $inflow_record_id)
                ->first();

            [$patientId, $returning, $caseNumber] = $this->registerPatient((string) $inflow_record_id, [
                'name'            => $inflow->patient_name,
                'dob'             => $inflow->date_of_birth,
                'age'             => $inflow->age,
                'sex'             => $inflow->sex,
                'civil_status'    => $inflow->civil_status,
                'contact_num'     => $inflow->contact_num,
                'id_number'       => $inflow->id_number,
                'philhealth'      => $this->philhealthFlag($inflow),
                'philhealth_name' => $inflow->philhealth_name,
                'philhealth_dob'  => $inflow->philhealth_dob,
                'illness'         => $otherData->illness_history ?? null,
                'allergy'         => $otherData->allergy_history ?? null,
            ]);
        }

        DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->update(['status' => 'Verified']);

        return redirect()->route('staff.patient-verification')
            ->with('success', $this->verifiedMessage($patientId, $returning, $caseNumber, 'Patient verified and moved to Case Encoding.'));
    }

    // Case Encoding page — show Verified records awaiting encoding
    public function caseEncoding(Request $request, $inflow_record_id = null)
    {
        $search = $request->input('search');

        $query = DB::table('inflow_general_particulars')
            ->join('patients', 'inflow_general_particulars.patient_id', '=', 'patients.patient_id')
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

        // A record opened from Patient Lookup is usually not in the Verified queue any more (its encoding is done and
        // it was handed to the Health Worker): load it directly so the form shows what was saved, and show it in the
        // list on the left instead of leaving the page empty.
        $openedRecord = null;
        if ($inflow_record_id && !$selectedPatient) {
            $openedRecord = DB::table('inflow_general_particulars')
                ->join('patients', 'inflow_general_particulars.patient_id', '=', 'patients.patient_id')
                ->where('inflow_general_particulars.inflow_record_id', $inflow_record_id)
                ->select('inflow_general_particulars.*', 'patients.patient_id')
                ->first();
            $selectedPatient = $openedRecord;
        }
        // Handed to the Health Worker (status Encoded): Staff only views it
        $readOnly = $selectedPatient && ($selectedPatient->status ?? null) !== 'Verified';

        $bhwExposure = null;
        if ($selectedPatient && !empty($selectedPatient->bhw_referral_id)) {
            $bhwExposure = DB::table('bhw_referral_info')
                ->join('bhw_referral_exposure', 'bhw_referral_info.referral_id', '=', 'bhw_referral_exposure.referral_id')
                ->where('bhw_referral_info.reference_no', $selectedPatient->bhw_referral_id)
                ->select('bhw_referral_info.referral_id', 'bhw_referral_exposure.*')
                ->first();
        }

        $healthworkers = DB::table('users')
            ->where('role', 'Health Worker')
            ->where('is_active', 1)
            ->select('user_id', 'full_name')
            ->orderBy('full_name')
            ->get();


        // A patient who registered before keeps their Patient ID: say so, and list the earlier cases (this visit is a NEW case)
        $earlierCases = collect();
        $thisCaseNumber = null;
        if ($selectedPatient && !empty($selectedPatient->patient_id)) {
            $thisCaseNumber = DB::table('bite_cases')->where('inflow_record_id', $selectedPatient->inflow_record_id)->value('case_number')
                ?? ((int) DB::table('bite_cases')->where('patient_id', $selectedPatient->patient_id)->max('case_number') + 1);
            $earlierCases = DB::table('bite_cases as bc')
                ->leftJoin('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
                ->where('bc.patient_id', $selectedPatient->patient_id)
                ->where(fn ($q) => $q->whereNull('bc.inflow_record_id')->orWhere('bc.inflow_record_id', '<>', $selectedPatient->inflow_record_id))
                ->orderByDesc('bc.case_number')
                ->get(['bc.case_number', 'bc.date_verified', 'bc.outcome', 's7.dose_type', 's7.route', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day14_date', 's7.day28_date'])
                ->map(function ($c) {
                    $next = $c->day0_date ? PepSchedule::nextDay($c->dose_type, $c->route, $c) : null;
                    $c->status = ($c->outcome && str_starts_with($c->outcome, 'Discharged')) ? 'Discharged'
                        : ($c->outcome === 'Incomplete' ? 'Past record'
                        : (!$c->day0_date ? 'Not vaccinated yet' : ($next === null ? 'Course complete' : 'Day ' . $next . ' dose still due')));
                    $c->open = in_array($c->status, ['Not vaccinated yet'], true) || str_ends_with($c->status, 'still due');

                    return $c;
                });
        }

        // Progress saved earlier with "Save Progress", so the form shows it again instead of starting blank
        $saved = null;
        if ($selectedPatient) {
            $draftCase = DB::table('bite_cases')->where('inflow_record_id', $selectedPatient->inflow_record_id)->first();
            if ($draftCase) {
                $saved = (object) [
                    's3'       => DB::table('bite_section3_exposure')->where('bite_case_id', $draftCase->bite_case_id)->first(),
                    's4'       => DB::table('bite_section4_wound_treatment')->where('bite_case_id', $draftCase->bite_case_id)->first(),
                    's5'       => DB::table('bite_section5_prior_arv')->where('bite_case_id', $draftCase->bite_case_id)->first(),
                    'assigned' => $draftCase->assigned_health_worker_id,
                ];
            }
        }

        return view('staff.Case_Encoding', compact('earlierCases', 'thisCaseNumber', 'verifiedQueue', 'selectedPatient', 'openedRecord', 'readOnly', 'search', 'bhwExposure', 'healthworkers', 'saved'));
    }

    public function storeCaseEncoding(Request $request, string $inflow_record_id)
    {
        $registrationPatientId = DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->value('patient_id');
        $patient = $registrationPatientId ? DB::table('patients')->where('patient_id', $registrationPatientId)->first() : null;

        if (!$patient) {
            return back()->withErrors(['error' => 'Patient record not found. Please verify attendance first.']);
        }

        // Once the case has been handed to the Health Worker (status Encoded) Staff can only view it
        $currentStatus = DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->value('status');
        if ($currentStatus !== 'Verified') {
            return redirect()->route('staff.case-encoding', $inflow_record_id)
                ->withErrors(['error' => 'This case was already handed to the Health Worker, so it can no longer be edited here.']);
        }

        $isComplete = $request->input('action') === 'complete';

        if ($isComplete && !in_array($request->input('pet_status'), ['Pet', 'Stray'], true)) {
            return back()->withErrors(['error' => 'Please select if the animal is a Pet or Stray.'])->withInput();
        }

        if ($isComplete && $request->input('prev_arv_given') === '1') {
            $hasDoseDate = $request->filled('dose1_date') || $request->filled('dose2_date') || $request->filled('dose3_date') || $request->filled('booster_date');
            if (!$hasDoseDate) {
                return back()->withErrors(['error' => 'Please provide at least one dose date since "Previously Vaccinated" is set to Yes.'])->withInput();
            }
        }

        // Save Progress may be incomplete; Complete Encoding needs the core exposure facts
        if ($isComplete) {
            $request->validate([
                'animal_type' => 'required|string|max:50',
                'bite_date'   => 'required|date|before_or_equal:today',
            ], [
                'animal_type.required' => 'Please choose the animal type before completing.',
                'bite_date.required'   => 'Please enter the date of the bite before completing.',
            ]);
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

            // Look up integer referral_id if this inflow came from a BHW referral
            $bhwReferralId = null;
            if (!empty($inflow->bhw_referral_id)) {
                $bhwReferralId = DB::table('bhw_referral_info')
                    ->where('reference_no', $inflow->bhw_referral_id)
                    ->value('referral_id');
            }

            // Get or create the bite_cases record for this patient
            $biteCase = DB::table('bite_cases')->where('inflow_record_id', $inflow_record_id)->first();

            if (!$biteCase) {
                $caseNumber = DB::table('bite_cases')->where('patient_id', $patient->patient_id)->max('case_number') + 1;

                $biteCaseId = DB::table('bite_cases')->insertGetId([
                    'patient_id'        => $patient->patient_id,
                    'inflow_record_id'  => $inflow_record_id,
                    'bhw_referral_id'   => $bhwReferralId,
                    'case_number'       => $caseNumber,
                    'date_verified'     => now(),
                    'barangay'          => $inflow->barangay ?? 'Unknown',
                    'category'          => $category,
                    'philhealth_status' => ($inflow->philhealth_verification ?? null) === 'Expired' ? 'Expired' : ($patient->philhealth_member ? 'Member' : 'Non-member'),
                ], 'bite_case_id');

                if ($bhwReferralId) {
                    DB::table('bhw_referral_info')
                        ->where('referral_id', $bhwReferralId)
                        ->update(['bite_case_id' => $biteCaseId]);
                }
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
                    // A draft can still be missing these, so blank is stored as NULL (never a made-up value)
                    'animal_type'       => $request->input('animal_type') ?: null,
                    'animal_type_other' => $request->input('animal_type_other'),
                    'animal_ownership'  => in_array($request->input('pet_status'), ['Pet', 'Stray'], true) ? $request->input('pet_status') : null,
                    'bite_date_time'    => $request->filled('bite_date')
                        ? $request->input('bite_date') . ($request->input('bite_time') ? ' ' . $request->input('bite_time') : ' 00:00:00')
                        : null,
                    'animal_vax_status' => $request->input('animal_vax_status'),
                    'animal_vax_date'   => $request->input('animal_vax_date') ?: null,
                    'animal_fate'       => $request->input('fate'),
                    'obs_14_days'       => $request->input('obs_14_days') ?: null,
                    'exposure_type'     => implode(', ', $request->input('exposure_type', [])) ?: null,
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

            if ($request->filled('assigned_health_worker_id')) {
                DB::table('bite_cases')
                    ->where('bite_case_id', $biteCaseId)
                    ->update(['assigned_health_worker_id' => $request->input('assigned_health_worker_id')]);
            }

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

    /**
     * PhilHealth Verification: Staff records what they found for a patient who said they are a PhilHealth member.
     * The result is kept on the registration (inflow) record, and the patient's PhilHealth flag and the case's status
     * follow it, so Patient Lookup and the Health Worker's database show the checked answer.
     */
    public function verifyPhilhealth(Request $request, string $inflow_record_id)
    {
        $data = $request->validate([
            'result' => 'required|in:' . implode(',', self::PHILHEALTH_RESULTS),
        ], ['result.required' => 'Please choose a result.', 'result.in' => 'Please choose a valid result.']);

        $inflow = DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->first();
        if (!$inflow || !$inflow->philhealth_member) {
            return back()->withErrors(['error' => 'That patient did not say they are a PhilHealth member.']);
        }

        $result = $data['result'];
        DB::transaction(function () use ($inflow_record_id, $result, $inflow) {
            DB::table('inflow_general_particulars')->where('inflow_record_id', $inflow_record_id)->update([
                'philhealth_verification' => $result,
                'philhealth_verified_at'  => now(),
                'philhealth_verified_by'  => Auth::user()->full_name ?? null,
            ]);

            // the patient and the case, if they already exist
            if ($inflow->patient_id) {
                DB::table('patients')->where('patient_id', $inflow->patient_id)
                    ->update(['philhealth_member' => $result === 'Verified' ? 1 : 0]);
            }
            DB::table('bite_cases')->where('inflow_record_id', $inflow_record_id)
                ->update(['philhealth_status' => ['Verified' => 'Member', 'Not a Member' => 'Non-member', 'Expired' => 'Expired'][$result]]);
        });

        Audit::log('philhealth_verified', "PhilHealth check for {$inflow->patient_name} (record #{$inflow_record_id}): {$result}");

        return redirect()->route('staff.newdashboard')
            ->with('success', "PhilHealth recorded for {$inflow->patient_name}: " . ['Verified' => 'verified member', 'Not a Member' => 'not a member', 'Expired' => 'membership expired'][$result] . '.');
    }

    public function callPatient(string $inflow_record_id)
    {
        $inflow = DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->first();

        if (!$inflow) {
            return back()->withErrors(['error' => 'Record not found.']);
        }

        // Link this registration to its patient once (the existing patient is reused when the person registered before)
        $returning = false;
        $caseNumber = 1;
        $patientId = $inflow->patient_id;
        if (!$patientId) {
            $otherData = DB::table('inflow_other_personal_data')
                ->where('inflow_record_id', $inflow_record_id)
                ->first();

            [$patientId, $returning, $caseNumber] = $this->registerPatient((string) $inflow_record_id, [
                'name'            => $inflow->patient_name,
                'dob'             => $inflow->date_of_birth,
                'age'             => $inflow->age,
                'sex'             => $inflow->sex,
                'civil_status'    => $inflow->civil_status,
                'contact_num'     => $inflow->contact_num,
                'id_number'       => $inflow->id_number,
                'philhealth'      => $this->philhealthFlag($inflow),
                'philhealth_name' => $inflow->philhealth_name,
                'philhealth_dob'  => $inflow->philhealth_dob,
                'illness'         => $otherData->illness_history ?? null,
                'allergy'         => $otherData->allergy_history ?? null,
            ]);
        }

        DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->update(['status' => 'Verified']);

        return redirect()->route('staff.dashboard')
            ->with('success', $this->verifiedMessage($patientId, $returning, $caseNumber, "Patient {$inflow->patient_name} verified! Ticket removed from queue and ready for Case Encoding."));
    }

    // Patient Lookup & Records (Master Database View linked to Section 9 PEP Progress)
    public function patientLookup(Request $request)
    {
        $search = $request->input('search');

        // PhilHealth: what the patient said (registration step 3) and what Staff found (PhilHealth Verification on the dashboard)
        $philhealthChecked = Schema::hasColumn('inflow_general_particulars', 'philhealth_verification');

        // A patient can have several bite cases: Patient Lookup shows the LATEST one (its dates, notes and status), so an
        // earlier case of the same Patient ID is never mixed in. "View Case" / "Open Full Case Editor" open that case.
        $query = DB::table('patients')
            ->leftJoin('bite_cases', function ($j) {
                $j->on('patients.patient_id', '=', 'bite_cases.patient_id')
                    ->whereRaw('bite_cases.case_number = (SELECT MAX(lc.case_number) FROM bite_cases lc WHERE lc.patient_id = patients.patient_id)');
            })
            ->leftJoin('inflow_general_particulars', 'inflow_general_particulars.inflow_record_id', '=', DB::raw('COALESCE(bite_cases.inflow_record_id, patients.inflow_record_id)'))
            ->leftJoin('bite_section3_exposure', 'bite_cases.bite_case_id', '=', 'bite_section3_exposure.bite_case_id')
            ->leftJoin('bite_section9_progress_notes', 'bite_cases.bite_case_id', '=', 'bite_section9_progress_notes.bite_case_id')
            ->select(
                'patients.patient_id',
                'patients.patient_name',
                'patients.age',
                'patients.sex',
                'patients.date_registered',
                'patients.contact_num',
                'patients.id_number',
                'patients.civil_status',
                'patients.philhealth_member',
                DB::raw('MAX(COALESCE(bite_cases.inflow_record_id, patients.inflow_record_id)) as inflow_record_id'),
                DB::raw('(SELECT COUNT(*) FROM bite_cases cc WHERE cc.patient_id = patients.patient_id) as case_count'),
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
                DB::raw('MAX(bite_section9_progress_notes.day28_notes) as day28_notes'),
                DB::raw('MAX(inflow_general_particulars.philhealth_member) as ph_claimed'),
                $philhealthChecked
                    ? DB::raw('MAX(inflow_general_particulars.philhealth_verification) as ph_verification')
                    : DB::raw('NULL as ph_verification')
            )
            ->groupBy(
                'patients.patient_id',
                'patients.patient_name',
                'patients.age',
                'patients.sex',
                'patients.date_registered',
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
            // PhilHealth status shown on the row and in the case summary
            [$patient->ph_label, $patient->ph_class] = PhilhealthStatus::badge($patient->ph_claimed, $patient->ph_verification, $patient->philhealth_member);

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
        // 1. Stats para sa kasamtangang adlaw (Today)
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

        // 2. Breakdown sa Priority ug Normal
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

        // 3. Follow-Up Inflow Queries (Para sa Day 3, Day 7, Day 28 ug Name Lists sa ubos)
        $targetDay3  = now()->subDays(3)->toDateString();
        $targetDay7  = now()->subDays(7)->toDateString();
        $targetDay28 = now()->subDays(28)->toDateString();

        $patientsDay3 = DB::table('inflow_general_particulars')
            ->whereDate('reg_date', $targetDay3)
            ->get();

        $patientsDay7 = DB::table('inflow_general_particulars')
            ->whereDate('reg_date', $targetDay7)
            ->get();

        $patientsDay28 = DB::table('inflow_general_particulars')
            ->whereDate('reg_date', $targetDay28)
            ->get();

        $dueDay3Count  = $patientsDay3->count();
        $dueDay7Count  = $patientsDay7->count();
        $dueDay28Count = $patientsDay28->count();

        // 3b. PhilHealth Verification: patients who said (registration form, step 3) that they are a PhilHealth member and
        // have not been checked yet. (Skipped until the migration that adds the verification columns has been run.)
        $philhealthReady = Schema::hasColumn('inflow_general_particulars', 'philhealth_verification');
        $philhealthTotal = 0;
        $philhealthPending = collect();
        if ($philhealthReady) {
            $pendingPhilhealth = fn () => DB::table('inflow_general_particulars as ig')
                ->where('ig.philhealth_member', 1)
                ->whereNull('ig.philhealth_verification');
            $philhealthTotal = $pendingPhilhealth()->count();
            $philhealthPending = $pendingPhilhealth()
                ->leftJoin('patients as p', 'p.patient_id', '=', 'ig.patient_id')
                ->orderByDesc('ig.queue_date')->orderByDesc('ig.inflow_record_id')
                ->limit(5)
                ->get(['ig.inflow_record_id', 'ig.patient_name', 'ig.queue_id', 'ig.queue_date', 'ig.philhealth_name', 'ig.philhealth_dob', 'p.patient_id']);
        }

        // 4. I-compact ang tanang kinahanglanon sa view
        return view('staff.newdashboard', compact(
            'philhealthReady',
            'philhealthTotal',
            'philhealthPending',
            'totalRegistered',
            'verifiedCount',
            'pendingCount',
            'priorityCount',
            'normalCount',
            'encodedCount',
            'dueDay3Count',
            'dueDay7Count',
            'dueDay28Count',
            'patientsDay3',
            'patientsDay7',
            'patientsDay28'
        ));
    }
}
