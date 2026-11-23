<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Staff can now "Save Progress" on Case Encoding before every exposure field is known, so the
 * three columns that used to be mandatory may be empty on a draft. "Complete Encoding" still
 * requires the animal type and bite date (validated in StaffController).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bite_section3_exposure', function (Blueprint $table) {
            $table->string('animal_type', 50)->nullable()->change();
            $table->dateTime('bite_date_time')->nullable()->change();
            $table->string('exposure_type', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        // Not reversed: drafts may already hold empty values that the old NOT NULL columns would reject.
    }
};
