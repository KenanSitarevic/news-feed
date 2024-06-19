<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('news-get', function (){
    NewsController::getNewest('https://www.klix.ba/rss', 'klix');
    NewsController::getNewest('https://www.vijesti.ba/rss/svevijesti', 'vijesti.ba');
    //NewsController::getNewest('https://www.slobodna-bosna.ba/rss/100/sve_vijesti.html', 'slobodna bosna');
});

Schedule::command('news-get')->everyFiveMinutes();


