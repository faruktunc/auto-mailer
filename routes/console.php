<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');




$taskSchedules = \App\Models\MailSchedules::where('active',true)->get();
foreach ($taskSchedules as $key => $taskSchedule){
    $params = explode(",", $taskSchedule->params);
    Schedule::call(function () use ($taskSchedule){
        Artisan::queue('jotform:mail-gonder',['hedefotomailId' => $taskSchedule->id]);
        Log::info("{$taskSchedule->id} idli mail" . now().' Zamaninda Calistirildi');
    })->{$taskSchedule->frequency}(...$params)->name($taskSchedule->id);
}

