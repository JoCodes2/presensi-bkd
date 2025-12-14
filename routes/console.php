<?php

use App\Jobs\AlphaNotificationJob;
use App\Models\PresensiModel;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $yesterday = now()->subDay()->toDateString();


    $allActiveUserIds = User::where('status', 'active')->pluck('id')->all();

    $attendedUserIds = PresensiModel::where('tanggal', $yesterday)->pluck('id_user')->all();

    $alphaUserIds = array_diff($allActiveUserIds, $attendedUserIds);

    foreach ($alphaUserIds as $userId) {
        AlphaNotificationJob::dispatch($userId, $yesterday);
    }
})->dailyAt('17:00');
