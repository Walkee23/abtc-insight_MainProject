<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Pet / Stray is stored in bite_section3_exposure.animal_ownership (the column the analytics reads).
 * The earlier migration added it as pet_status, so this moves anything saved there and leaves a
 * single column, whichever of the two a database happens to have.
 */
return new class extends Migration
{
    public function up(): void
    {
        $hasOld = Schema::hasColumn('bite_section3_exposure', 'pet_status');
        $hasNew = Schema::hasColumn('bite_section3_exposure', 'animal_ownership');

        if ($hasOld && !$hasNew) {
            Schema::table('bite_section3_exposure', function ($table) {
                $table->renameColumn('pet_status', 'animal_ownership');
            });
        } elseif ($hasOld && $hasNew) {
            DB::table('bite_section3_exposure')->whereNull('animal_ownership')->whereNotNull('pet_status')
                ->update(['animal_ownership' => DB::raw('pet_status')]);
            Schema::table('bite_section3_exposure', function ($table) {
                $table->dropColumn('pet_status');
            });
        } elseif (!$hasOld && !$hasNew) {
            Schema::table('bite_section3_exposure', function ($table) {
                $table->string('animal_ownership', 10)->nullable()->after('animal_type_other');
            });
        }
    }

    public function down(): void
    {
        // Not reversed: animal_ownership is the column the rest of the system reads.
    }
};
