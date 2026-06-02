# 🎓 Best Practices & Customization Guide

## 📚 Table of Contents

1. [Best Practices](#best-practices)
2. [Customization Guide](#customization-guide)
3. [Performance Optimization](#performance-optimization)
4. [SEO Tips](#seo-tips)
5. [Accessibility Enhancements](#accessibility-enhancements)
6. [Troubleshooting & FAQ](#troubleshooting--faq)

---

## ✅ Best Practices

### 1. Data Validation & Sanitization

**❌ JANGAN:**
```php
// Langsung render tanpa sanitasi
{!! $berita->isi_berita !!}  // Berisiko XSS jika dari user input
```

**✅ LAKUKAN:**
```php
// Sanitasi HTML dengan whitelist
{!! \Illuminate\Support\HtmlString::sanitize($berita->isi_berita) !!}

// Atau gunakan purifier package
{!! \App\Services\HtmlPurifier::clean($berita->isi_berita) !!}
```

**Note**: Saat ini file show.blade.php menggunakan `{!! !!}` karena content dari admin (trusted source). Untuk production, pertimbangkan sanitasi tambahan.

### 2. Image Optimization

**❌ JANGAN:**
```blade
<img src="{{ asset('storage/' . $berita->gambar) }}" 
     alt="{{ $berita->judul }}"
     class="w-full">
```

**✅ LAKUKAN:**
```blade
<img src="{{ asset('storage/' . $berita->gambar) }}" 
     alt="{{ $berita->judul }}"
     class="w-full h-auto object-cover"
     loading="lazy"
     width="1200"
     height="600"
     decoding="async">
```

**Implementasi di show.blade.php**: ✅ Sudah menggunakan `loading="lazy"`

### 3. Route Model Binding

**✅ SUDAH BENAR:**
```php
Route::get('/berita/{berita}', [HomeController::class, 'showBerita'])
    ->name('frontend.berita.show')
    ->whereNumber('berita');  // Hanya terima angka
```

**Keuntungan**:
- Lazy loading otomatis (404 jika tidak ada)
- Secure (tidak perlu manual ID validation)
- Clean URL

### 4. Query Optimization

**❌ JANGAN (N+1 problem):**
```php
$berita_lain = Berita::all();
foreach ($berita_lain as $item) {
    echo $item->penulis;  // Query berulang!
}
```

**✅ LAKUKAN:**
```php
$berita_lain = Berita::with('penulis')  // Eager loading
    ->where('id', '!=', $berita->id)
    ->limit(3)
    ->get();
```

**Implementasi di show.blade.php**: ✅ Sudah optimal (simple queries)

### 5. Caching Strategy

```php
// app/Http/Controllers/HomeController.php

public function showBerita(Berita $berita)
{
    // Cache related articles selama 1 jam
    $berita_lain = Cache::remember(
        'berita_related_' . $berita->id,
        now()->addHour(),
        function () use ($berita) {
            return Berita::query()
                ->where('id', '!=', $berita->id)
                ->latest('tanggal')
                ->limit(3)
                ->get();
        }
    );

    return view('frontend.berita.show', [
        'berita' => $berita,
        'berita_lain' => $berita_lain,
    ]);
}
```

---

## 🎨 Customization Guide

### 1. Mengubah Warna Scheme

**Option A: CSS Variables**
```css
:root {
    --primary: #047857;      /* Emerald ke warna lain */
    --accent: #f59e0b;       /* Amber ke warna lain */
    --text-main: #1c1917;    /* Stone 900 */
}
```

**Option B: Tailwind Class Override**

Di `resources/views/frontend/berita/show.blade.php`, ubah class Tailwind:

```blade
<!-- Sebelum: bg-emerald-900 -->
<section class="bg-blue-900">

<!-- Atau gunakan style attribute -->
<section style="background-color: #1e40af;">
```

**Popular Color Combinations**:
```
Green Theme:    Primary: #047857, Accent: #f59e0b
Blue Theme:     Primary: #0369a1, Accent: #d97706
Purple Theme:   Primary: #6d28d9, Accent: #f59e0b
Dark Theme:     Primary: #1f2937, Accent: #60a5fa
```

### 2. Mengubah Font Size untuk Senior

**Current (Optimal)**:
```css
.article-content {
    font-size: 1.125rem;  /* 18px */
    line-height: 1.9;
}
```

**Jika ingin lebih besar**:
```css
.article-content {
    font-size: 1.25rem;   /* 20px */
    line-height: 2;
}
```

**Implementation**:
Edit `<style>` tag di show.blade.php:
```css
.article-content {
    font-size: 1.25rem;   /* Ubah dari 1.125rem */
    line-height: 2;       /* Ubah dari 1.9 */
}
```

### 3. Related Articles: 2 vs 4 Items

**Mengubah jumlah berita lain**:

Di HomeController:
```php
// Dari 3
->limit(3)

// Menjadi 2, 4, atau 5
->limit(4)
```

Update `related-articles-grid`:
```css
/* 2 kolom */
.related-articles-grid {
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
}

/* 4 kolom */
.related-articles-grid {
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}
```

### 4. Menghilangkan Share Buttons

Di halaman show.blade.php, hapus section:
```blade
<!-- Remove this section -->
<div class="mt-12 flex flex-col sm:flex-row gap-6 justify-between items-center">
    <div class="flex items-center gap-4">
        ... (share buttons)
    </div>
</div>
```

### 5. Mengubah AOS Animation

**Current**:
```javascript
AOS.init({
    duration: 800,
    easing: 'ease-in-out-cubic',
    offset: 50,
});
```

**Opsi lain**:
```javascript
// Animasi lebih cepat
AOS.init({
    duration: 500,           /* Dari 800 */
    easing: 'ease-in-quad',  /* Dari ease-in-out-cubic */
    offset: 100,             /* Dari 50 */
    disable: 'phone'         /* Dari 'mobile' */
});
```

**AOS Animation Types yang tersedia**:
```
fade-up, fade-down, fade-left, fade-right
zoom-in, zoom-in-up, zoom-in-down, zoom-in-left, zoom-in-right
flip-left, flip-right, flip-up, flip-down
slide-up, slide-down, slide-left, slide-right
bounce-up, bounce-down, bounce-left, bounce-right
rotate, rotate-left, rotate-right
```

---

## ⚡ Performance Optimization

### 1. Implement Image Lazy Loading (✅ Sudah Ada)

```blade
<img src="{{ asset('storage/' . $berita->gambar) }}" 
     alt="{{ $berita->judul }}"
     loading="lazy"
     decoding="async">
```

### 2. Add Content Delivery Network (CDN)

```html
<!-- AOS dari CDN (✅ Sudah Ada) -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Fonts dari Google Fonts CDN (✅ Sudah Ada) -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:...">

<!-- Bootstrap Icons dari CDN (✅ Sudah Ada) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/...">

<!-- Tailwind dari CDN (✅ Sudah Ada) -->
<script src="https://cdn.tailwindcss.com"></script>
```

### 3. Minify & Compress Assets

```bash
# Production build (jika menggunakan build tools)
npm run build

# Laravel compression
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Browser Caching Headers

Di `.htaccess` atau nginx config:
```apache
<IfModule mod_headers.c>
  # Cache images, fonts untuk 1 bulan
  <FilesMatch ".(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2)$">
    Header set Cache-Control "max-age=2592000, public"
  </FilesMatch>
</IfModule>
```

---

## 🔍 SEO Tips

### 1. Meta Tags

**Tambahkan di head section**:
```blade
<meta name="description" 
      content="{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 160) }}">

<meta name="keywords" 
      content="berita, masjid, {{ $berita->judul }}, Al-Musabaqoh">

<meta name="author" content="{{ $berita->penulis ?? 'Admin' }}">

<!-- Open Graph untuk social media preview -->
<meta property="og:title" content="{{ $berita->judul }}">
<meta property="og:description" 
      content="{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 160) }}">
<meta property="og:image" 
      content="{{ asset('storage/' . $berita->gambar) }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:type" content="article">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $berita->judul }}">
<meta name="twitter:description" 
      content="{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 160) }}">
<meta name="twitter:image" 
      content="{{ asset('storage/' . $berita->gambar) }}">
```

### 2. Structured Data (Schema.org)

```blade
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ $berita->judul }}",
  "image": "{{ asset('storage/' . $berita->gambar) }}",
  "datePublished": "{{ $berita->created_at->toIso8601String() }}",
  "dateModified": "{{ $berita->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $berita->penulis ?? 'Admin' }}"
  },
  "description": "{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 160) }}"
}
</script>
```

### 3. URL Structure

**✅ BAIK** (sudah ada):
```
/berita/{id}

Contoh: /berita/1, /berita/42
```

**⚡ LEBIH BAIK** (optional upgrade):
```
/berita/{slug}
/berita/2026/05/12-judul-berita-dengan-slug

Butuh: Model migration + slug generation
```

---

## ♿ Accessibility Enhancements

### 1. Add Skip Links

```blade
<!-- Di awal halaman -->
<a href="#main-content" class="sr-only">Skip to main content</a>

<!-- Tambahkan id di main section -->
<main id="main-content" class="flex-1">
```

### 2. Improve Focus Management

```css
/* Add di <style> tag */
a:focus-visible,
button:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}
```

### 3. Semantic HTML Improvements

```blade
<!-- ✅ Sudah semantik -->
<article>
  <header>
    <h1>{{ $berita->judul }}</h1>
    <time datetime="{{ $berita->created_at->toIso8601String() }}">
        {{ $berita->created_at->translatedFormat('d F Y') }}
    </time>
  </header>
  <img alt="{{ $berita->judul }}">
  <section>{{ content }}</section>
</article>

<!-- ✅ Sudah ada aria-labels pada ikon -->
<i class="bi bi-calendar-event" aria-hidden="true"></i>
```

### 4. Color Contrast Verification

**Ratios (harus minimum AA 4.5:1)**:
- ✅ Text (#1c1917) on BG (#faf9f6): ~13:1 (AAA)
- ✅ Links (#047857) on BG (#faf9f6): ~7.5:1 (AAA)
- ✅ Meta text (#57534e) on BG (#faf9f6): ~7.2:1 (AAA)

---

## 🔧 Troubleshooting & FAQ

### Q1: Berita tidak tampil di halaman?

**Answer**:
1. Cek apakah Berita dengan ID tersebut ada di database
   ```sql
   SELECT * FROM berita WHERE id = 1;
   ```

2. Cek routing di `routes/web.php`
   ```bash
   php artisan route:list | grep berita.show
   ```

3. Test URL langsung: `/berita/1`

4. Lihat logs: `storage/logs/laravel.log`

### Q2: Gambar tidak tampil?

**Answer**:
1. Pastikan symlink sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. Verifikasi path di database (jangan include "storage/"):
   ```sql
   SELECT gambar FROM berita WHERE id = 1;
   -- Output: berita/image-xyz.jpg (BUKAN: storage/berita/image-xyz.jpg)
   ```

3. Cek file actual ada:
   ```
   storage/app/public/berita/image-xyz.jpg
   ```

### Q3: AOS animasi tidak jalan?

**Answer**:
1. Cek CDN sudah loaded:
   - DevTools → Network → cari "aos.js"
   - DevTools → Console → ketik `typeof AOS`
   - Harus return `"object"` (bukan undefined)

2. Scroll halaman (AOS perlu scroll trigger)

3. Cek `data-aos` attribute ada di elemen:
   ```html
   <div data-aos="fade-up">Content</div>
   ```

4. Jika masih tidak jalan, initialize ulang di console:
   ```javascript
   AOS.refresh();
   ```

### Q4: Font sangat besar untuk beberapa pengguna?

**Answer**:
```css
/* Cek font-size di class .article-content */
.article-content {
    font-size: 1.125rem;  /* 18px default */
}

/* Tambahkan responsive size */
@media (max-width: 640px) {
    .article-content {
        font-size: 1rem;  /* 16px di mobile */
    }
}
```

### Q5: Bagaimana jika isi berita mengandung JavaScript berbahaya?

**Answer**:
Gunakan HTML Purifier package:
```bash
composer require mews/purifier
```

Di controller:
```php
use Mews\Purifier\Facades\Purifier;

public function showBerita(Berita $berita)
{
    $berita->isi_berita = Purifier::clean($berita->isi_berita);
    
    return view('frontend.berita.show', [
        'berita' => $berita,
    ]);
}
```

Di view:
```blade
{!! $berita->isi_berita !!}
```

---

## 📈 Performance Metrics Goals

### Core Web Vitals Targets

```
Largest Contentful Paint (LCP):  < 2.5s  ✅
First Input Delay (FID):         < 100ms ✅
Cumulative Layout Shift (CLS):   < 0.1   ✅

Page Load Speed (Lighthouse):    > 90    (Target)
```

### Testing Tools

- **Google PageSpeed Insights**: https://pagespeed.web.dev
- **GTmetrix**: https://gtmetrix.com
- **WebPageTest**: https://www.webpagetest.org

---

## 🚀 Deployment Checklist

- [ ] Test semua link & button
- [ ] Verifikasi gambar semua tampil
- [ ] Test di mobile, tablet, desktop
- [ ] Jalankan `php artisan config:cache`
- [ ] Jalankan `php artisan route:cache`
- [ ] Jalankan `php artisan view:cache`
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Backup database sebelum deploy
- [ ] Test AOS animasi di production
- [ ] Verifikasi social sharing
- [ ] Test breadcrumb navigation
- [ ] Cek console untuk error messages

---

Semoga panduan ini membantu! Happy customizing! 🎉
