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
        Schema::table('inflow_general_particulars', function (Blueprint $table) {
            $table->string('bhw_referral_id')->nullable()->after('id_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inflow_general_particulars', function (Blueprint $table) {
            $table->dropColumn('bhw_referral_id');
        });
    }
};