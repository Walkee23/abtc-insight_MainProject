<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Lets the IT dashboard log "Test" messages that aren't tied to a patient/case/schedule.
// Foreign keys still apply to real reminders; NULL simply skips the FK check.
return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE sms MODIFY patient_id VARCHAR(50) NULL, MODIFY bite_case_id INT(11) NULL, MODIFY sched_id INT(11) NULL');
    }

    public function down(): void
    {
        DB::statement("DELETE FROM sms WHERE patient_id IS NULL");
        DB::statement('ALTER TABLE sms MODIFY patient_id VARCHAR(50) NOT NULL, MODIFY bite_case_id INT(11) NOT NULL, MODIFY sched_id INT(11) NOT NULL');
    }
};
