<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    // Search for an existing patient by name or ID
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        $words = array_filter(
            preg_split('/[\s,]+/', $query),
            fn($w) => mb_strlen($w) >= 2
        );

        $patient = DB::table('inflow_general_particulars')
            ->where(function ($q) use ($words, $query) {
                if (count($words) > 0) {
                    foreach ($words as $word) {
                        $q->where('patient_name', 'LIKE', "%{$word}%");
                    }
                } else {
                    $q->where('patient_name', 'LIKE', "%{$query}%");
                }
            })
            ->orWhere('inflow_record_id', $query)
            ->orWhere('id_number', $query)
            ->orderBy('reg_date', 'desc')
            ->first();

        if (!$patient) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'patient' => [
                'patient_id'    => $patient->inflow_record_id,
                'patient_name'  => $patient->patient_name,
                'date_of_birth' => $patient->date_of_birth,
                'sex'           => $patient->sex,
                'age'           => $patient->age,
                'id_number'     => $patient->id_number,
            ],
        ]);
    }

    public function storeReturning(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|string',
            'contact_num'       => 'required|string|max:20',
            'civil_status'      => 'nullable|string|max:20',
            'philhealth_member' => 'required|boolean',
            'barangay'          => 'required|string|max:100',
            'priority_status'   => 'nullable|string',
        ]);

        $patient = DB::table('inflow_general_particulars')->where('inflow_record_id', $validated['patient_id'])->first();

        if (!$patient) {
            return back()->withErrors(['patient_id' => 'Patient record not found.']);
        }

        $isPriority = ($validated['priority_status'] ?? 'none') !== 'none';
        $prefix = $isPriority ? 'P' : 'N';
        $queueDate = now()->toDateString();

        $countToday = DB::table('inflow_general_particulars')
            ->where('queue_date', $queueDate)
            ->where('queue_id', 'LIKE', $prefix . '%')
            ->count();
        $queueId = $prefix . ($countToday + 1);

        DB::table('inflow_general_particulars')->insert([
            'queue_id'          => $queueId,
            'queue_date'        => $queueDate,
            'id_number'         => $patient->id_number,
            'patient_name'      => $patient->patient_name,
            'age'               => $patient->age,
            'sex'               => $patient->sex,
            'date_of_birth'     => $patient->date_of_birth,
            'civil_status'      => $validated['civil_status'] ?? 'Single',
            'contact_num'       => $validated['contact_num'],
            'barangay'          => $validated['barangay'],
            'philhealth_member' => $validated['philhealth_member'],
            'reg_date'          => now(),
            'status'            => 'Pending',
        ]);

        return $isPriority
            ? view('patient.PQ_confirmation', ['queueNumber' => $queueId])
            : view('patient.NQ_confirmation', ['queueNumber' => $queueId]);
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