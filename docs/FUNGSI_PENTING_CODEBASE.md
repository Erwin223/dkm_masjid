# Fungsi Penting di Codebase

Dokumen ini merangkum fungsi-fungsi yang paling penting di codebase `dkm_masjid`, terutama fungsi yang mengendalikan autentikasi, otorisasi, dashboard admin, pengelolaan admin, dan profil pengguna.

Tujuan dokumen ini:
- membantu developer baru memahami titik masuk utama aplikasi
- mempermudah debugging saat ada bug di login, OTP, dashboard, atau admin
- menjadi referensi cepat sebelum mengubah logic penting

## Gambaran Singkat

Area fungsi yang paling penting saat ini:
- autentikasi admin dengan password + OTP login
- reset password admin via OTP email
- proteksi route admin
- agregasi data dashboard admin
- manajemen akun admin
- update profil dan password akun login

## 1. Autentikasi Login Admin

### File
- [app/Http/Controllers/Auth/AuthenticatedSessionController.php](../app/Http/Controllers/Auth/AuthenticatedSessionController.php)
- [app/Http/Requests/Auth/LoginRequest.php](../app/Http/Requests/Auth/LoginRequest.php)
- [app/Models/Admin.php](../app/Models/Admin.php)
- [routes/auth.php](../routes/auth.php)

### Fungsi penting

#### `AuthenticatedSessionController::create()`
- Menampilkan halaman login admin.
- Dipanggil oleh route `GET /login`.

#### `AuthenticatedSessionController::store(LoginRequest $request)`
- Menangani tahap pertama login.
- Flow:
  1. validasi email dan password lewat `LoginRequest`
  2. cek apakah admin wajib OTP login
  3. jika tidak wajib OTP, login langsung diselesaikan
  4. jika wajib OTP, sistem membuat challenge OTP dan mengirim email
- Dipanggil oleh route `POST /login`.

#### `AuthenticatedSessionController::showLoginOtpForm(Request $request)`
- Menampilkan form OTP login.
- Hanya bisa diakses jika session challenge login masih ada.
- Dipanggil oleh route `GET /login/verify-otp`.

#### `AuthenticatedSessionController::verifyLoginOtp(Request $request)`
- Memverifikasi OTP login admin.
- Mengecek:
  - OTP harus 6 digit
  - session challenge masih ada
  - OTP belum kedaluwarsa
  - percobaan belum melewati batas
  - OTP cocok dengan hash di session
- Jika lolos, login diselesaikan lewat `completeLogin()`.
- Dipanggil oleh route `POST /login/verify-otp`.

#### `AuthenticatedSessionController::resendLoginOtp(Request $request)`
- Mengirim ulang OTP login jika cooldown sudah habis.
- Dipanggil oleh route `POST /login/resend-otp`.

#### `AuthenticatedSessionController::destroy(Request $request)`
- Logout user aktif.
- Menghapus challenge OTP sementara jika masih ada.
- Meng-invalidate session dan regenerate CSRF token.
- Dipanggil oleh route `POST /logout`.

#### `AuthenticatedSessionController::completeLogin(Request $request, Admin $admin)`
- Menyelesaikan login setelah semua syarat lolos.
- Pekerjaan utama:
  - memanggil `Auth::login($admin)`
  - regenerate session
  - mencatat waktu dan IP login
  - menulis log login sukses
  - redirect ke dashboard admin

#### `AuthenticatedSessionController::issueLoginOtp(Request $request, Admin $admin)`
- Membuat OTP login 6 digit.
- Mengirim OTP ke email admin.
- Menyimpan data challenge ke session:
  - `login_otp_admin_id`
  - `login_otp_hash`
  - `login_otp_expires_at`
  - `login_otp_last_sent_at`
  - `login_otp_attempts`

#### `AuthenticatedSessionController::clearPendingLoginChallenge(Request $request)`
- Membersihkan semua state OTP login dari session.
- Dipakai saat login berhasil, logout, challenge expired, atau gagal total.

### Validasi dan Rate Limit Login

#### `LoginRequest::rules()`
- Mendefinisikan validasi input login:
  - `email` wajib format email
  - `password` wajib string

#### `LoginRequest::authenticate()`
- Mengecek kredensial admin tanpa langsung membuat session login final.
- Tugas utamanya:
  - menjalankan rate limit check
  - memastikan email dan password valid
  - menolak akun yang sedang locked
  - membersihkan counter rate limit jika lolos
- Mengembalikan model `Admin` yang valid.

#### `LoginRequest::ensureIsNotRateLimited()`
- Menahan brute force login.
- Menggunakan dua level pembatasan:
  - key `email + IP`
  - key `IP global`

#### `LoginRequest::throttleKey()`
- Key throttle berbasis email dan IP.

#### `LoginRequest::ipThrottleKey()`
- Key throttle berbasis IP saja.

#### `LoginRequest::hitRateLimiters()`
- Menambah hit counter saat login gagal.

#### `LoginRequest::clearRateLimiters()`
- Membersihkan counter saat login valid.

### Helper pada Model Admin

#### `Admin::isLocked()`
- Mengecek apakah akun admin sedang dikunci sampai waktu tertentu.

#### `Admin::recordLogin(string $ip)`
- Menyimpan metadata login sukses:
  - `last_login_at`
  - `last_login_ip`
  - reset `failed_login_attempts`

#### `Admin::requiresTwoFactorAuth()`
- Menentukan apakah OTP login wajib aktif.
- Saat ini nilainya mengikuti `config('auth.require_admin_otp')`.

## 2. Reset Password Admin via OTP

### File
- [app/Http/Controllers/Auth/OtpPasswordController.php](../app/Http/Controllers/Auth/OtpPasswordController.php)
- [app/Mail/SendOtpMail.php](../app/Mail/SendOtpMail.php)

### Fungsi penting

#### `OtpPasswordController::showEmailForm()`
- Menampilkan form input email untuk reset password.

#### `OtpPasswordController::sendOtp(Request $request)`
- Memulai flow reset password.
- Validasi email lalu memanggil `issueOtp()`.
- Menyimpan email ke session `reset_email`.
- Selalu memakai pesan generik agar tidak membocorkan apakah email terdaftar.

#### `OtpPasswordController::showVerifyForm()`
- Menampilkan form OTP reset password.
- Menghitung dua nilai UI:
  - `cooldownRemaining`
  - `lockRemainingSeconds`

#### `OtpPasswordController::verifyOtp(Request $request)`
- Memverifikasi OTP reset password.
- Cek utama:
  - email reset masih ada di session
  - OTP record ada
  - akun admin terkait ada
  - OTP belum expired
  - akun OTP tidak sedang locked
  - OTP cocok
- Jika sukses, session `otp_verified` diset `true`.

#### `OtpPasswordController::resendOtp(Request $request)`
- Mengirim ulang OTP reset password jika cooldown memungkinkan.

#### `OtpPasswordController::showResetForm()`
- Menampilkan form password baru.
- Hanya boleh jika `reset_email` dan `otp_verified` ada di session.

#### `OtpPasswordController::resetPassword(Request $request)`
- Menyimpan password baru admin.
- Password di-hash lalu disimpan ke database.
- Record OTP dan session reset dibersihkan setelah sukses.

#### `OtpPasswordController::issueOtp(string $email, bool $sendMail)`
- Membuat OTP reset password.
- Menyimpan OTP dalam bentuk hash ke tabel `password_reset_otps`.
- Mengatur cooldown, attempt counter, dan lock status.

## 3. Update Password Saat User Sudah Login

### File
- [app/Http/Controllers/Auth/PasswordController.php](../app/Http/Controllers/Auth/PasswordController.php)

### Fungsi penting

#### `PasswordController::update(Request $request)`
- Mengubah password user yang sedang login.
- Validasi:
  - `current_password` wajib benar
  - password baru wajib konfirmasi
- Menyimpan password baru dalam bentuk hash.

## 4. Proteksi Route Admin

### File
- [app/Http/Middleware/AdminOnly.php](../app/Http/Middleware/AdminOnly.php)
- [routes/web.php](../routes/web.php)

### Fungsi penting

#### `AdminOnly::handle(Request $request, Closure $next)`
- Memastikan user login benar-benar admin.
- Jika tidak ada user atau `is_admin` false, request dihentikan dengan `403`.

### Middleware pada route admin

Semua route panel admin berada di grup:
- `auth`
- `admin`
- `nocache`

Artinya:
- user harus login
- user harus admin
- browser tidak dianjurkan cache halaman sensitif admin

## 5. Dashboard Admin

### File
- [app/Http/Controllers/Admin/DashboardController.php](../app/Http/Controllers/Admin/DashboardController.php)

### Fungsi utama

#### `DashboardController::index()`
- Pusat agregasi data dashboard admin.
- Mengambil data dari beberapa domain:
  - kas masuk dan kas keluar
  - anggaran kegiatan
  - jadwal kegiatan
  - pengurus dan imam
  - donasi masuk dan keluar
  - zakat masuk dan distribusi
  - donatur
  - berita dan galeri
- Menghasilkan ringkasan yang dipakai widget dan tabel dashboard.

### Fungsi helper dashboard

#### `sumDonasiMasuk($items)`
- Menjumlahkan total donasi masuk.

#### `sumDonasiKeluar($items)`
- Menjumlahkan total donasi keluar.

#### `sumPenerimaanZakat($items)`
- Menjumlahkan total zakat masuk.
- Mendukung dua mode data: uang dan barang.

#### `sumDistribusiZakat($items)`
- Menjumlahkan total distribusi zakat.

#### `summarizeDonasiMasuk($items)`
- Membuat ringkasan donasi masuk:
  - total uang
  - jumlah transaksi uang
  - jumlah transaksi barang
  - preview label barang
  - jumlah kategori donasi unik

#### `summarizeDonasiKeluar($items)`
- Membuat ringkasan donasi keluar berdasarkan uang, barang, dan tujuan.

#### `summarizePenerimaanZakat($items)`
- Membuat ringkasan penerimaan zakat:
  - total uang
  - jumlah transaksi uang
  - jumlah barang
  - preview label barang
  - total jiwa/tanggungan
  - jumlah zakat fitrah uang

#### `summarizeDistribusiZakat($items)`
- Membuat ringkasan distribusi zakat berdasarkan jenis dan mode distribusi.

#### `previewLabels($labels)`
- Merangkum maksimal dua label item barang agar widget dashboard tetap ringkas.

## 6. Manajemen Admin

### File
- [app/Http/Controllers/Admin/AdminController.php](../app/Http/Controllers/Admin/AdminController.php)

### Fungsi penting

#### `AdminController::index()`
- Menampilkan daftar semua admin.

#### `AdminController::create()`
- Menampilkan form tambah admin.

#### `AdminController::store(Request $request)`
- Membuat admin baru.
- Validasi:
  - nama wajib
  - email unik
  - password mengikuti rule password Laravel

#### `AdminController::edit($id)`
- Menampilkan form edit admin tertentu.

#### `AdminController::update(Request $request, $id)`
- Mengubah data admin.
- Jika admin mengubah akunnya sendiri, wajib mengisi `current_password`.
- Bisa update nama, email, dan password baru jika diisi.

#### `AdminController::destroy($id)`
- Menghapus admin.
- Melarang admin menghapus akunnya sendiri.

## 7. Profil User Login

### File
- [app/Http/Controllers/ProfileController.php](../app/Http/Controllers/ProfileController.php)

### Fungsi penting

#### `ProfileController::edit(Request $request)`
- Menampilkan halaman profile user yang sedang login.

#### `ProfileController::update(ProfileUpdateRequest $request)`
- Mengubah nama dan email profile user.
- Jika email berubah, `email_verified_at` direset ke `null`.

#### `ProfileController::destroy(Request $request)`
- Menghapus akun user yang sedang login.
- Meminta password saat ini.
- Logout lalu menghapus akun.

## 8. Rate Limiter Global yang Penting

### File
- [app/Providers/AppServiceProvider.php](../app/Providers/AppServiceProvider.php)

### Fungsi di `boot()`

#### `RateLimiter::for('otp-email', ...)`
- Membatasi permintaan OTP reset password berdasarkan IP + email.

#### `RateLimiter::for('otp-verify', ...)`
- Membatasi percobaan verifikasi OTP reset password.

#### `RateLimiter::for('otp-resend', ...)`
- Membatasi kirim ulang OTP reset password.

#### `RateLimiter::for('login-otp-verify', ...)`
- Membatasi percobaan verifikasi OTP login.

#### `RateLimiter::for('login-otp-resend', ...)`
- Membatasi kirim ulang OTP login.

## 9. Route Penting untuk Flow Utama

### Route Auth
- `GET /login` -> tampilkan form login
- `POST /login` -> validasi kredensial dan kirim OTP login
- `GET /login/verify-otp` -> tampilkan form OTP login
- `POST /login/verify-otp` -> verifikasi OTP login
- `POST /login/resend-otp` -> kirim ulang OTP login
- `GET /forgot-password` -> form reset password
- `POST /forgot-password` -> kirim OTP reset
- `GET /verify-otp` -> form OTP reset password
- `POST /verify-otp` -> verifikasi OTP reset password
- `GET /reset-password` -> form password baru
- `POST /reset-password` -> simpan password baru
- `PUT /password` -> update password saat user sudah login
- `POST /logout` -> logout

### Route Admin utama
- `GET /admin/dashboard` -> dashboard agregasi utama
- `GET /admin/admins` -> daftar admin
- `POST /admin/admins` -> tambah admin
- `PUT /admin/admins/{id}` -> update admin
- `DELETE /admin/admins/{id}` -> hapus admin

## 10. Catatan Perubahan Saat Debugging

Sebelum mengubah fungsi-fungsi di atas, perhatikan:
- flow login sekarang 2 tahap, jadi bug login tidak selalu ada di password; bisa juga di session OTP atau mail
- reset password memakai tabel `password_reset_otps`, bukan token reset Laravel bawaan
- model `Admin` memakai tabel `users` tetapi diberi global scope `is_admin = true`
- dashboard admin melakukan banyak query lintas domain, jadi perubahan model bisa berdampak ke halaman dashboard

## 11. Saran Pemakaian Dokumen

Gunakan dokumen ini saat:
- onboarding developer baru
- audit keamanan auth
- perubahan flow login atau OTP
- debugging dashboard
- refactor controller admin
