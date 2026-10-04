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
                    WHEN s9.day3_notes <> '' AND s9.day7_notes <> '' AND s9.day28_notes <> '' THEN 'Completed'
                    WHEN s9.progress_id IS NOT NULL OR s6.wound_desc_id IS NOT NULL THEN 'In Progress'
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

        // A draft saves whatever is filled in; moving on needs the core fields
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'total_wounds' => $required . '|in:Single,Multiple',
            'wound_description' => 'nullable|string',
            'site_of_bite' => $required . '|string|max:100',
            'category_of_exposure' => $required . '|in:I,II,III',
        ]);

        DB::table('bite_section6_wound_description')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            array_merge($validated, [
                // Fall back to whatever bite_cases already has if this form
                // hasn't set a category yet (e.g. very first save)
                'category_of_exposure' => $validated['category_of_exposure'] ?? $case->category,
            ])
        );

        // Keep bite_cases.category in sync, since bite_section6's column
        // comment says it mirrors this value - if the health worker changes
        // it here, bite_cases should reflect the same category.
        if (!empty($validated['category_of_exposure']) && $validated['category_of_exposure'] !== $case->category) {
            DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update([
                'category' => $validated['category_of_exposure'],
            ]);
        }

        if ($isDraft) {
            return back()->with('status', 'Section VI saved as draft.');
        }

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

        // A draft saves whatever is filled in, required or not; moving on to
        // Section VIII needs the core fields.
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'patient_weight' => $required . '|numeric|min:0|max:999.99',
            'tetanus_given' => 'nullable|boolean',
            'tetanus_details' => 'nullable|string|max:200',
            'tig_given' => 'nullable|boolean',
            'tig_details' => 'nullable|string|max:200',
            'vaccine_brand' => $required . '|string|max:100',
            'route' => $required . '|in:ID,IM',
            'dose_type' => $required . '|in:Primary,Booster',
            'day0_date' => $required . '|date|before_or_equal:today',
            'day3_date' => 'nullable|date|before_or_equal:today',
            'day7_date' => 'nullable|date|before_or_equal:today',
            'day28_date' => 'nullable|date|before_or_equal:today',
            'passive_given' => 'nullable|boolean',
            'passive_type' => 'nullable|string|max:50',
            // Only needed once a passive immunoglobulin (ERIG/HRIG) is chosen
            'passive_route' => ($isDraft ? 'nullable' : 'required_with:passive_type') . '|in:IU infiltrate,IM',
            'skin_test_due' => 'nullable|date_format:H:i',
            'administered_by' => $required . '|string|max:100',
        ]);

        $validated['tetanus_given'] = $request->boolean('tetanus_given');
        $validated['tig_given'] = $request->boolean('tig_given');
        $validated['passive_given'] = $request->boolean('passive_given');
        // dose_type is NOT NULL in the table: an unchosen value on a draft is stored
        // as '' (shows as "Select" again) rather than a made-up default
        $validated['dose_type'] = $validated['dose_type'] ?? '';

        DB::table('bite_section7_immunization')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        if ($isDraft) {
            return back()->with('status', 'Section VII saved as draft.');
        }

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

        // A draft saves whatever is filled in; moving on to Section IX needs both fields
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'medication' => $required . '|string|max:5000',
            'advice' => $required . '|string|max:5000',
        ]);

        DB::table('bite_section8_remarks')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        if ($isDraft) {
            return back()->with('status', 'Section VIII saved as draft.');
        }

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

        // A draft saves whatever is filled in (notes are added visit by visit);
        // finalizing the record needs all three
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'day3_notes' => $required . '|string|max:5000',
            'day7_notes' => $required . '|string|max:5000',
            'day28_notes' => $required . '|string|max:5000',
        ]);

        DB::table('bite_section9_progress_notes')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        if ($isDraft) {
            return back()->with('status', 'Section IX saved as draft.');
        }

        // Last section - send the health worker back to their dashboard
        return redirect()->route('healthworker.dashboard')
            ->with('status', 'Clinical encoding completed for this case.');
    }
}