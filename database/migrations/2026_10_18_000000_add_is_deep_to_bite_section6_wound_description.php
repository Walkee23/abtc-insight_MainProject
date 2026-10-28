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
        Schema::table('bite_section6_wound_description', function (Blueprint $table) {
            $table->boolean('is_deep')->nullable()->after('wound_description')
                ->comment('Deep (transdermal) wound? Deep wounds are Category III.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bite_section6_wound_description', function (Blueprint $table) {
            $table->dropColumn('is_deep');
        });
    }
};
