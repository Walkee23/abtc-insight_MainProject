<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bhw_referral_info', 'priority_status')) {
            Schema::table('bhw_referral_info', function (Blueprint $table) {
                $table->string('priority_status', 30)->default('None')->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bhw_referral_info', 'priority_status')) {
            Schema::table('bhw_referral_info', function (Blueprint $table) {
                $table->dropColumn('priority_status');
            });
        }
    }
};