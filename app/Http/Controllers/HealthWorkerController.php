<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HealthWorkerController extends Controller
{
    /**
     * Fetch the pending queue based on existing bite_cases records.
     * Determines progress across Sections 6, 7, 8, 9.[cite: 6]
     */
    private function getPendingQueue()
    {
        $cases = DB::table('bite_cases')
            ->join('patients', 'bite_cases.patient_id', '=', 'patients.patient_id')
            ->select(
                'bite_cases.bite_case_id', 
                'patients.patient_name', 
                'bite_cases.date_verified', 
                'bite_cases.category',
                'patients.patient_id'
            )
            ->whereNull('bite_cases.outcome')
            ->orderBy('bite_cases.date_verified', 'desc')
            ->get();

        foreach ($cases as $case) {
            $sec6 = DB::table('bite_section6_wound_description')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec7 = DB::table('bite_section7_immunization')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec8 = DB::table('bite_section8_remarks')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec9 = DB::table('bite_section9_progress_notes')->where('bite_case_id', $case->bite_case_id)->exists();

            $completed = 0;
            if ($sec6) $completed++;
            if ($sec7) $completed++;
            if ($sec8) $completed++;
            if ($sec9) $completed++;

            if ($completed == 0) {
                $case->status = 'Not Started';
            } elseif ($completed == 4) {
                $case->status = 'Completed';
            } else {
                $case->status = 'In Progress';
            }
        }

        return $cases;
    }

    private function getCurrentCase($bite_case_id)
    {
        return DB::table('bite_cases')
            ->join('patients', 'bite_cases.patient_id', '=', 'patients.patient_id')
            ->select('bite_cases.*', 'patients.patient_name')
            ->where('bite_cases.bite_case_id', $bite_case_id)
            ->first();
    }

    public function clinical_encoding_index()
    {
        $queue = $this->getPendingQueue();
        if ($queue->isNotEmpty()) {
            return redirect()->route('healthworker.ce-vi', ['bite_case_id' => $queue->first()->bite_case_id]);
        }
        return redirect()->route('healthworker.dashboard')->with('message', 'No active encoding cases found.');
    }

    // --- Section VI: Wound Description ---
    public function ce_vi($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        $record = DB::table('bite_section6_wound_description')->where('bite_case_id', $bite_case_id)->first();
        
        return view('healthworker.CE_VI', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_vi(Request $request, $bite_case_id)
    {
        DB::table('bite_section6_wound_description')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'site_of_bite' => $request->site_of_bite,
                'category_of_exposure' => $request->category_of_exposure,
                'total_wounds' => $request->total_wounds,
                'wound_description' => $request->wound_description ?? 'N/A'
            ]
        );
        return redirect()->route('healthworker.ce-vii', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section VII: Immunization ---
    public function ce_vii($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        $record = DB::table('bite_section7_immunization')->where('bite_case_id', $bite_case_id)->first();
        
        return view('healthworker.CE_VII', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_vii(Request $request, $bite_case_id)
    {
        DB::table('bite_section7_immunization')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'vaccine_brand' => $request->vaccine_brand,
                'route' => $request->route,
                'passive_given' => $request->passive_given === 'Yes' ? 1 : 0,
                'passive_type' => $request->passive_type,
                'day0_date' => $request->day0_date,
                'day3_date' => $request->day3_date,
                'day7_date' => $request->day7_date,
                'day28_date' => $request->day28_date,
                'dose_type' => 'Primary'
            ]
        );
        return redirect()->route('healthworker.ce-viii', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section VIII: Remarks ---
    public function ce_viii($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        $record = DB::table('bite_section8_remarks')->where('bite_case_id', $bite_case_id)->first();
        
        return view('healthworker.CE_VIII', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_viii(Request $request, $bite_case_id)
    {
        DB::table('bite_section8_remarks')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'advice' => $request->advice,
                'medication' => $request->medication
            ]
        );
        return redirect()->route('healthworker.ce-ix', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section IX: Progress Notes ---
    public function ce_ix($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        $record = DB::table('bite_section9_progress_notes')->where('bite_case_id', $bite_case_id)->first();
        
        return view('healthworker.CE_IX', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_ix(Request $request, $bite_case_id)
    {
        DB::table('bite_section9_progress_notes')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'day3_notes' => $request->day3_notes,
                'day7_notes' => $request->day7_notes,
                'day28_notes' => $request->day28_notes
            ]
        );
        
        // Finalize outcome[cite: 6]
        DB::table('bite_cases')
            ->where('bite_case_id', $bite_case_id)
            ->update(['outcome' => 'Completed']);

        return redirect()->route('healthworker.dashboard')->with('success', 'Clinical Encoding Finalized');
    }
}