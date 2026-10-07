<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PepComplianceController extends Controller
{
    /**
     * PEP Compliance & SMS Logs.
     *
     * Doses are worked out from Section VII (bite_section7_immunization): the Day 0 date
     * sets the schedule (Primary: D0/D3/D7/D28, Booster: D0/D3) and each recorded day date
     * is the actual dose. SMS stats and logs come from the `sms` table.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $status = in_array($request->query('status'), ['pending', 'missed', 'completed'], true)
            ? $request->query('status') : 'all';

        $doses = $this->doses();

        // --- Summary cards --------------------------------------------------
        $completed = $doses->filter(fn ($d) => str_starts_with($d->status, 'Completed'))->count();
        $onTime = $doses->where('status', 'Completed On Time')->count();
        $missed = $doses->where('status', 'Missed')->count();
        $tomorrow = $this->today()->copy()->addDay();
        $pendingReminders = $doses->where('status', 'Pending')
            ->filter(fn ($d) => $d->scheduled->lte($tomorrow))->count();

        $stats = [
            'completion' => ($completed + $missed) > 0 ? round($completed / ($completed + $missed) * 100, 1) : null,
            'on_time_pct' => $completed > 0 ? (int) round($onTime / $completed * 100) : null,
            'missed' => $missed,
            'pending_reminders' => $pendingReminders,
        ];

        $smsSent = DB::table('sms')->where('status', 'Sent')->count();
        $smsFailed = DB::table('sms')->where('status', 'Failed')->count();
        $stats['sms_rate'] = ($smsSent + $smsFailed) > 0 ? round($smsSent / ($smsSent + $smsFailed) * 100, 1) : null;
        $stats['sms_total'] = DB::table('sms')->count();

        // --- Tracking table: needs-attention first ---------------------------
        $rows = $doses->filter(function ($d) use ($status, $search) {
            if ($status === 'pending' && $d->status !== 'Pending') return false;
            if ($status === 'missed' && $d->status !== 'Missed') return false;
            if ($status === 'completed' && !str_starts_with($d->status, 'Completed')) return false;
            $hay = mb_strtolower($d->patient_name . ' ' . $d->patient_id . ' ' . $d->dose_label . ' ' . $d->label . ' ' . $d->barangay);
            foreach (preg_split('/\s+/', mb_strtolower($search), -1, PREG_SPLIT_NO_EMPTY) as $term) {
                if (!str_contains($hay, $term)) return false;
            }
            return true;
        })->sort(function ($a, $b) {
            $rank = ['Missed' => 0, 'Pending' => 1, 'Completed Late' => 2, 'Completed On Time' => 2];
            return [$rank[$a->status], $a->status === 'Missed' || $a->status === 'Pending' ? $a->scheduled->timestamp : -$a->scheduled->timestamp]
                <=> [$rank[$b->status], $b->status === 'Missed' || $b->status === 'Pending' ? $b->scheduled->timestamp : -$b->scheduled->timestamp];
        })->values();

        $perPage = 10;
        $page = max(1, (int) $request->query('page', 1));
        $tracking = new LengthAwarePaginator(
            $rows->forPage($page, $perPage)->values(), $rows->count(), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // --- SMS outreach logs ----------------------------------------------
        $smsLogs = DB::table('sms')->orderByDesc('send_date')->limit(30)
            ->get(['sms_type', 'contact_num', 'status', 'send_date', 'error_detail']);

        // --- Performance by barangay (completed vs. completed + missed) ------
        $barangays = $doses->groupBy('barangay')->map(function ($group, $name) {
            $done = $group->filter(fn ($d) => str_starts_with($d->status, 'Completed'))->count();
            $miss = $group->where('status', 'Missed')->count();
            return (object) [
                'name' => $name ?: 'Unknown',
                'pct' => ($done + $miss) > 0 ? (int) round($done / ($done + $miss) * 100) : null,
                'doses' => $done + $miss,
            ];
        })->filter(fn ($b) => $b->pct !== null)->sortByDesc('pct')->values()->take(12);

        return view('healthworker.PEP_Compliance_&_SMS_Logs', compact(
            'stats', 'tracking', 'smsLogs', 'barangays', 'search', 'status'
        ));
    }

    /** Full compliance report as CSV (every scheduled dose). */
    public function export()
    {
        $doses = $this->doses()->sortBy(fn ($d) => [$d->patient_name, $d->scheduled->timestamp])->values();

        return response()->streamDownload(function () use ($doses) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Patient Name', 'Patient ID', 'Barangay', 'Case No.', 'Dose', 'Label', 'Scheduled Date', 'Actual Date', 'Status']);
            foreach ($doses as $d) {
                fputcsv($out, [
                    $d->patient_name, $d->patient_id, $d->barangay, $d->case_number, $d->dose_label, $d->label,
                    $d->scheduled->toDateString(), $d->actual ? $d->actual->toDateString() : '', $d->status,
                ]);
            }
            fclose($out);
        }, 'pep-compliance-report-' . $this->today()->toDateString() . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function today(): Carbon
    {
        return now('Asia/Manila')->startOfDay();
    }

    /**
     * Every scheduled dose of every case that has a Day 0 date, with its status:
     * Completed On Time / Completed Late / Missed / Pending.
     */
    private function doses()
    {
        $today = $this->today();

        $cases = DB::table('bite_cases as bc')
            ->join('patients as p', 'p.patient_id', '=', 'bc.patient_id')
            ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
            ->whereNotNull('s7.day0_date')
            ->get([
                'bc.bite_case_id', 'bc.case_number', 'bc.category', 'bc.barangay',
                'p.patient_id', 'p.patient_name',
                's7.dose_type', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day28_date',
            ]);

        $doses = collect();
        foreach ($cases as $c) {
            $schedule = $c->dose_type === 'Booster' ? [0, 3] : [0, 3, 7, 28];
            $label = $c->category === 'III' ? 'High Risk' : ($c->dose_type === 'Booster' ? 'Booster' : 'Standard');
            $day0 = Carbon::parse($c->day0_date)->startOfDay();

            foreach ($schedule as $i => $day) {
                $scheduled = $day0->copy()->addDays($day);
                $actualRaw = $c->{'day' . $day . '_date'};
                $actual = $actualRaw ? Carbon::parse($actualRaw)->startOfDay() : null;

                if ($actual) {
                    $status = $actual->lte($scheduled) ? 'Completed On Time' : 'Completed Late';
                } else {
                    $status = $scheduled->lt($today) ? 'Missed' : 'Pending';
                }

                $doses->push((object) [
                    'bite_case_id' => $c->bite_case_id,
                    'case_number' => $c->case_number,
                    'patient_id' => $c->patient_id,
                    'patient_name' => $c->patient_name,
                    'barangay' => $c->barangay,
                    'dose_label' => 'Dose ' . ($i + 1) . ' (D' . $day . ')',
                    'label' => $label,
                    'scheduled' => $scheduled,
                    'actual' => $actual,
                    'status' => $status,
                ]);
            }
        }

        return $doses;
    }
}
