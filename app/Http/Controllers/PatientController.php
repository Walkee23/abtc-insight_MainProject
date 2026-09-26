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

        // 2. Generate patient_id: CEB-[today]-[dob]-[seq]
        $dob = $request->input('date_of_birth') ?: $validReferral->date_of_birth;
        $regDate = now()->format('Ymd');
        $dobFormatted = \Carbon\Carbon::parse($dob)->format('Ymd');

        $countSameDay = DB::table('patients')
            ->where('patient_id', 'LIKE', "CEB-{$regDate}-{$dobFormatted}-%")
            ->count();
        $sequence = str_pad($countSameDay + 1, 3, '0', STR_PAD_LEFT);
        $patientId = "CEB-{$regDate}-{$dobFormatted}-{$sequence}";

        // 3. Insert the patient into the PATIENTS table
        DB::table('patients')->insert([
            'patient_id'         => $patientId,
            'inflow_record_id'   => null,
            'date_registered'    => now(),
            'patient_name'       => $request->input('patient_name') ?: $validReferral->patient_name,
            'age'                => $request->input('age') ?: $validReferral->age,
            'sex'                => $request->input('sex') ?: $validReferral->gender,
            'date_of_birth'      => $dob,
            'civil_status'       => $request->input('civil_status') ?: $validReferral->civil_status,
            'contact_num'        => $request->input('contact_number') ?: $validReferral->contact_num,
            'philhealth_member'  => $request->input('philhealth_member') === 'yes' ? 1 : 0,
            'philhealth_name'    => $request->input('philhealth_member_name'),
            'philhealth_dob'     => $request->input('philhealth_member_dob') ?: null,
        ]);

        // 4. Lock the referral so it cannot be used again
        DB::table('bhw_referral_info')
            ->where('referral_id', $validReferral->referral_id)
            ->update([
                'status' => 'Received',
                'updated_at' => now()
            ]);

        // 5. Link the referral to the new bite case
        $biteCaseId = DB::table('bite_cases')->insertGetId([
            'patient_id'        => $patientId,
            'inflow_record_id'  => null,
            'case_number'       => DB::table('bite_cases')->max('case_number') + 1,
            'bhw_referral_id'   => $validReferral->referral_id,
            'date_verified'     => now(),
            'barangay'          => $request->input('barangay') ?: $validReferral->patient_barangay,
            'category'          => 'Cat II',
            'philhealth_status' => $request->input('philhealth_member') === 'yes' ? 'Member' : 'Non-member',
        ], 'bite_case_id');

        // 6. Link the bite case back to the referral so BHW dashboard shows it as Received
        DB::table('bhw_referral_info')
            ->where('referral_id', $validReferral->referral_id)
            ->update(['bite_case_id' => $biteCaseId]);

        // 7. Priority Condition Redirect
        $priority = $request->input('priority_status');

        if ($priority === 'none' || empty($priority)) {
            return redirect()->route('patient.queue.normal');
        } else {
            return redirect()->route('patient.queue.priority');
        }
    }
}