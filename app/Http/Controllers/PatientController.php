<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Audit;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function getReferralData($referral_id)
    {
        $referral = DB::table('bhw_referral_info')
            ->where('reference_no', $referral_id)
            ->where('status', 'Pending')
            ->first();

        if (!$referral) {
            return response()->json([
                'success' => false,
                'message' => 'Referral ID not found or has already been used.'
            ]);
        }

        $fullName = trim($referral->patient_name ?? '');
        $lastName = '';
        $firstName = '';
        $middleInitial = '';

        // Handle names formatted with a comma (e.g., "Dela Cruz, Juan, P." or "Dela Cruz, Juan P.")
        if (strpos($fullName, ',') !== false) {
            $parts = array_map('trim', explode(',', $fullName));
            $lastName = $parts[0];

            if (isset($parts[2])) {
                $firstName = $parts[1];
                $middleInitial = $parts[2];
            } elseif (isset($parts[1])) {
                $givenParts = explode(' ', $parts[1]);
                $lastWord = end($givenParts);
                if (strlen(trim($lastWord, '.')) === 1) {
                    $middleInitial = array_pop($givenParts);
                }
                $firstName = implode(' ', $givenParts);
            }
        } else {
            // Handle names formatted without a comma (e.g., "Juan P. Dela Cruz")
            $parts = explode(' ', $fullName);
            if (count($parts) > 1) {
                $lastName = array_pop($parts);
                $secondToLast = end($parts);
                if (strlen(trim($secondToLast, '.')) === 1) {
                    $middleInitial = array_pop($parts);
                }
                $firstName = implode(' ', $parts);
            } else {
                $firstName = $fullName;
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'last_name'       => $lastName,
                'first_name'      => $firstName,
                'middle_initial'  => str_replace('.', '', $middleInitial),
                'contact_number'  => $referral->contact_num ?? '',
                'date_of_birth'   => $referral->date_of_birth ?? '',
                'sex'             => strtolower($referral->gender ?? ''),
                'civil_status'    => strtolower($referral->civil_status ?? ''),
                'priority_status' => $referral->priority_status ?? 'None',
                'barangay'        => $referral->patient_barangay ?? ($referral->barangay ?? ''),
            ]
        ]);
    }

    /** Dose visits a returning patient can check in for (Day 0 was given at the first visit). */
    private const PRIMARY_DAYS = [3, 7, 14, 28];
    private const BOOSTER_DAYS = [3];

    /**
     * Returning Patient: find a patient by full name AND exact date of birth, then list the
     * unfinished bite case(s) they can come back for. Both are required, so the public page
     * cannot be used to browse patient records by name alone. Not found and ambiguous look the same.
     */
    public function search(Request $request)
    {
        $name = trim((string) $request->input('name', ''));
        $dob  = (string) $request->input('dob', '');

        $words = array_values(array_filter(
            preg_split('/[^a-z0-9]+/', strtolower(\Illuminate\Support\Str::ascii($name)), -1, PREG_SPLIT_NO_EMPTY),
            fn ($w) => strlen($w) >= 2
        ));

        if (count($words) < 2 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
            return response()->json(['found' => false]);
        }

        $matches = DB::table('patients')
            ->whereDate('date_of_birth', $dob)
            ->get()
            ->filter(function ($p) use ($words) {
                $stored = preg_split('/[^a-z0-9]+/', strtolower(\Illuminate\Support\Str::ascii($p->patient_name)), -1, PREG_SPLIT_NO_EMPTY);
                return count(array_diff($words, $stored)) === 0;
            })
            ->values();

        if ($matches->count() !== 1) {
            return response()->json(['found' => false]);
        }

        $patient = $matches->first();

        $cases = DB::table('bite_cases as bc')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->where('bc.patient_id', $patient->patient_id)
            ->whereNull('bc.outcome')
            ->whereNotNull('s7.day0_date')
            ->orderByDesc('bc.case_number')
            ->get(['bc.bite_case_id', 'bc.case_number', 'bc.category', 'bc.return_dose_day',
                's7.dose_type', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day14_date', 's7.day28_date'])
            ->map(fn ($c) => [
                'bite_case_id'   => $c->bite_case_id,
                'case_number'    => $c->case_number,
                'category'       => $c->category,
                'dose_type'      => $c->dose_type ?: 'Primary',
                'days'           => $c->dose_type === 'Booster' ? self::BOOSTER_DAYS : self::PRIMARY_DAYS,
                'dates'          => [
                    0  => $c->day0_date,
                    3  => $c->day3_date,
                    7  => $c->day7_date,
                    14 => $c->day14_date,
                    28 => $c->day28_date,
                ],
                'checked_in_for' => $c->return_dose_day,
            ])
            ->values();

        return response()->json([
            'found'   => true,
            'patient' => [
                'patient_name'  => $patient->patient_name,
                'date_of_birth' => $patient->date_of_birth,
                'sex'           => $patient->sex,
                'contact_num'   => $patient->contact_num,
            ],
            'cases'   => $cases,
            // Proves to the check-in step which patient was found (valid 30 minutes, tamper-proof)
            'token'   => encrypt(json_encode(['patient_id' => $patient->patient_id, 'exp' => now()->addMinutes(30)->timestamp])),
        ]);
    }

    /**
     * Returning Patient check-in for the next dose of the SAME bite case. The case is updated,
     * never duplicated: it goes back to the Health Workers' unclaimed pool marked with the dose
     * the patient came for. No queue number is issued.
     */
    public function storeReturning(Request $request)
    {
        $validated = $request->validate([
            'token'        => 'required|string',
            'bite_case_id' => 'required|integer',
            'dose_day'     => 'required|integer|in:3,7,14,28',
            'contact_num'  => 'nullable|string|max:20',
        ]);

        try {
            $proof = json_decode(decrypt($validated['token']), true);
        } catch (\Throwable $e) {
            $proof = null;
        }
        if (!$proof || ($proof['exp'] ?? 0) < now()->timestamp) {
            return redirect()->route('patient.returning-patient')
                ->withErrors(['token' => 'Your search expired. Please look up your record again.']);
        }

        $day = (int) $validated['dose_day'];

        return DB::transaction(function () use ($validated, $proof, $day) {
            $case = DB::table('bite_cases')
                ->where('bite_case_id', $validated['bite_case_id'])
                ->where('patient_id', $proof['patient_id'])
                ->whereNull('outcome')
                ->lockForUpdate()
                ->first();

            $s7 = $case ? DB::table('bite_section7_immunization')->where('bite_case_id', $case->bite_case_id)->first() : null;

            $allowed = $s7 && $s7->dose_type === 'Booster' ? self::BOOSTER_DAYS : self::PRIMARY_DAYS;

            if (!$case || !$s7 || !$s7->day0_date || !in_array($day, $allowed, true)) {
                return redirect()->route('patient.returning-patient')
                    ->withErrors(['token' => 'That dose cannot be checked in for. Please look up your record again.']);
            }

            if ($s7->{'day' . $day . '_date'}) {
                return redirect()->route('patient.returning-patient')
                    ->withErrors(['token' => "Day {$day} is already recorded as given."]);
            }

            // Same bite case, so it is only updated. Back to the pool, marked with the dose due.
            DB::table('bite_cases')->where('bite_case_id', $case->bite_case_id)->update([
                'assigned_health_worker_id' => null,
                'return_dose_day'           => $day,
                'returned_at'               => now(),
            ]);

            if (!empty($validated['contact_num'])) {
                DB::table('patients')->where('patient_id', $proof['patient_id'])
                    ->update(['contact_num' => $validated['contact_num']]);
            }

            $patient = DB::table('patients')->where('patient_id', $proof['patient_id'])->first();

            Audit::log('returning_checkin', "Patient {$proof['patient_id']} checked in for the Day {$day} dose of case #{$case->case_number}", 'Patient (self check-in)');

            return view('patient.returning_confirmation', [
                'patientName' => $patient->patient_name,
                'doseDay'     => $day,
            ]);
        });
    }

    // BHW-referral registration
    public function registerPatient(Request $request)
    {
        $validated = $request->validate([
            'bhw_referral_id'        => ['required', 'string', 'regex:/^BRY-\d{3}-\d{8}-\d{4}$/'],
            'full_name'              => 'required|string|max:100',
            'date_of_birth'          => 'required|date',
            'sex'                    => 'required|string|in:Male,Female,male,female',
            'civil_status'           => 'nullable|string|max:20',
            'contact_number'         => 'required|string|max:20',
            'barangay_of_incidence'  => 'required|string|max:100',
            'valid_id_number'        => 'nullable|string|max:50',
            'philhealth_member'      => 'required|in:yes,no',
            'philhealth_member_name' => 'nullable|string|max:100',
            'philhealth_member_dob'  => 'nullable|date',
            'current_illnesses'      => 'nullable|string',
            'known_allergies'        => 'nullable|string',
            'priority_status'        => 'nullable|string',
        ]);

        $referralCode = trim($validated['bhw_referral_id']);

        return DB::transaction(function () use ($referralCode, $validated) {

            // 1. Verify the code exists and is still Pending
            $validReferral = DB::table('bhw_referral_info')
                ->where('reference_no', $referralCode)
                ->where('status', 'Pending')
                ->lockForUpdate()
                ->first();

            if (!$validReferral) {
                return back()
                    ->withErrors(['bhw_referral_id' => 'Referral code is invalid or has already been used.'])
                    ->withInput();
            }

            $age = \Carbon\Carbon::parse($validated['date_of_birth'])->age;
            $isPriority = ($validated['priority_status'] ?? 'none') !== 'none';
            $isPhilhealthMember = $validated['philhealth_member'] === 'yes';
            $normalizedSex = ucfirst(strtolower($validated['sex']));
            $normalizedCivilStatus = ucfirst(strtolower($validated['civil_status'] ?? 'Single'));
            $queueDate = now()->toDateString();

            // 2. Queue entry
            $prefix = $isPriority ? 'P' : 'N';
            $countToday = DB::table('inflow_general_particulars')
                ->where('queue_date', $queueDate)
                ->where('queue_id', 'LIKE', $prefix . '%')
                ->lockForUpdate()
                ->count();
            $queueId = $prefix . ($countToday + 1);

            $inflowRecordId = DB::table('inflow_general_particulars')->insertGetId([
                'queue_id'          => $queueId,
                'queue_date'        => $queueDate,
                'id_number'         => $validated['valid_id_number'] ?? null,
                'bhw_referral_id'   => $referralCode,
                'patient_name'      => $validated['full_name'],
                'age'               => $age,
                'sex'               => $normalizedSex,
                'date_of_birth'     => $validated['date_of_birth'],
                'civil_status'      => $normalizedCivilStatus,
                'contact_num'       => $validated['contact_number'],
                'barangay'          => $validated['barangay_of_incidence'],
                'philhealth_member' => $isPhilhealthMember,
                'philhealth_name'   => $validated['philhealth_member_name'] ?? null,
                'philhealth_dob'    => $validated['philhealth_member_dob'] ?? null,
                'reg_date'          => now(),
                'status'            => 'Pending',
            ]);

            // 3. Insert the permanent identity record into PATIENTS
            $patientId = $this->generatePatientId($validated['date_of_birth']);

            DB::table('patients')->insert([
                'patient_id'        => $patientId,
                'inflow_record_id'  => $inflowRecordId,
                'patient_name'      => $validated['full_name'],
                'age'               => $age,
                'sex'               => $normalizedSex,
                'date_of_birth'     => $validated['date_of_birth'],
                'civil_status'      => $normalizedCivilStatus,
                'contact_num'       => $validated['contact_number'],
                'id_number'         => $validated['valid_id_number'] ?? null,
                'philhealth_member' => $isPhilhealthMember,
                'philhealth_name'   => $validated['philhealth_member_name'] ?? null,
                'philhealth_dob'    => $validated['philhealth_member_dob'] ?? null,
                'illness_history'   => $validated['current_illnesses'] ?? null,
                'allergy_history'   => $validated['known_allergies'] ?? null,
                'date_registered'   => now(),
            ]);

            // 4. Lock the referral so it cannot be used again
            DB::table('bhw_referral_info')
                ->where('referral_id', $validReferral->referral_id)
                ->update([
                    'status'     => 'Received',
                    'updated_at' => now(),
                ]);

            // 5. Link the referral to the new bite case
            DB::table('bite_cases')->insert([
                'patient_id'       => $patientId,
                'inflow_record_id' => $inflowRecordId,
                'barangay'         => $validated['barangay_of_incidence'],
                'category'         => 'Pending',
                'bhw_referral_id'  => $validReferral->referral_id,
                'date_verified'    => now(),
            ]);

            // 6. Return queue confirmation view
            return $isPriority
                ? view('patient.PQ_confirmation', ['queueNumber' => $queueId])
                : view('patient.NQ_confirmation', ['queueNumber' => $queueId]);
        });
    }

    private function generatePatientId(string $dateOfBirth): string
    {
        $today = now()->format('Ymd');
        $dob = \Carbon\Carbon::parse($dateOfBirth)->format('Ymd');

        $countToday = DB::table('patients')
            ->where('patient_id', 'LIKE', "CEB-{$today}-%")
            ->count();

        $seq = str_pad((string) ($countToday + 1), 4, '0', STR_PAD_LEFT);

        return "CEB-{$today}-{$dob}-{$seq}";
    }
}