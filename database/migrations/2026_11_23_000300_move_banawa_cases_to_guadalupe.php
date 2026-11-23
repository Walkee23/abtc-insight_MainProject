<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * "Banawa" is a sitio inside Barangay Guadalupe, not a barangay of its own (the 2012 plebiscite to split it off was
 * rejected), so the boundary file of the Spatial Map has no "Banawa" polygon and its cases were left off the map.
 * Records that say "Banawa" are moved to Guadalupe, the barangay they belong to.
 *
 * One old imported case (Donal, Teodora, 2025) has no barangay name at all: a spreadsheet turned it into the number
 * 1.11111111111111E+27, so it was left off the map too. Its real barangay is not known and it is an old record, so it
 * is set to Lahug.
 *
 * Only an exact "Banawa" and that exact number are changed, and running it again changes nothing, so it is safe on any
 * database. It cannot be undone (nothing says afterwards which records were changed).
 */
return new class extends Migration
{
    private const COLUMNS = [
        'bite_cases'                 => 'barangay',
        'inflow_general_particulars' => 'barangay',
        'bhw_referral_info'          => 'patient_barangay',
    ];

    /** What each wrong value becomes. */
    private const FIXES = [
        'Banawa'               => 'Guadalupe',
        '1.11111111111111E+27' => 'Lahug',   // spreadsheet damage on one imported case
    ];

    public function up(): void
    {
        foreach (self::COLUMNS as $table => $column) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, $column)) {
                continue;
            }
            foreach (self::FIXES as $wrong => $right) {
                DB::table($table)->where($column, $wrong)->update([$column => $right]);
            }
        }
    }

    public function down(): void
    {
        // not reversible: see the note above
    }
};
