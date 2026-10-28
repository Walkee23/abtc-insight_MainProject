<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClinicalEncodingController extends Controller
{
    /** Wound types the health worker can pick in Section VI (stored comma-separated in wound_description). */
    public const WOUND_TYPES = ['Punctured', 'Lacerated', 'Avulsion', 'Abrasion'];

    /**
     * Only cases Staff has finished (Case Encoding "Complete Encoding" sets the walk-in
     * record to 'Encoded') belong to the Health Worker. A bite_cases row can already
     * exist from a Staff draft, so its existence alone is not the hand-off.
     */
    private function handedOff($query, string $alias = 'bc')
    {
        $query->whereExists(function ($e) use ($alias) {
            $e->select(DB::raw(1))->from('inflow_general_particulars as hg')
                ->whereColumn('hg.inflow_record_id', $alias . '.inflow_record_id')
                ->where('hg.status', 'Encoded');
        });

        return $this->assignedToMe($query, $alias);
    }

    /**
     * Staff assigns each case to a Health Worker, and a Health Worker only sees their
     * own cases. A new account has no cases yet; with nobody logged in nothing is shown
     * (careful: where(col, null) would match every unassigned case instead).
     */
    private function assignedToMe($query, string $alias = 'bc')
    {
        $userId = Auth::id();

        return $userId
            ? $query->where($alias . '.assigned_health_worker_id', $userId)
            : $query->whereRaw('1 = 0');
    }

    /** A case that is assigned to the logged-in health worker, or a 404. */
    private function ownCase($biteCaseId)
    {
        return $this->assignedToMe(DB::table('bite_cases as bc'))
            ->where('bc.bite_case_id', $biteCaseId)
            ->select('bc.*')
            ->first() ?? abort(404);
    }

    /**
     * Every unfinished bite_cases row (created once Staff finishes Case Encoding,
     * Sections 1-5) joined to its patient, with a derived status based on
     * which section tables already have a matching row for that case.
     */
    private function getQueue()
    {
        return $this->handedOff(DB::table('bite_cases as bc'))
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->leftJoin('bite_section6_wound_description as s6', 's6.bite_case_id', '=', 'bc.bite_case_id')
            ->leftJoin('bite_section9_progress_notes as s9', 's9.bite_case_id', '=', 'bc.bite_case_id')
            // Finalized cases (Section IX saved and finalized) leave the queue
            ->where(function ($q) {
                $q->whereNull('bc.outcome')->orWhere('bc.outcome', '<>', 'Completed');
            })
            ->select(
                'bc.bite_case_id',
                'bc.case_number',
                'bc.category',
                'bc.date_verified',
                'p.patient_id',
                'p.patient_name',
                DB::raw("CASE
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
        return $this->assignedToMe(DB::table('bite_cases as bc'))
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
        $case = $this->ownCase($biteCaseId);

        // A draft saves whatever is filled in; moving on needs the core fields
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'total_wounds' => $required . '|in:Single,Multiple',
            // Wound description: one or more of the listed wound types
            'wound_types' => $isDraft ? 'nullable|array' : 'required|array|min:1',
            'wound_types.*' => 'in:' . implode(',', self::WOUND_TYPES),
            'is_deep' => $required . '|in:0,1',
            'site_of_bite' => $required . '|string|max:100',
            'category_of_exposure' => $required . '|in:I,II,III',
        ]);

        $isDeep = isset($validated['is_deep']) ? (int) $validated['is_deep'] : null;

        // Fall back to whatever bite_cases already has if this form hasn't set a
        // category yet (e.g. very first save). A deep wound is always Category III.
        $category = $validated['category_of_exposure'] ?? $case->category;
        if ($isDeep === 1) {
            $category = 'III';
        }

        DB::table('bite_section6_wound_description')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            [
                'total_wounds' => $validated['total_wounds'] ?? null,
                'wound_description' => implode(', ', $validated['wound_types'] ?? []) ?: null,
                'is_deep' => $isDeep,
                'site_of_bite' => $validated['site_of_bite'] ?? null,
                'category_of_exposure' => $category,
            ]
        );

        // Keep bite_cases.category in sync, since bite_section6's column
        // comment says it mirrors this value - if the health worker changes
        // it here, bite_cases should reflect the same category.
        if ($category !== $case->category) {
            DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update([
                'category' => $category,
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

        // Weight taken at the BHW referral, if this patient came through one
        $bhwWeight = $biteCaseId ? $this->bhwWeight($biteCaseId) : null;

        return view('healthworker.CE_VII', compact('queue', 'case', 'section', 'bhwWeight'));
    }

    /**
     * Weight (kg) recorded in the BHW referral vitals for this case, or null when the
     * patient is a walk-in or the referral has no weight. A case links to its referral
     * through bite_cases.bhw_referral_id or the reference number on the walk-in record.
     */
    private function bhwWeight($biteCaseId): ?string
    {
        $weight = DB::table('bite_cases as bc')
            ->leftJoin('inflow_general_particulars as ig', 'ig.inflow_record_id', '=', 'bc.inflow_record_id')
            ->join('bhw_referral_info as bri', function ($j) {
                $j->on('bri.referral_id', '=', 'bc.bhw_referral_id')
                    ->orOn('bri.reference_no', '=', 'ig.bhw_referral_id');
            })
            ->join('bhw_referral_vitals as v', 'v.referral_id', '=', 'bri.referral_id')
            ->where('bc.bite_case_id', $biteCaseId)
            ->whereNotNull('v.weight_kg')
            ->value('v.weight_kg');

        return $weight === null ? null : rtrim(rtrim(number_format((float) $weight, 2, '.', ''), '0'), '.');
    }

    public function storeSectionVII(Request $request, $biteCaseId)
    {
        $case = $this->ownCase($biteCaseId);

        // Passive immunization is only for Category III: nothing is accepted for other categories
        if ($case->category !== 'III') {
            $request->merge(['passive_type' => null, 'passive_route' => null]);
        }

        // A draft saves whatever is filled in, required or not; moving on to
        // Section VIII needs the core fields.
        $isDraft = $request->input('action') === 'draft';
        $required = $isDraft ? 'nullable' : 'required';

        $validated = $request->validate([
            'tetanus_given' => 'nullable|boolean',
            'tetanus_details' => 'exclude_unless:tetanus_given,true,1|' . $required . '|string|max:200',
            'tig_given' => 'nullable|boolean',
            'tig_details' => 'exclude_unless:tig_given,true,1|' . $required . '|string|max:200',
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
            'passive_route' => 'nullable|required_with:passive_type|in:ID,SC',
        ]);

        // Patient weight always comes from the BHW referral, never from the form
        // (a case with no BHW weight keeps whatever was saved before)
        if (($bhwWeight = $this->bhwWeight($biteCaseId)) !== null) {
            $validated['patient_weight'] = $bhwWeight;
        }

        // Administered by is always the logged-in health worker: never taken from the form
        // (a guest session leaves whatever was saved before untouched)
        if ($name = Auth::user()->full_name ?? null) {
            $validated['administered_by'] = $name;
        }

        // "Given at the barangay (by the BHW)" counts as given
        $validated['tetanus_by_barangay'] = $request->boolean('tetanus_by_barangay');
        $validated['tig_by_barangay'] = $request->boolean('tig_by_barangay');
        $validated['tetanus_given'] = $request->boolean('tetanus_given') || $validated['tetanus_by_barangay'];
        $validated['tig_given'] = $request->boolean('tig_given') || $validated['tig_by_barangay'];
        $validated['passive_given'] = !empty($validated['passive_type']);
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
        $this->ownCase($biteCaseId);

        // Nothing is required in this section; a draft just stays on the page
        $isDraft = $request->input('action') === 'draft';

        $validated = $request->validate([
            'medication' => 'nullable|string|max:5000',
            'advice' => 'nullable|string|max:5000',
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
        $this->ownCase($biteCaseId);

        // The notes are optional and can be left blank, even when finalizing
        $isDraft = $request->input('action') === 'draft';

        $validated = $request->validate([
            'day3_notes' => 'nullable|string|max:5000',
            'day7_notes' => 'nullable|string|max:5000',
            'day28_notes' => 'nullable|string|max:5000',
        ]);

        DB::table('bite_section9_progress_notes')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        if ($isDraft) {
            return back()->with('status', 'Section IX saved as draft.');
        }

        // Finalized: mark the case Completed so it drops out of the queue
        DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update(['outcome' => 'Completed']);

        // Last section - stay in Clinical Encoding: back to the queue with no case selected,
        // where the finalized case no longer appears
        return redirect()->route('healthworker.clinical-encoding')
            ->with('status', 'Clinical encoding completed for this case.');
    }

    // ---------------------------------------------------------------
    // Health Worker Dashboard
    // ---------------------------------------------------------------

    public function dashboard()
    {
        $today = now()->toDateString();

        // Cases still in Clinical Encoding / PEP (finalized ones have outcome = 'Completed')
        $unfinished = fn () => $this->handedOff(DB::table('bite_cases as bc'))->where(function ($q) {
            $q->whereNull('bc.outcome')->orWhere('bc.outcome', '<>', 'Completed');
        });

        $stats = [
            'pending' => $unfinished()->count(),
            'pending_cat3' => $unfinished()->where('bc.category', 'III')->count(),
            'active_pep' => $unfinished()
                ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
                ->whereNotNull('s7.day0_date')->count(),
            'started_today' => $unfinished()
                ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
                ->where('s7.day0_date', $today)->count(),
            'verified_today' => $this->handedOff(DB::table('bite_cases as bc'))->whereDate('bc.date_verified', $today)->count(),
            'encoding_started_today' => $this->handedOff(DB::table('bite_cases as bc'))
                ->join('bite_section6_wound_description as s6', 's6.bite_case_id', '=', 'bc.bite_case_id')
                ->whereDate('bc.date_verified', $today)->count(),
        ];
        $stats['encoded_pct'] = $stats['verified_today']
            ? (int) round($stats['encoding_started_today'] / $stats['verified_today'] * 100)
            : 0;

        // Priority queue: Category III first, then longest-waiting first
        $queue = $unfinished()
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->leftJoin('inflow_general_particulars as ig', 'ig.inflow_record_id', '=', 'bc.inflow_record_id')
            ->leftJoin('bite_section6_wound_description as s6', 's6.bite_case_id', '=', 'bc.bite_case_id')
            ->leftJoin('bite_section9_progress_notes as s9', 's9.bite_case_id', '=', 'bc.bite_case_id')
            ->select(
                'bc.bite_case_id',
                'bc.case_number',
                'bc.category',
                'bc.date_verified',
                'p.patient_id',
                'p.patient_name',
                'ig.queue_id',
                DB::raw("CASE
                    WHEN s9.progress_id IS NOT NULL OR s6.wound_desc_id IS NOT NULL THEN 'In Progress'
                    ELSE 'Not Started'
                END as encoding_status")
            )
            ->orderByRaw("CASE WHEN bc.category = 'III' THEN 0 ELSE 1 END")
            ->orderBy('bc.date_verified')
            ->limit(10)
            ->get();

        // Reminders: PEP doses that are due or overdue, worked out from the Day 0 date
        // (Primary: Day 3 / 7 / 28, Booster: Day 3), skipping doses already recorded
        $reminders = [];
        $immunizations = $unfinished()
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            ->select('bc.bite_case_id', 'p.patient_name', 's7.dose_type', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day28_date')
            ->get();

        foreach ($immunizations as $row) {
            $days = $row->dose_type === 'Booster' ? [3] : [3, 7, 28];
            foreach ($days as $day) {
                $due = \Carbon\Carbon::parse($row->day0_date)->addDays($day)->startOfDay();
                // Already given, or not due yet
                if ($row->{'day' . $day . '_date'} || $due->isFuture()) {
                    continue;
                }
                $reminders[] = (object) [
                    'bite_case_id' => $row->bite_case_id,
                    'patient_name' => $row->patient_name,
                    'day' => $day,
                    'due' => $due,
                    'overdue_by' => (int) $due->diffInDays(now()->startOfDay()),
                ];
            }
        }
        usort($reminders, fn ($a, $b) => $b->overdue_by <=> $a->overdue_by);
        $reminders = array_slice($reminders, 0, 5);

        // Recent activity, from the dates the system records: newly verified cases
        // and PEP doses that were given
        $activity = [];
        $verified = $this->handedOff(DB::table('bite_cases as bc'))
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->orderByDesc('bc.date_verified')->limit(5)
            ->get(['bc.bite_case_id', 'bc.category', 'bc.date_verified', 'p.patient_name']);
        foreach ($verified as $v) {
            $activity[] = (object) [
                'at' => \Carbon\Carbon::parse($v->date_verified),
                'type' => 'verified',
                'title' => 'New Case Verified',
                'text' => $v->patient_name . ' (Cat ' . $v->category . ') is ready for clinical encoding.',
            ];
        }
        $doses = $this->handedOff(DB::table('bite_section7_immunization as s7')
            ->join('bite_cases as bc', 'bc.bite_case_id', '=', 's7.bite_case_id'))
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->get(['p.patient_name', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day28_date']);
        foreach ($doses as $d) {
            foreach ([0, 3, 7, 28] as $day) {
                $date = $d->{'day' . $day . '_date'};
                if ($date) {
                    $activity[] = (object) [
                        'at' => \Carbon\Carbon::parse($date),
                        'type' => 'dose',
                        'title' => 'Day ' . $day . ' Dose Recorded',
                        'text' => $d->patient_name . ' received the Day ' . $day . ' PEP dose.',
                    ];
                }
            }
        }
        usort($activity, fn ($a, $b) => $b->at <=> $a->at);
        $activity = array_slice($activity, 0, 6);

        return view('healthworker.dashboard', compact('stats', 'queue', 'reminders', 'activity'));
    }
}