<?php

use App\Services\SmsService;
use Illuminate\Support\Facades\Schedule;

// Every morning at 08:00 (Manila): text patients whose D3 / D7 / D28 dose is TOMORROW.
// Change addDay() to today() if you want same-day reminders instead.
Schedule::call(function () {
    app(SmsService::class)->queueDueReminders(today()->addDay());
})->name('sms-reminders')->dailyAt('15:55')->timezone('Asia/Manila')->withoutOverlapping();
