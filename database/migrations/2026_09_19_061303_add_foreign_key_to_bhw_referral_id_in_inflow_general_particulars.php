<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // A foreign key must point to a column with a UNIQUE (or PRIMARY) index.
        // Add one to reference_no if it doesn't already have one.
        $hasUnique = collect(DB::select("SHOW INDEX FROM bhw_referral_info WHERE Column_name = 'reference_no' AND Non_unique = 0"))->isNotEmpty();

        if (!$hasUnique) {
            Schema::table('bhw_referral_info', function (Blueprint $table) {
                $table->unique('reference_no');
            });
        }

        Schema::table('inflow_general_particulars', function (Blueprint $table) {
            $table->foreign('bhw_referral_id')
                ->references('reference_no')
                ->on('bhw_referral_info')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inflow_general_particulars', function (Blueprint $table) {
            $table->dropForeign(['bhw_referral_id']);
        });
    }
};