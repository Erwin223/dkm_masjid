# 📸 Halaman "Baca Berita" - Visual Structure & Features

## 🎯 Overview

Halaman "Baca Berita" dirancang dengan **prinsip Senior-Friendly UI** yang mengutamakan:
- ✅ **Keterbacaan Maksimal** - Font besar, line-height longgar, kontras tinggi
- ✅ **Navigasi Jelas** - Back button, breadcrumb, tombol share
- ✅ **Content Hero** - Gambar responsif dengan styling rapi
- ✅ **Article Body** - Dukungan penuh untuk HTML dari Rich Text Editor
- ✅ **Discover More** - Related news grid untuk engagement berkelanjutan

---

## 📐 Layout & Structure

### Desktop View (1024px+)

```
┌─────────────────────────────────────────────────────────┐
│  NAVBAR (Beranda | Profil | Berita | Galeri)            │
├─────────────────────────────────────────────────────────┤
│  < Kembali ke Indeks      [HOME / BERITA / ARTIKEL]   │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  HALAMAN BACA BERITA BESAR BESAR BOLD                  │
│  Seperti Ini Dengan Font Outfit                         │
│                                                           │
│  📅 12 Mei 2026   |   👤 Admin                          │
│                                                           │
│  "Sinopsis berita ditampilkan di sini sebagai quote     │
│   block dengan styling khusus dan highlight warna"     │
│                                                           │
├─────────────────────────────────────────────────────────┤
│                    [GAMBAR HERO]                        │
│          (Responsive + border-radius + shadow)         │
│                                                           │
├─────────────────────────────────────────────────────────┤
│  ─── DIVIDER LINE (gradient) ───                        │
│                                                           │
│  ISI ARTIKEL DISINI                                     │
│  Paragraf pertama dengan font-size 18px (1.125rem)     │
│  dan line-height 1.9 agar sangat mudah dibaca.         │
│                                                           │
│  Paragraf kedua dengan heading support. Tag <strong>   │
│  akan berwarna emerald, dan <em> akan muted.           │
│                                                           │
│  Poin-poin penting:                                     │
│  • Bullet point 1                                      │
│  • Bullet point 2                                      │
│  • Bullet point 3                                      │
│                                                           │
│  ## Heading 2 (jika ada dalam Rich Text Editor)        │
│  Konten berlanjut...                                    │
│                                                           │
├─────────────────────────────────────────────────────────┤
│  Bagikan artikel:  [F] [𝕏] [W]                         │
│                              [Lihat Berita Lain >]      │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  BERITA LAINNYA                                         │
│  Jangan lewatkan informasi penting lainnya              │
│                                                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │   GAMBAR 1   │  │   GAMBAR 2   │  │   GAMBAR 3   │ │
│  │   [HOVER]    │  │   [HOVER]    │  │   [HOVER]    │ │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤ │
│  │ 12 MEI 2026  │  │ 10 MEI 2026  │  │ 08 MEI 2026  │ │
│  │              │  │              │  │              │ │
│  │ Judul Berita │  │ Judul Berita │  │ Judul Berita │ │
│  │ Panjang      │  │ Panjang      │  │ Panjang      │ │
│  │              │  │              │  │              │ │
│  │ Ringkasan    │  │ Ringkasan    │  │ Ringkasan    │ │
│  │ konten...    │  │ konten...    │  │ konten...    │ │
│  │              │  │              │  │              │ │
│  │ > Baca dst   │  │ > Baca dst   │  │ > Baca dst   │ │
│  └──────────────┘  └──────────────┘  └──────────────┘ │
│                                                           │
├─────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────┐   │
│  │  INGIN MEMBACA BERITA LAINNYA?                  │   │
│  │  Kunjungi halaman berita kami untuk info terbaru│   │
│  │                                                 │   │
│  │         [📰 Lihat Semua Berita]                │   │
│  └─────────────────────────────────────────────────┘   │
│                                                           │
├─────────────────────────────────────────────────────────┤
│ FOOTER (Copyright © 2026 DKM Al-Musabaqoh Subang)      │
└─────────────────────────────────────────────────────────┘
```

---

### Mobile View (375px)

```
┌──────────────────────┐
│  NAVBAR HAMBURGER    │
├──────────────────────┤
│  [< KEMBALI]         │
├──────────────────────┤
│                      │
│  JUDUL BERITA       │
│  BESAR DAN BOLD     │
│  (responsive)       │
│                      │
│  📅 12 Mei 2026     │
│  👤 Admin           │
│                      │
│  "Sinopsis quote"   │
│                      │
├──────────────────────┤
│   [GAMBAR HERO]      │
│   (Full width)       │
├──────────────────────┤
│  ISI KONTEN          │
│  (Font 18px)         │
│  Line-height 1.9     │
│  Paragraph 1...      │
│                      │
│  Paragraph 2...      │
│                      │
│  • Bullet point      │
│  • Bullet point      │
│                      │
├──────────────────────┤
│ Bagikan:             │
│  [F] [𝕏] [W]        │
│ [Lihat Berita Lain]  │
├──────────────────────┤
│ BERITA LAINNYA       │
│ Jangan lewatkan...   │
│                      │
│ ┌────────────────┐   │
│ │   GAMBAR 1     │   │
│ ├────────────────┤   │
│ │ 12 MEI 2026    │   │
│ │ Judul Berita   │   │
│ │ Ringkasan...   │   │
│ │ > Baca dst     │   │
│ └────────────────┘   │
│ ┌────────────────┐   │
│ │   GAMBAR 2     │   │
│ ├────────────────┤   │
│ │ 10 MEI 2026    │   │
│ │ Judul Berita   │   │
│ │ Ringkasan...   │   │
│ │ > Baca dst     │   │
│ └────────────────┘   │
│ ┌────────────────┐   │
│ │   GAMBAR 3     │   │
│ ├────────────────┤   │
│ │ 08 MEI 2026    │   │
│ │ Judul Berita   │   │
│ │ Ringkasan...   │   │
│ │ > Baca dst     │   │
│ └────────────────┘   │
│                      │
├──────────────────────┤
│ [Lihat Semua Berita] │
│                      │
└──────────────────────┘
```

---

## 🎨 Color & Typography Scheme

### Color Palette

```
┌─────────────────────┬──────────────┬──────────────────┐
│ Element             │ Color        │ CSS Value        │
├─────────────────────┼──────────────┼──────────────────┤
│ Text Main           │ Stone 900    │ #1c1917          │
│ Text Muted          │ Stone 600    │ #57534e          │
│ Back Button Border  │ Emerald 700  │ #047857          │
│ Article Meta Icon   │ Amber 600    │ #d97706          │
│ Strong Text         │ Emerald 700  │ #047857          │
│ Link Hover          │ Emerald 600  │ #059669          │
│ CTA Background      │ Emerald 900  │ #064e3b          │
│ Sinopsis BG         │ Amber 50     │ #fffbeb          │
│ Card Shadow         │ Stone 900/5% │ rgba(28,25...)   │
└─────────────────────┴──────────────┴──────────────────┘
```

### Typography

```
╔═══════════════════╦═════════════╦══════════════╗
║ Element           ║ Font Size   ║ Font Weight  ║
╠═══════════════════╬═════════════╬══════════════╣
║ Article Title H1  ║ 48px (4xl)  ║ 900 (black)  ║
║ Article Content   ║ 18px (1.1r) ║ 400 (normal) ║
║ Related Title H3  ║ 20px (1.25) ║ 700 (bold)   ║
║ Section Header H2 ║ 36px (3xl)  ║ 900 (black)  ║
║ Meta Label        ║ 16px (base) ║ 600 (semi)   ║
║ Breadcrumb        ║ 15px (0.95) ║ 600 (semi)   ║
║ Related Excerpt   ║ 15px (0.95) ║ 400 (normal) ║
╚═══════════════════╩═════════════╩══════════════╝

Font Family:
- Text: "Plus Jakarta Sans", Segoe UI, sans-serif
- Heading: "Outfit", Segoe UI, sans-serif
```

---

## ✨ Interactive Elements

### Back Button
```
DEFAULT:
┌─────────────────────────┐
│ < Kembali ke Indeks     │  Background: White
└─────────────────────────┘  Border: 2px Emerald 700
                            Color: Emerald 700

HOVER:
┌─────────────────────────┐
│ < Kembali ke Indeks     │  Background: Emerald 700
└─────────────────────────┘  Border: 2px Emerald 700
                            Color: White
                            Smooth transition
```

### Related Article Card
```
DEFAULT:
┌──────────────────┐
│   [IMG: SCALE]   │  Shadow: md
│                  │  Scale: 1
├──────────────────┤
│ 12 MEI 2026      │
│                  │
│ Judul Berita ... │
│                  │
│ Ringkasan...     │
│                  │
│ > Baca Lebih     │
└──────────────────┘

HOVER:
┌──────────────────┐
│   [IMG: SCALE    │  Shadow: xl
│    1.08x ZOOM]   │  Transform: translateY(-4px)
├──────────────────┤
│ 12 MEI 2026      │
│                  │
│ Judul Berita ... │
│                  │
│ Ringkasan...     │
│                  │
│ > Baca Lebih     │  Color: Emerald 600
│   (gap wider)    │
└──────────────────┘
```

### Share Buttons
```
Facebook: [F] - Blue bg, blue text, hover: blue inverse
Twitter:  [𝕏] - Sky bg, sky text, hover: sky inverse
WhatsApp: [W] - Green bg, green text, hover: green inverse
```

---

## 🎬 Animation Details

### AOS (Animate On Scroll) Triggers

```
┌──────────────────────────────────────────┐
│ Element                  │ Animation Type │
├──────────────────────────────────────────┤
│ Back Button              │ fade-in        │
│ Breadcrumb               │ fade-in        │
│ Article Title            │ fade-up        │
│ Article Meta             │ fade-up        │
│ Hero Image               │ zoom-in        │
│ Section Divider          │ fade-right     │
│ Article Content          │ fade-up        │
│ Share Section            │ fade-up        │
│ Related Section Title    │ fade-up        │
│ Related Card 1           │ fade-up (100ms delay) │
│ Related Card 2           │ fade-up (200ms delay) │
│ Related Card 3           │ fade-up (300ms delay) │
│ CTA Section              │ zoom-in        │
└──────────────────────────────────────────┘
```

**Configuration**:
- Duration: 800ms
- Easing: ease-in-out-cubic
- Once: false (repeat on scroll)
- Mirror: true (animate on scroll up)
- Offset: 50px (trigger 50px before in viewport)

---

## 🌐 Responsive Breakpoints

```
Mobile:    < 640px    (single column, full width)
SM:        640px      (tablet start)
MD:        768px      (tablet full)
LG:        1024px     (desktop)
XL:        1280px     (desktop large)
2XL:       1536px     (desktop XL)

Related Articles Grid:
- Mobile: 1 column
- Tablet: 2 columns
- Desktop: 3 columns (auto-fit minmax 280px)
```

---

## 📋 Feature Checklist

### ✅ Article Display
- [x] Judul besar & bold (H1)
- [x] Tanggal publikasi format "d M Y"
- [x] Nama penulis (fallback: "Admin")
- [x] Gambar hero responsif
- [x] Sinopsis/quote block
- [x] Content body dengan HTML support

### ✅ Navigation
- [x] Back button ke berita index
- [x] Breadcrumb navigation (desktop only)
- [x] Sticky back button
- [x] Mobile-optimized back

### ✅ Sharing
- [x] Facebook share
- [x] Twitter share
- [x] WhatsApp share
- [x] URL encoding
- [x] Color-coded icons

### ✅ Related Articles
- [x] 3-item grid
- [x] Responsive layout
- [x] Hover effects
- [x] Image zoom
- [x] AOS fade-up dengan delay

### ✅ Animations
- [x] AOS library integrated
- [x] Multiple animation types
- [x] Staggered delays
- [x] Mobile optimization

### ✅ Typography
- [x] Senior-friendly font sizes
- [x] Optimal line-height
- [x] Letter-spacing
- [x] Contrast optimization
- [x] Semantic HTML

### ✅ Accessibility
- [x] Semantic HTML (`<article>`, `<header>`)
- [x] Image alt text
- [x] Link descriptions
- [x] Color contrast (WCAG AA)
- [x] Mobile-friendly

---

## 🎯 Key UX Features

### Senior-Friendly Design
✅ Large font (18px minimum body text)
✅ High contrast colors (text: #1c1917 on #faf9f6)
✅ Generous line-height (1.9)
✅ Clear navigation (back button, breadcrumb)
✅ Simple layout (single column, no clutter)

### Content Clarity
✅ Rich text support (HTML from editor)
✅ Semantic markup (h2, h3, strong, em, lists)
✅ Quote blocks for sinopsis
✅ Visual hierarchy (size, weight, spacing)

### Engagement
✅ Related articles discovery
✅ Social sharing options
✅ CTA section to browse more
✅ Smooth animations
✅ Hover effects for interaction

---

## 📦 Browser Support

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Android)

---

Desain halaman "Baca Berita" ini mengoptimalkan **keterbacaan untuk segmen demografi senior** sambil tetap mempertahankan **modernitas dan interaktivitas**. 🎉
