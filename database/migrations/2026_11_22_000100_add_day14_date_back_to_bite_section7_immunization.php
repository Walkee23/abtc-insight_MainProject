<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Day 14 is part of the schedule again, for the IM (intramuscular) route only:
 *   Primary IM -> Day 0, 3, 7, 14      Primary ID -> Day 0, 3, 7, 28      Booster -> Day 0, 3
 * (the earlier migration 2026_11_22_000000 dropped the column when Day 14 was removed from every schedule).
 * The column comes back empty: the old values were the imported "4th dose" dates, which are Day 28 dates
 * and already live in day28_date.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            Schema::table('bite_section7_immunization', function ($table) {
                $table->date('day14_date')->nullable()->after('day7_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            Schema::table('bite_section7_immunization', function ($table) {
                $table->dropColumn('day14_date');
            });
        }
    }
};
