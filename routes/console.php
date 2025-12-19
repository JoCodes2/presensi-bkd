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
    $today = now()->toDateString();

    $allActiveUserIds = User::where('status', 'active')->pluck('id')->all();

    $attendedUserIds = PresensiModel::where('tanggal', $today)
        ->pluck('id_user')
        ->all();

    // 4. Bandingkan untuk mendapatkan user yang BELUM absen (Alpha)
    $alphaUserIds = array_diff($allActiveUserIds, $attendedUserIds);

    // 5. Kirim Job/Notifikasi
    foreach ($alphaUserIds as $userId) {
        AlphaNotificationJob::dispatch($userId, $today);
    }
})->everyMinute();
