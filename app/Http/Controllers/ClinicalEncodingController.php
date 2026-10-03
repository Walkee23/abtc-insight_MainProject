<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicalEncodingController extends Controller
{
    /**
     * Every bite_cases row (created once Staff finishes Case Encoding,
     * Sections 1-5) joined to its patient, with a derived status based on
     * which section tables already have a matching row for that case.
     */
    private function getQueue()
    {
        return DB::table('bite_cases as bc')
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->leftJoin('bite_section6_wound_description as s6', 's6.bite_case_id', '=', 'bc.bite_case_id')
            ->leftJoin('bite_section9_progress_notes as s9', 's9.bite_case_id', '=', 'bc.bite_case_id')
            ->select(
                'bc.bite_case_id',
                'bc.case_number',
                'bc.category',
                'bc.date_verified',
                'p.patient_id',
                'p.patient_name',
                DB::raw("CASE
                    WHEN s9.progress_id IS NOT NULL THEN 'Completed'
                    WHEN s6.wound_desc_id IS NOT NULL THEN 'In Progress'
                    ELSE 'Not Started'
                END as encoding_status")
            )
            ->orderBy('bc.date_verified', 'desc')
            ->get();
    }

    /**
     * One bite case plus its patient's identity details, for the form header.
     */
    private function getCase($biteCaseId)
    {
        return DB::table('bite_cases as bc')
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->where('bc.bite_case_id', $biteCaseId)
            ->select('bc.*', 'p.patient_name', 'p.age', 'p.sex', 'p.date_of_birth')
            ->first();
    }

    // ---------------------------------------------------------------
    // Section VI - Wound Description & Category
    // ---------------------------------------------------------------

    public function sectionVI($biteCaseId = null)
    {
        $queue = $this->getQueue();
        $case = $biteCaseId ? $this->getCase($biteCaseId) : null;
        $section = $biteCaseId
            ? DB::table('bite_section6_wound_description')->where('bite_case_id', $biteCaseId)->first()
            : null;

        return view('healthworker.CE_VI', compact('queue', 'case', 'section'));
    }

    public function storeSectionVI(Request $request, $biteCaseId)
    {
        $case = DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->firstOrFail();

        $validated = $request->validate([
            'total_wounds' => 'nullable|in:Single,Multiple',
            'wound_description' => 'nullable|string',
            'site_of_bite' => 'nullable|string|max:100',
        ]);

        DB::table('bite_section6_wound_description')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            array_merge($validated, [
                // Mirrors bite_cases.category, per the column comment -
                // not independently editable here, just carried over.
                'category_of_exposure' => $case->category,
            ])
        );

        return redirect()->route('healthworker.ce-vii', ['bite_case_id' => $biteCaseId]);
    }

    // ---------------------------------------------------------------
    // Section VII - Schedule of Immunization
    // ---------------------------------------------------------------

    public function sectionVII($biteCaseId = null)
    {
        $queue = $this->getQueue();
        $case = $biteCaseId ? $this->getCase($biteCaseId) : null;
        $section = $biteCaseId
            ? DB::table('bite_section7_immunization')->where('bite_case_id', $biteCaseId)->first()
            : null;

        return view('healthworker.CE_VII', compact('queue', 'case', 'section'));
    }

    public function storeSectionVII(Request $request, $biteCaseId)
    {
        DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->firstOrFail();

        $validated = $request->validate([
            'patient_weight' => 'nullable|numeric|min:0|max:999.99',
            'tetanus_given' => 'nullable|boolean',
            'tetanus_details' => 'nullable|string|max:200',
            'tig_given' => 'nullable|boolean',
            'tig_details' => 'nullable|string|max:200',
            'vaccine_brand' => 'nullable|string|max:100',
            'route' => 'nullable|in:ID,IM',
            'dose_type' => 'required|in:Primary,Booster',
            'day0_date' => 'nullable|date',
            'day3_date' => 'nullable|date',
            'day7_date' => 'nullable|date',
            'day28_date' => 'nullable|date',
            'passive_given' => 'nullable|boolean',
            'passive_type' => 'nullable|string|max:50',
            'passive_route' => 'nullable|string|max:10',
            'skin_test_due' => 'nullable|date_format:H:i',
            'administered_by' => 'nullable|string|max:100',
        ]);

        $validated['tetanus_given'] = $request->boolean('tetanus_given');
        $validated['tig_given'] = $request->boolean('tig_given');
        $validated['passive_given'] = $request->boolean('passive_given');

        DB::table('bite_section7_immunization')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        return redirect()->route('healthworker.ce-viii', ['bite_case_id' => $biteCaseId]);
    }

    // ---------------------------------------------------------------
    // Section VIII - Remarks
    // ---------------------------------------------------------------

    public function sectionVIII($biteCaseId = null)
    {
        $queue = $this->getQueue();
        $case = $biteCaseId ? $this->getCase($biteCaseId) : null;
        $section = $biteCaseId
            ? DB::table('bite_section8_remarks')->where('bite_case_id', $biteCaseId)->first()
            : null;

        return view('healthworker.CE_VIII', compact('queue', 'case', 'section'));
    }

    public function storeSectionVIII(Request $request, $biteCaseId)
    {
        DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->firstOrFail();

        $validated = $request->validate([
            'medication' => 'nullable|string',
            'advice' => 'nullable|string',
        ]);

        DB::table('bite_section8_remarks')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        return redirect()->route('healthworker.ce-ix', ['bite_case_id' => $biteCaseId]);
    }

    // ---------------------------------------------------------------
    // Section IX - Progress Notes
    // ---------------------------------------------------------------

    public function sectionIX($biteCaseId = null)
    {
        $queue = $this->getQueue();
        $case = $biteCaseId ? $this->getCase($biteCaseId) : null;
        $section = $biteCaseId
            ? DB::table('bite_section9_progress_notes')->where('bite_case_id', $biteCaseId)->first()
            : null;

        return view('healthworker.CE_IX', compact('queue', 'case', 'section'));
    }

    public function storeSectionIX(Request $request, $biteCaseId)
    {
        DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->firstOrFail();

        $validated = $request->validate([
            'day3_notes' => 'nullable|string',
            'day7_notes' => 'nullable|string',
            'day28_notes' => 'nullable|string',
        ]);

        DB::table('bite_section9_progress_notes')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        // Last section - send the health worker back to their dashboard
        return redirect()->route('healthworker.dashboard')
            ->with('status', 'Clinical encoding completed for this case.');
    }
}