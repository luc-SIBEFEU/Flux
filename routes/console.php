<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Clôture quotidienne des séjours et des baux arrivés à échéance (moratoire inclus).
// Nécessite que le worker de planification tourne : php artisan schedule:work (ou un cron système appelant schedule:run chaque minute).
Schedule::command('flux:terminer-sejours')->daily();
Schedule::command('flux:traiter-baux')->daily();
