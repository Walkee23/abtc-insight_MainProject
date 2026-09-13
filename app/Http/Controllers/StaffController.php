<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    // Patient Verification page — show Pending walk-ins split into Priority/Normal queues
    public function patientVerification(Request $request)
    {
        $search = $request->input('search');

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

    $priorityQueue = $priorityQuery->orderBy('queue_date')->orderBy('queue_id')->get();
    $normalQueue = $normalQuery->orderBy('queue_date')->orderBy('queue_id')->paginate(5, ['*'], 'normal_page')
    ->withQueryString();

    return view('staff.Patient_Verification', compact('priorityQueue', 'normalQueue', 'search'));
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