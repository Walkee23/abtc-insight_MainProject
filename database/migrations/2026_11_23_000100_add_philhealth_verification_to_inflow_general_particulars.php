<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Step 3 of the patient registration form asks whether the patient is a PhilHealth member. That is only the patient's
 * own answer: Staff checks it (Staff dashboard > PhilHealth Verification) and records the result here.
 *
 * philhealth_verification: NULL = not checked yet, 'Verified' = confirmed member,
 *                          'Not a Member' = not a PhilHealth member, 'Expired' = membership no longer active.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('inflow_general_particulars', 'philhealth_verification')) {
            Schema::table('inflow_general_particulars', function ($table) {
                $table->string('philhealth_verification', 20)->nullable();
                $table->dateTime('philhealth_verified_at')->nullable();
                $table->string('philhealth_verified_by', 100)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('inflow_general_particulars', 'philhealth_verification')) {
            Schema::table('inflow_general_particulars', function ($table) {
                $table->dropColumn(['philhealth_verification', 'philhealth_verified_at', 'philhealth_verified_by']);
            });
        }
    }
};
