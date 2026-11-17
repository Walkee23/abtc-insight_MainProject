<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            Schema::table('bite_section7_immunization', function (Blueprint $table) {
                $table->date('day14_date')->nullable()->after('day7_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bite_section7_immunization', 'day14_date')) {
            Schema::table('bite_section7_immunization', function (Blueprint $table) {
                $table->dropColumn('day14_date');
            });
        }
    }
};
