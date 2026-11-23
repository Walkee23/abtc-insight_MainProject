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

// 08:00 Manila: remind patients whose next dose is TOMORROW (D3 / D7 / D14 for IM, D3 / D7 / D28 for ID, D3 for a Booster).
Schedule::call(function () {
    app(SmsService::class)->queueDueReminders(today()->addDay());
})->name('sms-reminders')->dailyAt('08:00')->timezone('Asia/Manila')->withoutOverlapping();

// 09:00 Manila: text patients who MISSED a dose that was due YESTERDAY.
// (An hour after the reminders so the two batches don't overlap at the gateway.)
Schedule::call(function () {
    app(SmsService::class)->queueLateFollowUps(today()->subDay());
})->name('sms-late-followups')->dailyAt('09:00')->timezone('Asia/Manila')->withoutOverlapping();

Schedule::command('inflow:summarize')
    ->dailyAt('00:05')
    ->timezone('Asia/Manila');