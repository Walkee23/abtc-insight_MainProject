<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
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