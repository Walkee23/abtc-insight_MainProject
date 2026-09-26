<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // Search for an existing patient by name or ID
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        // Names are stored as "Surname, Given Name, M.I." but people naturally
        // type them as "Given Name M.I. Surname" - so split into words and
        // require each one to appear somewhere in patient_name, regardless of order.
        $words = array_filter(
            preg_split('/[\s,]+/', $query),
            fn($w) => mb_strlen($w) >= 2
        );

        // Walk-in registrations live in inflow_general_particulars, not patients
        // (patients only gets a row once ABTC staff verifies the record)
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
                // aliased to patient_id so the existing frontend JS doesn't need changes
                'patient_id' => $patient->inflow_record_id,
                'patient_name' => $patient->patient_name,
                'date_of_birth' => $patient->date_of_birth,
                'sex' => $patient->sex,
                'age' => $patient->age,
                'id_number' => $patient->id_number,
            ],
        ]);
    }

    public function storeReturning(Request $request)
    {
        $validated = $request->validate([
            'patient_id'         => 'required|string', // actually an inflow_record_id, see search() above
            'contact_num'        => 'required|string|max:20',
            'civil_status'       => 'nullable|string|max:20',
            'philhealth_member'  => 'required|boolean',
            'barangay'           => 'required|string|max:100',
            'priority_status'    => 'nullable|string',
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

    // BHW-referral registration (from main)
    public function registerPatient(Request $request)
    {
        // The form field is named `bhw_referral_id` (see
        // New_Record_Registration.blade.php), not `reference_no` — reading
        // the wrong key meant this always resolved to null and every
        // submission was rejected regardless of the referral code entered.
        $validated = $request->validate([
            'bhw_referral_id'        => ['required', 'string', 'regex:/^BRY-\d{3}-\d{8}-\d{4}$/'],
            'full_name'              => 'required|string|max:100',
            'date_of_birth'          => 'required|date',
            'sex'                    => 'required|string|in:Male,Female',
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

        // Client-side JS trims the value before its own format check, but
        // nothing guaranteed that server-side, so trim again here in case
        // the request bypassed the browser entirely.
        $referralCode = trim($validated['bhw_referral_id']);

        // Wrap the existence check and every write in a single transaction,
        // with lockForUpdate() on the referral row. Without this, two
        // requests submitted close together could both read the referral as
        // "Pending" before either one updates it, letting the same referral
        // be consumed twice.
        return DB::transaction(function () use ($referralCode, $validated) {

            // 1. Verify the code exists and is still Pending
            $validReferral = DB::table('bhw_referral_info')
                ->where('reference_no', $referralCode)
                ->where('status', 'Pending')
                ->lockForUpdate()
                ->first();

            if (!$validReferral) {
                // Error key now matches @error('bhw_referral_id') in the
                // blade view — under the old 'reference_no' key the inline
                // error message next to the field would never have rendered.
                return back()
                    ->withErrors(['bhw_referral_id' => 'Referral code is invalid or has already been used.'])
                    ->withInput();
            }

            $age = \Carbon\Carbon::parse($validated['date_of_birth'])->age;
            $isPriority = ($validated['priority_status'] ?? 'none') !== 'none';
            $isPhilhealthMember = $validated['philhealth_member'] === 'yes';
            $queueDate = now()->toDateString();

            // 2. Queue entry — patients.inflow_record_id and
            // bite_cases.inflow_record_id are both NOT NULL, but this
            // referral flow previously never created the
            // inflow_general_particulars row the walk-in flow (see
            // storeReturning() above) creates to satisfy that. Since the
            // table already has a bhw_referral_id column made for exactly
            // this case, this flow now writes one too, following the same
            // queue_id pattern as storeReturning() so referred patients join
            // the same physical queue as walk-ins.
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
                'sex'               => $validated['sex'],
                'date_of_birth'     => $validated['date_of_birth'],
                'civil_status'      => $validated['civil_status'] ?? 'Single',
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
                'sex'               => $validated['sex'],
                'date_of_birth'     => $validated['date_of_birth'],
                'civil_status'      => $validated['civil_status'] ?? 'Single',
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
                // PLACEHOLDER: WHO exposure category (I/II/III) isn't
                // captured anywhere on this form or in bhw_referral_info —
                // in practice it's assigned by clinical staff during
                // in-person triage, not at referral/registration time. This
                // satisfies the NOT NULL constraint so the insert doesn't
                // fail, but confirm with the team where this should really
                // come from (a staff-facing update step, most likely) before
                // treating "Pending" as meaningful data.
                'category'         => 'Pending',
                'bhw_referral_id'  => $validReferral->referral_id,
                'date_verified'    => now(),
            ]);

            // 6. Reuse the same confirmation views as storeReturning() —
            // route('patient.queue.normal')/('patient.queue.priority')
            // don't exist anywhere in web.php, so the original redirect
            // would have thrown a RouteNotFoundException on every
            // successful registration.
            return $isPriority
                ? view('patient.PQ_confirmation', ['queueNumber' => $queueId])
                : view('patient.NQ_confirmation', ['queueNumber' => $queueId]);
        });
    }

    /**
     * Build a patient_id in the CEB-[REG DATE]-[DOB]-[SEQ] format described
     * by the comment on patients.patient_id in the schema.
     *
     * Caveat: the sequence number comes from a same-day COUNT() inside the
     * calling transaction. That's fine against the specific race this fix
     * targets (two submissions for the same referral, which lockForUpdate()
     * on bhw_referral_info already serializes), but two *different*
     * referrals registering at the same moment could still COUNT() before
     * either INSERT lands and collide on the same sequence number, since
     * patients has no unique constraint enforcing it. If that's a real
     * concern at your expected traffic, replace this with a dedicated
     * sequence table or an auto-increment shadow column.
     */
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