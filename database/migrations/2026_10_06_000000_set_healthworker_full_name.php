<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('username', 'healthworker')
            ->update(['full_name' => 'Dr. Elena Santos']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('username', 'healthworker')
            ->update(['full_name' => 'Test HW']);
    }
};
