<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Section VII also records the Day 14 dose (needed for the 5-dose schedule).
     */
    public function up(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->date('day14_date')->nullable()->after('day7_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->dropColumn('day14_date');
        });
    }
};
