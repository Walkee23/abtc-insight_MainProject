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

    // Save the returning patient's new inflow record
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

        // Get the existing patient record to copy locked fields
        $patient = DB::table('patients')->where('patient_id', $validated['patient_id'])->first();

        if (!$patient) {
            return back()->withErrors(['patient_id' => 'Patient record not found.']);
        }

        // Generate a simple queue ID (you can adjust the format later)
        $queueId = 'Q-' . strtoupper(substr(uniqid(), -6));

        DB::table('inflow_general_particulars')->insert([
            'queue_id'          => $queueId,
            'queue_date'        => now()->toDateString(),
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

        // Redirect based on priority, same logic as before
        $priority = $validated['priority_status'] ?? 'none';

        if ($priority === 'none' || empty($priority)) {
            return redirect()->route('patient.queue.normal');
        } else {
            return redirect()->route('patient.queue.priority');
        }
    }
}