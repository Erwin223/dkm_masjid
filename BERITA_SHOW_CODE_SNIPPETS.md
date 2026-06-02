<!-- ============================================================
     IMPLEMENTASI HALAMAN BACA BERITA - CODE SNIPPETS
     Copy-paste langsung ke file yang sesuai
     ============================================================ -->

<!-- FILE: routes/web.php
     LOKASI: Tambahkan di bagian FRONTEND (setelah Route::get('/berita', ...))
     ============================================================ -->

```php
// Route untuk menampilkan detail berita
Route::get('/berita/{berita}', [HomeController::class, 'showBerita'])
    ->name('frontend.berita.show')
    ->whereNumber('berita');
```

---

<!-- FILE: app/Http/Controllers/HomeController.php
     LOKASI: Tambahkan method ini di dalam class HomeController
     ============================================================ -->

```php
/**
 * Tampilkan halaman detail berita
 *
 * @param \App\Models\Berita $berita
 * @return \Illuminate\View\View
 */
public function showBerita(Berita $berita)
{
    // Ambil 3 berita terbaru lainnya (exclude berita yang sedang dibaca)
    $berita_lain = Berita::query()
        ->where('id', '!=', $berita->id)
        ->latest('tanggal')
        ->latest('id')
        ->limit(3)
        ->get();

    // Return view dengan data
    return view('frontend.berita.show', [
        'berita' => $berita,
        'berita_lain' => $berita_lain,
    ]);
}
```

---

<!-- FILE: resources/views/frontend/berita.blade.php
     LOKASI: Update link "Baca Selengkapnya" (cari di dalam loop @foreach)
     SEBELUM:
     ============================================================ -->

```blade
<a href="{{ $url }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-900 px-5 py-3 text-sm md:text-base font-bold text-white transition hover:bg-emerald-800">
    Baca Selengkapnya
</a>
```

<!-- SESUDAH:
     ============================================================ -->

```blade
<a href="{{ route('frontend.berita.show', $item->id) }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-900 px-5 py-3 text-sm md:text-base font-bold text-white transition hover:bg-emerald-800">
    Baca Selengkapnya
</a>
```

---

<!-- OPTIONAL: File Model Berita (resources/views/frontend/berita.blade.php)
     Jika ingin menambahkan method di model Berita
     ============================================================ -->

```php
// app/Models/Berita.php - Optional helper methods

/**
 * Dapatkan URL detail berita
 */
public function getUrlAttribute()
{
    return route('frontend.berita.show', $this->id);
}

/**
 * Dapatkan deskripsi singkat
 */
public function getDescriptionAttribute()
{
    return \Illuminate\Support\Str::limit(
        strip_tags($this->sinopsis ?? $this->isi_berita),
        180
    );
}

/**
 * Format tanggal untuk frontend
 */
public function getFormattedDateAttribute()
{
    return $this->created_at->translatedFormat('d F Y');
}
```

---

<!-- TESTING CHECKLIST
     ============================================================ -->

✅ TESTING CHECKLIST:

1. Route Testing:
   - [ ] Buka http://localhost:8000/berita
   - [ ] Klik salah satu berita
   - [ ] URL berubah menjadi http://localhost:8000/berita/{id}
   
2. Content Testing:
   - [ ] Judul berita tampil dengan benar
   - [ ] Tanggal publikasi tampil dengan format "d M Y"
   - [ ] Nama penulis tampil (atau "Admin" jika kosong)
   - [ ] Gambar hero tampil dan responsif
   - [ ] Isi konten HTML terender dengan benar
   - [ ] Sinopsis tampil dalam quote box
   
3. Related Articles Testing:
   - [ ] 3 berita lain tampil di bawah
   - [ ] Berita yang sedang dibaca TIDAK ada di bagian related
   - [ ] Tombol "Baca Selengkapnya" berfungsi
   
4. Animation Testing:
   - [ ] Animasi AOS fade-up terlihat saat scroll
   - [ ] Delay animasi berjalan bertingkat
   - [ ] Hover effect pada related cards berfungsi
   
5. Responsiveness Testing:
   - [ ] Mobile (375px): Layout single column
   - [ ] Tablet (768px): Layout 2 column related
   - [ ] Desktop (1024px+): Layout 3 column related
   
6. Browser Compatibility:
   - [ ] Chrome/Edge
   - [ ] Firefox
   - [ ] Safari
   - [ ] Mobile browser (iOS/Android)

---

<!-- TROUBLESHOOTING
     ============================================================ -->

❌ TROUBLESHOOTING:

**Masalah: 404 Not Found saat akses /berita/{id}**
- Solusi 1: Pastikan route sudah ditambahkan di routes/web.php
- Solusi 2: Jalankan `php artisan route:clear`
- Solusi 3: Verifikasi ID berita valid di database

**Masalah: Method showBerita tidak ditemukan**
- Solusi: Pastikan method sudah ditambahkan di HomeController
- Cek: `php artisan make:controller HomeController` (jika belum ada)

**Masalah: Gambar tidak tampil**
- Solusi 1: Pastikan path gambar benar di database (tanpa "storage/")
- Solusi 2: Jalankan `php artisan storage:link` untuk symlink
- Solusi 3: Verifikasi file ada di `storage/app/public/`

**Masalah: AOS animasi tidak berjalan**
- Solusi 1: Pastikan AOS CDN loading: buka DevTools → Network
- Solusi 2: Scroll halaman untuk trigger animasi (AOS perlu scroll)
- Solusi 3: Cek browser console untuk error

**Masalah: Styling tidak sesuai**
- Solusi: Pastikan Tailwind CSS dan CDN script sudah loaded
- Cek DevTools → Elements untuk melihat class yang ter-apply

---

<!-- CONTOH DATA MODEL BERITA
     ============================================================ -->

📋 STRUKTUR TABLE BERITA (Untuk Reference):

```sql
CREATE TABLE berita (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    tanggal DATE NOT NULL,
    penulis VARCHAR(255) NULLABLE,
    gambar VARCHAR(255) NULLABLE,  /* path: berita/xxxxx.jpg */
    judul VARCHAR(255) NOT NULL,
    sinopsis TEXT NULLABLE,
    isi_berita LONGTEXT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

Field yang digunakan di halaman show.blade.php:
- `judul` ← Heading artikel
- `isi_berita` ← Main content body
- `sinopsis` ← Quote/summary
- `gambar` ← Hero image
- `penulis` ← Author name
- `created_at` / `tanggal` ← Publication date

---

✨ SIAP DIIMPLEMENTASIKAN! 🚀
