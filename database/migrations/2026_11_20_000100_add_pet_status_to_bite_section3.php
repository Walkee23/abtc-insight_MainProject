<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Staff Case Encoding asks "Pet or Stray?"; until now the answer had no column and was dropped. */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('bite_section3_exposure', 'pet_status')) {
            Schema::table('bite_section3_exposure', function (Blueprint $table) {
                $table->string('pet_status', 10)->nullable()->after('animal_type_other');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('bite_section3_exposure', 'pet_status')) {
            Schema::table('bite_section3_exposure', function (Blueprint $table) {
                $table->dropColumn('pet_status');
            });
        }
    }
};
