<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SummarizeDailyInflow extends Command
{
    protected $signature = 'inflow:summarize {--date= : Specific YYYY-MM-DD date (defaults to yesterday)} {--backfill : Summarize all historical dates in inflow_general_particulars}';
    protected $description = 'Snapshot daily patient inflow counts into daily_inflow_summary and purge past unverified no-shows';

    public function handle(): int
    {
        if ($this->option('backfill')) {
            $dates = DB::table('inflow_general_particulars')
                ->select('queue_date')
                ->distinct()
                ->orderBy('queue_date')
                ->pluck('queue_date');

            foreach ($dates as $d) {
                $this->summarizeDate((string) $d, 'System (Backfill)');
            }

            $this->info('Backfilled ' . $dates->count() . ' dates into daily_inflow_summary.');
            return self::SUCCESS;
        }

        $date = $this->option('date') ?: Carbon::yesterday('Asia/Manila')->toDateString();
        $this->summarizeDate($date, 'System');
        $this->info("Summarized inflow and cleaned up unverified rows for {$date}.");

        return self::SUCCESS;
    }

    private function summarizeDate(string $date, string $triggeredBy): void
    {
        DB::transaction(function () use ($date, $triggeredBy) {
            $rows = DB::table('inflow_general_particulars')
                ->whereDate('queue_date', $date)
                ->get(['queue_id', 'status']);

            $totalPatients = $rows->count();
            $totalPriority = $rows->filter(fn ($r) => str_starts_with((string) $r->queue_id, 'P'))->count();
            $totalNormal   = $rows->filter(fn ($r) => str_starts_with((string) $r->queue_id, 'N'))->count();
            $totalVerified = $rows->whereIn('status', ['Verified', 'Encoded'])->count();

            $lastP = $rows->filter(fn ($r) => str_starts_with((string) $r->queue_id, 'P'))
                ->map(fn ($r) => (int) substr((string) $r->queue_id, 1))
                ->max();

            $lastN = $rows->filter(fn ($r) => str_starts_with((string) $r->queue_id, 'N'))
                ->map(fn ($r) => (int) substr((string) $r->queue_id, 1))
                ->max();

            DB::table('daily_inflow_summary')->updateOrInsert(
                ['inflow_date' => $date],
                [
                    'total_patients'     => $totalPatients,
                    'total_priority'     => $totalPriority,
                    'total_normal'       => $totalNormal,
                    'total_verified'     => $totalVerified,
                    'last_queue_p'       => $lastP,
                    'last_queue_n'       => $lastN,
                    'reset_triggered_by' => $triggeredBy,
                    'reset_time'         => now('Asia/Manila'),
                ]
            );

            // Safely purge unverified Pending no-shows from past days (only if not linked to patients or bite_cases)
            if ($date < Carbon::today('Asia/Manila')->toDateString()) {
                DB::table('inflow_general_particulars')
                    ->whereDate('queue_date', $date)
                    ->where('status', 'Pending')
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('patients')
                            ->whereColumn('patients.inflow_record_id', 'inflow_general_particulars.inflow_record_id');
                    })
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('bite_cases')
                            ->whereColumn('bite_cases.inflow_record_id', 'inflow_general_particulars.inflow_record_id');
                    })
                    ->delete();
            }
        });
    }
}