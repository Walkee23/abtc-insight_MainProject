<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BhwController extends Controller
{
    public function dashboard()
    {
        // 1. Get the currently logged-in BHW ID
        $userId = auth()->id();

        // 2. Count the metrics for the cards
        $totalSubmissions = DB::table('bhw_referral_info')->where('bhw_user_id', $userId)->count();
        $pending = DB::table('bhw_referral_info')->where('bhw_user_id', $userId)->where('status', 'Pending')->count();
        $received = DB::table('bhw_referral_info')->where('bhw_user_id', $userId)->where('status', 'Received')->count();
        $completed = DB::table('bhw_referral_info')->where('bhw_user_id', $userId)->where('status', 'Completed')->count();

        // 3. Get the list of referrals and join with exposure table to get the exposure type
        $referrals = DB::table('bhw_referral_info')
            ->leftJoin('bhw_referral_exposure', 'bhw_referral_info.referral_id', '=', 'bhw_referral_exposure.referral_id')
            ->where('bhw_user_id', $userId)
            ->orderBy('bhw_referral_info.submitted_at', 'desc')
            ->get();

        // 4. Send the data to the view
        return view('bhw.dashboard', compact('totalSubmissions', 'pending', 'received', 'completed', 'referrals'));
    }

    public function storeReferral(Request $request)
    {
        $barangayName = $request->input('patient_barangay');
        
        // 1. Get the 3-digit code from the config file, default to '000' if not found
        $brgyCode = config("barangays.{$barangayName}", '000');
        $dateStr = Carbon::now()->format('Ymd');
        
        // 2. Count today's referrals for this specific barangay to create the sequence
        $countToday = DB::table('bhw_referral_info')
            ->where('reference_no', 'like', "BRY-{$brgyCode}-{$dateStr}-%")
            ->count();
            
        $sequence = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
        
        // 3. Assemble the final unique code
        $referenceNo = "BRY-{$brgyCode}-{$dateStr}-{$sequence}";

        // 4. Save to the main bhw_referral_info table and get the new ID
        $referralId = DB::table('bhw_referral_info')->insertGetId([
            'reference_no' => $referenceNo,
            'bhw_user_id' => auth()->id(), // FIX: Grabs the logged-in user's ID
            'status' => 'Pending',
            'patient_name' => $request->input('patient_name'),
            'date_of_birth' => $request->input('date_of_birth'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'civil_status' => $request->input('civil_status', 'Single'),
            'patient_barangay' => $barangayName,
            'contact_num' => $request->input('contact_num'),
            'referred_by' => auth()->user()->full_name, // FIX: Grabs BHW name
            'referral_date' => now()->toDateString(),
            'submitted_at' => now(),
            'updated_at' => now()
        ]);

        // 5. Save the vitals into the bhw_referral_vitals table
        DB::table('bhw_referral_vitals')->insert([
            'referral_id' => $referralId,
            'temperature' => $request->input('temperature'),
            'blood_pressure' => $request->input('blood_pressure'),
            'pulse_rate' => $request->input('pulse_rate'),
            'respiratory_rate' => $request->input('respiratory_rate'),
            'height_cm' => $request->input('height_cm'),
            'weight_kg' => $request->input('weight_kg')
        ]);

        // 6. Save the exposure details into the bhw_referral_exposure table
        DB::table('bhw_referral_exposure')->insert([
            'referral_id' => $referralId,
            'exposure_type' => $request->input('exposure_type'),
            'exposure_datetime' => $request->input('exposure_date') . ' ' . ($request->input('exposure_time') ?: '00:00:00'),
            'site_of_bite' => $request->input('site_of_bite'),
            'biting_animal' => $request->input('biting_animal'),
            'biting_animal_other' => $request->input('biting_animal_other'),
            'lab_exam' => $request->input('lab_exam'),
            'action_desired' => $request->input('action_desired')
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Referral created successfully! Your code is: ' . $referenceNo);
    }

    

    public function printReferral($id)
    {
        // Fetch the referral and join the vitals and exposure tables
        $referral = DB::table('bhw_referral_info')
            ->leftJoin('bhw_referral_vitals', 'bhw_referral_info.referral_id', '=', 'bhw_referral_vitals.referral_id')
            ->leftJoin('bhw_referral_exposure', 'bhw_referral_info.referral_id', '=', 'bhw_referral_exposure.referral_id')
            ->where('bhw_referral_info.referral_id', $id)
            ->where('bhw_referral_info.bhw_user_id', auth()->id()) // Ensure they own it
            ->first();

        if (!$referral) {
            return redirect()->route('bhw.dashboard')->with('error', 'Referral not found.');
        }

        return view('bhw.print_referral', compact('referral'));
    }
}

 