<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // Search for an existing patient by name or ID
    public function search(Request $request)
    {
        $query = $request->input('query');

        $patient = DB::table('patients')
            ->where('patient_name', 'LIKE', "%{$query}%")
            ->orWhere('patient_id', $query)
            ->orWhere('id_number', $query)
            ->first();

        if (!$patient) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'patient' => $patient,
        ]);
    }

    public function storeReturning(Request $request)
    {
        $validated = $request->validate([
            'patient_id'         => 'required|string',
            'contact_num'        => 'required|string|max:20',
            'civil_status'       => 'nullable|string|max:20',
            'philhealth_member'  => 'required|boolean',
            'barangay'           => 'required|string|max:100',
            'priority_status'    => 'nullable|string',
        ]);

        $patient = DB::table('patients')->where('patient_id', $validated['patient_id'])->first();

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