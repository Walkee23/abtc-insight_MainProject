<?php

use App\Services\SmsService;
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

// Every morning at 08:00 (Manila): text patients whose D3 / D7 / D28 dose is TOMORROW.
// Change addDay() to today() if you want same-day reminders instead.
Schedule::call(function () {
    app(SmsService::class)->queueDueReminders(today()->addDay());
})->name('sms-reminders')->dailyAt('13:55')->timezone('Asia/Manila')->withoutOverlapping();

Schedule::command('inflow:summarize')
    ->dailyAt('00:05')
    ->timezone('Asia/Manila');