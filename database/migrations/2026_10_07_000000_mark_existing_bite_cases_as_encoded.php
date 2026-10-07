<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Case Encoding now hands a case to the Health Worker only when Staff completes it
     * (walk-in status 'Encoded'). Bite cases created before that rule were already visible
     * to the Health Worker, so mark their walk-in records as Encoded to keep them there.
     */
    public function up(): void
    {
        DB::table('inflow_general_particulars')
            ->where('status', 'Verified')
            ->whereIn('inflow_record_id', DB::table('bite_cases')->select('inflow_record_id'))
            ->update(['status' => 'Encoded']);
    }

    /**
     * Reverse the migrations.
     *
     * Not reversible: it can't tell which records were Encoded before this ran.
     */
    public function down(): void
    {
        //
    }
};
