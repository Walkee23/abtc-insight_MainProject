<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * A PEP course takes several visits (Day 0, 3, 7 ... 14 or 28). When a Health Worker finishes the encoding of a visit
 * and more doses are still due, the case stays open (no outcome) but is DONE for that day: it leaves the Clinical
 * Encoding queue until the patient registers again for the next dose.
 *
 * visit_completed_at is set when the visit is finalized (Section IX) with doses still due, and cleared when the patient
 * checks in again through the Returning Patient portal.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_cases', 'visit_completed_at')) {
            Schema::table('bite_cases', function ($table) {
                $table->dateTime('visit_completed_at')->nullable()->after('returned_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bite_cases', 'visit_completed_at')) {
            Schema::table('bite_cases', function ($table) {
                $table->dropColumn('visit_completed_at');
            });
        }
    }
};
