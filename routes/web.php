<?php

use App\Http\Controllers\CMS\LokasiKantorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
});
