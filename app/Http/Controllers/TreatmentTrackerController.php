<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TreatmentTrackerController extends Controller
{
    /**
     * Treatment Tracker: one row per PEP course (a handed-off bite case with a Day 0 date
     * in Section VII). Schedule: Primary D0/D3/D7/D28, Booster D0/D3; each recorded day
     * date is a dose that was given.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $barangay = (string) $request->query('barangay', '');
        $status = in_array($request->query('status'), ['active', 'completed', 'missed'], true)
            ? $request->query('status') : 'all';

        $today = now('Asia/Manila')->startOfDay();
        $courses = $this->courses($today);

        // --- Summary cards (all courses, regardless of filters) --------------
        $activeCourses = $courses->where('state', '!=', 'Completed');
        $stats = [
            'active' => $activeCourses->count(),
            'new_this_week' => $activeCourses->filter(fn ($c) => $c->day0->gte($today->copy()->subDays(7)))->count(),
            'due_today' => $courses->filter(fn ($c) => $c->next && $c->next['date']->isSameDay($today))->count(),
            'missed' => $courses->sum(fn ($c) => $c->overdue_count),
            'missed_patients' => $courses->where('state', 'Late')->count(),
        ];

        // --- Filters ----------------------------------------------------------
        $barangays = $courses->pluck('barangay')->filter()->unique()->sort()->values();

        $rows = $courses->filter(function ($c) use ($status, $barangay, $search) {
            if ($barangay !== '' && $c->barangay !== $barangay) return false;
            if ($status === 'active' && $c->state !== 'On Track') return false;
            if ($status === 'completed' && $c->state !== 'Completed') return false;
            if ($status === 'missed' && $c->state !== 'Late') return false;
            $hay = mb_strtolower($c->patient_name . ' ' . $c->patient_id . ' ' . $c->barangay . ' Cat ' . $c->category);
            foreach (preg_split('/\s+/', mb_strtolower($search), -1, PREG_SPLIT_NO_EMPTY) as $term) {
                if (!str_contains($hay, $term)) return false;
            }
            return true;
        })->sortBy(function ($c) {
            // Late first (most overdue first), then on track by next dose date, completed last
            $rank = ['Late' => 0, 'On Track' => 1, 'Completed' => 2][$c->state];
            return [$rank, $c->next ? $c->next['date']->timestamp : PHP_INT_MAX, $c->patient_name];
        })->values();

        $perPage = 10;
        $page = max(1, (int) $request->query('page', 1));
        $tracker = new LengthAwarePaginator(
            $rows->forPage($page, $perPage)->values(), $rows->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // --- Compliance by barangay, doses that fell due in the last 30 days --
        $since = $today->copy()->subDays(30);
        $compliance = $courses->flatMap(fn ($c) => collect($c->doses)->map(fn ($d) => $d + ['barangay' => $c->barangay]))
            ->filter(fn ($d) => $d['date']->between($since, $today) && ($d['given'] || $d['date']->lt($today)))
            ->groupBy('barangay')->map(function ($doses, $name) {
                $done = $doses->where('given', true)->count();
                return (object) ['name' => $name ?: 'Unknown', 'pct' => (int) round($done / $doses->count() * 100), 'doses' => $doses->count()];
            })->sortByDesc('doses')->take(5)->values();

        // --- Upcoming critical appointments: overdue, due today, due tomorrow ---
        $tomorrow = $today->copy()->addDay();
        $appointments = $courses->filter(fn ($c) => $c->next && $c->next['date']->lte($tomorrow))
            ->sortBy(fn ($c) => $c->next['date']->timestamp)->take(5)->values();

        return view('healthworker.Treatment_Tracker', compact(
            'stats', 'tracker', 'barangays', 'compliance', 'appointments', 'today', 'search', 'barangay', 'status'
        ));
    }

    private function courses(Carbon $today)
    {
        $cases = DB::table('bite_cases as bc')
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            // only cases Staff has handed over to the Health Worker
            ->whereExists(function ($e) {
                $e->select(DB::raw(1))->from('inflow_general_particulars as hg')
                    ->whereColumn('hg.inflow_record_id', 'bc.inflow_record_id')->where('hg.status', 'Encoded');
            })
            ->get([
                'bc.bite_case_id', 'bc.case_number', 'bc.category', 'bc.barangay',
                'p.patient_id', 'p.patient_name', 'p.contact_num',
                's7.dose_type', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day28_date',
            ]);

        return $cases->map(function ($c) use ($today) {
            $schedule = $c->dose_type === 'Booster' ? [0, 3] : [0, 3, 7, 28];
            $day0 = Carbon::parse($c->day0_date)->startOfDay();

            $doses = [];
            foreach ($schedule as $day) {
                $given = $c->{'day' . $day . '_date'};
                $doses[] = [
                    'day' => $day,
                    'date' => $day0->copy()->addDays($day),
                    'given' => $given ? Carbon::parse($given)->startOfDay() : null,
                ];
            }

            $givenDoses = array_values(array_filter($doses, fn ($d) => $d['given']));
            $pending = array_values(array_filter($doses, fn ($d) => !$d['given']));
            $overdue = array_filter($pending, fn ($d) => $d['date']->lt($today));

            $c->day0 = $day0;
            $c->doses = $doses;
            $c->total = count($doses);
            $c->given_count = count($givenDoses);
            $c->pct = (int) round(count($givenDoses) / count($doses) * 100);
            $c->last = $givenDoses ? max(array_map(fn ($d) => $d['given']->timestamp, $givenDoses)) : null;
            $c->last = $c->last ? Carbon::createFromTimestamp($c->last, $today->timezone)->startOfDay() : null;
            $c->next = $pending[0] ?? null;
            $c->overdue_count = count($overdue);
            $c->state = !$pending ? 'Completed' : ($overdue ? 'Late' : 'On Track');
            return $c;
        });
    }
}
