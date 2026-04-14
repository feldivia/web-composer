<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Publicar automáticamente posts y páginas programados cuya fecha ya pasó
Schedule::command('posts:publish-scheduled')->everyMinute();
