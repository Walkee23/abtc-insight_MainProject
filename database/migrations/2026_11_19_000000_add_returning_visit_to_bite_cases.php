<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A returning patient checks in for the next dose of the SAME bite case: the case is updated
 * (not duplicated) and goes back to the Health Workers' unclaimed pool, marked with the dose
 * the patient came for. The Health Worker's Section VII save clears the mark again.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bite_cases', function (Blueprint $table) {
            if (!Schema::hasColumn('bite_cases', 'return_dose_day')) {
                $table->unsignedTinyInteger('return_dose_day')->nullable()->after('assigned_health_worker_id');
            }
            if (!Schema::hasColumn('bite_cases', 'returned_at')) {
                $table->dateTime('returned_at')->nullable()->after('return_dose_day');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bite_cases', function (Blueprint $table) {
            foreach (['returned_at', 'return_dose_day'] as $col) {
                if (Schema::hasColumn('bite_cases', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
