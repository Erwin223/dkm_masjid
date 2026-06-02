# Implementasi Halaman "Baca Berita" (Berita/Show)

## 📋 Ringkasan

Halaman **Baca Berita** (`resources/views/frontend/berita/show.blade.php`) telah dibuat dengan:
- ✅ Desain ramah untuk bapak-bapak (font besar, kontras tinggi, keterbacaan optimal)
- ✅ Animasi AOS (Animate On Scroll) seperti di halaman lainnya
- ✅ Support untuk tag HTML dari Rich Text Editor dengan `{!! $berita->isi_berita !!}`
- ✅ Tombol kembali & breadcrumb navigation
- ✅ Header artikel lengkap (judul, tanggal, penulis)
- ✅ Gambar hero yang responsif
- ✅ Grid berita lainnya (3 card) dengan AOS fade-up bertingkat
- ✅ Fitur share ke social media (Facebook, Twitter, WhatsApp)

---

## 🔧 Langkah Implementasi

### 1️⃣ Tambahkan Route di `routes/web.php`

Tambahkan route untuk menampilkan detail berita:

```php
// Di bagian FRONTEND, tambahkan setelah route '/berita'
Route::get('/berita/{berita}', [HomeController::class, 'showBerita'])
    ->name('frontend.berita.show')
    ->whereNumber('berita');
```

**Catatan**: `whereNumber('berita')` memastikan parameter hanya menerima ID numerik.

---

### 2️⃣ Tambahkan Method di `app/Http/Controllers/HomeController.php`

Tambahkan method `showBerita()` di HomeController:

```php
/**
 * Tampilkan detail berita
 *
 * @param \App\Models\Berita $berita
 * @return \Illuminate\View\View
 */
public function showBerita(Berita $berita)
{
    // Ambil 3 berita lain yang terbaru (exclude berita yang sedang dibaca)
    $berita_lain = Berita::query()
        ->where('id', '!=', $berita->id)
        ->latest('tanggal')
        ->latest('id')
        ->limit(3)
        ->get();

    return view('frontend.berita.show', [
        'berita' => $berita,
        'berita_lain' => $berita_lain,
    ]);
}
```

**Penjelasan**:
- `Berita $berita` → Laravel Route Model Binding otomatis mencari berdasarkan ID
- `$berita_lain` → Mengambil 3 berita lain yang tidak sedang dibaca
- View menerima kedua variabel untuk ditampilkan

---

### 3️⃣ Update Link di Halaman Berita Index

Di file `resources/views/frontend/berita.blade.php`, ubah link "Baca Selengkapnya" menjadi:

**Dari**:
```blade
<a href="{{ $url }}" class="inline-flex items-center gap-2 ...">
    Baca Selengkapnya
</a>
```

**Menjadi**:
```blade
<a href="{{ route('frontend.berita.show', $item->id) }}" class="inline-flex items-center gap-2 ...">
    Baca Selengkapnya
</a>
```

---

## 📦 Data Binding yang Didukung

Halaman show.blade.php mengharapkan variabel-variabel berikut dari Controller:

| Variabel | Field | Format | Catatan |
|----------|-------|--------|---------|
| `$berita->judul` | string | Judul artikel | Ditampilkan sebagai H1 |
| `$berita->isi_berita` | HTML/text | Isi konten | Menggunakan `{!! !!}` untuk render HTML |
| `$berita->sinopsis` | text | Ringkasan artikel | Optional, tampil sebagai quote |
| `$berita->gambar` | path | Path gambar di storage | Menggunakan `asset('storage/' . $path)` |
| `$berita->penulis` | string | Nama penulis | Default: "Admin" jika kosong |
| `$berita->tanggal` | timestamp | Tanggal publikasi | Format: d F Y (translatedFormat) |
| `$berita->created_at` | timestamp | Tanggal dibuat | Sebagai fallback tanggal |
| `$berita_lain` | Collection | Array/Collection Berita | Maksimal 3 item untuk grid |

---

## 🎨 Fitur & Komponen

### 1. Back Button & Breadcrumb
- Tombol dengan kontras tinggi untuk navigasi kembali
- Breadcrumb responsif (hidden di mobile)
- Ikon bootstrap-icons untuk visual clarity

### 2. Article Header
- **Judul Besar**: Font 4xl (mobile) → 5xl (desktop)
- **Metadata**: Tanggal & penulis dengan ikon
- **Sinopsis**: Quote block dengan styling khusus (optional)

### 3. Article Content
- Line-height: 1.9 (optimal untuk keterbacaan)
- Font size: 1.125rem (18px) untuk senior-friendly
- Styling untuk `<strong>`, `<em>`, `<ul>`, `<ol>`, dll.
- Support untuk heading levels (h2, h3, etc.)

### 4. Share Buttons
- Facebook, Twitter, WhatsApp
- Warna-coded icons untuk brand recognition
- Menggunakan `urlencode()` untuk URL dan teks

### 5. Related Articles
- Grid 3 kolom (responsive)
- AOS fade-up dengan delay bertingkat (100ms, 200ms, 300ms)
- Hover effect: shadow & translate up
- Image zoom pada hover

---

## ✨ Animasi AOS

Halaman menggunakan AOS dengan konfigurasi:

```javascript
AOS.init({
    duration: 800,           // Durasi animasi 800ms
    easing: 'ease-in-out-cubic',
    once: false,            // Animasi berulang saat scroll
    mirror: true,           // Animasi saat scroll up juga
    offset: 50,             // Trigger saat element 50px dari viewport
    disable: 'mobile'       // Disable di mobile (optional)
});
```

**Elemen dengan AOS**:
- `data-aos="fade-up"` - Back button, breadcrumb, metadata
- `data-aos="fade-up" data-aos-delay="200"` - Article content
- `data-aos="fade-right" data-aos-delay="150"` - Section divider
- `data-aos="zoom-in" data-aos-delay="100"` - Hero image
- `data-aos="fade-up" data-aos-delay="100"` - Related section header
- `data-aos="fade-up" data-aos-delay="100-300"` - Related cards (bertingkat)

---

## 🎯 Customization Tips

### Mengubah Warna Scheme
Edit CSS di dalam `<style>` tag atau ubah CSS variables:
```css
--primary: #047857;      /* Warna utama (emerald) */
--accent: #f59e0b;       /* Warna highlight (amber) */
--text-main: #1c1917;    /* Warna teks utama */
```

### Mengubah Font Size
Edit class `.article-content`:
```css
.article-content {
    font-size: 1.25rem;      /* Lebih besar dari 1.125rem */
    line-height: 2;          /* Line-height lebih longgar */
}
```

### Menambah/Mengurangi Berita Lain
Di HomeController method `showBerita()`:
```php
// Ubah limit() dari 3 menjadi jumlah yang diinginkan
->limit(3)
```

---

## 🚀 Testing & Deployment

1. **Test route model binding**:
   ```
   php artisan route:list | grep berita
   ```

2. **Test di browser**:
   - Buka `/berita` → klik salah satu berita
   - Verifikasi URL menjadi `/berita/{id}`
   - Verifikasi konten dimuat dengan benar

3. **Test responsiveness**:
   - Mobile (375px)
   - Tablet (768px)
   - Desktop (1024px+)

4. **Test gambar**:
   - Pastikan folder `storage/berita/` ada
   - File gambar sudah ter-upload di database

---

## 📝 Struktur HTML Semantic

Halaman menggunakan struktur semantic yang baik:
```html
<article>           <!-- Main article container -->
  <header>          <!-- Article metadata -->
    <h1>            <!-- Article title -->
    <meta>          <!-- Tanggal, penulis -->
  </header>
  <img>             <!-- Hero image -->
  <div class="article-content">  <!-- Main content -->
    {!! isi_berita !!}
  </div>
</article>
```

---

## 🔒 Security Considerations

- ✅ Route Model Binding mencegah unauthorized access
- ✅ `{!! !!}` hanya digunakan untuk content dari database (admin-controlled)
- ✅ Social share links menggunakan `urlencode()` untuk sanitasi
- ✅ Image paths menggunakan `asset()` helper

---

## 📚 File yang Digunakan

| File | Path | Status |
|------|------|--------|
| **View** | `resources/views/frontend/berita/show.blade.php` | ✅ Dibuat |
| **Controller** | `app/Http/Controllers/HomeController.php` | ⏳ Perlu update |
| **Routes** | `routes/web.php` | ⏳ Perlu update |

---

Selamat! Halaman "Baca Berita" siap diimplementasikan! 🎉
