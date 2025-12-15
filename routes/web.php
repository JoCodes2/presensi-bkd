<?php

use App\Http\Controllers\CMS\JabatanController;
use App\Http\Controllers\CMS\JamController;
use App\Http\Controllers\CMS\LokasiKantorController;
use App\Http\Controllers\CMS\NotifikasiController;
use App\Http\Controllers\CMS\PegawaiController;
use App\Http\Controllers\CMS\PresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/jam', function () {
    return view('Admin.jam');
});

Route::get('/jabatan', function () {
    return view('Admin.jabatan');
});

Route::get('/kantor', function () {
    return view('Admin.lokasi');
});


// route pegawai
Route::get('/pegawai', function () {
    return view('pages.pegawai');
});
Route::get('/notif', function () {
    return view('pages.notif');
});
Route::get('/presensi', function () {
    return view('pages.presensi');
});

/** route api */
Route::prefix('presensi')->group(function () {

    // lokasi kantor
    Route::prefix('kantor')->controller(LokasiKantorController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
    // jabatan
    Route::prefix('jabatan')->controller(JabatanController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
    // pegawai
    Route::prefix('pegawai')->controller(PegawaiController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::post('/aktivasi/{id}', 'handleAccountStatus');
        Route::delete('/delete/{id}', 'deleteData');
    });

    Route::prefix('jam')->controller(JamController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });

    // presensi
    Route::prefix('bkd')->controller(PresensiController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/in', 'presensiIn');
        Route::post('/out', 'presensiOut');
    });

    // presensi
    Route::prefix('notifikasi')->controller(NotifikasiController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/mark-all-read', 'markAllAsRead');
    });
});
