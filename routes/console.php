<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
Schedule::command('app:send-reminders')->daily();
Schedule::command('app:cleanup-ktp')->daily();
Schedule::command('app:process-daily-tasks')->daily();
Schedule::command('app:send-payment-reminders')->dailyAt('08:00');


