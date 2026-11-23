<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * "Banawa" is a sitio inside Barangay Guadalupe, not a barangay of its own (the 2012 plebiscite to split it off was
 * rejected), so the boundary file of the Spatial Map has no "Banawa" polygon and its cases were left off the map.
 * Records that say "Banawa" are moved to Guadalupe, the barangay they belong to.
 *
 * Only an exact "Banawa" is changed, and running it again changes nothing, so it is safe on any database.
 * It cannot be undone (after the change nothing says which Guadalupe records were written as Banawa).
 */
return new class extends Migration
{
    private const COLUMNS = [
        'bite_cases'                 => 'barangay',
        'inflow_general_particulars' => 'barangay',
        'bhw_referral_info'          => 'patient_barangay',
    ];

    public function up(): void
    {
        foreach (self::COLUMNS as $table => $column) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                DB::table($table)->where($column, 'Banawa')->update([$column => 'Guadalupe']);
            }
        }
    }

    public function down(): void
    {
        // not reversible: see the note above
    }
};
