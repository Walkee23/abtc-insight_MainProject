<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\Audit;
use App\Support\PepSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;

class ClinicalEncodingController extends Controller
{
    /** The vaccine brands a dose can be given with (stored with these exact names). */
    public const VACCINE_BRANDS = ['VERORAB (PVRV)', 'SPEEDA (PVRV)', 'VAXIRAB (PCEC)', 'ABHAYRAB (PVRV)'];

    /** Wound types the health worker can pick in Section VI (stored comma-separated in wound_description). */
    public const WOUND_TYPES = ['Punctured', 'Lacerated', 'Avulsion', 'Abrasion'];

    /** bite_cases.outcome of a Category I case the health worker discharged (no vaccine needed). */
    public const DISCHARGED = 'Discharged (Cat. I)';

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

    /**
     * Cases Staff has finished that no Health Worker owns yet: the pool Health Workers
     * pick from. Once one claims a case it leaves this pool and only that account can
     * open or change it (see ownCase).
     */
    private function unclaimed($query, string $alias = 'bc')
    {
        return $query
            ->whereExists(function ($e) use ($alias) {
                $e->select(DB::raw(1))->from('inflow_general_particulars as hg')
                    ->whereColumn('hg.inflow_record_id', $alias . '.inflow_record_id')
                    ->where('hg.status', 'Encoded');
            })
            ->whereNull($alias . '.assigned_health_worker_id')
            ->whereNull($alias . '.outcome');
    }

    /**
     * Claim an unassigned case. One UPDATE that only matches while nobody owns the case,
     * so if two Health Workers click at the same moment exactly one gets it.
     */
    public function claim($biteCaseId)
    {
        $userId = Auth::id();
        abort_unless($userId, 403);

        $claimed = $this->unclaimed(DB::table('bite_cases as bc'))
            ->where('bc.bite_case_id', $biteCaseId)
            ->update(['bc.assigned_health_worker_id' => $userId]);

        if ($claimed !== 1) {
            return redirect()->route('healthworker.dashboard')
                ->with('claim_error', 'That case is no longer available. Another Health Worker already took it.');
        }

        $case = DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->first();
        Audit::log('case_claimed', "Claimed case #{$case->case_number} of patient {$case->patient_id}");

        return redirect()->route('healthworker.clinical-encoding', ['bite_case_id' => $biteCaseId])
            ->with('status', 'Case claimed. It is now yours and hidden from other Health Workers.');
    }

    /** Give a case back to the pool. Only its owner can do this, and finished cases stay put. */
    public function release($biteCaseId)
    {
        $case = $this->ownCase($biteCaseId);

        $released = DB::table('bite_cases')
            ->where('bite_case_id', $biteCaseId)
            ->where('assigned_health_worker_id', Auth::id())
            ->whereNull('outcome')
            ->update(['assigned_health_worker_id' => null]);

        if ($released === 1) {
            Audit::log('case_released', "Released case #{$case->case_number} of patient {$case->patient_id} back to the unclaimed pool");
        }

        return redirect()->route('healthworker.dashboard')
            ->with('status', $released === 1 ? 'Case released. Other Health Workers can now claim it.' : 'Finished cases cannot be released.');
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
                $q->whereNull('bc.outcome');
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

        // A draft saves whatever is filled in; moving on (or discharging) needs the core fields
        $isDraft = $request->input('action') === 'draft';
        $isDischarge = $request->input('action') === 'discharge';
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

        // Only a Category I patient can be discharged: no vaccine is needed
        if ($isDischarge && $category !== 'I') {
            return back()->withInput()->withErrors(['category_of_exposure' => 'Only Category I patients can be discharged.']);
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

        if ($isDischarge) {
            DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update(['outcome' => self::DISCHARGED]);
            Audit::log('case_discharged', "Discharged case #{$case->case_number} of patient {$case->patient_id} (Category I, no vaccine needed)");

            // The case leaves the queue, so go back to Clinical Encoding with nothing selected
            return redirect()->route('healthworker.clinical-encoding')
                ->with('status', 'Patient discharged: Category I, no vaccine needed.');
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
            // the brand is chosen per dose: Day 0 always, the other days only when that dose has a date
            'day0_brand' => [$isDraft ? 'nullable' : 'required', \Illuminate\Validation\Rule::in(self::VACCINE_BRANDS)],
            'day3_brand' => [$isDraft ? 'nullable' : 'required_with:day3_date', 'nullable', \Illuminate\Validation\Rule::in(self::VACCINE_BRANDS)],
            'day7_brand' => [$isDraft ? 'nullable' : 'required_with:day7_date', 'nullable', \Illuminate\Validation\Rule::in(self::VACCINE_BRANDS)],
            'day14_brand' => [$isDraft ? 'nullable' : 'required_with:day14_date', 'nullable', \Illuminate\Validation\Rule::in(self::VACCINE_BRANDS)],
            'day28_brand' => [$isDraft ? 'nullable' : 'required_with:day28_date', 'nullable', \Illuminate\Validation\Rule::in(self::VACCINE_BRANDS)],
            'route' => $required . '|in:ID,IM',
            'dose_type' => $required . '|in:Primary,Booster',
            'day0_date' => $required . '|date|before_or_equal:today',
            'day3_date' => 'nullable|date|before_or_equal:today',
            'day7_date' => 'nullable|date|before_or_equal:today',
            'day14_date' => 'nullable|date|before_or_equal:today',
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

        // "Given at the barangay (by the BHW)" counts as given
        $validated['tetanus_by_barangay'] = $request->boolean('tetanus_by_barangay');
        $validated['tig_by_barangay'] = $request->boolean('tig_by_barangay');
        $validated['tetanus_given'] = $request->boolean('tetanus_given') || $validated['tetanus_by_barangay'];
        $validated['tig_given'] = $request->boolean('tig_given') || $validated['tig_by_barangay'];
        $validated['passive_given'] = !empty($validated['passive_type']);
        // dose_type is NOT NULL in the table: an unchosen value on a draft is stored
        // as '' (shows as "Select" again) rather than a made-up default
        $validated['dose_type'] = $validated['dose_type'] ?? '';

        // The dose dates follow the dose type and route (App\Support\PepSchedule): Primary IM = Day 0, 3, 7, 14;
        // Primary ID = Day 0, 3, 7, 28; Booster = Day 0, 3. A dose that is not part of the course keeps nothing:
        // no date, no brand, no "administered by".
        $courseDays = PepSchedule::days($validated['dose_type'], $validated['route'] ?? null);
        $existing = DB::table('bite_section7_immunization')->where('bite_case_id', $biteCaseId)->first();
        $me = Auth::user()->full_name ?? null;   // a guest session leaves whatever was saved before untouched

        foreach ([0, 3, 7, 14, 28] as $day) {
            $date = 'day' . $day . '_date';
            $brand = 'day' . $day . '_brand';
            $by = 'day' . $day . '_administered_by';

            if (!in_array($day, $courseDays, true)) {
                $validated[$date] = null;
                $validated[$brand] = null;
                $validated[$by] = null;
                continue;
            }
            if (empty($validated[$date])) {
                $validated[$by] = null;   // no date, so nobody gave this dose yet
                continue;
            }
            // Each dose is given by whoever recorded it: saving another visit never changes it. Only a dose that is newly
            // recorded (or whose date was changed) belongs to the person saving now.
            $wasDate = $existing->{$date} ?? null;
            $wasBy = $existing->{$by} ?? null;
            $unchanged = $wasBy && $wasDate && substr((string) $wasDate, 0, 10) === substr((string) $validated[$date], 0, 10);
            $validated[$by] = $unchanged ? $wasBy : ($me ?: $wasBy);
        }

        // the older single columns mirror the Day 0 dose (nothing reads them any more, but old exports may)
        $validated['vaccine_brand'] = array_key_exists('day0_brand', $validated) ? $validated['day0_brand'] : ($existing->vaccine_brand ?? null);
        $validated['administered_by'] = $validated['day0_administered_by'] ?? ($existing->administered_by ?? null);

        DB::table('bite_section7_immunization')->updateOrInsert(
            ['bite_case_id' => $biteCaseId],
            $validated
        );

        // The dose the patient checked in for (Returning Patient) is now recorded: clear the mark
        if ($case->return_dose_day && !empty($validated['day' . $case->return_dose_day . '_date'])) {
            DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update(['return_dose_day' => null, 'returned_at' => null]);
        }

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

        // Finalizing a visit only completes the case when EVERY dose of its course is recorded (route-based schedule).
        // Otherwise the case stays open, with the doses saved so far, until the patient comes back for the next one.
        $s7 = DB::table('bite_section7_immunization')->where('bite_case_id', $biteCaseId)->first();
        $nextDose = ($s7 && $s7->day0_date) ? PepSchedule::nextDay($s7->dose_type, $s7->route, $s7) : null;

        if ($nextDose === null) {
            // The course is finished: mark the case Completed so it drops out of the queue
            DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->update(['outcome' => 'Completed']);
        }

        $patientId = DB::table('bite_cases')->where('bite_case_id', $biteCaseId)->value('patient_id');

        $qrImage = (new QRCode(new QROptions([
            'outputInterface' => QRMarkupSVG::class,
            'outputBase64'    => true,   // returns a data:image/svg+xml;base64,... string for <img src>
            'scale'      => 6,
        ])))->render($patientId);

        $qrPopup = ['patient_id' => $patientId, 'image' => $qrImage];

        // Last section - back to the queue; the QR pop-up shows there
        return redirect()->route('healthworker.clinical-encoding')
            ->with('status', $nextDose === null
                ? 'Clinical encoding completed for this case.'
                : "Visit saved. The case stays open: the patient registers again for the Day {$nextDose} dose.")
            ->with('qr_popup', $qrPopup);   // the patient's ID, so they have it for the next visit
    }

    // ---------------------------------------------------------------
    // Health Worker Dashboard
    // ---------------------------------------------------------------

    public function dashboard()
    {
        $today = now()->toDateString();

        // Cases still in Clinical Encoding / PEP (finalized or discharged ones have an outcome)
        $unfinished = fn () => $this->handedOff(DB::table('bite_cases as bc'))->where(function ($q) {
            $q->whereNull('bc.outcome');
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

        // Unclaimed pool: handed-off cases nobody owns yet (Category III first, longest-waiting first)
        // Filters (all optional): search text, WHO category, and new vs returning
        $uFilter = [
            'q'    => trim((string) request('uq', '')),
            'cat'  => in_array(request('ucat'), ['I', 'II', 'III'], true) ? request('ucat') : '',
            'type' => in_array(request('utype'), ['new', 'returning'], true) ? request('utype') : '',
        ];
        $unclaimedQuery = fn () => $this->unclaimed(DB::table('bite_cases as bc'))
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->leftJoin('inflow_general_particulars as ig', 'ig.inflow_record_id', '=', 'bc.inflow_record_id')
            ->when($uFilter['q'] !== '', function ($q) use ($uFilter) {
                // every typed word must appear in the name; the whole text may also be a patient ID or queue number
                $words = array_filter(preg_split('/[\s,]+/', $uFilter['q']), fn ($w) => $w !== '');
                $q->where(function ($w) use ($words, $uFilter) {
                    $w->where(function ($n) use ($words) {
                        foreach ($words as $word) {
                            $n->where('p.patient_name', 'like', '%' . $word . '%');
                        }
                    })->orWhere('p.patient_id', 'like', '%' . $uFilter['q'] . '%')
                      ->orWhere('ig.queue_id', 'like', '%' . $uFilter['q'] . '%');
                });
            })
            ->when($uFilter['cat'] !== '', fn ($q) => $q->where('bc.category', $uFilter['cat']))
            ->when($uFilter['type'] === 'new', fn ($q) => $q->whereNull('bc.return_dose_day')->where('bc.case_number', '<=', 1))
            ->when($uFilter['type'] === 'returning', fn ($q) => $q->where(fn ($r) => $r->whereNotNull('bc.return_dose_day')->orWhere('bc.case_number', '>', 1)))
            ->orderByRaw("CASE WHEN bc.category = 'III' THEN 0 ELSE 1 END")
            ->orderByRaw('COALESCE(bc.returned_at, bc.date_verified)');
        // 5 per page; a page past the end (e.g. the last case on it was just claimed) falls back to the last page
        $unclaimedPages = max(1, (int) ceil($unclaimedQuery()->count() / 5));
        $unclaimedPage = min(max(1, (int) request('unclaimed_page', 1)), $unclaimedPages);
        $unclaimed = $unclaimedQuery()
            ->paginate(5, ['bc.bite_case_id', 'bc.case_number', 'bc.category', 'bc.date_verified', 'bc.return_dose_day', 'bc.returned_at', 'p.patient_id', 'p.patient_name', 'ig.queue_id'], 'unclaimed_page', $unclaimedPage)
            ->fragment('unclaimed')
            ->withQueryString();

        // Reminders: PEP doses that are due or overdue, worked out from the Day 0 date and the case's route
        // (App\Support\PepSchedule: Primary IM Day 3 / 7 / 14, Primary ID Day 3 / 7 / 28, Booster Day 3),
        // skipping doses already recorded
        $reminders = [];
        $immunizations = $unfinished()
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            ->select('bc.bite_case_id', 'p.patient_name', 's7.dose_type', 's7.route', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day14_date', 's7.day28_date')
            ->get();

        foreach ($immunizations as $row) {
            $days = PepSchedule::followUpDays($row->dose_type, $row->route);
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
        usort($reminders, fn($a, $b) => $b->overdue_by <=> $a->overdue_by);
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
            ->get(['p.patient_name', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day14_date', 's7.day28_date']);
        foreach ($doses as $d) {
            foreach ([0, 3, 7, 14, 28] as $day) {
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
        usort($activity, fn($a, $b) => $b->at <=> $a->at);
        $activity = array_slice($activity, 0, 6);

        return view('healthworker.dashboard', compact('stats', 'queue', 'unclaimed', 'uFilter', 'reminders', 'activity'));
    }
}
