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
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->boolean('tetanus_by_barangay')->default(false)->after('tetanus_details')
                ->comment('Tetanus prophylaxis was already given at the barangay (by the BHW).');
            $table->boolean('tig_by_barangay')->default(false)->after('tig_details')
                ->comment('TIG was already given at the barangay (by the BHW).');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->dropColumn(['tetanus_by_barangay', 'tig_by_barangay']);
        });
    }
};
