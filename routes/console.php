<?php

use App\Jobs\SyncVoidedSubscriptions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('queue:work --stop-when-empty')->everyMinute();

Schedule::job(new SyncVoidedSubscriptions())
    ->timezone('africa/bangui')
    ->dailyAt('3:00');
