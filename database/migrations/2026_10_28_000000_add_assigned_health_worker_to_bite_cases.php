<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Staff assigns each case to a Health Worker; a Health Worker's Clinical Encoding
     * queue only lists the cases assigned to them. NULL = not assigned yet.
     */
    public function up(): void
    {
        Schema::table('bite_cases', function (Blueprint $table) {
            $table->integer('assigned_health_worker_id')->nullable()->after('bhw_referral_id')
                ->comment('users.user_id of the Health Worker the case was assigned to by Staff. NULL until assigned.');
            $table->foreign('assigned_health_worker_id', 'fk_bc_health_worker')
                ->references('user_id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });

        // Cases that were already handed over before assignment existed stay with the
        // original test health worker, so their queue doesn't suddenly empty out.
        $original = DB::table('users')->where('username', 'healthworker')->value('user_id');
        if ($original) {
            DB::table('bite_cases')->whereNull('assigned_health_worker_id')
                ->whereIn('inflow_record_id', DB::table('inflow_general_particulars')->where('status', 'Encoded')->select('inflow_record_id'))
                ->update(['assigned_health_worker_id' => $original]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bite_cases', function (Blueprint $table) {
            $table->dropForeign('fk_bc_health_worker');
            $table->dropColumn('assigned_health_worker_id');
        });
    }
};
