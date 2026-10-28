<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The skin test field was removed from Section VII, so the column is no longer used.
     */
    public function up(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->dropColumn('skin_test_due');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Brings the (empty) column back; any times that were stored in it are not restored.
     */
    public function down(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->time('skin_test_due')->nullable()->after('passive_route')
                ->comment('30-min post-injection allergy skin test time.');
        });
    }
};
