<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The vaccine brand and "administered by" belong to each dose, not to the whole course: a patient who reacts to
 * the Day 0 brand may get a different brand on Day 3, and whoever saves one visit must not overwrite the others.
 *
 * Adds  day{0,3,7,14,28}_brand  and  day{0,3,7,14,28}_administered_by  to bite_section7_immunization.
 *
 * Existing records keep what they had: the single brand / administered-by of the course is copied onto every dose
 * that already has a date (the old form could only store one value for all of them), and the old short brand
 * names are brought to the full names used everywhere else (e.g. VAXIRAB -> VAXIRAB (PCEC)).
 * The old vaccine_brand and administered_by columns stay and mirror the Day 0 dose.
 */
return new class extends Migration
{
    private const DAYS = [0, 3, 7, 14, 28];

    public function up(): void
    {
        $table = 'bite_section7_immunization';

        Schema::table($table, function ($t) use ($table) {
            foreach (self::DAYS as $day) {
                if (!Schema::hasColumn($table, "day{$day}_brand")) {
                    $t->string("day{$day}_brand", 100)->nullable();
                }
                if (!Schema::hasColumn($table, "day{$day}_administered_by")) {
                    $t->string("day{$day}_administered_by", 100)->nullable();
                }
            }
        });

        $full = "CASE vaccine_brand
                    WHEN 'VERORAB' THEN 'VERORAB (PVRV)'
                    WHEN 'SPEEDA' THEN 'SPEEDA (PVRV)'
                    WHEN 'VAXIRAB' THEN 'VAXIRAB (PCEC)'
                    WHEN 'ABHAYRAB' THEN 'ABHAYRAB (PVRV)'
                    ELSE vaccine_brand END";

        DB::statement("UPDATE {$table} SET vaccine_brand = {$full} WHERE vaccine_brand IN ('VERORAB', 'SPEEDA', 'VAXIRAB', 'ABHAYRAB')");

        foreach (self::DAYS as $day) {
            DB::statement("UPDATE {$table}
                              SET day{$day}_brand = NULLIF(vaccine_brand, ''),
                                  day{$day}_administered_by = NULLIF(administered_by, '')
                            WHERE day{$day}_date IS NOT NULL
                              AND day{$day}_brand IS NULL
                              AND day{$day}_administered_by IS NULL");
        }
    }

    public function down(): void
    {
        $table = 'bite_section7_immunization';

        Schema::table($table, function ($t) use ($table) {
            foreach (self::DAYS as $day) {
                foreach (["day{$day}_brand", "day{$day}_administered_by"] as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $t->dropColumn($column);
                    }
                }
            }
        });
    }
};
