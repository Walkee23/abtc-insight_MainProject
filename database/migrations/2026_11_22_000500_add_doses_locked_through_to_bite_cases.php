<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Clinical Encoding, Section VII: once a visit has been finalized (Section IX), the doses recorded up to then are part
 * of the patient's record. At the next visit they are only read from the system, never edited again.
 *
 * doses_locked_through = the last dose day (0, 3, 7, 14 or 28) that was recorded when the visit was finalized;
 * every recorded dose up to that day is locked. NULL = nothing locked yet.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_cases', 'doses_locked_through')) {
            Schema::table('bite_cases', function ($table) {
                $table->unsignedTinyInteger('doses_locked_through')->nullable()->after('visit_completed_at');
            });
        }

        // Visits that were finalized before this column existed (waiting for their next dose): lock what was recorded
        if (Schema::hasTable('bite_section7_immunization')) {
            $rows = DB::table('bite_cases as bc')
                ->join('bite_section7_immunization as s7', 's7.bite_case_id', '=', 'bc.bite_case_id')
                ->whereNotNull('bc.visit_completed_at')
                ->whereNull('bc.doses_locked_through')
                ->get(['bc.bite_case_id', 's7.day0_date', 's7.day3_date', 's7.day7_date', 's7.day14_date', 's7.day28_date']);

            foreach ($rows as $row) {
                $last = null;
                foreach ([0, 3, 7, 14, 28] as $day) {
                    if (!empty($row->{'day' . $day . '_date'})) {
                        $last = $day;
                    }
                }
                if ($last !== null) {
                    DB::table('bite_cases')->where('bite_case_id', $row->bite_case_id)->update(['doses_locked_through' => $last]);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bite_cases', 'doses_locked_through')) {
            Schema::table('bite_cases', function ($table) {
                $table->dropColumn('doses_locked_through');
            });
        }
    }
};
