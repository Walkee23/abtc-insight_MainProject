<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Cases verified before 2026 are past data that was imported or left over: those patients are not coming back for
 * another dose, yet the cases that were still open kept showing in Clinical Encoding. They are closed as `Incomplete`,
 * like the other past records that never finished a course.
 *
 * A case from before 2026 that has a dose recorded in 2026 or later is clearly still being worked on, so it is left alone.
 * Cases that already have an outcome are not touched, so it is safe to run on any database.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bite_cases')) {
            return;
        }

        $query = DB::table('bite_cases as bc')
            ->whereNull('bc.outcome')
            ->where('bc.date_verified', '<', '2026-01-01');

        if (Schema::hasTable('bite_section7_immunization')) {
            // still in use: any dose dated in 2026 or later
            $query->whereNotExists(function ($e) {
                $e->select(DB::raw(1))->from('bite_section7_immunization as s7')
                    ->whereColumn('s7.bite_case_id', 'bc.bite_case_id')
                    ->where(function ($d) {
                        foreach (['day0_date', 'day3_date', 'day7_date', 'day14_date', 'day28_date'] as $col) {
                            $d->orWhere('s7.' . $col, '>=', '2026-01-01');
                        }
                    });
            });
        }

        $query->update(['bc.outcome' => 'Incomplete']);
    }

    public function down(): void
    {
        // Not reversed: these cases were never going to be continued.
    }
};
