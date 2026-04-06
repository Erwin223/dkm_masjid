# 🔄 DETAILED WORKFLOW DOCUMENTATION - DKM Masjid

## Table of Contents
1. [Request-Response Cycle](#request-response-cycle)
2. [Donasi Masuk Process (Detailed)](#donasi-masuk-process-detailed)
3. [Zakat Workflow](#zakat-workflow)
4. [Dashboard Data Aggregation](#dashboard-data-aggregation)
5. [Financial Management](#financial-management)
6. [Error Handling & Validation](#error-handling--validation)
7. [Caching Strategy](#caching-strategy)

---

## Request-Response Cycle

### Step-by-Step HTTP Request Flow

```
┌─────────────────────────────────────────────────────┐
│ CLIENT (Browser)                                    │
│ • User clicks button/submits form                  │
│ • JavaScript handler (Alpine.js) processes event   │
│ • Prepare HTTP request with data                   │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ HTTP REQUEST TRANSMISSION                           │
│ • Method: GET / POST / PUT / DELETE                │
│ • URL: /admin/kas-masuk/store                      │
│ • Headers: CSRF token, Content-Type, Session ID   │
│ • Body: Form data (JSON or form-encoded)          │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ LARAVEL CORE                                        │
│ • HttpKernel receives request                      │
│ • Boot service providers                           │
│ • Apply global middleware                          │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ ROUTER (routes/web.php)                            │
│ • Match URL to defined route                       │
│ • Extract route parameters                         │
│ • Identify controller & action                     │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ ROUTE-SPECIFIC MIDDLEWARE STACK                    │
│                                                     │
│ ① SessionMiddleware → Load session data           │
│ ② VerifyCsrfToken → Check CSRF token              │
│ ③ auth → Verify user logged in                    │
│ ④ AdminOnly → Check is_admin = true               │
│ ⑤ NoCache → Set cache headers to no-cache         │
│                                                     │
│ Each middleware has 'before' & 'after' actions    │
│ Any middleware can reject request (throw exception)
└────────────────────┬────────────────────────────────┘
                     ↓ (if passed)
┌─────────────────────────────────────────────────────┐
│ CONTROLLER ACTION                                   │
│ • Instantiate controller class                     │
│ • Call action method (e.g., store())              │
│ • Dependency injection (if needed)                 │
│                                                     │
│ Example: KasMasukController@store                 │
│ public function store(StoreRequest $request)      │
│ {                                                  │
│     // $request already validated                 │
│     $data = $request->validated();               │
│     KasMasuk::create($data);                     │
│     return redirect()->route('kas.masuk.index'); │
│ }                                                  │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ REQUEST VALIDATION (Form Request)                  │
│ • Check if $request is FormRequest subclass       │
│ • Run authorize() method                          │
│ • Run rules() validation rules                    │
│                                                     │
│ If validation fails:                              │
│ 1. Create ValidationException                     │
│ 2. Redirect back with errors                      │
│ 3. Flash input to session                         │
│ 4. Display error messages on form                 │
│                                                     │
│ If validation passes:                             │
│ 1. Continue to controller logic                   │
│ 2. Request::validated() available                 │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ BUSINESS LOGIC                                      │
│ • Check business rules                            │
│ • Calculate derived values                        │
│ • Prepare data for persistence                    │
│                                                     │
│ Example (Donasi):                                 │
│ // Calculate total nilai donasi                  │
│ if ($data['jenis'] === 'Barang') {              │
│     $data['total'] = $data['jumlah'] ×          │
│         $hargaBarang;                            │
│ }                                                  │
│ // Store in model                                 │
│ DonasiMasuk::create($data);                      │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ MODEL & ELOQUENT ORM                               │
│ • Load model class (e.g., DonasiMasuk)            │
│ • Prepare data for database                       │
│ • Apply attribute casting                         │
│ • Trigger model events (creating, created)        │
│ • Generate SQL query                              │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ DATABASE QUERY                                      │
│ • Send SQL to database server                     │
│ • Execute transaction                             │
│                                                     │
│ Example SQL:                                      │
│ INSERT INTO donasi_masuk (                        │
│   donatur_id, donatur_nama, tanggal,              │
│   jenis_donasi, kategori_donasi, jumlah,         │
│   satuan, total, keterangan, created_at,         │
│   updated_at                                      │
│ ) VALUES (?, ?, ?, ...)                          │
│                                                     │
│ Return: Last inserted ID                          │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ MODEL RESPONSE                                      │
│ • Record created with auto-incremented ID         │
│ • Fire 'created' event                            │
│ • Return model instance                           │
│ • Store in session/cache if needed                │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ CONTROLLER RESPONSE PREPARATION                    │
│ • Create redirect response (HTTP 302)            │
│ • Add flash data to session                       │
│  (success message, etc)                           │
│ • Set response headers                            │
│                                                     │
│ return redirect()                                 │
│     ->route('kas.masuk.index')                   │
│     ->with('success',                            │
│          'Data berhasil disimpan');              │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ HTTP RESPONSE TRANSMISSION                         │
│ • Status: 302 Found                               │
│ • Headers: Location, Set-Cookie (session)         │
│ • Body: Empty or minimal (redirect)               │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ BROWSER FOLLOWS REDIRECT                           │
│ • Make new GET request to Location header         │
│ • Include session cookie                          │
│ → Go back to ROUTER step with new URL            │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ CONTROLLER (Index Action)                          │
│ • Query all KasMasuk records                       │
│ • Sort/filter as needed                           │
│ • Pass data to view                               │
│                                                     │
│ return view('admin.kas_masuk.index', [           │
│     'records' => KasMasuk::latest()->get(),      │
│ ]);                                                │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ BLADE TEMPLATE RENDERING                          │
│ • Load Blade template file                        │
│ • Parse PHP/Blade directives                      │
│ • Inject data variables                           │
│ • Compile to HTML                                 │
│                                                     │
│ @foreach ($records as $record)                   │
│     <tr>                                           │
│         <td>{{ $record->tanggal }}</td>          │
│         <td>{{ $record->jumlah }}</td>           │
│     </tr>                                          │
│ @endforeach                                       │
│                                                     │
│ Output: Complete HTML document                    │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ HTTP RESPONSE                                       │
│ • Status: 200 OK                                   │
│ • Headers: Content-Type: text/html, ...           │
│ • Body: Complete HTML document                    │
│ • Session cookie                                  │
│ • Flash message visible                           │
└────────────────────┬────────────────────────────────┘
                     ↓
┌─────────────────────────────────────────────────────┐
│ BROWSER RENDERING                                   │
│ • Parse HTML                                       │
│ • Load stylesheets (Tailwind CSS)                 │
│ • Execute JavaScript (Alpine.js)                  │
│ • Render interactive page                         │
│ • Display success message                         │
│ • Show updated table with new record              │
└─────────────────────────────────────────────────────┘
```

**Total Time:** ~200-500ms (depending on database performance)

---

## Donasi Masuk Process (Detailed)

### Database Transaction

```sql
-- Pre-validation checks:
SELECT COUNT(*) FROM donatur WHERE id = ?
-- If donatur_id provided, verify exists

-- Create record:
BEGIN TRANSACTION;
INSERT INTO donasi_masuk (
    donatur_id,
    donatur_nama,
    tanggal,
    jenis_donasi,
    kategori_donasi,
    jumlah,
    satuan,
    total,
    keterangan,
    created_at,
    updated_at
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
);
-- Get inserted ID
COMMIT;

-- Optional: Update donatur if first donation
UPDATE donatur SET updated_at = NOW() WHERE id = ?
```

### Data Processing in Controller

```php
// Old Input
$input = [
    'donatur_id' => 5,           // Or null
    'donatur_nama' => 'Budi',    // Display name
    'tanggal' => '2026-04-07',
    'jenis_donasi' => 'Barang',  // Dropdown: Uang/Barang/Makanan
    'kategori_donasi' => 'Infaq', // Dropdown
    'jumlah' => 50,              // Quantity or amount
    'satuan' => 'kg',            // For goods
    'total' => 250000,           // Rp value (if uang, = jumlah)
    'keterangan' => 'Beras untuk ifthar',
];

// Transformation
$processed = [
    'donatur_id' => 5,
    'donatur_nama' => 'Budi',
    'tanggal' => Carbon::parse('2026-04-07'),
    'jenis_donasi' => 'Barang',
    'kategori_donasi' => 'Infaq',
    'jumlah' => 50.00,           // Cast to decimal
    'satuan' => 'kg',
    'total' => 250000.00,        // Rp currency
    'keterangan' => 'Beras untuk ifthar',
];

// Model Attributes (Auto-calculated properties - NOT in DB)
$model->is_barang;      // true (from jenis_donasi)
$model->nilaiDana;      // 250000 (from total)
$model->labelJumlah;    // "50 kg" (formatted)
$model->namaDonatur;    // "Budi" (from donatur relation)
```

### Dashboard Impact

```php
// When dashboard loads (or refreshes cache):

// 1. Sum by jenis_donasi
$byJenis = DbDonasiMasuk::get()->groupBy('jenis_donasi')
    ->map(fn($items) => [
        'jenis' => $items[0]->jenis_donasi,
        'total' => $items->sum('total'),
        'count' => $items->count(),
    ]);

// Example result:
[
    ['jenis' => 'Uang', 'total' => 5000000, 'count' => 25],
    ['jenis' => 'Barang', 'total' => 3500000, 'count' => 15],  // <- New entry
    ['jenis' => 'Makanan', 'total' => 2000000, 'count' => 8],
]

// 2. Pie chart data for frontend
$chartData = [
    'labels' => ['Uang', 'Barang', 'Makanan'],
    'data' => [5000000, 3500000, 2000000],
];

// 3. Widget updates
$totalDonasiMasuk = 10500000;  // Sum of all totals
$jmlDonasiMasuk = 48;          // Total record count
```

---

## Zakat Workflow

### Penerimaan Zakat (Inflow)

#### Diagram

```
Muzakki
  ↓
Check/Retrieve Record
  ├─ Existing → Load
  └─ New → Create
  ↓
Select Zakat Type
  ├─ Zakat Fitrah (Rp/barang per orang)
  ├─ Zakat Maal (per tahun, % harta)
  └─ Zakat Profesi (dari penghasilan)
  ↓
Input Amount/Goods
  ├─ nominal_uang: Rp amount
  └─ nominal_barang: Item type + quantity
  ↓
Create penerimaan_zakat record
  ├─ muzakki_id (FK)
  ├─ tanggal
  ├─ Amounts & descriptions
  └─ Timestamps
  ↓
Calculate Total Value
  ├─ If barang → convert to Rp
  └─ Add to total_zakat_masuk
  ↓
Create kas_masuk Entry (Impact on Finance)
  ├─ Increase total kas
  └─ Record as "Penerimaan Zakat"
  ↓
Dashboard Updated
  └─ Zakat metrics refreshed
```

#### Database Operations

```sql
-- Penerimaan
INSERT INTO penerimaan_zakat (
    muzakki_id,
    tanggal,
    nominal_uang,
    nominal_barang,
    detail_jenis_barang,
    detail_jumlah_barang,
    detail_harga_barang_fitrah,
    keterangan,
    created_at,
    updated_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW());

-- Create related kas_masuk
INSERT INTO kas_masuk (
    tanggal,
    sumber,
    jumlah,
    keterangan,
    created_at,
    updated_at
) VALUES (
    ?,
    'Penerimaan Zakat',
    ? + ?,  -- nominal_uang + converted_barang_value
    ?,
    NOW(),
    NOW()
);
```

### Distribusi Zakat (Outflow)

```
Mustahik (Recipient)Categories
  ├─ Fakir (very poor)
  ├─ Miskin (poor)
  ├─ Amil (zakat officials)
  ├─ Muallaf (new converts)
  ├─ Budak (slaves - historical)
  ├─ Gharim (debtors)
  ├─ Fisabilillah (in path of Allah)
  └─ Ibnu Sabiin (travelers)
  ↓
Select Distribution Method
  ├─ By kategori (equal per category)
  ├─ By individual need
  └─ By program (food, education,health)
  ↓
Input Distribution
  ├─ mustahik_id (individual recipient)
  ├─ tanggal (distribution date)
  ├─ nominal (Rp amount)
  ├─ nominal_barang (if goods)
  └─ harga_barang_fitrah (Rp/unit)
  ↓
Create distribusi_zakat record
  ├─ Update penerimaan_zakat relationship
  └─ Link to source zakat received
  ↓
Create kas_keluar Entry
  ├─ Decrease total kas
  ├─ Record as "Distribusi Zakat"
  └─ Track recipient
  ↓
Dashboard Updated
  ├─ Distribution metrics
  ├─ Mustahik count
  └─ Financial impact
```

---

## Dashboard Data Aggregation

### Caching Strategy

```php
// File: app/Http/Controllers/Admin/DashboardController.php

public function index()
{
    // Try to get from cache first
    $dashboardData = Cache::remember('dashboard-stats', 3600, function () {
        
        // 1. Financial Data Collection (Parallel)
        $kasData = [
            'totalMasuk' => KasMasuk::sum('jumlah'),
            'totalKeluar' => KasKeluar::sum('nominal'),
            'recentMasuk' => KasMasuk::latest()->limit(5)->get(),
            'recentKeluar' => KasKeluar::latest()->limit(5)->get(),
        ];
        
        // 2. Donation Data
        $donasiMasuk = DonasiMasuk::get();
        $donasiData = [
            'totalMasuk' => $donasiMasuk->sum('total'),
            'recentMasuk' => DonasiMasuk::with('donatur')->latest()->limit(5)->get(),
            'byKategori' => $donasiMasuk->groupBy('kategori_donasi')
                ->map(fn($items) => $items->sum('total')),
        ];
        
        // 3. Zakat Data
        $zakatData = [
            'totalPenerimaan' => PenerimaanZakat::sum('nominal_uang'),
            'totalDistribusi' => DistribusiZakat::sum('nominal'),
            'muzakki' => Muzakki::count(),
            'mustahik' => Mustahik::count(),
        ];
        
        // 4. Operational Data
        $kebiatanData = [
            'mendatang' => JadwalKegiatan::where('tanggal', '>', now())->count(),
            'hari_ini' => JadwalKegiatan::whereDate('tanggal', today())->count(),
            'selesai' => JadwalKegiatan::where('tanggal', '<', now())->count(),
        ];
        
        // Compile all
        return compact('kasData', 'donasiData', 'zakatData', 'kebiatanData');
    });
    
    return view('admin.dashboard.index', $dashboardData);
}
```

### Cache Invalidation

```php
// When new donation created:
public function store(StoreRequest $request)
{
    $donasi = DonasiMasuk::create($request->validated());
    
    // Invalidate cache
    Cache::forget('dashboard-stats');
    
    return redirect()->route('donasi.masuk.index')
        ->with('success', 'Donasi berhasil disimpan');
}

// Or tag-based (more sophisticated):
Cache::tags(['dashboard', 'donasi'])->forget('dashboard-stats');
```

---

## Financial Management

### Kas Masuk Sources

```
┌─────────────────────────────────────┐
│        KAS MASUK SOURCES            │
├─────────────────────────────────────┤
│ 1. Direct Manual Entry              │
│    • Sumber: Text field             │
│    • Jumlah: Amount                │
│                                     │
│ 2. From DonasiMasuk                 │
│    • Auto: When donation recorded   │
│    • Sumber: "Donasi Masuk"        │
│                                     │
│ 3. From PenerimaanZakat             │
│    • Auto: From penerimaan record   │
│    • Sumber: "Penerimaan Zakat"    │
│                                     │
│ 4. Other Operational Income         │
│    • Rental fees                    │
│    • Product sales                  │
│    • Investment returns (future)    │
└─────────────────────────────────────┘

Flow:
┌─────────────────────────────┐
│ Multiple Income Sources     │
└────────────┬────────────────┘
             ↓
    ┌────────────────────┐
    │ KasMasuk Table     │
    ├────────────────────┤
    │ id (PK)            │
    │ tanggal            │
    │ sumber             │
    │ jumlah (Decimal)   │
    │ keterangan         │
    │ timestamps         │
    └────────────────────┘
             ↓
    ┌────────────────────┐
    │ Dashboard Widget   │
    │ Total Kas: Rp ... │
    └────────────────────┘
```

### Kas Keluar Tracking

```
┌─────────────────────────────────────┐
│       KAS KELUAR TRACKING           │
├─────────────────────────────────────┤
│ Purpose Categories:                 │
│ • Kegiatan (Activities)             │
│ • Donasi Distribusi                 │
│ • Zakat Distribusi                  │
│ • Operational Costs                 │
│ • Staff Salary                      │
│ • Maintenance & Repairs             │
│ • Administrative Expenses           │
└─────────────────────────────────────┘

Related Records:
KasKeluar ← JadwalKegiatan
           ├─ Activity budgets
           └─ Expense tracking

KasKeluar ← DonasiKeluar
           └─ Donation distribution

KasKeluar ← DistribusiZakat
           └─ Zakat distribution
```

### Financial Summary Calculation

```php
// In DashboardController:

$totalKasMasuk = KasMasuk::sum('jumlah');      // All inflows
$totalKasKeluar = KasKeluar::sum('nominal');   // All outflows
$netBalance = $totalKasMasuk - $totalKasKeluar;

// Monthly breakdown:
$monthlyData = KasMasuk::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, SUM(jumlah) as total')
    ->groupBy('month')
    ->orderBy('month', 'desc')
    ->limit(12)
    ->get();

// By source breakdown:
$bySource = KasMasuk::selectRaw('sumber, SUM(jumlah) as total, COUNT(*) as count')
    ->groupBy('sumber')
    ->orderBy('total', 'desc')
    ->get();

// Output:
[
    ['sumber' => 'Donasi Masuk', 'total' => 10500000, 'count' => 48],
    ['sumber' => 'Penerimaan Zakat', 'total' => 8000000, 'count' => 24],
    ['sumber' => 'Rental Gedung', 'total' => 2000000, 'count' => 4],
]
```

---

## Error Handling & Validation

### Form Request Validation

```php
// File: app/Http/Requests/StoreDonasiMasukRequest.php

class StoreDonasiMasukRequest extends FormRequest
{
    public function authorize()
    {
        // Check user is admin
        return auth()->user()?->is_admin;
    }
    
    public function rules()
    {
        return [
            'donatur_id' => 'nullable|exists:donatur,id',
            'donatur_nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_donasi' => 'required|in:Uang,Barang,Makanan',
            'kategori_donasi' => 'required|in:Infaq,Sedekah,Hibah,Wakaf',
            'jumlah' => 'required|numeric|min:0.01',
            'satuan' => 'nullable|string|max:50',
            'total' => 'required|numeric|min:0.01',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }
    
    public function messages()
    {
        return [
            'donatur_nama.required' => 'Nama & donatur harus diisi',
            'jumlah.min' => 'Jumlah harus lebih dari 0',
            'tanggal.date' => 'Format tanggal tidak valid',
        ];
    }
}
```

### Validation Response

```php
// If validation fails:
// 1. Laravel catches ValidationException
// 2. Redirect back to previous page
// 3. Flash errors to session
// 4. Errors available in Blade:

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

// Or for specific field:
@error('donatur_nama')
    <span class="error">{{ $message }}</span>
@enderror
```

---

## Caching Strategy

### Cache Levels

```
┌───────────────────────────────────────────┐
│ LEVEL 1: HTTP Cache (Browser)            │
│ • Static assets (CSS, JS, Images)        │
│ • Expires: 1 year                        │
│ • Admin pages: disabled (nocache MW)     │
└───────────────────────────────────────────┘
                    ↓
┌───────────────────────────────────────────┐
│ LEVEL 2: Application Cache (Redis/File) │
│ • Dashboard stats: 1 hour                │
│ • Donatur list: 30 minutes               │
│ • Configuration: 24 hours                │
│ • Invalidate on: Create/Update/Delete    │
└───────────────────────────────────────────┘
                    ↓
┌───────────────────────────────────────────┐
│ LEVEL 3: Database Query Cache            │
│ • Lazy loading with relationships        │
│ • N+1 prevention with eager loading      │
│ • Query logging for optimization         │
└───────────────────────────────────────────┘
```

### When to Cache

| Data | TTL | Why | Invalidate |
|------|-----|-----|------------|
| Dashboard stats | 1h | Expensive aggregation | On any transaction |
| Donatur dropdown | 30m | Frequent display | New donatur entry |
| Muzakki list | 30m | Frequent display | New muzakki entry |
| System config | 24h | Rarely changes | Manual refresh |
| Pengurus | 24h | Reference data | Update/create |
| Berita recent | 2h | Content list | New article |

### Invalidation on Transaction

```php
// Example: Clear related caches after donasi creation
public function store(StoreRequest $request)
{
    $donasi = DonasiMasuk::create($request->validated());
    
    // Invalidate affected caches
    Cache::tags(['dashboard', 'donasi'])->flush();
    Cache::forget('dashboard-stats');
    Cache::forget('donasi-summary');
    
    // Optionally: broadcast event for real-time update
    broadcast(new DonasiCreated($donasi))->toOthers();
    
    return redirect()->route('donasi.masuk.index')
        ->with('success', 'Berhasil disimpan');
}
```

---

**Document Version:** 1.0  
**Created:** April 2026  
**Purpose:** Detailed Workflow Documentation for DKM Masjid
