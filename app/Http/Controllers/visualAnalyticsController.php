<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class visualAnalyticsController extends Controller
{
    /**
     * Main entry point for Visual Analytics dashboard.
     */
   public function visualAnalytics(Request $request)
{
    $query = $this->analyticsQuery($request);

    // --- KPI METRICS ---
    $analyticsTotalBites = (clone $query)->count();
    $totalBites = $analyticsTotalBites; // Alias for filter description text
    // Unique patients: how many DIFFERENT people the matching records belong to. A person with two (or more)
    // records is one registered patient, so they count once. A person is the same name + birthdate; the
    // comparison ignores capitals and accents (Nino = Niño), like the database's own text comparison. A record
    // with no name at all cannot be matched to anyone, so it counts as its own person.
    $analyticsUniquePatients = (int) (clone $query)
        ->selectRaw("COUNT(DISTINCT IF(inflow_general_particulars.patient_name IS NULL OR TRIM(inflow_general_particulars.patient_name) = '', "
            . "CONCAT('#', inflow_general_particulars.inflow_record_id), "
            . "CONCAT(TRIM(inflow_general_particulars.patient_name), '|', IFNULL(inflow_general_particulars.date_of_birth, '')))) as people")
        ->value('people');
    $uniquePatients = $analyticsUniquePatients;
    $analyticsAvgAge = round((clone $query)->avg('inflow_general_particulars.age'), 1);

    // Exposure categories: exact values only. (LIKE '%I%' also matches "II" and "III", which used to
    // push every case into Category I.) Same spellings the Admin dashboard accepts.
    $catExpr = 'UPPER(TRIM(bite_cases.category))';
    $cat1 = (clone $query)->whereIn(DB::raw($catExpr), ['I', '1', 'CAT I', 'CAT 1', 'CATEGORY I', 'CATEGORY 1'])->count();
    $cat2 = (clone $query)->whereIn(DB::raw($catExpr), ['II', '2', 'CAT II', 'CAT 2', 'CATEGORY II', 'CATEGORY 2'])->count();
    $cat3 = (clone $query)->whereIn(DB::raw($catExpr), ['III', '3', '03', 'CAT III', 'CAT 3', 'CATEGORY III', 'CATEGORY 3'])->count();
    $analyticsCat3Count = $cat3;
    $analyticsCat3Pct = $analyticsTotalBites > 0 ? round(($cat3 / $analyticsTotalBites) * 100, 1) : 0;

    $completedCount = (clone $query)->where('bite_cases.outcome', 'Completed')->count();
    $analyticsPepCompletion = $analyticsTotalBites > 0 ? round(($completedCount / $analyticsTotalBites) * 100, 1) : 0;

    // --- DEMOGRAPHIC & EXPOSURE BREAKDOWN (the three donut charts) ---
    $maleCount = (clone $query)->where('inflow_general_particulars.sex', 'Male')->count();
    $femaleCount = (clone $query)->where('inflow_general_particulars.sex', 'Female')->count();

    // animal type: from the exposure record of each case (cases without one are left out, not guessed)
    $animals = (clone $query)
        ->join('bite_section3_exposure as ex', 'ex.bite_case_id', '=', 'bite_cases.bite_case_id')
        ->whereNotNull('ex.animal_type')
        ->where('ex.animal_type', '!=', '')
        ->selectRaw("COUNT(*) as known, COALESCE(SUM(UPPER(TRIM(ex.animal_type)) = 'DOG'), 0) as dogs, COALESCE(SUM(UPPER(TRIM(ex.animal_type)) = 'CAT'), 0) as cats")
        ->first();
    $dogCount = (int) ($animals->dogs ?? 0);
    $catAnimalCount = (int) ($animals->cats ?? 0);
    $otherAnimalCount = max(0, (int) ($animals->known ?? 0) - $dogCount - $catAnimalCount);

    // pet / stray: from animal_ownership of each case's exposure record (cases without a value are left out)
    $ownRows = (clone $query)
        ->join('bite_section3_exposure as ow', 'ow.bite_case_id', '=', 'bite_cases.bite_case_id')
        ->whereIn('ow.animal_ownership', ['Pet', 'Stray'])
        ->selectRaw("UPPER(TRIM(ow.animal_type)) as animal, ow.animal_ownership as ownership, COUNT(*) as total")
        ->groupBy('animal', 'ownership')
        ->get();

    $own = [
        'dog'   => ['Pet' => 0, 'Stray' => 0],
        'cat'   => ['Pet' => 0, 'Stray' => 0],
        'other' => ['Pet' => 0, 'Stray' => 0],
    ];
    foreach ($ownRows as $r) {
        $key = $r->animal === 'DOG' ? 'dog' : ($r->animal === 'CAT' ? 'cat' : 'other');
        $own[$key][$r->ownership] += (int) $r->total;
    }
    $petCount   = $own['dog']['Pet']   + $own['cat']['Pet']   + $own['other']['Pet'];
    $strayCount = $own['dog']['Stray'] + $own['cat']['Stray'] + $own['other']['Stray'];

    // colours are used for the legend dot AND the slice, so they always match
    $breakdowns = [
        'exposure' => $this->donut([['Category III', $cat3, '#002d6b'], ['Category II', $cat2, '#0b61bb'], ['Category I', $cat1, '#49607f']]),
        'sex' => $this->donut([['Male', $maleCount, '#3b82f6'], ['Female', $femaleCount, '#f472b6']]),
        'animal' => $this->donut([['Dogs', $dogCount, '#004a93'], ['Cats', $catAnimalCount, '#D4AF37'], ['Others', $otherAnimalCount, '#8b95a5']]),
        'ownership' => $this->donut([['Pet', $petCount, '#059669'], ['Stray', $strayCount, '#fb923c']]),
    ];
    // --- AGE GROUP DISTRIBUTION ---
    // One count per group; shares are of the cases that HAVE an age, and add up to exactly 100.
    $ageGroups = [['0-12', 0, 12], ['13-19', 13, 19], ['20-39', 20, 39], ['40-59', 40, 59], ['60+', 60, 200]];
    $ageSelect = [];
    foreach ($ageGroups as $i => [$label, $from, $to]) {
        $ageSelect[] = "COALESCE(SUM(inflow_general_particulars.age BETWEEN {$from} AND {$to}), 0) as g{$i}";
    }
    $ageRow = (clone $query)->selectRaw(implode(', ', $ageSelect))->first();
    $ageCounts = [];
    foreach ($ageGroups as $i => $g) {
        $ageCounts[$i] = (int) ($ageRow->{'g' . $i} ?? 0);
    }
    $ageKnown = array_sum($ageCounts);
    $ageShares = $this->shares($ageCounts, 1);
    $ageMax = max($ageCounts) ?: 1;
    $ageColors = ['#9fc0ee', '#6c9be0', '#2f78cf', '#0b4fa3', '#002d6b'];   // young -> old, lightest to darkest
    $ageBars = [];
    foreach ($ageGroups as $i => [$label]) {
        $ageBars[] = ['label' => $label, 'count' => $ageCounts[$i], 'pct' => $ageShares[$i], 'height' => round($ageCounts[$i] / $ageMax * 100, 2), 'color' => $ageColors[$i]];
    }
    $ageChart = ['bars' => $ageBars, 'known' => $ageKnown, 'unknown' => max(0, $analyticsTotalBites - $ageKnown)];
    // --- CHART (Total, New, Returning) ---
    // One grouped query over the chosen range (filters applied, no other window); every bucket of the
    // range - day, week, month, quarter or year - is then filled from it, empty ones with zero.
    $ctx = $this->analyticsContext($request);
    $chartBase = $this->analyticsQuery($request, false);
    $col = 'inflow_general_particulars.queue_date';

    $grouped = (clone $chartBase)
        ->whereBetween($col, [$ctx['from']->toDateString(), $ctx['to']->toDateString()])
        ->selectRaw($ctx['key_sql'] . ' as bucket_key, COUNT(*) as total, SUM(bite_cases.case_number = 1) as new_cases, SUM(bite_cases.case_number > 1) as returning_cases')
        ->groupBy('bucket_key')
        ->get()
        ->keyBy(fn ($row) => (string) $row->bucket_key);

    $chartLabels = [];
    $totalCasesData = [];
    $newCasesData = [];
    $returningCasesData = [];
    foreach ($ctx['buckets'] as $bucket) {
        $row = $grouped->get((string) $bucket['key']);
        $chartLabels[] = $bucket['label'];
        $totalCasesData[] = (int) ($row->total ?? 0);
        $newCasesData[] = (int) ($row->new_cases ?? 0);
        $returningCasesData[] = (int) ($row->returning_cases ?? 0);
    }
    $chartSubtitle = $ctx['subtitle'];
    $rangeValues = $ctx['values'];
    $analyticsYears = $ctx['years'];
    $quarterOptions = $ctx['quarters'];
    $rangeBounds = $ctx['bounds'];
    $rangeNotice = $ctx['notice'];
    $rangeFrom = $ctx['from']->toDateString();
    $rangeTo = $ctx['to']->toDateString();
    // --- TOP BARANGAYS RANKING (Limit to Top 15) ---
    // Exact counts per barangay; ties are ordered by name so the list never reshuffles. Every share is of ALL the
    // cases matching the filters, and the cases of the remaining barangays (and places outside Cebu City) are
    // added as "All others", so the shares add up to exactly 100%.
    $topBarangays = (clone $query)
        ->select('inflow_general_particulars.barangay', DB::raw('count(*) as total'))
        ->groupBy('inflow_general_particulars.barangay')
        ->orderByDesc('total')
        ->orderBy('inflow_general_particulars.barangay')
        ->limit(15)
        ->get();

    $topCounts = $topBarangays->pluck('total')->map(fn ($n) => (int) $n)->all();
    $otherCases = max(0, $analyticsTotalBites - array_sum($topCounts));
    $brgyShares = $this->shares(array_merge($topCounts, [$otherCases]), 1);
    $brgyMax = max($topCounts ?: [1]) ?: 1;
    $brgyRows = [];
    foreach ($topBarangays as $i => $b) {
        $name = trim((string) $b->barangay);
        $brgyRows[] = ['name' => $name !== '' ? $name : 'Not recorded', 'count' => $topCounts[$i], 'pct' => $brgyShares[$i], 'width' => round($topCounts[$i] / $brgyMax * 100, 2)];
    }
    $barangayChart = [
        'rows' => $brgyRows,
        'total' => $analyticsTotalBites,
        'other' => [
            'count' => $otherCases,
            'pct' => $brgyShares[count($topCounts)] ?? 0,
            'places' => max(0, (clone $query)->distinct()->count('inflow_general_particulars.barangay') - count($topCounts)),
        ],
    ];
    return view('admin.V_and_A', compact(
        'analyticsTotalBites',
        'totalBites',
        'analyticsUniquePatients',
        'uniquePatients',
        'analyticsCat3Count',
        'analyticsCat3Pct',
        'analyticsAvgAge',
        'analyticsPepCompletion',
        'totalCasesData',
        'newCasesData',
        'returningCasesData',
        'chartLabels',
        'chartSubtitle',
        'analyticsYears',
        'quarterOptions',
        'rangeValues',
        'rangeBounds',
        'rangeNotice',
        'rangeFrom',
        'rangeTo',
        'barangayChart',
        'ageChart',
        'breakdowns',
        'breakdowns',
        'own'
    ));
}


public function generateReport(Request $request)
{
    $filter = $request->input('filter', $request->input('group', 'all'));
    if (!in_array($filter, ['all', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly'])) {
        $filter = 'all';
    }

    $col = 'inflow_general_particulars.queue_date';

    // BASE: inflow_general_particulars (parehas sa dashboard), leftJoin sa bite_cases
    $query = DB::table('inflow_general_particulars')
        ->leftJoin('bite_cases', 'inflow_general_particulars.inflow_record_id', '=', 'bite_cases.inflow_record_id')
        ->select(
            'inflow_general_particulars.inflow_record_id',
            'inflow_general_particulars.id_number',
            'inflow_general_particulars.patient_name',
            'inflow_general_particulars.date_of_birth',
            'inflow_general_particulars.age',
            'inflow_general_particulars.sex',
            'inflow_general_particulars.barangay',
            'inflow_general_particulars.queue_date',
            'bite_cases.bite_case_id',
            'bite_cases.category',
            'bite_cases.outcome'
        );

    $appliedFilters = [];

    // --- 1. DATE FILTERS ---
    $hasCustomRange = $request->filled('date_from') || $request->filled('date_to');

    if ($hasCustomRange) {
        if ($request->filled('date_from')) {
            $query->whereDate($col, '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate($col, '<=', $request->date_to);
        }
        $appliedFilters['Date Range'] =
            ($request->filled('date_from') ? Carbon::parse($request->date_from)->format('M d, Y') : 'Start')
            . ' to ' .
            ($request->filled('date_to') ? Carbon::parse($request->date_to)->format('M d, Y') : 'Present');

    } elseif ($filter !== 'all') {

        if ($filter === 'daily') {
            $day = $request->filled('filter_date') ? Carbon::parse($request->filter_date) : today();
            $query->whereDate($col, $day->toDateString());
            $appliedFilters['Period'] = 'Daily - ' . $day->format('M d, Y');

        } elseif ($filter === 'weekly') {
            $selectedMonth = (int) $request->get('filter_month', date('m'));
            $selectedYear  = (int) $request->get('filter_year', date('Y'));
            $weekIndex     = $request->get('filter_week_index', 'all');

            $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
            $endOfMonth   = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

            if ($weekIndex !== 'all' && is_numeric($weekIndex)) {
                $iter = $startOfMonth->copy();
                for ($i = 1; $i < (int) $weekIndex; $i++) {
                    $iter->addWeek();
                }
                $weekStart = $iter->copy()->max($startOfMonth);
                $weekEnd   = $iter->copy()->endOfWeek()->min($endOfMonth);
                $query->whereBetween($col, [$weekStart->toDateString(), $weekEnd->toDateString()]);
                $appliedFilters['Period'] = 'Weekly - Week ' . $weekIndex . ' of ' . $startOfMonth->format('F Y')
                    . ' (' . $weekStart->format('M d') . ' - ' . $weekEnd->format('M d, Y') . ')';
            } else {
                $query->whereYear($col, $selectedYear)->whereMonth($col, $selectedMonth);
                $appliedFilters['Period'] = 'Weekly - All weeks of ' . $startOfMonth->format('F Y');
            }

        } elseif ($filter === 'monthly') {
            $monthsCount = max(1, (int) $request->get('filter_months_count', 12));
            $from = now()->subMonths($monthsCount - 1)->startOfMonth();
            $query->whereDate($col, '>=', $from->toDateString());
            $appliedFilters['Period'] = 'Monthly - Last ' . $monthsCount . ' month(s) (' . $from->format('M Y') . ' to ' . now()->format('M Y') . ')';

        } elseif ($filter === 'quarterly') {
            $from = now()->startOfQuarter()->subMonths(9);
            $query->whereDate($col, '>=', $from->toDateString());
            $appliedFilters['Period'] = 'Quarterly - Last 4 quarters (' . $from->format('M Y') . ' to ' . now()->format('M Y') . ')';

        } elseif ($filter === 'yearly') {
            $fromYear = (int) date('Y') - 4;
            $query->whereYear($col, '>=', $fromYear);
            $appliedFilters['Period'] = 'Yearly - ' . $fromYear . ' to ' . date('Y');
        }
    } else {
        $appliedFilters['Period'] = 'All Dates (no period filter)';
    }

    // --- 2. INDIVIDUAL FILTERS ---
    if ($request->filled('health_area')) {
        $this->applyHealthArea($query, $request->health_area);
        $appliedFilters['Health Area'] = $request->health_area;
    }
    if ($request->filled('barangay')) {
        $query->where('inflow_general_particulars.barangay', 'LIKE', '%' . $request->barangay . '%');
        $appliedFilters['Barangay'] = $request->barangay;
    }
    if ($request->filled('sex') && $request->sex != 'All') {
        $query->where('inflow_general_particulars.sex', $request->sex);
        $appliedFilters['Sex'] = $request->sex;
    }
    if ($request->filled('age_min') || $request->filled('age_max')) {
        if ($request->filled('age_min')) {
            $query->where('inflow_general_particulars.age', '>=', $request->age_min);
        }
        if ($request->filled('age_max')) {
            $query->where('inflow_general_particulars.age', '<=', $request->age_max);
        }
        $appliedFilters['Age Range'] =
            ($request->filled('age_min') ? $request->age_min : '0') . ' - ' .
            ($request->filled('age_max') ? $request->age_max : 'up');
    }

    $query->orderByDesc($col)->orderByDesc('inflow_general_particulars.inflow_record_id');

    $records = $query->get();

    // --- 3. STATISTICS ---
    // Ihap kada pasyente-record (inflow_record_id) aron parehas sa dashboard
    $totalBites = $records->unique('inflow_record_id')->count();
    // same definition as the Analytics page: one person = same name + birthdate (capitals and accents ignored)
    $uniquePatients = $records->unique(fn($r) => trim((string) $r->patient_name) === ''
        ? '#' . $r->inflow_record_id
        : Str::lower(Str::ascii(trim((string) $r->patient_name))) . '|' . ($r->date_of_birth ?? ''))->count();

    $cat3Count = $records->filter(fn($r) => in_array(
        strtoupper(trim($r->category ?? '')),
        ['III', '3', 'CAT III', 'CAT 3', 'CATEGORY III', 'CATEGORY 3']
    ))->count();
    $cat3Pct = $totalBites > 0 ? round(($cat3Count / $totalBites) * 100) : 0;

    $byPatient = $records->unique('inflow_record_id');
    $avgAge = $totalBites > 0 ? round($byPatient->avg('age'), 1) : 0;

    $completedPep = $records->where('outcome', 'Completed')->count();
    $pepRate = $totalBites > 0 ? round(($completedPep / $totalBites) * 100) : 0;

    $maleCount   = $byPatient->where('sex', 'Male')->count();
    $femaleCount = $byPatient->where('sex', 'Female')->count();
    $malePct     = $totalBites > 0 ? round(($maleCount / $totalBites) * 100) : 0;
    $femalePct   = $totalBites > 0 ? round(($femaleCount / $totalBites) * 100) : 0;

    $age0_12  = $byPatient->filter(fn($r) => $r->age !== null && $r->age >= 0  && $r->age <= 12)->count();
    $age13_19 = $byPatient->filter(fn($r) => $r->age !== null && $r->age >= 13 && $r->age <= 19)->count();
    $age20_39 = $byPatient->filter(fn($r) => $r->age !== null && $r->age >= 20 && $r->age <= 39)->count();
    $age40_59 = $byPatient->filter(fn($r) => $r->age !== null && $r->age >= 40 && $r->age <= 59)->count();
    $age60_up = $byPatient->filter(fn($r) => $r->age !== null && $r->age >= 60)->count();

    $caseIds = $records->pluck('bite_case_id')->filter()->unique()->values();
    $animalRows = $caseIds->isEmpty()
        ? collect()
        : DB::table('bite_section3_exposure')
            ->whereIn('bite_case_id', $caseIds)
            ->select('animal_type', 'animal_ownership', DB::raw('count(*) as total'))
            ->groupBy('animal_type', 'animal_ownership')
            ->get();

    // Dogs, Cats, Others (everything that is not a dog or a cat), each split into Pet / Stray
    $animalBreakdown = [
        'Dogs'   => ['Pet' => 0, 'Stray' => 0, 'Not recorded' => 0],
        'Cats'   => ['Pet' => 0, 'Stray' => 0, 'Not recorded' => 0],
        'Others' => ['Pet' => 0, 'Stray' => 0, 'Not recorded' => 0],
    ];
    foreach ($animalRows as $r) {
        $type = strtoupper(trim((string) $r->animal_type));
        $group = $type === 'DOG' ? 'Dogs' : ($type === 'CAT' ? 'Cats' : 'Others');
        $own = in_array($r->animal_ownership, ['Pet', 'Stray'], true) ? $r->animal_ownership : 'Not recorded';
        $animalBreakdown[$group][$own] += (int) $r->total;
    }

    $hotspots = $byPatient
        ->groupBy('barangay')
        ->map(fn($group, $barangay) => (object) ['barangay' => $barangay, 'total' => $group->count()])
        ->sortByDesc('total')
        ->take(15)
        ->values();

    $dataFrom = $records->min('queue_date');
    $dataTo   = $records->max('queue_date');

    $view = view('admin.official_report_print', compact(
    'filter', 'records', 'totalBites', 'uniquePatients', 'cat3Pct', 'avgAge', 'pepRate',
    'maleCount', 'femaleCount', 'malePct', 'femalePct',
    'age0_12', 'age13_19', 'age20_39', 'age40_59', 'age60_up',
    'animalBreakdown', 'hotspots', 'appliedFilters', 'dataFrom', 'dataTo'
    ))->render();

    $filename = 'ABTC_Comprehensive_Report_' . strtoupper($filter) . '_' . date('Y-m-d') . '.doc';

    return response($view, 200, [
        'Content-Type'        => 'application/msword',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Cache-Control'       => 'max-age=0',
    ]);
}

    /**
     * Export the filtered results of the Visual Analytics page as an Excel sheet (.xls).
     * Only the rows matching the filters currently applied on the page are exported.
     *
     * Same style as the annual barangay export and the annual report: a title block, the filters that were
     * applied, a coloured heading row, numbered and banded rows, and a total. The heading is rendered by
     * admin/filtered_results_excel.blade.php; the rows are streamed after it so even the whole database
     * (tens of thousands of rows) is written without being held in memory.
     * (The route and method keep their old "csv" name.)
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        // the file contains patient names, so only a logged-in Admin may download it
        abort_unless(Auth::check() && Auth::user()->role === 'Admin', 403, 'Please log in as an Admin to export results.');

        $ctx = $this->analyticsContext($request);
        $query = $this->analyticsQuery($request);
        $total = (clone $query)->count();

        // Column widths (px), sized to the longest value in this export so nothing wraps or shows as ####
        // (Excel cannot auto-fit an HTML sheet, so the longest text is measured here instead).
        $longest = (clone $query)->selectRaw(
            'MAX(CHAR_LENGTH(inflow_general_particulars.patient_name)) as patient_name, '
            . 'MAX(CHAR_LENGTH(inflow_general_particulars.barangay)) as barangay, '
            . 'MAX(CHAR_LENGTH(bite_cases.outcome)) as outcome'
        )->first();
        $data = fn (int $chars) => (int) ceil($chars * 8 + 28);       // regular 10pt text
        $caps = fn (string $text) => (int) ceil(strlen($text) * 10 + 30); // bold capitals of the heading
        $widths = [
            max($caps('NO.'), $data(strlen((string) $total))),
            max($caps('DATE'), 118),
            max($caps('PATIENT NAME'), $data((int) ($longest->patient_name ?? 0))),
            max($caps('AGE'), 60),
            max($caps('SEX'), $data(6)),
            max($caps('BARANGAY'), $data((int) ($longest->barangay ?? 0))),
            max($caps('HEALTH AREA'), $data(17)),                      // "Outside Cebu City" is the longest area
            max($caps('CATEGORY'), 60),
            max($caps('OUTCOME'), $data((int) ($longest->outcome ?? 0))),
        ];

        // --- the filters, in words, for the top of the sheet ---
        $periodNames = ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly'];
        $filters = ['Period' => ($ctx['group'] ? $periodNames[$ctx['group']] : 'Year') . ' - ' . $ctx['subtitle']];
        if ($request->filled('health_area')) {
            $filters['Health Area'] = ucfirst(strtolower(trim((string) $request->health_area)));
        }
        if ($request->filled('barangay')) {
            $filters['Barangay'] = 'contains "' . trim((string) $request->barangay) . '"';
        }
        if ($request->filled('sex') && $request->sex != 'All') {
            $filters['Sex'] = $request->sex;
        }
        if ($request->filled('age_min') || $request->filled('age_max')) {
            $filters['Age Range'] = ($request->filled('age_min') ? $request->age_min : '0') . ' - ' . ($request->filled('age_max') ? $request->age_max : 'up');
        }

        // barangay (spelling-insensitive) -> health area, for the HEALTH AREA column
        $norm = fn ($s) => preg_replace('/[^a-z0-9]/', '', strtolower(Str::ascii((string) $s)));
        $areaOf = [];
        foreach ($this->healthAreaDefs() as $areaName => $def) {
            $label = ucfirst(strtolower(str_replace(' HEALTH AREA', '', $areaName)));
            foreach ($def['barangays'] as $b) {
                $areaOf[$norm($b)] = $label;
            }
        }

        $rows = $query
            ->select(
                'inflow_general_particulars.queue_date',
                'inflow_general_particulars.patient_name',
                'inflow_general_particulars.age',
                'inflow_general_particulars.sex',
                'inflow_general_particulars.barangay',
                'bite_cases.category',
                'bite_cases.outcome'
            )
            ->orderBy('inflow_general_particulars.queue_date')
            ->orderBy('inflow_general_particulars.inflow_record_id');

        $head = view('admin.filtered_results_excel', compact('filters', 'total', 'widths'))->render();
        $filename = 'ABTC_Filtered_Results_' . date('Y-m-d_His') . '.xls';

        return response()->streamDownload(function () use ($head, $rows, $total, $areaOf, $norm) {
            $h = fn ($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
            $dash = fn ($v) => ($v === null || $v === '') ? '-' : $h($v);

            echo $head;
            $n = 0;
            foreach ($rows->cursor() as $r) {
                $n++;
                $z = $n % 2 === 0 ? 'z' : '';   // banded rows: the same class with a z, never two classes
                $barangay = trim((string) $r->barangay);
                $area = $areaOf[$norm($barangay)] ?? (stripos($barangay, 'others') === 0 ? 'Outside Cebu City' : '-');
                $cat = (strtoupper(trim((string) $r->category)) === 'III' ? 'b' : 'n') . $z;   // Category III in bold

                echo '<tr>'
                    . '<td class="n' . $z . '">' . $n . '</td>'
                    . '<td class="d' . $z . '">' . $h($r->queue_date) . '</td>'
                    . '<td class="t' . $z . '">' . $h($r->patient_name) . '</td>'
                    . '<td class="n' . $z . '">' . $dash($r->age) . '</td>'
                    . '<td class="n' . $z . '">' . $dash($r->sex) . '</td>'
                    . '<td class="t' . $z . '">' . $dash($barangay) . '</td>'
                    . '<td class="n' . $z . '">' . $h($area) . '</td>'
                    . '<td class="' . $cat . '">' . $dash($r->category) . '</td>'
                    . '<td class="n' . $z . '">' . $dash($r->outcome) . '</td>'
                    . "</tr>\n";
            }

            echo '<tr><td colspan="8" class="grandl">TOTAL NUMBER OF CASES</td><td class="grand">' . number_format($total) . '</td></tr>';
            echo "\n</table>\n</body>\n</html>";
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Cache-Control' => 'max-age=0',
        ]);
    }
    /**
     * Shares of a set of counts, as percentages that add up to EXACTLY 100 (largest-remainder method):
     * every share is rounded down to the wanted number of decimals, then the leftover hundredths go to the
     * entries with the biggest remainders. Keys are kept. $decimals = 0 gives whole numbers.
     */
    private function shares(array $counts, int $decimals = 0): array
    {
        $total = array_sum($counts);
        if ($total <= 0) {
            return array_fill_keys(array_keys($counts), $decimals ? 0.0 : 0);
        }
        $scale = 10 ** $decimals;
        $whole = 100 * $scale;
        $floors = [];
        $remainders = [];
        foreach ($counts as $k => $c) {
            $exact = $c / $total * $whole;
            $floors[$k] = (int) floor($exact + 1e-9);
            $remainders[$k] = $exact - $floors[$k];
        }
        $left = $whole - array_sum($floors);
        arsort($remainders);
        foreach (array_keys($remainders) as $k) {
            if ($left <= 0) {
                break;
            }
            $floors[$k]++;
            $left--;
        }
        return array_map(fn ($v) => $decimals ? $v / $scale : (int) $v, $floors);
    }
    /**
     * Data for one donut chart. $parts = [[label, count, colour], ...].
     * Each slice gets its exact share (for drawing the arc) and a whole-number percentage for the legend;
     * the whole numbers use the largest-remainder method, so they always add up to exactly 100.
     */
    private function donut(array $parts): array
    {
        $total = array_sum(array_column($parts, 1));
        $pcts = $this->shares(array_column($parts, 1), 0);
        $shares = [];
        foreach ($parts as $i => [$label, $count, $color]) {
            $shares[$i] = $total > 0 ? $count / $total * 100 : 0;
        }

        $segments = [];
        foreach ($parts as $i => [$label, $count, $color]) {
            $segments[] = ['label' => $label, 'count' => (int) $count, 'color' => $color, 'pct' => $pcts[$i], 'frac' => round($shares[$i], 3)];
        }
        return ['segments' => $segments, 'total' => (int) $total];
    }
    /**
     * The rows behind the Visual Analytics page with the page's filters applied.
     * Used by the page and by the CSV export, so both always show the same results.
     *
     * $withWindow = false leaves out the period window (see analyticsContext) - the chart uses that
     * and cuts its own buckets.
     */
    private function analyticsQuery(Request $request, bool $withWindow = true)
    {
        $query = DB::table('inflow_general_particulars')
            ->leftJoin('bite_cases', 'inflow_general_particulars.inflow_record_id', '=', 'bite_cases.inflow_record_id');
        $col = 'inflow_general_particulars.queue_date';

        // --- APPLY FILTERS ---
        if ($request->filled('date_from')) {
            $query->whereDate($col, '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate($col, '<=', $request->date_to);
        }
        if ($request->filled('health_area')) {
            $this->applyHealthArea($query, $request->health_area);
        }
        if ($request->filled('barangay')) {
            $query->where('inflow_general_particulars.barangay', 'LIKE', '%' . $request->barangay . '%');
        }
        if ($request->filled('sex') && $request->sex != 'All') {
            $query->where('inflow_general_particulars.sex', $request->sex);
        }
        if ($request->filled('age_min')) {
            $query->where('inflow_general_particulars.age', '>=', $request->age_min);
        }
        if ($request->filled('age_max')) {
            $query->where('inflow_general_particulars.age', '<=', $request->age_max);
        }

        // --- PERIOD WINDOW: exactly the range the chart shows, so the KPI cards add up what the chart plots ---
        if ($withWindow) {
            $ctx = $this->analyticsContext($request);
            $query->whereBetween($col, [$ctx['from']->toDateString(), $ctx['to']->toDateString()]);
        }

        return $query;
    }

    /**
     * The range the Analytics page is looking at, worked out from the period grouping and its range fields:
     *
     *   daily      date_from .. date_to           (dates)
     *   weekly     week_from .. week_to           (ISO weeks, Monday-Sunday)
     *   monthly    month_from .. month_to         (months)
     *   quarterly  quarter_from .. quarter_to     (quarters, "2025-2" = Q2 2025)
     *   yearly     year [.. year_to]              (year_to is optional; without it just that one year)
     *   none       year                           (that one year, month by month)
     *
     * A missing or invalid field falls back to a default: the current year when it has data, otherwise the
     * latest year that has data (so the page never opens on an empty year). From and to are swapped if
     * they come in the wrong order, and very long ranges are cut short with a notice.
     *
     * Returns the buckets to plot (label, key), the first and last day covered (the KPI cards use the same
     * span), the SQL that gives a row's bucket key, and the values to put back into the range fields.
     */
    private function analyticsContext(Request $request): array
    {
        // worked out once per request (kept on the request, so nothing is shared between requests)
        if ($request->attributes->has('analytics_ctx')) {
            return $request->attributes->get('analytics_ctx');
        }
        $today = today();
        $col = 'queue_date';

        $dataYears = DB::table('inflow_general_particulars')
            ->whereNotNull($col)
            ->selectRaw('DISTINCT YEAR(queue_date) as y')
            ->orderBy('y')
            ->pluck('y')
            ->map(fn ($y) => (int) $y)
            ->filter(fn ($y) => $y >= 2000 && $y <= $today->year)
            ->values()
            ->all();
        $years = $dataYears ?: [$today->year];
        $firstYear = min($years);
        $lastYear = max($years);
        $defaultYear = in_array($today->year, $years, true) ? $today->year : $lastYear;
        // "as of" day for the daily / weekly defaults: today for the current year, else the last day of that year
        $anchor = $defaultYear === $today->year ? $today->copy()->startOfDay() : Carbon::create($defaultYear, 12, 31)->startOfDay();

        $text = fn (string $key) => is_string($request->query($key)) ? trim($request->query($key)) : '';
        $parseDate = function (string $v) use ($today) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
                return null;
            }
            try {
                $d = Carbon::createFromFormat('!Y-m-d', $v);
            } catch (\Throwable $e) {
                return null;
            }
            return $d && $d->format('Y-m-d') === $v && $d->year >= 2000 && $d->year <= $today->year ? $d : null;
        };
        $parseWeek = function (string $v) use ($today) {
            if (!preg_match('/^(\d{4})-W(\d{2})$/', $v, $m) || (int) $m[1] < 2000 || (int) $m[1] > $today->year || (int) $m[2] < 1 || (int) $m[2] > 53) {
                return null;
            }
            return Carbon::create((int) $m[1], 1, 4)->setISODate((int) $m[1], (int) $m[2])->startOfWeek(Carbon::MONDAY)->startOfDay();
        };
        $parseMonth = function (string $v) use ($today) {
            if (!preg_match('/^(\d{4})-(\d{2})$/', $v, $m) || (int) $m[1] < 2000 || (int) $m[1] > $today->year || (int) $m[2] < 1 || (int) $m[2] > 12) {
                return null;
            }
            return Carbon::create((int) $m[1], (int) $m[2], 1)->startOfDay();
        };
        $parseQuarter = function (string $v) use ($today) {
            if (!preg_match('/^(\d{4})-([1-4])$/', $v, $m) || (int) $m[1] < 2000 || (int) $m[1] > $today->year) {
                return null;
            }
            return Carbon::create((int) $m[1], ((int) $m[2] - 1) * 3 + 1, 1)->startOfDay();
        };
        $parseYear = fn (string $v) => ctype_digit($v) && (int) $v >= 2000 && (int) $v <= $today->year ? (int) $v : null;

        // from / to: both given -> as they are; only one given -> that one for both; none -> the defaults
        $pair = function ($from, $to, $defaultFrom, $defaultTo) {
            if ($from === null && $to === null) {
                [$from, $to] = [$defaultFrom, $defaultTo];
            } elseif ($from === null) {
                $from = $to;
            } elseif ($to === null) {
                $to = $from;
            }
            return $from->gt($to) ? [$to, $from] : [$from, $to];
        };

        $group = in_array($request->query('group'), ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'], true) ? $request->query('group') : null;
        $notice = null;

        // the defaults of every period (also used to fill the range fields of the periods not chosen)
        $default = [
            'date' => [$anchor->copy()->subDays(6), $anchor->copy()],
            'week' => [$anchor->copy()->startOfWeek(Carbon::MONDAY)->subWeeks(7), $anchor->copy()->startOfWeek(Carbon::MONDAY)],
            'month' => [Carbon::create($defaultYear, 1, 1), Carbon::create($defaultYear, 12, 1)],
            'quarter' => [Carbon::create($defaultYear, 1, 1), Carbon::create($defaultYear, 10, 1)],
        ];

        $dateRange = $pair($parseDate($text('date_from')), $parseDate($text('date_to')), ...$default['date']);
        $weekRange = $pair($parseWeek($text('week_from')), $parseWeek($text('week_to')), ...$default['week']);
        $monthRange = $pair($parseMonth($text('month_from')), $parseMonth($text('month_to')), ...$default['month']);
        $quarterRange = $pair($parseQuarter($text('quarter_from')), $parseQuarter($text('quarter_to')), ...$default['quarter']);

        $yearStart = $parseYear($text('year'));
        $yearEnd = $parseYear($text('year_to'));
        $singleYear = in_array($yearStart, $years, true) ? $yearStart : $defaultYear;   // none: the one year shown

        $buckets = [];
        $keySql = "DATE_FORMAT(queue_date, '%Y-%m')";
        $toBlank = false;   // yearly only: "to year" was left empty

        if ($group === 'daily') {
            [$from, $to] = $dateRange;
            if ($from->diffInDays($to) > 365) {
                $to = $from->copy()->addDays(365);
                $notice = 'Daily view is limited to 366 days, so the range was shortened to ' . $from->format('M d, Y') . ' – ' . $to->format('M d, Y') . '.';
            }
            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                $buckets[] = ['label' => $d->format('M d'), 'key' => $d->toDateString()];
            }
            $keySql = 'DATE(queue_date)';
            $subtitle = $from->isSameDay($to) ? $from->format('M d, Y') : $from->format('M d, Y') . ' – ' . $to->format('M d, Y');
            $spanFrom = $from->copy();
            $spanTo = $to->copy();
        } elseif ($group === 'weekly') {
            [$from, $to] = $weekRange;
            if ($from->diffInWeeks($to) > 155) {
                $to = $from->copy()->addWeeks(155);
                $notice = 'Weekly view is limited to 156 weeks, so the range was shortened.';
            }
            for ($d = $from->copy(); $d->lte($to); $d->addWeek()) {
                $buckets[] = ['label' => 'W' . $d->isoWeek . ' · ' . $d->format('M d'), 'key' => $d->isoWeekYear * 100 + $d->isoWeek];
            }
            $keySql = 'YEARWEEK(queue_date, 3)';
            $subtitle = 'Week of ' . $from->format('M d, Y') . ($from->isSameDay($to) ? '' : ' – week of ' . $to->format('M d, Y'));
            $spanFrom = $from->copy();
            $spanTo = $to->copy()->addDays(6);
        } elseif ($group === 'monthly') {
            [$from, $to] = $monthRange;
            if ($from->diffInMonths($to) > 119) {
                $to = $from->copy()->addMonths(119);
                $notice = 'Monthly view is limited to 120 months, so the range was shortened.';
            }
            $multiYear = $from->year !== $to->year;
            for ($d = $from->copy(); $d->lte($to); $d->addMonthNoOverflow()) {
                $buckets[] = ['label' => $multiYear ? $d->format('M Y') : strtoupper($d->format('M')), 'key' => $d->format('Y-m')];
            }
            $subtitle = $from->format('M Y') . ($from->isSameMonth($to) && $from->isSameYear($to) ? '' : ' – ' . $to->format('M Y'));
            $spanFrom = $from->copy();
            $spanTo = $to->copy()->endOfMonth()->startOfDay();
        } elseif ($group === 'quarterly') {
            [$from, $to] = $quarterRange;
            if ($from->diffInMonths($to) > 119) {
                $to = $from->copy()->addMonths(117);
                $notice = 'Quarterly view is limited to 40 quarters, so the range was shortened.';
            }
            for ($d = $from->copy(); $d->lte($to); $d->addMonthsNoOverflow(3)) {
                $buckets[] = ['label' => 'Q' . $d->quarter . ' ' . $d->year, 'key' => $d->year . '-' . $d->quarter];
            }
            $keySql = "CONCAT(YEAR(queue_date), '-', QUARTER(queue_date))";
            $subtitle = 'Q' . $from->quarter . ' ' . $from->year . ($from->isSameQuarter($to) && $from->isSameYear($to) ? '' : ' – Q' . $to->quarter . ' ' . $to->year);
            $spanFrom = $from->copy();
            $spanTo = $to->copy()->addMonthsNoOverflow(2)->endOfMonth()->startOfDay();
        } elseif ($group === 'yearly') {
            // "year" alone is just that year; "year" with "to year" is the range;
            // no year fields at all (e.g. a plain ?group=yearly link): every year with data
            if ($yearStart === null && $yearEnd === null && !$request->has('year')) {
                [$a, $b] = [$firstYear, $lastYear];
            } else {
                $a = $yearStart ?? $yearEnd ?? $defaultYear;
                $b = $yearEnd ?? $a;
                $toBlank = $yearEnd === null;
                if ($a > $b) {
                    [$a, $b] = [$b, $a];
                }
            }
            for ($y = $a; $y <= $b; $y++) {
                $buckets[] = ['label' => (string) $y, 'key' => $y];
            }
            $keySql = 'YEAR(queue_date)';
            $subtitle = $a === $b ? (string) $a : $a . ' – ' . $b;
            $spanFrom = Carbon::create($a, 1, 1)->startOfDay();
            $spanTo = Carbon::create($b, 12, 31)->startOfDay();
        } else {
            // no period grouping: one year, month by month
            foreach (range(1, 12) as $m) {
                $buckets[] = ['label' => strtoupper(Carbon::create($singleYear, $m, 1)->format('M')), 'key' => sprintf('%d-%02d', $singleYear, $m)];
            }
            $subtitle = (string) $singleYear;
            $spanFrom = Carbon::create($singleYear, 1, 1)->startOfDay();
            $spanTo = Carbon::create($singleYear, 12, 31)->startOfDay();
        }

        // quarters offered in the quarter fields: every quarter of every year with data
        $quarters = [];
        foreach ($years as $y) {
            foreach ([1, 2, 3, 4] as $q) {
                $quarters[] = [
                    'value' => $y . '-' . $q,
                    'label' => 'Q' . $q . ' ' . $y . ' (' . date('M', mktime(0, 0, 0, ($q - 1) * 3 + 1, 1)) . '–' . date('M', mktime(0, 0, 0, $q * 3, 1)) . ')',
                ];
            }
        }

        $minDate = DB::table('inflow_general_particulars')->where($col, '>=', '2000-01-01')->min($col);
        $minDate = Carbon::parse($minDate ?: Carbon::create($firstYear, 1, 1));

        // what the range fields show: the chosen range when it applies, the defaults otherwise
        $isDaily = $group === 'daily';
        $isWeekly = $group === 'weekly';
        $isMonthly = $group === 'monthly';
        $isQuarterly = $group === 'quarterly';
        $values = [
            'date_from' => ($isDaily ? $from : $dateRange[0])->toDateString(),
            'date_to' => ($isDaily ? $to : $dateRange[1])->toDateString(),
            'week_from' => ($isWeekly ? $from : $weekRange[0])->format('o-\WW'),
            'week_to' => ($isWeekly ? $to : $weekRange[1])->format('o-\WW'),
            'month_from' => ($isMonthly ? $from : $monthRange[0])->format('Y-m'),
            'month_to' => ($isMonthly ? $to : $monthRange[1])->format('Y-m'),
            'quarter_from' => ($isQuarterly ? $from : $quarterRange[0])->year . '-' . ($isQuarterly ? $from : $quarterRange[0])->quarter,
            'quarter_to' => ($isQuarterly ? $to : $quarterRange[1])->year . '-' . ($isQuarterly ? $to : $quarterRange[1])->quarter,
            'year' => $singleYear,
            'year_start' => $group === 'yearly' ? $a : $firstYear,
            'year_end' => $group === 'yearly' ? ($toBlank ? '' : $b) : $lastYear,
        ];

        $ctx = [
            'group' => $group,
            'buckets' => $buckets,
            'key_sql' => $keySql,
            'from' => $spanFrom,
            'to' => $spanTo,
            'subtitle' => $subtitle,
            'notice' => $notice,
            'values' => $values,
            'years' => array_reverse($years),
            'quarters' => $quarters,
            'bounds' => ['min' => $minDate->toDateString(), 'max' => $today->toDateString(), 'min_month' => $minDate->format('Y-m'), 'max_month' => $today->format('Y-m'), 'min_week' => $minDate->format('o-\WW'), 'max_week' => $today->format('o-\WW')],
        ];
        $request->attributes->set('analytics_ctx', $ctx);

        return $ctx;
    }
    /**
     * Health areas and their barangays (spelled as in config/barangays.php). Same grouping the annual
     * barangay export uses.
     */
    private function healthAreaDefs(): array
    {
        return [
            'CENTRAL HEALTH AREA' => ['color' => '#b4c7e7', 'barangays' => [
                'Babag','Bo.Luz','Busay','Capitol','Carreta','Hipodromo','Kalunasan',
                'Kamputhaw','Lahug','Malubog','Pung-ol','Sapangdaku']],
            'EAST HEALTH AREA' => ['color' => '#f4b6b6', 'barangays' => [
                'Cogon Ramos','Day-as','Ermita','Kalubihan','Kamagayan','Lorega','Pahina Central',
                'Pari-an','Pasil','Sambag I','Sambag II','San Antonio','San Roque','Sta. Cruz',
                'Sto. Niño','Suba','T.Padilla','Tejero','Tinago','Zapatera']],
            'NORTH HEALTH AREA' => ['color' => '#c6e0b4', 'barangays' => [
                'Adlaon','Agsungot','Apas','Bacayan','Banilad','Binaliw','Budlaan','Cambinocot',
                'Guba','Kasambagan','Lusaran','Mabini','Mabolo','Paril','Pit-os','Pulangbato',
                'San Jose','Sirao','Tabunan','Tagbao','Talamban','TapTap']],
            'SOUTH HEALTH AREA' => ['color' => '#ffe699', 'barangays' => [
                'Basak Pardo','Basak San Nicolas','Bonbon','Buhisan','Bulacao','Bout-Taup',
                'Cogon Pardo','Inayawan','Kinasang-an','Mambaling','Pamutan','Pardo','Quiot',
                'Sinsin','Sudlon I','Sudlon II','Toong']],
            'WEST HEALTH AREA' => ['color' => '#d9c3e6', 'barangays' => [
                'Calamba','Duljo','Guadalupe','Banawa','Labangon','Punta Princesa',
                'San Nicolas Proper','San Nicolas Pahina','Sawang Calero','Tisa']],
        ];
    }

    /** Limits a query to the barangays of one health area ("North", "West", ...); an unknown area matches nothing. */
    private function applyHealthArea($query, ?string $area): void
    {
        $defs = $this->healthAreaDefs();
        $key = strtoupper(trim((string) $area)) . ' HEALTH AREA';
        if (!isset($defs[$key])) {
            $query->whereRaw('1 = 0');
            return;
        }
        $query->whereIn('inflow_general_particulars.barangay', $defs[$key]['barangays']);
    }
public function exportMonthlyCsv(Request $request)
{
    $year = (int) $request->get('year', date('Y'));

    // Master list gikan sa config/barangays.php (wala usba)
    $masterList = array_keys(config('barangays'));

    // Health areas and their barangays (shared with the Analytics health-area filter)
    $areaDefs = $this->healthAreaDefs();

    // Population kada barangay (cases / population x 1000). Pananglitan: 'Babag' => 6260,
    $population = [
        // 'Babag' => 6260,
    ];

    $norm = fn($s) => preg_replace('/[^a-z0-9]/', '', strtolower(Str::ascii((string) $s)));

    $rows = DB::table('inflow_general_particulars')
        ->selectRaw('barangay, MONTH(queue_date) as m, COUNT(*) as total')
        ->whereYear('queue_date', $year)
        ->groupByRaw('barangay, MONTH(queue_date)')
        ->get();

    $counts = [];
    foreach ($rows as $r) {
        $k = $norm($r->barangay);
        $counts[$k][(int) $r->m] = ($counts[$k][(int) $r->m] ?? 0) + (int) $r->total;
    }

    $popNorm = [];
    foreach ($population as $name => $p) {
        $popNorm[$norm($name)] = $p;
    }

    $makeRow = function (string $name) use ($counts, $popNorm, $norm) {
        $k = $norm($name);
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = $counts[$k][$m] ?? 0;
        }
        return ['name' => $name, 'months' => $months, 'pop' => $popNorm[$k] ?? null];
    };

    $assigned = [];
    $areas = [];
    foreach ($areaDefs as $areaName => $def) {
        $list = [];
        foreach ($def['barangays'] as $b) {
            $assigned[$norm($b)] = true;
            $list[] = $makeRow($b);
        }
        $areas[$areaName] = ['color' => $def['color'], 'rows' => $list];
    }

    // Barangay sa barangays.php nga wala pa na-assign sa health area
    $unassigned = [];
    foreach ($masterList as $b) {
        if (!isset($assigned[$norm($b)])) {
            $unassigned[] = $makeRow($b);
        }
    }
    if ($unassigned) {
        $areas['UNASSIGNED HEALTH AREA'] = ['color' => '#e7e6e6', 'rows' => $unassigned];
    }

    // Wala sa master list -> NON-CEBU CITY VOTERS
    $known = [];
    foreach ($masterList as $b) {
        $known[$norm($b)] = true;
    }
    $nonCebu = array_fill(1, 12, 0);
    foreach ($counts as $k => $byMonth) {
        if (!isset($known[$k])) {
            foreach ($byMonth as $m => $c) {
                $nonCebu[$m] += $c;
            }
        }
    }

    $html = view('admin.monthly_export_excel', compact('areas', 'nonCebu', 'year'))->render();

    return response($html, 200, [
        'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="ABTC_Animal_Bite_Cases_Per_Barangay_' . $year . '.xls"',
        'Cache-Control'       => 'max-age=0',
    ]);
}

    public function exportAnnualReport(Request $request)
{
    $year = (int) $request->get('year', date('Y'));

    $blank = fn() => [
        'male' => 0, 'female' => 0, 'u15' => 0, 'o15' => 0,
        'dog' => 0, 'cat' => 0, 'others' => 0,
        'c1' => 0, 'c2' => 0, 'c3' => 0, 'total' => 0, 'hr' => 0,
        'tcv' => 0, 'hrig' => 0, 'erig' => 0,
    ];

    $data = [];
    for ($m = 1; $m <= 12; $m++) {
        $data[$m] = $blank();
    }

    // 1) SEX, AGE, TOTAL: usa ka record kada pasyente-visit (parehas sa dashboard)
    $patients = DB::table('inflow_general_particulars')
        ->selectRaw('inflow_record_id, MONTH(queue_date) as m, sex, age')
        ->whereYear('queue_date', $year)
        ->get();

    foreach ($patients as $p) {
        $m = (int) $p->m;
        $data[$m]['total']++;
        $sex = strtolower(trim((string) $p->sex));
        if ($sex === 'male')   $data[$m]['male']++;
        if ($sex === 'female') $data[$m]['female']++;
        if ((int) $p->age < 15) $data[$m]['u15']++; else $data[$m]['o15']++;
    }

    // 2) CATEGORY I / II / III gikan sa bite_cases
    $cats = DB::table('bite_cases')
        ->join('inflow_general_particulars', 'bite_cases.inflow_record_id', '=', 'inflow_general_particulars.inflow_record_id')
        ->selectRaw('MONTH(inflow_general_particulars.queue_date) as m, bite_cases.category')
        ->whereYear('inflow_general_particulars.queue_date', $year)
        ->get();

    foreach ($cats as $c) {
        $m = (int) $c->m;
        $cat = strtoupper(trim((string) $c->category));
        if (in_array($cat, ['I', '1', 'CAT I', 'CAT 1', 'CATEGORY I', 'CATEGORY 1']))        $data[$m]['c1']++;
        elseif (in_array($cat, ['II', '2', 'CAT II', 'CAT 2', 'CATEGORY II', 'CATEGORY 2'])) $data[$m]['c2']++;
        elseif (in_array($cat, ['III', '3', 'CAT III', 'CAT 3', 'CATEGORY III', 'CATEGORY 3'])) $data[$m]['c3']++;
    }

    // 3) BITING ANIMAL (Dog / Cat / Others)
    $animals = DB::table('bite_section3_exposure')
        ->join('bite_cases', 'bite_section3_exposure.bite_case_id', '=', 'bite_cases.bite_case_id')
        ->join('inflow_general_particulars', 'bite_cases.inflow_record_id', '=', 'inflow_general_particulars.inflow_record_id')
        ->selectRaw('MONTH(inflow_general_particulars.queue_date) as m, bite_section3_exposure.animal_type')
        ->whereYear('inflow_general_particulars.queue_date', $year)
        ->get();

    foreach ($animals as $a) {
        $m = (int) $a->m;
        $type = strtolower(trim((string) $a->animal_type));
        if (str_contains($type, 'dog'))      $data[$m]['dog']++;
        elseif (str_contains($type, 'cat'))  $data[$m]['cat']++;
        else                                 $data[$m]['others']++;
    }

    // 4) HR, TCV, HRIG, ERIG: 0 pa kay wala pa nako makita ang table (tan-awa ang timan-an sa ubos)

    // ---- Build rows: bulan, TOTAL Q, TOTAL ----
    $monthNames = ['JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER'];
    $sum = function (array $a, array $b) {
        foreach ($b as $k => $v) {
            $a[$k] = ($a[$k] ?? 0) + $v;
        }
        return $a;
    };

    $rows = [];
    $yearTotal = $blank();
    for ($q = 0; $q < 4; $q++) {
        $qTotal = $blank();
        for ($i = 1; $i <= 3; $i++) {
            $m = $q * 3 + $i;
            $rows[] = ['label' => $monthNames[$m - 1], 'type' => 'month', 'd' => $data[$m]];
            $qTotal = $sum($qTotal, $data[$m]);
        }
        $rows[] = ['label' => 'TOTAL Q' . ($q + 1), 'type' => 'quarter', 'd' => $qTotal];
        $yearTotal = $sum($yearTotal, $qTotal);
    }
    $rows[] = ['label' => 'TOTAL', 'type' => 'year', 'd' => $yearTotal];

    $html = view('admin.annual_report_excel', compact('rows', 'year'))->render();

    return response($html, 200, [
        'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="ABTC_Annual_Report_' . $year . '.xls"',
        'Cache-Control'       => 'max-age=0',
    ]);
}
}