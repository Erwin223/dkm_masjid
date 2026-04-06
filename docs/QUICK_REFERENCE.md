# 📋 QUICK REFERENCE GUIDE - DKM Masjid System Architecture

## 🎯 Executive Summary

**DKM Masjid** adalah aplikasi manajemen masjid terintegrasi berbasis **Laravel 12**, yang mengelola keseluruhan operasional masjid (Keuangan, Donasi, Zakat, Operasional) melalui satu dashboard terpusat.

---

## 📊 SISTEM OVERVIEW

### Komponen Utama (4 Domain Bisnis)

| Domain | Tabel Utama | Fungsi |
|--------|-------------|--------|
| **Keuangan** 💰 | KasMasuk, KasKeluar | Manajemen arus kas & pengeluaran |
| **Donasi** 🤝 | DonasiMasuk, DonasiKeluar, Donatur | Terima & distribusi donasi |
| **Zakat** 💚 | PenerimaanZakat, DistribusiZakat, Muzakki, Mustahik | Kelola zakat masuk/keluar |
| **Operasional** 📅 | JadwalKegiatan, Pengurus, Berita, Galeri | Manajemen kegiatan & konten |

### Arsitektur Berlapis

```
Presentation (Blade + Tailwind + Alpine)
    ↓
Routing & Middleware (Auth, Admin, NoCache)
    ↓
Controllers (13 Controllers)
    ↓
Models & Business Logic (15 Models)
    ↓
Cache Layer (Redis/File)
    ↓
Database (MySQL/PostgreSQL - 15 tables + 43 migrations)
    ↓
External Services (Mail, Storage, Queue)
```

---

## 🔑 KEY INFORMATION

### Access Points
- **Frontend:** `/` - Halaman publik
- **Admin Panel:** `/admin/*` - Dashboard terpusat (Protected)
- **Login:** `/login` - Autentikasi pengguna

### Authentication
- **Method:** Session-based (Laravel Sessions)
- **Protection:** `auth`, `admin`, `nocache` middleware
- **User Model:** `App\Models\User` (with `is_admin` flag)

### Database
- **Engine:** MySQL 8.0+ atau PostgreSQL 13+
- **ORM:** Laravel Eloquent
- **Tables:** 15 utama (+ system tables)
- **Migrations:** 43 total

---

## 🌊 DATA FLOW (Simplified)

```
User Input Form
    ↓
POST Request → Router → Middleware
    ↓
Controller → Validate Input
    ↓
Calculate/Process
    ↓
Model → Database Query
    ↓
INSERT/UPDATE/FETCH
    ↓
Return Result to Controller
    ↓
Render Template (Blade)
    ↓
Display Response (HTML)
```

---

## 📱 MAIN WORKFLOWS

### 1️⃣ Workflow: Donasi Masuk

**Flow:** Admin Input → Validate → Save → Dashboard Update

```
Admin di Dashboard
  ↓
Klik "Tambah Donasi Masuk"
  ↓
Form Display (dengan dropdown Donatur)
  ↓
Isi Form:
  • Donatur (atau guest)
  • Jenis (Uang/Barang)
  • Jumlah & Satuan
  • Tanggal & Keterangan
  ↓
Submit (POST /admin/donasi-masuk/store)
  ↓
Validasi Input (Form Request)
  ↓
Calculate Total (jumlah × harga)
  ↓
Save to Database (donasi_masuk table)
  ↓
Dashboard Auto-Update (totals & charts)
  ↓
Success Message
```

**Data Stored:**
- `donatur_id` → Reference to Donatur (optional)
- `donatur_nama` → Fallback donor name
- `jenis_donasi` → Type (Uang/Barang/Makanan)
- `kategori_donasi` → Category (Infaq/Sedekah/Hibah)
- `jumlah` → Amount/Quantity
- `satuan` → Unit (pcs, kg, liter)
- `total` → Calculated value (Rp)
- `tanggal` → Date of donation

---

### 2️⃣ Workflow: Dashboard Aggregation

**Flow:** Query All Modules → Calculate Metrics → Cache → Display

```
Admin Access /admin/dashboard
  ↓
[Parallel Queries]
├─ Kas: SUM(kas_masuk), SUM(kas_keluar)
├─ Donasi: COUNT, SUM, GROUP BY kategori
├─ Zakat: COUNT (muzakki/mustahik), SUM
├─ Kegiatan: COUNT dengan status grouping
└─ Operasional: Recent entries
  ↓
Aggregate Results
  ↓
Cache for 1 hour (optimization)
  ↓
Render Dashboard View
  ↓
Display:
  • Top metric cards
  • Charts (donasi breakdown, kas trend)
  • Recent transactions tables
  • Quick stats
```

**Dashboard Components:**
- **Top Cards:** Total Kas, Donasi, Zakat, Kegiatan Budget
- **Charts:** Donasi vs Zakat trend, Category breakdown, Monthly cash flow
- **Tables:** Last 5 transactions per module
- **Widgets:** Pengurus count, Donatur count, Kegiatan schedule

---

### 3️⃣ Workflow: Zakat Management

**INFLOW (Penerimaan):**
```
Muzakki datang/transfer zakat
  ↓
Admin input → penerimaan_zakat:
  • muzakki_id
  • tanggal
  • nominal_uang
  • nominal_barang (converted to Rp)
  ↓
Save to Database
  ↓
Create kas_masuk entry (affect balance)
  ↓
Update Dashboard stats
```

**OUTFLOW (Distribusi):**
```
Admin planning → Approve mustahik list
  ↓
Input → distribusi_zakat:
  • mustahik_id
  • tanggal
  • nominal (amount per person)
  • keterangan (notes)
  ↓
Save & create kas_keluar
  ↓
Dashboard reduced (balance decreases)
```

---

## 🛠️ TECHNOLOGY STACK

### Backend
```
- Framework: Laravel 12
- Language: PHP 8.2+
- Database: MySQL 8.0+ / PostgreSQL 13+
- ORM: Eloquent
- Authentication: Sessions (+ Sanctum for future API)
```

### Frontend
```
- View Engine: Blade Templates
- Styling: Tailwind CSS 3.1
- Interactivity: Alpine.js 3.4
- Build Tool: Vite v7
- HTTP Client: Axios
```

### Infrastructure
```
- Server: Apache/Nginx
- Runtime: PHP-FPM
- Cache: Redis (optional) / File
- Queue: Redis Queue / Database (future)
```

---

## 📊 MODEL RELATIONSHIPS (Quick Reference)

```
Donatur (1) ──→ (Many) DonasiMasuk
Muzakki (1) ──→ (Many) PenerimaanZakat
Mustahik (1) ──→ (Many) DistribusiZakat
JadwalKegiatan (Many) ──→ (1) KasKeluar
User (1) ──→ (Many) JadwalKegiatan
DataImam (1) ──→ (Many) JadwalImam
```

---

## 🔐 Security Measures

| Layer | Protection |
|-------|-----------|
| **Auth** | Password hashing (bcrypt), Session cookies |
| **Authorization** | is_admin flag, middleware checks |
| **Data** | CSRF tokens, parameterized queries (Eloquent) |
| **Output** | Blade Auto-escaping, XSS prevention |
| **API** | Rate limiting, token validation (future) |

---

## ⚡ Performance Tips

### Current Optimizations
- ✅ Eager loading with `->with()` on related models
- ✅ Query limiting (e.g., `->limit(5)`)
- ✅ Dashboard caching (1 hour TTL)

### Recommended Enhancements
- 📌 Add indexes on frequently queried fields (tanggal, donatur_id)
- 📌 Implement query result caching
- 📌 Use pagination for large lists
- 📌 Add query scopes for common filters
- 📌 CDN for static assets (production)

---

## 📝 Files Reference

### Key Directories
```
app/Http/Controllers/
├── Admin/              # 13 admin controllers
├── Auth/              # Login/logout
└── HomeController.php # Frontend homepage

app/Models/
├── Kas models           (KasMasuk, KasKeluar)
├── Donasi models        (DonasiMasuk, DonasiKeluar, Donatur)
├── Zakat models         (PenerimaanZakat, DistribusiZakat, Muzakki, Mustahik)
└── Operational models   (JadwalKegiatan, Pengurus, Berita, Galeri, etc)

routes/
└── web.php            # All route definitions

resources/views/
├── frontend/          # Public pages
└── admin/            # Admin dashboard module views

database/
├── migrations/        # 43 migration files
└── factories/         # Test data generators
```

### Routes Pattern
```
GET  /admin/kas-masuk              → List view
GET  /admin/kas-masuk/create       → Create form
POST /admin/kas-masuk/store        → Save data
GET  /admin/kas-masuk/edit/{id}    → Edit form
PUT  /admin/kas-masuk/update/{id}  → Update data
DELETE /admin/kas-masuk/{id}       → Delete record
```

---

## 🚀 Deployment Checklist

- [ ] Setup environment (.env configuration)
- [ ] Run migrations (`php artisan migrate`)
- [ ] Generate app key (`php artisan key:generate`)
- [ ] Build frontend assets (`npm run build`)
- [ ] Setup database backups
- [ ] Configure email service (SMTP)
- [ ] Enable HTTPS in production
- [ ] Setup logging & monitoring
- [ ] Configure cache backend
- [ ] Test all workflows
- [ ] Create admin user
- [ ] Document custom configurations

---

## 🆘 Common Operations

### View All Models
```bash
ls app/Models/
```

### Generate New Model with Controller
```bash
php artisan make:model ModelName -c
```

### Run Database Migrations
```bash
php artisan migrate
```

### Clear Cache
```bash
php artisan cache:clear
```

### View Logs
```bash
php artisan pail --timeout=0
```

### Start Development Server
```bash
composer run dev
```

---

## 📞 Support & Documentation

- **Full Architecture Doc:** [SYSTEM_ARCHITECTURE_COMPLETE.md](./SYSTEM_ARCHITECTURE_COMPLETE.md)
- **Laravel Docs:** https://laravel.com/docs/12
- **Blade Reference:** https://laravel.com/docs/12/blade
- **Eloquent Guide:** https://laravel.com/docs/12/eloquent

---

## 📅 Document Info

**Version:** 1.0  
**Created:** April 2026  
**Purpose:** Quick Reference Guide for DKM Masjid System Architecture  
**Audience:** Developers, System Administrators, Project Managers
