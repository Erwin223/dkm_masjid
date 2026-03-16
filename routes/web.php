<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;


/*
|--------------------------------------------------------------------------
| FRONTEND (PUBLIC WEBSITE)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/kegiatan', [KegiatanController::class, 'index']);


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/kas/create', function () {
        return "Halaman tambah kas masuk";
    })->name('kas.create');

    Route::resource('/kegiatan', AdminKegiatanController::class);

});


/*
|--------------------------------------------------------------------------
| PROFILE (BREEZE DEFAULT)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth','nocache'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/kas/create', function () {
        return "Halaman tambah kas masuk";
    })->name('kas.create');

});


require __DIR__.'/auth.php';
