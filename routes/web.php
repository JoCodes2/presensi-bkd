<?php

use App\Http\Controllers\CMS\JabatanController;
use App\Http\Controllers\CMS\LokasiKantorController;
use App\Http\Controllers\CMS\PegawaiController;
use App\Http\Controllers\CMS\PresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('Admin.pengguna');
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
        Route::post('/aktivasi/{id}', 'activateAccount');
        Route::delete('/delete/{id}', 'deleteData');
    });
    // presensi
    Route::prefix('bkd')->controller(PresensiController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/in', 'presensiIn');
        Route::post('/out', 'presensiOut');
    });

    // Route::get('/auth/verify-email/{token}', [AuthController::class, 'verifyEmail']);
});
