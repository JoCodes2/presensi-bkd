<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CMS\JabatanController;
use App\Http\Controllers\CMS\JamController;
use App\Http\Controllers\CMS\LokasiKantorController;
use App\Http\Controllers\CMS\NotifikasiController;
use App\Http\Controllers\CMS\PegawaiController;
use App\Http\Controllers\CMS\PresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::post('auth/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return view('Auth.auth');
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('Auth.register');
})->middleware('guest');
// pegawai
Route::prefix('presensi/pegawai')->controller(PegawaiController::class)->group(function () {
    Route::get('/', 'getAllData');
    Route::post('/create', 'createData');
    Route::get('/get/{id}', 'getDataById');
    Route::post('/update/{id}', 'updateData');
    Route::post('/aktivasi/{id}', 'handleAccountStatus');
    Route::delete('/delete/{id}', 'deleteData');
});

Route::middleware(['auth', 'web'])->group(function () {

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware(['role:admin']);

    Route::get('/jam', function () {
        return view('Admin.jam');
    })->middleware(['role:admin']);

    Route::get('/jabatan', function () {
        return view('Admin.jabatan');
    })->middleware(['role:admin']);

    Route::get('/kantor', function () {
        return view('Admin.lokasi');
    })->middleware(['role:admin']);

    Route::get('/', function () {
        return view('Ui.absensi');
    })->middleware(['role:pegawai']);

    Route::get('/profil-ui', function () {
        return view('Ui.profil-ui');
    })->middleware(['role:pegawai']);

    Route::get('/notifikasi-ui', function () {
        return view('Ui.notifikasi-ui');
    })->middleware(['role:pegawai']);

    // route pegawai
    Route::get('/pegawai', function () {
        return view('pages.pegawai');
    })->middleware(['role:admin']);
    Route::get('/notif', function () {
        return view('pages.notif');
    })->middleware(['role:admin']);
    Route::get('/presensi', function () {
        return view('pages.presensi');
    })->middleware(['role:admin']);

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
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

});
