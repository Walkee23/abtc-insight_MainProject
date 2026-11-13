<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-backup (Admin > User & System Management > Configure Auto-Backup). The command only
// does something when the saved schedule says a backup is due. Needs the scheduler running:
//   php artisan schedule:work        (or a Windows Task Scheduler job: php artisan schedule:run, every minute)
Schedule::command('backup:database --auto')->everyMinute()->withoutOverlapping();
