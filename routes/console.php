<?php

use App\Jobs\AlphaNotificationJob;
use App\Models\PresensiModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
    $today = now()->toDateString();

    $allActiveUserIds = User::where('status', 'active')->pluck('id')->all();

    $attendedUserIds = PresensiModel::where('tanggal', $today)->pluck('id_user')->all();
    $alphaUserIds = array_diff($allActiveUserIds, $attendedUserIds);

    foreach ($alphaUserIds as $userId) {
        AlphaNotificationJob::dispatch($userId, $today, 'total');
        Log::info("Dispatch Alpha Total: " . $userId);
    }

    $lupaPulangUsers = PresensiModel::where('tanggal', $today)
        ->whereNotNull('jam_masuk')
        ->whereNull('status_keluar')
        ->get();

    foreach ($lupaPulangUsers as $presensi) {
        AlphaNotificationJob::dispatch($presensi->id_user, $today, 'pulang');
    }
})->everyMinute();
