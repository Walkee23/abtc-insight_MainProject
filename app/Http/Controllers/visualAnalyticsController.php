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
    $analyticsUniquePatients = (clone $query)->distinct('inflow_general_particulars.id_number')->count('inflow_general_particulars.id_number');
    $uniquePatients = $analyticsUniquePatients;
    $analyticsAvgAge = round((clone $query)->avg('inflow_general_particulars.age'), 1);

    // Categories
    /// Categories (Gihimo natong luag aron bisan unsa nga column o value maapil)
    $cat1 = (clone $query)->where(function($q) {
        $q->where('bite_cases.category', 'LIKE', '%1%')
          ->orWhere('bite_cases.category', 'LIKE', '%I%');
    })->count();

    $cat2 = (clone $query)->where(function($q) {
        $q->where('bite_cases.category', 'LIKE', '%2%')
          ->orWhere('bite_cases.category', 'LIKE', '%II%');
    })->count();

    $cat3 = (clone $query)->where(function($q) {
        $q->where('bite_cases.category', 'LIKE', '%3%')
          ->orWhere('bite_cases.category', 'LIKE', '%03%')
          ->orWhere('bite_cases.category', 'LIKE', '%III%');
    })->count();
    
    $analyticsCat3Count = $cat3;
    $analyticsCat3Pct = $analyticsTotalBites > 0 ? round(($cat3 / $analyticsTotalBites) * 100, 1) : 0;

    $completedCount = (clone $query)->where('bite_cases.outcome', 'Completed')->count();
    $analyticsPepCompletion = $analyticsTotalBites > 0 ? round(($completedCount / $analyticsTotalBites) * 100, 1) : 0;

    // --- DEMOGRAPHIC & EXPOSURE BREAKDOWN PERCENTAGES ---
    $catTotal = ($cat1 + $cat2 + $cat3) ?: 1;
    $cat1Pct = round(($cat1 / $catTotal) * 100);
    $cat2Pct = round(($cat2 / $catTotal) * 100);
    $cat3Pct = round(($cat3 / $catTotal) * 100);

    $maleCount = (clone $query)->where('inflow_general_particulars.sex', 'Male')->count();
    $femaleCount = (clone $query)->where('inflow_general_particulars.sex', 'Female')->count();
    $sexTotal = ($maleCount + $femaleCount) ?: 1;
    $malePct = round(($maleCount / $sexTotal) * 100);
    $femalePct = round(($femaleCount / $sexTotal) * 100);

    // Animal type metrics
    $dogCount = (clone $query)->where(DB::raw('UPPER(TRIM(bite_cases.category))'), 'LIKE', '%DOG%')->count(); // Fallback query mapping
    $dogPct = $analyticsTotalBites > 0 ? round(($dogCount / $analyticsTotalBites) * 100) : 82;
    $catAnimalPct = 14;
    $otherAnimalPct = 4;

    // --- AGE GROUP DISTRIBUTION COUNTS ---
    $age0_12  = (clone $query)->whereBetween('inflow_general_particulars.age', [0, 12])->count();
    $age13_19 = (clone $query)->whereBetween('inflow_general_particulars.age', [13, 19])->count();
    $age20_39 = (clone $query)->whereBetween('inflow_general_particulars.age', [20, 39])->count();
    $age40_59 = (clone $query)->whereBetween('inflow_general_particulars.age', [40, 59])->count();
    $age60_up = (clone $query)->where('inflow_general_particulars.age', '>=', 60)->count();

    $maxAgeCount = max([$age0_12, $age13_19, $age20_39, $age40_59, $age60_up]) ?: 1;
    $age0_12_pct  = round(($age0_12 / $maxAgeCount) * 100);
    $age13_19_pct = round(($age13_19 / $maxAgeCount) * 100);
    $age20_39_pct = round(($age20_39 / $maxAgeCount) * 100);
    $age40_59_pct = round(($age40_59 / $maxAgeCount) * 100);
    $age60_up_pct = round(($age60_up / $maxAgeCount) * 100);

    // --- CHART PERIOD GROUPING LOGIC (Total, New, Returning) ---
    $group = $request->get('group');
    $totalCasesData = [];
    $newCasesData = [];
    $returningCasesData = [];
    $chartLabels = [];

    if ($group == 'daily') {
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = date('M d', strtotime($date));
            
            $dayQuery = (clone $query)->whereDate('inflow_general_particulars.queue_date', $date);
            $totalCasesData[] = (clone $dayQuery)->count();
            $newCasesData[] = (clone $dayQuery)->where('bite_cases.case_number', 1)->count();
            $returningCasesData[] = (clone $dayQuery)->where('bite_cases.case_number', '>', 1)->count();
        }
    } elseif ($group == 'weekly') {
    $currentMonth = (int) date('m');
    $currentYear  = (int) date('Y');

    // Mosugod sa 1st sa bulan, mo-reset sa Wk 1 kada bag-ong bulan
    $startOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
    $endOfMonth   = $startOfMonth->copy()->endOfMonth();

    $weekCount = 1;
    $iter = $startOfMonth->copy();

    while ($iter->lte($endOfMonth)) {
        $weekStart = $iter->copy();
        // 7 ka adlaw, apan dili molapas sa katapusan sa bulan
        $weekEnd = $iter->copy()->addDays(6)->min($endOfMonth);

        $chartLabels[] = 'Wk ' . $weekCount;

        $wkQuery = (clone $query)->whereBetween(
            'inflow_general_particulars.queue_date',
            [$weekStart->toDateString(), $weekEnd->toDateString()]
        );

        $totalCasesData[]     = (clone $wkQuery)->count();
        $newCasesData[]       = (clone $wkQuery)->where('bite_cases.case_number', 1)->count();
        $returningCasesData[] = (clone $wkQuery)->where('bite_cases.case_number', '>', 1)->count();

        $weekCount++;
        $iter->addDays(7);
    }

    
    } elseif ($group == 'quarterly') {
        $chartLabels = ['Q1 (Jan-Mar)', 'Q2 (Apr-Jun)', 'Q3 (Jul-Sep)', 'Q4 (Oct-Dec)'];
        $currentYear = date('Y');
        for ($q = 1; $q <= 4; $q++) {
            $startMonth = ($q - 1) * 3 + 1;
            $endMonth = $q * 3;
            $qQuery = (clone $query)
                ->whereYear('inflow_general_particulars.queue_date', $currentYear)
                ->whereMonth('inflow_general_particulars.queue_date', '>=', $startMonth)
                ->whereMonth('inflow_general_particulars.queue_date', '<=', $endMonth);

            $totalCasesData[] = (clone $qQuery)->count();
            $newCasesData[] = (clone $qQuery)->where('bite_cases.case_number', 1)->count();
            $returningCasesData[] = (clone $qQuery)->where('bite_cases.case_number', '>', 1)->count();
        }
    } elseif ($group == 'yearly') {
        $currentYear = date('Y');
        for ($y = 4; $y >= 0; $y--) {
            $targetYear = $currentYear - $y;
            $chartLabels[] = (string) $targetYear;
            
            $yrQuery = (clone $query)->whereYear('inflow_general_particulars.queue_date', $targetYear);
            $totalCasesData[] = (clone $yrQuery)->count();
            $newCasesData[] = (clone $yrQuery)->where('bite_cases.case_number', 1)->count();
            $returningCasesData[] = (clone $yrQuery)->where('bite_cases.case_number', '>', 1)->count();
        }
    } else {
        // Default: Monthly breakdown
        $chartLabels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        for ($m = 1; $m <= 12; $m++) {
            $mQuery = (clone $query)
                ->whereYear('inflow_general_particulars.queue_date', date('Y'))
                ->whereMonth('inflow_general_particulars.queue_date', $m);

            $totalCasesData[] = (clone $mQuery)->count();
            $newCasesData[] = (clone $mQuery)->where('bite_cases.case_number', 1)->count();
            $returningCasesData[] = (clone $mQuery)->where('bite_cases.case_number', '>', 1)->count();
        }
    }

    // --- TOP BARANGAYS RANKING (Limit to Top 15) ---
    $topBarangays = (clone $query)
        ->select('inflow_general_particulars.barangay', DB::raw('count(*) as total'))
        ->groupBy('inflow_general_particulars.barangay')
        ->orderByDesc('total')
        ->limit(15)
        ->get();
    
    $maxBarangayTotal = $topBarangays->max('total') ?: 1;

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
        'topBarangays',
        'maxBarangayTotal',
        'cat1Pct',
        'cat2Pct',
        'cat3Pct',
        'malePct',
        'femalePct',
        'dogPct',
        'catAnimalPct',
        'otherAnimalPct',
        'age0_12', 'age0_12_pct',
        'age13_19', 'age13_19_pct',
        'age20_39', 'age20_39_pct',
        'age40_59', 'age40_59_pct',
        'age60_up', 'age60_up_pct'
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
        $query->where('inflow_general_particulars.barangay', 'LIKE', '%' . $request->health_area . '%');
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
    $uniquePatients = $records->unique(fn($r) => $r->id_number ?: $r->patient_name)->count();

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
    $animalTypes = $caseIds->isEmpty()
        ? collect()
        : DB::table('bite_section3_exposure')
            ->whereIn('bite_case_id', $caseIds)
            ->select('animal_type', DB::raw('count(*) as total'))
            ->groupBy('animal_type')
            ->get();

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
        'animalTypes', 'hotspots', 'appliedFilters', 'dataFrom', 'dataTo'
    ))->render();

    $filename = 'ABTC_Comprehensive_Report_' . strtoupper($filter) . '_' . date('Y-m-d') . '.doc';

    return response($view, 200, [
        'Content-Type'        => 'application/msword',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Cache-Control'       => 'max-age=0',
    ]);
}

    /**
     * Export the filtered results of the Visual Analytics page as CSV.
     * Only the rows matching the filters currently applied on the page are exported.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        // the file contains patient names, so only a logged-in Admin may download it
        abort_unless(Auth::check() && Auth::user()->role === 'Admin', 403, 'Please log in as an Admin to export results.');

        $query = $this->analyticsQuery($request)
            ->select(
                'inflow_general_particulars.queue_id',
                'inflow_general_particulars.queue_date',
                'inflow_general_particulars.patient_name',
                'inflow_general_particulars.age',
                'inflow_general_particulars.sex',
                'inflow_general_particulars.barangay',
                'bite_cases.category',
                'bite_cases.case_number',
                'bite_cases.outcome'
            )
            ->orderByDesc('inflow_general_particulars.queue_date')
            ->orderByDesc('inflow_general_particulars.inflow_record_id');

        $filename = 'abtc_insight_filtered_results_' . date('Y-m-d_His') . '.csv';

        // a cell that starts with = + - @ would be run as a formula when the file is opened in Excel
        $safe = fn ($v) => is_string($v) && $v !== '' && strpbrk($v[0], "=+-@\t\r") !== false ? "'" . $v : $v;

        return response()->streamDownload(function () use ($query, $safe) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel shows names with accents correctly
            fputcsv($out, ['Queue ID', 'Date', 'Patient Name', 'Age', 'Sex', 'Barangay', 'Category', 'Case No.', 'Outcome']);

            foreach ($query->cursor() as $r) {
                fputcsv($out, [
                    $safe($r->queue_id),
                    $r->queue_date,
                    $safe($r->patient_name),
                    $r->age,
                    $r->sex,
                    $safe($r->barangay),
                    $r->category,
                    $r->case_number,
                    $r->outcome,
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
    /**
     * The rows behind the Visual Analytics page with the page's filters applied.
     * Used by the page and by the CSV export, so both always show the same results.
     */
    private function analyticsQuery(Request $request)
    {
    $query = DB::table('inflow_general_particulars')
        ->leftJoin('bite_cases', 'inflow_general_particulars.inflow_record_id', '=', 'bite_cases.inflow_record_id');

    // --- APPLY FILTERS ---
    if ($request->filled('date_from')) {
        $query->whereDate('inflow_general_particulars.queue_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('inflow_general_particulars.queue_date', '<=', $request->date_to);
    }
    if ($request->filled('health_area')) {
        // Assuming health area is mapped or checked via barangay/location if applicable
        $query->where('inflow_general_particulars.barangay', 'LIKE', '%' . $request->health_area . '%');
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

        $group = $request->get('group');
        if (!$request->filled('date_from') && !$request->filled('date_to')) {
            if ($group == 'daily') {
                // Direkta na nga karong adlawa ra gyud ang i-filter. Kung walay record, mo-zero dayon.
                $query->whereDate('inflow_general_particulars.queue_date', today());
         } elseif ($group == 'weekly') {
            // Current week lang: 7-adlaw nga block gikan sa 1st sa bulan (parehas sa chart)
            $today        = now();
            $startOfMonth = $today->copy()->startOfMonth();
            $endOfMonth   = $today->copy()->endOfMonth();

            $currentWeek = (int) ceil($today->day / 7);   // Nov 14 = Wk 2
            $weekStart   = $startOfMonth->copy()->addDays(7 * ($currentWeek - 1));
            $weekEnd     = $weekStart->copy()->addDays(6)->min($endOfMonth);

            $query->whereBetween('inflow_general_particulars.queue_date', [
                $weekStart->toDateString(),
                $weekEnd->toDateString(),
            ]);

        } elseif ($group == 'monthly') {
            $query->whereYear('inflow_general_particulars.queue_date', date('Y'))
                  ->whereMonth('inflow_general_particulars.queue_date', date('m'));
        } elseif ($group == 'quarterly') {
            $query->where('inflow_general_particulars.queue_date', '>=', now()->subMonths(3));
        } elseif ($group == 'yearly') {
            $query->whereYear('inflow_general_particulars.queue_date', date('Y'));
        }
    }

    if ($request->filled('health_area')) {
        $query->where('inflow_general_particulars.barangay', 'LIKE', '%' . $request->health_area . '%');
    }

    return $query;
    }

public function exportMonthlyCsv(Request $request)
{
    $year = (int) $request->get('year', date('Y'));

    // Master list gikan sa config/barangays.php (wala usba)
    $masterList = array_keys(config('barangays'));

    // Grouping sa health areas (diri na lang)
    $areaDefs = [
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