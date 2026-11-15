<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Records which dose (D3 / D7 / D28) each SMS was for, and powers the duplicate check.
return new class extends Migration {
    public function up(): void
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->string('dose_label', 10)->nullable()->after('sched_id');
        });
    }

    public function down(): void
    {
        Schema::table('sms', function (Blueprint $table) {
            $table->dropColumn('dose_label');
        });
    }
};
