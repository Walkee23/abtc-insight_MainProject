<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A person keeps ONE Patient ID for life: when they register again for a new bite, Staff verification finds the
 * existing patient (same name and date of birth) and the new registration only gets a new bite case (#2, #3, ...).
 *
 * That means a registration (inflow_general_particulars row) can no longer be tied to its patient through
 * patients.inflow_record_id, which only points at the patient's FIRST registration. This column links every
 * registration to its patient.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('inflow_general_particulars', 'patient_id')) {
            Schema::table('inflow_general_particulars', function ($table) {
                $table->string('patient_id', 50)->nullable()->index();
            });
        }

        // every registration that already has a patient (the patient row was made from that registration)
        DB::statement('UPDATE inflow_general_particulars ig
            JOIN patients p ON p.inflow_record_id = ig.inflow_record_id
            SET ig.patient_id = p.patient_id
            WHERE ig.patient_id IS NULL');

        // registrations that created a bite case for a patient (covers anything not matched above)
        DB::statement('UPDATE inflow_general_particulars ig
            JOIN bite_cases bc ON bc.inflow_record_id = ig.inflow_record_id
            SET ig.patient_id = bc.patient_id
            WHERE ig.patient_id IS NULL');
    }

    public function down(): void
    {
        if (Schema::hasColumn('inflow_general_particulars', 'patient_id')) {
            Schema::table('inflow_general_particulars', function ($table) {
                $table->dropColumn('patient_id');
            });
        }
    }
};
