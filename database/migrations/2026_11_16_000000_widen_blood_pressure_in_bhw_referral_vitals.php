<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The BHW form sends 3 BP readings joined as "120/80, 118/80, 122/82" (22 chars),
        // which didn't fit in databases where blood_pressure was still a short varchar.
        Schema::table('bhw_referral_vitals', function (Blueprint $table) {
            $table->string('blood_pressure', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left as-is: shrinking the column could truncate stored BP readings.
    }
};
