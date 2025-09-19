<?php

use App\Jobs\SyncVoidedSubscriptions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Schedule::job(new SyncVoidedSubscriptions())->dailyAt('3:00'); 3am
Schedule::job(new SyncVoidedSubscriptions())
    ->timezone('africa/bangui')
    ->everyMinute();
