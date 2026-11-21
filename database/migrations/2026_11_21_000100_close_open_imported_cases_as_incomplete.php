<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The imported past records (queue numbers starting with "H") that were left without an outcome showed up in the
 * Health Worker "Unclaimed" pool even though those patients are long gone and there is no dose data to complete.
 * They are closed as `Incomplete`, like the other imported records that never finished a course.
 *
 * Only touches imported cases that nobody has claimed and that still have no outcome, so it is safe to run on any
 * database (a database without such cases is left exactly as it is).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bite_cases') || !Schema::hasTable('inflow_general_particulars')) {
            return;
        }

        DB::table('bite_cases as bc')
            ->join('inflow_general_particulars as g', 'g.inflow_record_id', '=', 'bc.inflow_record_id')
            ->where('g.status', 'Encoded')
            ->where('g.queue_id', 'like', 'H%')
            ->whereNull('bc.assigned_health_worker_id')
            ->whereNull('bc.outcome')
            ->update(['bc.outcome' => 'Incomplete']);
    }

    public function down(): void
    {
        // Not reversed: the records were never going to be completed, and the original blank outcome was not a real state.
    }
};
