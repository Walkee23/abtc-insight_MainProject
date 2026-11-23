<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Day 14 is no longer part of any PEP schedule (Primary = Day 0, 3, 7, 28; Booster = Day 0, 3), so the
 * `day14_date` column of bite_section7_immunization is dropped.
 *
 * Careful with the imported records: their "4TH DOSE" column was loaded into day14_date, but those dates are
 * about 28 days after Day 0 (the 4th dose of a 4-dose course), i.e. the Day 28 dose. They are moved into
 * day28_date first (only where Day 28 is still empty, the case is not a Booster and the date really falls
 * after Day 0), so the 4th dose of those patients is kept and they count as completed. Every non-empty
 * day14_date is also saved to a CSV in storage/app/private/backups before the column goes.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            return;
        }

        $rows = DB::table('bite_section7_immunization')->whereNotNull('day14_date')
            ->orderBy('bite_case_id')->get(['bite_case_id', 'dose_type', 'day0_date', 'day14_date', 'day28_date']);

        if ($rows->isNotEmpty()) {
            $csv = "bite_case_id,dose_type,day0_date,day14_date,day28_date\n";
            foreach ($rows as $r) {
                $csv .= implode(',', [$r->bite_case_id, $r->dose_type, $r->day0_date, $r->day14_date, $r->day28_date]) . "\n";
            }
            Storage::disk('local')->put('backups/day14_date_' . now()->format('Ymd_His') . '.csv', $csv);
        }

        DB::statement("UPDATE bite_section7_immunization
                          SET day28_date = day14_date
                        WHERE day14_date IS NOT NULL
                          AND day28_date IS NULL
                          AND day0_date IS NOT NULL
                          AND COALESCE(dose_type, '') <> 'Booster'
                          AND DATEDIFF(day14_date, day0_date) >= 10");

        Schema::table('bite_section7_immunization', function ($table) {
            $table->dropColumn('day14_date');
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            Schema::table('bite_section7_immunization', function ($table) {
                $table->date('day14_date')->nullable()->after('day7_date');
            });
        }
        // The dates themselves are not restored here; they are in the backups CSV (and the moved ones are in day28_date).
    }
};
