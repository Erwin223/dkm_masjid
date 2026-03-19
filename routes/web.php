<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController as AdminKegiatanController;
use App\Http\Controllers\Admin\KasMasukController;
use App\Http\Controllers\Admin\KasKeluarController;
use App\Http\Controllers\Admin\PengurusController;
use App\Http\Controllers\Admin\PenggunaController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);
//Route::get('/kegiatan', [KegiatanController::class, 'index']);

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','nocache'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Kas Masuk
    Route::get('/kas-masuk/create',        [KasMasukController::class, 'create'])->name('kas.masuk.create');
    Route::post('/kas-masuk/store',        [KasMasukController::class, 'store'])->name('kas.masuk.store');
    Route::get('/kas-masuk/edit/{id}',     [KasMasukController::class, 'edit'])->name('kas.masuk.edit');
    Route::put('/kas-masuk/update/{id}',   [KasMasukController::class, 'update'])->name('kas.masuk.update');
    Route::delete('/kas-masuk/{id}',       [KasMasukController::class, 'delete'])->name('kas.masuk.delete');

    // Kas Keluar
    Route::get('/kas-keluar/create',       [KasKeluarController::class, 'create'])->name('kas.keluar.create');
    Route::post('/kas-keluar/store',       [KasKeluarController::class, 'store'])->name('kas.keluar.store');
    Route::get('/kas-keluar/edit/{id}',    [KasKeluarController::class, 'edit'])->name('kas.keluar.edit');
    Route::put('/kas-keluar/update/{id}',  [KasKeluarController::class, 'update'])->name('kas.keluar.update');
    Route::delete('/kas-keluar/delete/{id}', [KasKeluarController::class, 'destroy'])->name('kas.keluar.delete');

    // Pengurus
    Route::get('/pengurus',                [PengurusController::class, 'index'])->name('pengurus.index');
    Route::get('/pengurus/create',         [PengurusController::class, 'create'])->name('pengurus.create');
    Route::post('/pengurus/store',         [PengurusController::class, 'store'])->name('pengurus.store');
    Route::get('/pengurus/edit/{id}',      [PengurusController::class, 'edit'])->name('pengurus.edit');
    Route::put('/pengurus/update/{id}',    [PengurusController::class, 'update'])->name('pengurus.update');
    Route::delete('/pengurus/delete/{id}', [PengurusController::class, 'destroy'])->name('pengurus.delete');

    // ===== KEGIATAN (pakai AdminKegiatanController) =====

    // Jadwal Kegiatan
    Route::get('/kegiatan/jadwal',              [AdminKegiatanController::class, 'jadwal'])->name('kegiatan.jadwal');
    Route::get('/kegiatan/jadwal/create',       [AdminKegiatanController::class, 'jadwalCreate'])->name('kegiatan.jadwal.create');
    Route::post('/kegiatan/jadwal',             [AdminKegiatanController::class, 'jadwalStore'])->name('kegiatan.jadwal.store');
    Route::get('/kegiatan/jadwal/{id}/edit',    [AdminKegiatanController::class, 'jadwalEdit'])->name('kegiatan.jadwal.edit');
    Route::put('/kegiatan/jadwal/{id}',         [AdminKegiatanController::class, 'jadwalUpdate'])->name('kegiatan.jadwal.update');
    Route::delete('/kegiatan/jadwal/{id}',      [AdminKegiatanController::class, 'jadwalDelete'])->name('kegiatan.jadwal.delete');

    // Jadwal Imam
  Route::get('/kegiatan/imam',                [AdminKegiatanController::class, 'imam'])->name('kegiatan.imam');
Route::get('/kegiatan/imam/create',         [AdminKegiatanController::class, 'imamCreate'])->name('kegiatan.imam.create');
Route::post('/kegiatan/imam',               [AdminKegiatanController::class, 'imamStore'])->name('kegiatan.imam.store');
Route::get('/kegiatan/imam/{id}/edit',      [AdminKegiatanController::class, 'imamEdit'])->name('kegiatan.imam.edit');
Route::put('/kegiatan/imam/{id}',           [AdminKegiatanController::class, 'imamUpdate'])->name('kegiatan.imam.update');
Route::delete('/kegiatan/imam/{id}',        [AdminKegiatanController::class, 'imamDelete'])->name('kegiatan.imam.delete');

// Data Imam
Route::get('/kegiatan/imam/data',           [AdminKegiatanController::class, 'imamData'])->name('imam.data');
Route::get('/kegiatan/imam/data/create',    [AdminKegiatanController::class, 'imamDataCreate'])->name('imam.data.create');
Route::post('/kegiatan/imam/data',          [AdminKegiatanController::class, 'imamDataStore'])->name('imam.data.store');
Route::get('/kegiatan/imam/data/{id}/edit', [AdminKegiatanController::class, 'imamDataEdit'])->name('imam.data.edit');
Route::put('/kegiatan/imam/data/{id}',      [AdminKegiatanController::class, 'imamDataUpdate'])->name('imam.data.update');
Route::delete('/kegiatan/imam/data/{id}',   [AdminKegiatanController::class, 'imamDataDelete'])->name('imam.data.delete');
    // Jadwal Sholat
    Route::get('/kegiatan/sholat',              [AdminKegiatanController::class, 'sholat'])->name('kegiatan.sholat');

});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
