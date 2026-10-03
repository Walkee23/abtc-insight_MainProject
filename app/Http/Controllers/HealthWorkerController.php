<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HealthWorkerController extends Controller
{
    /**
     * Retrieve queue of bite_cases joined to patients.
     * Calculates clinical encoding progress across Sections VI, VII, VIII, and IX.
     */
    private function getPendingQueue()
    {
        $cases = DB::table('bite_cases')
            ->join('patients', 'bite_cases.patient_id', '=', 'patients.patient_id')
            ->select(
                'bite_cases.bite_case_id',
                'bite_cases.case_number',
                'bite_cases.date_verified',
                'bite_cases.category',
                'bite_cases.outcome',
                'patients.patient_id',
                'patients.patient_name'
            )
            ->orderBy('bite_cases.date_verified', 'desc')
            ->get();

        foreach ($cases as $case) {
            $sec6 = DB::table('bite_section6_wound_description')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec7 = DB::table('bite_section7_immunization')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec8 = DB::table('bite_section8_remarks')->where('bite_case_id', $case->bite_case_id)->exists();
            $sec9 = DB::table('bite_section9_progress_notes')->where('bite_case_id', $case->bite_case_id)->exists();

            $completedSections = 0;
            if ($sec6) $completedSections++;
            if ($sec7) $completedSections++;
            if ($sec8) $completedSections++;
            if ($sec9) $completedSections++;

            if ($completedSections === 0) {
                $case->progress_status = 'Not Started';
            } elseif ($completedSections === 4) {
                $case->progress_status = 'Completed';
            } else {
                $case->progress_status = 'In Progress';
            }
        }

        return $cases;
    }

    private function getCurrentCase($bite_case_id)
    {
        return DB::table('bite_cases')
            ->join('patients', 'bite_cases.patient_id', '=', 'patients.patient_id')
            ->leftJoin('bite_section3_exposure', 'bite_cases.bite_case_id', '=', 'bite_section3_exposure.bite_case_id')
            ->select(
                'bite_cases.*',
                'patients.patient_name',
                'patients.age',
                'patients.sex',
                'patients.contact_num',
                'bite_section3_exposure.bite_date_time'
            )
            ->where('bite_cases.bite_case_id', $bite_case_id)
            ->first();
    }

    public function clinical_encoding_index()
    {
        $queue = $this->getPendingQueue();
        if ($queue->isNotEmpty()) {
            return redirect()->route('healthworker.ce-vi', ['bite_case_id' => $queue->first()->bite_case_id]);
        }
        return redirect()->route('healthworker.dashboard')->with('error', 'No active bite cases found in queue.');
    }

    // --- Section VI: Wound Description ---
    public function ce_vi($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        if (!$current_case) {
            return redirect()->route('healthworker.clinical-encoding');
        }
        $record = DB::table('bite_section6_wound_description')->where('bite_case_id', $bite_case_id)->first();

        return view('healthworker.CE_VI', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_vi(Request $request, $bite_case_id)
    {
        DB::table('bite_section6_wound_description')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'site_of_bite' => $request->input('site_of_bite'),
                'category_of_exposure' => $request->input('category_of_exposure'),
                'total_wounds' => $request->input('total_wounds'),
                'wound_description' => $request->input('wound_description', 'N/A')
            ]
        );

        if ($request->input('action') === 'draft') {
            return back()->with('success', 'Section VI saved as draft.');
        }

        return redirect()->route('healthworker.ce-vii', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section VII: Immunization ---
    public function ce_vii($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        if (!$current_case) {
            return redirect()->route('healthworker.clinical-encoding');
        }
        $record = DB::table('bite_section7_immunization')->where('bite_case_id', $bite_case_id)->first();

        return view('healthworker.CE_VII', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_vii(Request $request, $bite_case_id)
    {
        $passiveType = $request->input('passive_type');
        $passiveGiven = ($passiveType && $passiveType !== 'None') ? 1 : 0;

        DB::table('bite_section7_immunization')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'vaccine_brand' => $request->input('vaccine_brand'),
                'route' => $request->input('route'),
                'passive_given' => $passiveGiven,
                'passive_type' => $passiveType,
                'day0_date' => $request->input('day0_date'),
                'day3_date' => $request->input('day3_date'),
                'day7_date' => $request->input('day7_date'),
                'day28_date' => $request->input('day28_date'),
                'dose_type' => 'Primary'
            ]
        );

        if ($request->input('action') === 'draft') {
            return back()->with('success', 'Section VII saved as draft.');
        }

        return redirect()->route('healthworker.ce-viii', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section VIII: Remarks ---
    public function ce_viii($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        if (!$current_case) {
            return redirect()->route('healthworker.clinical-encoding');
        }
        $record = DB::table('bite_section8_remarks')->where('bite_case_id', $bite_case_id)->first();

        return view('healthworker.CE_VIII', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_viii(Request $request, $bite_case_id)
    {
        DB::table('bite_section8_remarks')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'advice' => $request->input('advice'),
                'medication' => $request->input('medication')
            ]
        );

        if ($request->input('action') === 'draft') {
            return back()->with('success', 'Section VIII saved as draft.');
        }

        return redirect()->route('healthworker.ce-ix', ['bite_case_id' => $bite_case_id]);
    }

    // --- Section IX: Progress Notes ---
    public function ce_ix($bite_case_id)
    {
        $queue = $this->getPendingQueue();
        $current_case = $this->getCurrentCase($bite_case_id);
        if (!$current_case) {
            return redirect()->route('healthworker.clinical-encoding');
        }
        $record = DB::table('bite_section9_progress_notes')->where('bite_case_id', $bite_case_id)->first();

        return view('healthworker.CE_IX', compact('queue', 'current_case', 'record'));
    }

    public function store_ce_ix(Request $request, $bite_case_id)
    {
        DB::table('bite_section9_progress_notes')->updateOrInsert(
            ['bite_case_id' => $bite_case_id],
            [
                'day3_notes' => $request->input('day3_notes'),
                'day7_notes' => $request->input('day7_notes'),
                'day28_notes' => $request->input('day28_notes')
            ]
        );

        if ($request->input('action') === 'draft') {
            return back()->with('success', 'Section IX saved as draft.');
        }

        // Finalize clinical encoding record
        DB::table('bite_cases')
            ->where('bite_case_id', $bite_case_id)
            ->update(['outcome' => 'Completed']);

        return redirect()->route('healthworker.dashboard')->with('success', 'Patient clinical encoding completed and finalized!');
    }
}