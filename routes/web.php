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
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\ZakatController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ProfilMasjidController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;

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

Route::middleware(['auth','admin','nocache'])->prefix('admin')->group(function () {

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

// KAS MASUK
Route::get('/kas-masuk',              [KasMasukController::class, 'index'])->name('kas.masuk.index');
Route::get('/kas-masuk/create',       [KasMasukController::class, 'create'])->name('kas.masuk.create');
Route::post('/kas-masuk/store',       [KasMasukController::class, 'store'])->name('kas.masuk.store');
Route::get('/kas-masuk/edit/{id}',    [KasMasukController::class, 'edit'])->name('kas.masuk.edit');
Route::put('/kas-masuk/update/{id}',  [KasMasukController::class, 'update'])->name('kas.masuk.update');
Route::delete('/kas-masuk/{id}',      [KasMasukController::class, 'delete'])->name('kas.masuk.delete');

// KAS KELUAR
Route::get('/kas-keluar',             [KasKeluarController::class, 'index'])->name('kas.keluar.index');
Route::get('/kas-keluar/create',      [KasKeluarController::class, 'create'])->name('kas.keluar.create');
Route::post('/kas-keluar/store',      [KasKeluarController::class, 'store'])->name('kas.keluar.store');
Route::get('/kas-keluar/edit/{id}',   [KasKeluarController::class, 'edit'])->name('kas.keluar.edit');
Route::put('/kas-keluar/update/{id}', [KasKeluarController::class, 'update'])->name('kas.keluar.update');
Route::delete('/kas-keluar/delete/{id}', [KasKeluarController::class, 'destroy'])->name('kas.keluar.delete');

// Pengurus
Route::get('/pengurus',                [PengurusController::class, 'index'])->name('pengurus.index');
Route::get('/pengurus/create',         [PengurusController::class, 'create'])->name('pengurus.create');
Route::post('/pengurus/store',         [PengurusController::class, 'store'])->name('pengurus.store');
Route::get('/pengurus/edit/{id}',      [PengurusController::class, 'edit'])->name('pengurus.edit');
Route::put('/pengurus/update/{id}',    [PengurusController::class, 'update'])->name('pengurus.update');
Route::delete('/pengurus/delete/{id}', [PengurusController::class, 'destroy'])->name('pengurus.delete');


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

// DONASI MASUK
Route::get('/donasi/masuk',              [DonasiController::class, 'masuk'])->name('donasi.masuk');
Route::get('/donasi/masuk/create',       [DonasiController::class, 'masukCreate'])->name('donasi.masuk.create');
Route::post('/donasi/masuk',             [DonasiController::class, 'masukStore'])->name('donasi.masuk.store');
Route::get('/donasi/masuk/{id}/edit',    [DonasiController::class, 'masukEdit'])->name('donasi.masuk.edit');
Route::put('/donasi/masuk/{id}',         [DonasiController::class, 'masukUpdate'])->name('donasi.masuk.update');
Route::delete('/donasi/masuk/{id}',      [DonasiController::class, 'masukDelete'])->name('donasi.masuk.delete');

// DONASI KELUAR
Route::get('/donasi/keluar',             [DonasiController::class, 'keluar'])->name('donasi.keluar');
Route::get('/donasi/keluar/create',      [DonasiController::class, 'keluarCreate'])->name('donasi.keluar.create');
Route::post('/donasi/keluar',            [DonasiController::class, 'keluarStore'])->name('donasi.keluar.store');
Route::get('/donasi/keluar/{id}/edit',   [DonasiController::class, 'keluarEdit'])->name('donasi.keluar.edit');
Route::put('/donasi/keluar/{id}',        [DonasiController::class, 'keluarUpdate'])->name('donasi.keluar.update');
Route::delete('/donasi/keluar/{id}',     [DonasiController::class, 'keluarDelete'])->name('donasi.keluar.delete');

//DONATUR
Route::get('/donatur',              [DonaturController::class, 'index'])->name('donatur.index');
Route::get('/donatur/create',       [DonaturController::class, 'create'])->name('donatur.create');
Route::post('/donatur',             [DonaturController::class, 'store'])->name('donatur.store');
Route::get('/donatur/{id}/edit',    [DonaturController::class, 'edit'])->name('donatur.edit');
Route::put('/donatur/{id}',         [DonaturController::class, 'update'])->name('donatur.update');
Route::delete('/donatur/{id}',      [DonaturController::class, 'delete'])->name('donatur.delete');
Route::get('/donatur/list',         [DonaturController::class, 'list'])->name('donatur.list');

// ZAKAT
Route::get('/zakat/muzakki',                [ZakatController::class, 'muzakki'])->name('zakat.muzakki.index');
Route::get('/zakat/muzakki/create',         [ZakatController::class, 'muzakkiCreate'])->name('zakat.muzakki.create');
Route::post('/zakat/muzakki',               [ZakatController::class, 'muzakkiStore'])->name('zakat.muzakki.store');
Route::get('/zakat/muzakki/{id}/edit',      [ZakatController::class, 'muzakkiEdit'])->name('zakat.muzakki.edit');
Route::put('/zakat/muzakki/{id}',           [ZakatController::class, 'muzakkiUpdate'])->name('zakat.muzakki.update');
Route::delete('/zakat/muzakki/{id}',        [ZakatController::class, 'muzakkiDelete'])->name('zakat.muzakki.delete');

Route::get('/zakat/penerimaan',             [ZakatController::class, 'penerimaan'])->name('zakat.penerimaan.index');
Route::get('/zakat/penerimaan/create',      [ZakatController::class, 'penerimaanCreate'])->name('zakat.penerimaan.create');
Route::post('/zakat/penerimaan',            [ZakatController::class, 'penerimaanStore'])->name('zakat.penerimaan.store');
Route::get('/zakat/penerimaan/{id}/edit',   [ZakatController::class, 'penerimaanEdit'])->name('zakat.penerimaan.edit');
Route::put('/zakat/penerimaan/{id}',        [ZakatController::class, 'penerimaanUpdate'])->name('zakat.penerimaan.update');
Route::delete('/zakat/penerimaan/{id}',     [ZakatController::class, 'penerimaanDelete'])->name('zakat.penerimaan.delete');

Route::get('/zakat/mustahik',               [ZakatController::class, 'mustahik'])->name('zakat.mustahik.index');
Route::get('/zakat/mustahik/create',        [ZakatController::class, 'mustahikCreate'])->name('zakat.mustahik.create');
Route::post('/zakat/mustahik',              [ZakatController::class, 'mustahikStore'])->name('zakat.mustahik.store');
Route::get('/zakat/mustahik/{id}/edit',     [ZakatController::class, 'mustahikEdit'])->name('zakat.mustahik.edit');
Route::put('/zakat/mustahik/{id}',          [ZakatController::class, 'mustahikUpdate'])->name('zakat.mustahik.update');
Route::delete('/zakat/mustahik/{id}',       [ZakatController::class, 'mustahikDelete'])->name('zakat.mustahik.delete');

Route::get('/zakat/distribusi',             [ZakatController::class, 'distribusi'])->name('zakat.distribusi.index');
Route::get('/zakat/distribusi/create',      [ZakatController::class, 'distribusiCreate'])->name('zakat.distribusi.create');
Route::post('/zakat/distribusi',            [ZakatController::class, 'distribusiStore'])->name('zakat.distribusi.store');
Route::get('/zakat/distribusi/{id}/edit',   [ZakatController::class, 'distribusiEdit'])->name('zakat.distribusi.edit');
Route::put('/zakat/distribusi/{id}',        [ZakatController::class, 'distribusiUpdate'])->name('zakat.distribusi.update');
Route::delete('/zakat/distribusi/{id}',     [ZakatController::class, 'distribusiDelete'])->name('zakat.distribusi.delete');

// MANAJEMEN ADMIN (USERS)
Route::get('/users',                [AdminUserController::class, 'index'])->name('admin.users.index');
Route::get('/users/create',         [AdminUserController::class, 'create'])->name('admin.users.create');
Route::post('/users',               [AdminUserController::class, 'store'])->name('admin.users.store');
Route::get('/users/{id}/edit',      [AdminUserController::class, 'edit'])->name('admin.users.edit');
Route::put('/users/{id}',           [AdminUserController::class, 'update'])->name('admin.users.update');
Route::delete('/users/{id}',        [AdminUserController::class, 'destroy'])->name('admin.users.delete');

// KONTEN WEBSITE
Route::get('/profil-masjid',             [ProfilMasjidController::class, 'index'])->name('profil_masjid.index');
Route::get('/profil-masjid/create',      [ProfilMasjidController::class, 'create'])->name('profil_masjid.create');
Route::post('/profil-masjid/store',      [ProfilMasjidController::class, 'store'])->name('profil_masjid.store');
Route::get('/profil-masjid/edit/{id}',   [ProfilMasjidController::class, 'edit'])->name('profil_masjid.edit');
Route::put('/profil-masjid/update/{id}', [ProfilMasjidController::class, 'update'])->name('profil_masjid.update');

// Berita
Route::get('/berita',                [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/create',         [BeritaController::class, 'create'])->name('berita.create');
Route::post('/berita/store',         [BeritaController::class, 'store'])->name('berita.store');
Route::get('/berita/edit/{id}',      [BeritaController::class, 'edit'])->name('berita.edit');
Route::put('/berita/update/{id}',    [BeritaController::class, 'update'])->name('berita.update');
Route::delete('/berita/delete/{id}', [BeritaController::class, 'destroy'])->name('berita.delete');

// GALERI
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
Route::post('/galeri/store', [GaleriController::class, 'store'])->name('galeri.store');
Route::get('/galeri/edit/{id}', [GaleriController::class, 'edit'])->name('galeri.edit');
Route::put('/galeri/update/{id}', [GaleriController::class, 'update'])->name('galeri.update');
Route::delete('/galeri/delete/{id}', [GaleriController::class, 'delete'])->name('galeri.delete');

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
