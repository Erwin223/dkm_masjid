# Dokumentasi Struktur Sistem - DKM Masjid

## 1. Ringkasan Umum

Aplikasi ini adalah monolit Laravel yang dibangun dengan pola MVC. Semua fungsi utama dijalankan dari satu aplikasi dengan panel admin sebagai pusat operasional.

Platform inti:
- Framework: Laravel
- View: Blade
- Bahasa: PHP
- Frontend assets: Tailwind / CSS / JavaScript
- Database: diatur dengan Laravel migrations

## 2. Struktur Folder Utama

Root project:
- `artisan` : helper CLI Laravel
- `app/` : logika aplikasi utama
- `bootstrap/` : bootstraping framework dan autoload
- `config/` : konfigurasi aplikasi
- `database/` : migration, seeders, factory
- `public/` : entry point aplikasi dan asset publik
- `resources/` : view Blade, CSS, JS, file frontend
- `routes/` : route definition
- `storage/` : cache, logs, generated files
- `tests/` : test suite
- `vendor/` : dependensi composer
- `docs/` : dokumentasi sistem dan referensi

## 3. Core Laravel Struktur Aplikasi

### 3.1 `app/`

- `app/Http/Controllers/` : controller yang memproses request
  - `Admin/` : controller admin untuk setiap modul
  - `HomeController.php`, `ProfileController.php`
- `app/Http/Middleware/` : middleware seperti `auth`, `admin`, `nocache`
- `app/Models/` : Eloquent model domain bisnis
- `app/Providers/` : service provider aplikasi
- `app/Mail/` : email mailables
- `app/View/Components/` : komponen Blade khusus jika ada

### 3.2 `resources/`

- `resources/views/admin/` : tampilan panel admin per modul
- `resources/views/frontend/` : tampilan publik / website
- `resources/css/`, `resources/js/` : asset frontend lokal

### 3.3 `routes/`

- `routes/web.php` : semua routing web utama
- `routes/auth.php` : routing autentikasi default Laravel
- `routes/console.php` : routing perintah Artisan custom

### 3.4 `database/`

- `database/migrations/` : schema database
- `database/seeders/` : data awal jika ada
- `database/factories/` : factory model untuk testing

## 4. Alur Sistem / Lapisan

1. Request masuk via `routes/web.php`
2. Middleware `auth`, `admin`, `nocache` memfilter akses
3. Request diarahkan ke Controller
4. Controller mengakses Model Eloquent
5. Model melakukan query ke database dan menyimpan hasil
6. Controller mengembalikan response ke Blade view
7. View dirender sebagai HTML ke pengguna

## 5. Modul Utama dan Domain Bisnis

### 5.1 Keuangan

- Controller:
  - `app/Http/Controllers/Admin/KasMasukController.php`
  - `app/Http/Controllers/Admin/KasKeluarController.php`
- Views:
  - `resources/views/admin/kas_masuk/`
  - `resources/views/admin/kas_keluar/`
- Model:
  - `app/Models/KasMasuk.php`
  - `app/Models/KasKeluar.php`

### 5.2 Donasi

- Controller:
  - `app/Http/Controllers/Admin/DonasiController.php`
  - `app/Http/Controllers/Admin/DonaturController.php`
- Views:
  - `resources/views/admin/donasi/`
  - `resources/views/admin/donatur/`
- Model:
  - `app/Models/DonasiMasuk.php`
  - `app/Models/DonasiKeluar.php`
  - `app/Models/Donatur.php`

### 5.3 Zakat

- Controller:
  - `app/Http/Controllers/Admin/ZakatController.php`
- Views:
  - `resources/views/admin/zakat/`
- Model:
  - `app/Models/Muzakki.php`
  - `app/Models/PenerimaanZakat.php`
  - `app/Models/Mustahik.php`
  - `app/Models/DistribusiZakat.php`

### 5.4 Operasional / Kegiatan

- Controller:
  - `app/Http/Controllers/Admin/KegiatanController.php`
- Views:
  - `resources/views/admin/kegiatan/`
- Model:
  - `app/Models/JadwalKegiatan.php`
  - `app/Models/DataImam.php`
  - `app/Models/JadwalImam.php`

### 5.5 Konten Website / Profil

- Controller:
  - `app/Http/Controllers/Admin/ProfilMasjidController.php`
  - `app/Http/Controllers/Admin/BeritaController.php`
  - `app/Http/Controllers/Admin/GaleriController.php`
- Views:
  - `resources/views/admin/profil_masjid/`
  - `resources/views/admin/berita/`
  - `resources/views/admin/galeri/`
- Model:
  - `app/Models/ProfilMasjid.php`
  - `app/Models/Berita.php`
  - `app/Models/Galeri.php`

### 5.6 Pengguna dan Admin

- Controller:
  - `app/Http/Controllers/Admin/AdminUserController.php`
  - `app/Http/Controllers/Admin/PengurusController.php`
- Views:
  - `resources/views/admin/users/`
  - `resources/views/admin/pengurus/`
- Model:
  - `app/Models/User.php`
  - `app/Models/Pengurus.php`

## 6. Middleware Penting

- `auth` : memastikan user login
- `admin` : memastikan user admin
- `nocache` : mencegah caching halaman admin

## 7. Rute Utama

### Frontend
- `/` → `HomeController@index`

### Admin (`/admin` prefix)
- `/admin/dashboard`
- `/admin/statistik`
- `/admin/laporan`
- `/admin/kas-masuk`, `/admin/kas-keluar`
- `/admin/donasi/masuk`, `/admin/donasi/keluar`
- `/admin/donatur`
- `/admin/zakat/muzakki`, `/admin/zakat/penerimaan`, `/admin/zakat/mustahik`, `/admin/zakat/distribusi`
- `/admin/kegiatan/jadwal`, `/admin/kegiatan/imam`, `/admin/kegiatan/sholat`
- `/admin/profil-masjid`
- `/admin/berita`
- `/admin/galeri`
- `/admin/users`

### Profile
- `/profile` → edit data user

## 8. Referensi Dokumentasi Lanjutan

- `docs/arsitektur-sistem.md` : dokumentasi arsitektur sistem yang sudah ada
- `docs/QUICK_REFERENCE.md` : ringkasan arsitektur dan workflow
- `docs/SYSTEM_ARCHITECTURE_COMPLETE.md` : dokumentasi arsitektur lengkap

## 9. Catatan Tambahan

Pada codebase ini, semua modul bisnis terintegrasi ke dalam satu monolit Laravel. Folder `app/Models` menyimpan domain data utama, sedangkan `resources/views/admin` menyimpan semua halaman admin. Semua route admin dilindungi oleh middleware dan dikelola di `routes/web.php`.
