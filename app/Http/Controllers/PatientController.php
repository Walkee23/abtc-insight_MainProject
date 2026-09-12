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
        $referralCode = $request->input('reference_no');

        // 1. Verify the code exists and is still Pending
        $validReferral = DB::table('bhw_referral_info')
            ->where('reference_no', $referralCode)
            ->where('status', 'Pending')
            ->first();

        if (!$validReferral) {
            return back()->withErrors(['reference_no' => 'Referral code is invalid or has already been used.']);
        }

        // 2. Insert the patient into the PATIENTS table
        $patientId = DB::table('patients')->insertGetId([
            'patient_name' => $request->input('patient_name'),
            'barangay' => $request->input('barangay'),
            'date_registered' => now(),
            // Add your other patient fields here
        ]);

        // 3. Lock the referral so it cannot be used again
        DB::table('bhw_referral_info')
            ->where('referral_id', $validReferral->referral_id)
            ->update([
                'status' => 'Received',
                'updated_at' => now()
            ]);

        // 4. Link the referral to the new bite case
        DB::table('bite_cases')->insert([
            'patient_id' => $patientId,
            'bhw_referral_id' => $validReferral->referral_id,
            'date_verified' => now(),
            // Add your other bite case fields here
        ]);

        // 5. Your Priority Condition Redirect
        $priority = $request->input('priority_status');

        if ($priority === 'none' || empty($priority)) {
            return redirect()->route('patient.queue.normal');
        } else {
            return redirect()->route('patient.queue.priority');
        }
    }
}