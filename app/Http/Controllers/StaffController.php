<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Patient Verification page — show Pending walk-ins split into Priority/Normal queues
    public function patientVerification()
    {
        $priorityQueue = DB::table('inflow_general_particulars')
            ->where('status', 'Pending')
            ->where('queue_id', 'LIKE', 'P%')
            ->orderBy('queue_date')
            ->orderBy('queue_id')
            ->get();

        $normalQueue = DB::table('inflow_general_particulars')
            ->where('status', 'Pending')
            ->where('queue_id', 'LIKE', 'N%')
            ->orderBy('queue_date')
            ->orderBy('queue_id')
            ->get();

        return view('staff.Patient_Verification', compact('priorityQueue', 'normalQueue'));
    }

    // Verify Attendance & Transfer — flips a Pending record to Verified
    public function verifyAttendance(string $inflow_record_id)
    {
        DB::table('inflow_general_particulars')
            ->where('inflow_record_id', $inflow_record_id)
            ->update(['status' => 'Verified']);

        return redirect()->route('staff.patient-verification')
            ->with('success', 'Patient verified and moved to Case Encoding.');
    }

    // Case Encoding page — show Verified records awaiting encoding
    public function caseEncoding()
    {
        $verifiedQueue = DB::table('inflow_general_particulars')
            ->where('status', 'Verified')
            ->orderBy('queue_date')
            ->get();

        return view('staff.Case_Encoding', compact('verifiedQueue'));
    }
}