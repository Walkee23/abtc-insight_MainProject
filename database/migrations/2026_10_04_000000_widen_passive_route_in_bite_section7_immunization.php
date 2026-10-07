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
        // 'IU infiltrate' is 13 characters, which didn't fit in varchar(10)
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->string('passive_route', 20)->nullable()->comment('Values: IU infiltrate, IM')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bite_section7_immunization', function (Blueprint $table) {
            $table->string('passive_route', 10)->nullable()->comment('Values: IU infiltrate, IM')->change();
        });
    }
};
