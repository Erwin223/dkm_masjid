@extends('layouts.admin')

@section('title', 'Statistik — DKM Masjid')
@section('page-title', 'Statistik & Analitik')
@include('admin.statistik._styles')

@push('styles')

@endpush

@section('content')
@php
    $totalRevenue = array_sum($donasiPerBulan ?? []) + array_sum($zakatPerBulan ?? []);
    $totalTrx     = ($ringkasan['donasi_count'] ?? 0) + ($ringkasan['zakat_count'] ?? 0);
    $avgBulanan   = $totalRevenue / max(count($donasiPerBulan ?? [1]), 1);

    $topKategoriLabel = $donasiKategoriLabel[0] ?? '-';
    $topKategoriValue = $donasiKategoriData[0]  ?? 0;
    $topJenisLabel    = $zakatJenisLabel[0] ?? '-';
    $topJenisValue    = $zakatJenisData[0]  ?? 0;
    $topDonasiMetode  = $donasiMetodeLabel[0] ?? '-';
    $topDonasiMetodeCt= $donasiMetodeData[0]  ?? 0;
    $topZakatMetode   = $zakatMetodeLabel[0] ?? '-';
    $topZakatMetodeCt = $zakatMetodeData[0]  ?? 0;

    $totalKategoriVal = max(array_sum($donasiKategoriData ?? []), 1);
    $totalJenisVal    = max(array_sum($zakatJenisData ?? []), 1);
@endphp

<div class="stat-page">

    {{-- ① HERO ──────────────────────────────────────────── --}}
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fa fa-arrow-left"></i> Dashboard
        </a>
        <span style="color:#d1d5db;font-size:18px;">|</span>
        <span style="font-size:13px;color:#9ca3af;">Statistik Donasi & Zakat</span>
    </div>

    <div class="stat-hero">
        <div class="stat-hero-left">
            <div class="stat-hero-tag"><span></span> Live Analytics</div>
            <h1>Statistik Donasi &amp; Zakat</h1>
            <p>Pantau tren pemasukan, komposisi kategori, dan metode pembayaran secara visual.</p>
        </div>
        <div class="stat-hero-kpis">
            <div class="kpi-pill">
                <div class="kpi-pill-label">Total Donasi</div>
                <div class="kpi-pill-value">Rp {{ number_format($ringkasan['total_donasi'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-pill-sub">{{ $ringkasan['donasi_count'] ?? 0 }} transaksi</div>
            </div>
            <div class="kpi-pill">
                <div class="kpi-pill-label">Total Zakat</div>
                <div class="kpi-pill-value">Rp {{ number_format($ringkasan['total_zakat'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-pill-sub">{{ $ringkasan['zakat_count'] ?? 0 }} transaksi</div>
            </div>
            <div class="kpi-pill">
                <div class="kpi-pill-label">Total Kas Masuk</div>
                <div class="kpi-pill-value">Rp {{ number_format($ringkasan['total_kas_masuk'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-pill-sub">Kas masuk</div>
            </div>
            <div class="kpi-pill">
                <div class="kpi-pill-label">Total Kas Keluar</div>
                <div class="kpi-pill-value">Rp {{ number_format($ringkasan['total_kas_keluar'] ?? 0, 0, ',', '.') }}</div>
                <div class="kpi-pill-sub">Kas keluar</div>
            </div>
        </div>
    </div>

    {{-- ② KPI CARDS ──────────────────────────────────────── --}}
    <div class="stat-summary-row">
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#d1fae5;color:#065f46;"><i class="fa fa-money-bill-wave"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Total Pemasukan</div>
                <div class="stat-sum-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-sum-sub">Donasi + Zakat 6 bulan</div>
            </div>
        </div>
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#dbeafe;color:#1e40af;"><i class="fa fa-chart-line"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Rata-rata Bulanan</div>
                <div class="stat-sum-value">Rp {{ number_format($avgBulanan, 0, ',', '.') }}</div>
                <div class="stat-sum-sub">Per bulan (6 bulan terakhir)</div>
            </div>
        </div>
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#dcfce7;color:#15803d;"><i class="fa fa-arrow-down"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Total Kas Masuk</div>
                <div class="stat-sum-value">Rp {{ number_format($ringkasan['total_kas_masuk'] ?? 0, 0, ',', '.') }}</div>
                <div class="stat-sum-sub">Seluruh pemasukan kas</div>
            </div>
        </div>
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#fee2e2;color:#b91c1c;"><i class="fa fa-arrow-up"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Total Kas Keluar</div>
                <div class="stat-sum-value">Rp {{ number_format($ringkasan['total_kas_keluar'] ?? 0, 0, ',', '.') }}</div>
                <div class="stat-sum-sub">Seluruh pengeluaran kas</div>
            </div>
        </div>
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#fef3c7;color:#92400e;"><i class="fa fa-tag"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Top Kategori Donasi</div>
                <div class="stat-sum-value" style="font-size:15px;">{{ $topKategoriLabel }}</div>
                <div class="stat-sum-sub">Rp {{ number_format($topKategoriValue, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="stat-sum-card">
            <div class="stat-sum-icon" style="background:#ede9fe;color:#5b21b6;"><i class="fa fa-mosque"></i></div>
            <div class="stat-sum-body">
                <div class="stat-sum-label">Top Jenis Zakat</div>
                <div class="stat-sum-value" style="font-size:15px;">{{ $topJenisLabel }}</div>
                <div class="stat-sum-sub">Rp {{ number_format($topJenisValue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- ③ MAIN GRID ─────────────────────────────────────── --}}
    <div class="stat-grid">

        {{-- LEFT COLUMN --}}
        <div>

            {{-- Tren Line Chart --}}
            <div class="chart-card">
                <div class="chart-card-head">
                    <div>
                        <div class="chart-card-title-label">6 Bulan Terakhir</div>
                        <h2 class="chart-card-title">Tren Donasi vs Zakat</h2>
                    </div>
                    <div class="chart-badge-row">
                        <span class="chart-badge chart-badge-green"><i class="fa fa-circle" style="font-size:8px;"></i> Donasi</span>
                        <span class="chart-badge chart-badge-blue"><i class="fa fa-circle" style="font-size:8px;"></i> Zakat</span>
                    </div>
                </div>
                <div class="chart-canvas-wrap chart-canvas-wrap-line">
                    <canvas id="chartTren"></canvas>
                </div>
            </div>

            {{-- Tren Kas Line Chart --}}
            <div class="chart-card">
                <div class="chart-card-head">
                    <div>
                        <div class="chart-card-title-label">6 Bulan Terakhir</div>
                        <h2 class="chart-card-title">Tren Kas Masuk vs Kas Keluar</h2>
                    </div>
                    <div class="chart-badge-row">
                        <span class="chart-badge chart-badge-green"><i class="fa fa-circle" style="font-size:8px;"></i> Kas Masuk</span>
                        <span class="chart-badge chart-badge-red"><i class="fa fa-circle" style="font-size:8px;"></i> Kas Keluar</span>
                    </div>
                </div>
                <div class="chart-canvas-wrap chart-canvas-wrap-line">
                    <canvas id="chartTrenKas"></canvas>
                </div>
            </div>

            {{-- Metode Row --}}
            <div class="chart-row-2">
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Metode</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Metode Donasi</h3>
                        </div>
                        <span class="chart-badge chart-badge-amber">{{ count($donasiMetodeLabel ?? []) }} jenis</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-donut">
                        <canvas id="chartMetodeDonasi" style="max-width:190px;max-height:190px;"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Metode</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Metode Zakat</h3>
                        </div>
                        <span class="chart-badge chart-badge-blue">{{ count($zakatMetodeLabel ?? []) }} jenis</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-donut">
                        <canvas id="chartMetodeZakat" style="max-width:190px;max-height:190px;"></canvas>
                    </div>
                </div>
            </div>

            {{-- Kategori & Jenis Row --}}
            <div class="chart-row-3">
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Distribusi</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Kategori Donasi</h3>
                        </div>
                        <span class="chart-badge chart-badge-green">{{ count($donasiKategoriLabel ?? []) }} kategori</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-donut">
                        <canvas id="chartKategoriDonasi" style="max-width:190px;max-height:190px;"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Nominal</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Jenis Zakat</h3>
                        </div>
                        <span class="chart-badge chart-badge-purple">{{ count($zakatJenisLabel ?? []) }} jenis</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-bar">
                        <canvas id="chartJenisZakat"></canvas>
                    </div>
                </div>
            </div>

            {{-- Kas Row --}}
            <div class="chart-row-2">
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Sumber</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Kas Masuk per Sumber</h3>
                        </div>
                        <span class="chart-badge chart-badge-green">{{ count($kasMasukSumberLabel ?? []) }} sumber</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-donut">
                        <canvas id="chartKasMasukSumber" style="max-width:190px;max-height:190px;"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-card-head">
                        <div>
                            <div class="chart-card-title-label">Jenis</div>
                            <h3 class="chart-card-title" style="font-size:15px;">Kas Keluar per Jenis</h3>
                        </div>
                        <span class="chart-badge chart-badge-red">{{ count($kasKeluarJenisLabel ?? []) }} jenis</span>
                    </div>
                    <div class="chart-canvas-wrap chart-canvas-wrap-donut">
                        <canvas id="chartKasKeluarJenis" style="max-width:190px;max-height:190px;"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT ASIDE --}}
        <div class="stat-aside">

            {{-- Ringkasan Utama --}}
            <div class="aside-card">
                <div class="aside-title-label">Ringkasan</div>
                <p class="aside-title">Fokus Utama</p>

                <div class="aside-item" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <div class="aside-item-label" style="color:#065f46;">Total Pemasukan (6 Bln)</div>
                    <div class="aside-item-value" style="color:#065f46;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">Donasi + Zakat gabungan</div>
                </div>
                <div class="aside-item">
                    <div class="aside-item-label">Total Donasi</div>
                    <div class="aside-item-value">Rp {{ number_format($ringkasan['total_donasi'] ?? 0, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">{{ $ringkasan['donasi_count'] ?? 0 }} transaksi</div>
                </div>
                <div class="aside-item">
                    <div class="aside-item-label">Total Zakat</div>
                    <div class="aside-item-value">Rp {{ number_format($ringkasan['total_zakat'] ?? 0, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">{{ $ringkasan['zakat_count'] ?? 0 }} transaksi</div>
                </div>
                <div class="aside-item" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="aside-item-label" style="color:#1e40af;">Rata-rata Bulanan</div>
                    <div class="aside-item-value" style="color:#1e40af;">Rp {{ number_format($avgBulanan, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">Per bulan selama 6 bulan terakhir</div>
                </div>
            </div>

            {{-- Top Kategori Donasi --}}
            <div class="aside-card">
                <div class="aside-title-label">Ranking</div>
                <p class="aside-title">Top Kategori Donasi</p>
                @if(count($donasiKategoriLabel ?? []))
                <div class="rank-bar-wrap">
                    @foreach($donasiKategoriLabel as $i => $label)
                    @php
                        $val = $donasiKategoriData[$i] ?? 0;
                        $pct = $totalKategoriVal > 0 ? round($val / $totalKategoriVal * 100) : 0;
                        $colors = ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'];
                        $c = $colors[$i % count($colors)];
                    @endphp
                    <div class="rank-item">
                        <div class="rank-num">{{ $i+1 }}</div>
                        <div class="rank-info">
                            <div class="rank-name">{{ $label ?: 'Tidak diisi' }}</div>
                            <div class="rank-bar-track">
                                <div class="rank-bar-fill js-rank-bar" data-width="{{ $pct }}" data-color="{{ $c }}"></div>
                            </div>
                        </div>
                        <div class="rank-val">{{ $pct }}%</div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="color:#9ca3af;font-size:13px;text-align:center;padding:16px 0;">Belum ada data kategori</p>
                @endif
            </div>

            {{-- Top Jenis Zakat --}}
            <div class="aside-card">
                <div class="aside-title-label">Ranking</div>
                <p class="aside-title">Top Jenis Zakat</p>
                @if(count($zakatJenisLabel ?? []))
                <div class="rank-bar-wrap">
                    @foreach($zakatJenisLabel as $i => $label)
                    @php
                        $val = $zakatJenisData[$i] ?? 0;
                        $pct = $totalJenisVal > 0 ? round($val / $totalJenisVal * 100) : 0;
                        $colors2 = ['#8b5cf6','#0ea5e9','#f59e0b','#10b981','#ef4444','#ec4899'];
                        $c2 = $colors2[$i % count($colors2)];
                    @endphp
                    <div class="rank-item">
                        <div class="rank-num">{{ $i+1 }}</div>
                        <div class="rank-info">
                            <div class="rank-name">{{ $label ?: 'Tidak diisi' }}</div>
                            <div class="rank-bar-track">
                                <div class="rank-bar-fill js-rank-bar" data-width="{{ $pct }}" data-color="{{ $c2 }}"></div>
                            </div>
                        </div>
                        <div class="rank-val">{{ $pct }}%</div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="color:#9ca3af;font-size:13px;text-align:center;padding:16px 0;">Belum ada data jenis zakat</p>
                @endif
            </div>

            {{-- Metode Populer --}}
            <div class="aside-card">
                <div class="aside-title-label">Info</div>
                <p class="aside-title">Metode Terpopuler</p>
                <div class="aside-item" style="background:#fff7ed;border:1px solid #fed7aa;">
                    <div class="aside-item-label" style="color:#92400e;">Donasi</div>
                    <div class="aside-item-value" style="color:#92400e;">{{ $topDonasiMetode ?: '-' }}</div>
                    <div class="aside-item-sub">{{ number_format($topDonasiMetodeCt, 0, ',', '.') }} transaksi</div>
                </div>
                <div class="aside-item" style="background:#eff6ff;border:1px solid #bfdbfe;">
                    <div class="aside-item-label" style="color:#1e40af;">Zakat</div>
                    <div class="aside-item-value" style="color:#1e40af;">{{ $topZakatMetode ?: '-' }}</div>
                    <div class="aside-item-sub">{{ number_format($topZakatMetodeCt, 0, ',', '.') }} transaksi</div>
                </div>
            </div>

            {{-- Kas Masuk Widget --}}
            <div class="aside-card">
                <div class="aside-title-label">Keuangan</div>
                <p class="aside-title">Kas Masuk</p>
                <div class="aside-item" style="background:#dcfce7;border:1px solid #86efac;">
                    <div class="aside-item-label" style="color:#15803d;">Total Kas Masuk</div>
                    <div class="aside-item-value" style="color:#15803d;">Rp {{ number_format($ringkasan['total_kas_masuk'] ?? 0, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">{{ $ringkasan['kas_masuk_count'] ?? 0 }} transaksi</div>
                </div>
            </div>

            {{-- Kas Keluar Widget --}}
            <div class="aside-card">
                <div class="aside-title-label">Keuangan</div>
                <p class="aside-title">Kas Keluar</p>
                <div class="aside-item" style="background:#fee2e2;border:1px solid #fca5a5;">
                    <div class="aside-item-label" style="color:#b91c1c;">Total Kas Keluar</div>
                    <div class="aside-item-value" style="color:#b91c1c;">Rp {{ number_format($ringkasan['total_kas_keluar'] ?? 0, 0, ',', '.') }}</div>
                    <div class="aside-item-sub">{{ $ringkasan['kas_keluar_count'] ?? 0 }} transaksi</div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script type="application/json" id="statistik-chart-data">
{
    "bulanList": @json($bulanList ?? []),
    "donasiPerBulan": @json($donasiPerBulan ?? []),
    "zakatPerBulan": @json($zakatPerBulan ?? []),
    "kasMasukPerBulan": @json($kasMasukPerBulan ?? []),
    "kasKeluarPerBulan": @json($kasKeluarPerBulan ?? []),
    "donasiMetodeLabel": @json($donasiMetodeLabel ?? []),
    "donasiMetodeData": @json($donasiMetodeData ?? []),
    "zakatMetodeLabel": @json($zakatMetodeLabel ?? []),
    "zakatMetodeData": @json($zakatMetodeData ?? []),
    "donasiKategoriLabel": @json($donasiKategoriLabel ?? []),
    "donasiKategoriData": @json($donasiKategoriData ?? []),
    "zakatJenisLabel": @json($zakatJenisLabel ?? []),
    "zakatJenisData": @json($zakatJenisData ?? []),
    "kasMasukSumberLabel": @json($kasMasukSumberLabel ?? []),
    "kasMasukSumberData": @json($kasMasukSumberData ?? []),
    "kasKeluarJenisLabel": @json($kasKeluarJenisLabel ?? []),
    "kasKeluarJenisData": @json($kasKeluarJenisData ?? [])
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-rank-bar').forEach(function (bar) {
        bar.style.width = (bar.dataset.width || 0) + '%';
        bar.style.background = bar.dataset.color || '#10b981';
    });

    const statistikChartDataEl = document.getElementById('statistik-chart-data');
    const statistikChartData = statistikChartDataEl ? JSON.parse(statistikChartDataEl.textContent) : {};

    /* ── shared defaults ──────────────────────────── */
    Chart.defaults.font.family = "'Segoe UI', 'Inter', sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#6b7280';

    const rp = v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v);

    /* ── ① Tren line chart ───────────────────────── */
    const ctxLine = document.getElementById('chartTren').getContext('2d');
    const gDonasi = ctxLine.createLinearGradient(0, 0, 0, 260);
    gDonasi.addColorStop(0, 'rgba(16,185,129,0.25)');
    gDonasi.addColorStop(1, 'rgba(16,185,129,0)');
    const gZakat  = ctxLine.createLinearGradient(0, 0, 0, 260);
    gZakat.addColorStop(0, 'rgba(59,130,246,0.22)');
    gZakat.addColorStop(1, 'rgba(59,130,246,0)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: statistikChartData.bulanList || [],
            datasets: [
                {
                    label: 'Donasi',
                    data: statistikChartData.donasiPerBulan || [],
                    backgroundColor: gDonasi,
                    borderColor: '#10b981',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    tension: 0.38,
                    fill: true,
                },
                {
                    label: 'Zakat',
                    data: statistikChartData.zakatPerBulan || [],
                    backgroundColor: gZakat,
                    borderColor: '#3b82f6',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    tension: 0.38,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f3f4f6',
                    bodyColor:  '#d1d5db',
                    padding: 12,
                    callbacks: { label: c => ' ' + c.dataset.label + ': ' + rp(c.parsed.y) }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(229,231,235,0.8)' },
                    ticks: {
                        callback: v => v >= 1e6 ? 'Rp ' + (v/1e6).toFixed(1) + 'Jt'
                                      : v >= 1e3 ? 'Rp ' + (v/1e3).toFixed(0) + 'Rb'
                                      : 'Rp ' + v
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });

    /* ── Tren Kas Masuk vs Kas Keluar ────────────── */
    const ctxKas = document.getElementById('chartTrenKas').getContext('2d');
    const gKasMasuk = ctxKas.createLinearGradient(0, 0, 0, 260);
    gKasMasuk.addColorStop(0, 'rgba(16,185,129,0.25)');
    gKasMasuk.addColorStop(1, 'rgba(16,185,129,0)');
    const gKasKeluar  = ctxKas.createLinearGradient(0, 0, 0, 260);
    gKasKeluar.addColorStop(0, 'rgba(239,68,68,0.22)');
    gKasKeluar.addColorStop(1, 'rgba(239,68,68,0)');

    new Chart(ctxKas, {
        type: 'line',
        data: {
            labels: statistikChartData.bulanList || [],
            datasets: [
                {
                    label: 'Kas Masuk',
                    data: statistikChartData.kasMasukPerBulan || [],
                    backgroundColor: gKasMasuk,
                    borderColor: '#10b981',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    tension: 0.38,
                    fill: true,
                },
                {
                    label: 'Kas Keluar',
                    data: statistikChartData.kasKeluarPerBulan || [],
                    backgroundColor: gKasKeluar,
                    borderColor: '#ef4444',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ef4444',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    tension: 0.38,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f3f4f6',
                    bodyColor:  '#d1d5db',
                    padding: 12,
                    callbacks: { label: c => ' ' + c.dataset.label + ': ' + rp(c.parsed.y) }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(229,231,235,0.8)' },
                    ticks: {
                        callback: v => v >= 1e6 ? 'Rp ' + (v/1e6).toFixed(1) + 'Jt'
                                      : v >= 1e3 ? 'Rp ' + (v/1e3).toFixed(0) + 'Rb'
                                      : 'Rp ' + v
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });

    /* ── doughnut factory ────────────────────────── */
    const mkDoughnut = (id, labels, data, colors) => {
        const allZero = !data || data.every(v => v === 0);
        new Chart(document.getElementById(id), {
            type: 'doughnut',
            data: {
                labels: allZero ? ['Belum ada data'] : labels,
                datasets: [{
                    data: allZero ? [1] : data,
                    backgroundColor: allZero ? ['#e5e7eb'] : colors,
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 11, padding: 10, font: { size: 11 } } },
                    tooltip: {
                        enabled: !allZero,
                        backgroundColor: '#1f2937',
                        titleColor: '#f3f4f6',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        callbacks: {
                            label: c => ' ' + c.label + ': ' + new Intl.NumberFormat('id-ID').format(c.parsed)
                        }
                    }
                }
            }
        });
    };

    mkDoughnut('chartMetodeDonasi',
        statistikChartData.donasiMetodeLabel || [],
        statistikChartData.donasiMetodeData || [],
        ['#f59e0b','#10b981','#ef4444','#8b5cf6','#06b6d4','#ec4899']
    );
    mkDoughnut('chartMetodeZakat',
        statistikChartData.zakatMetodeLabel || [],
        statistikChartData.zakatMetodeData || [],
        ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4']
    );
    mkDoughnut('chartKategoriDonasi',
        statistikChartData.donasiKategoriLabel || [],
        statistikChartData.donasiKategoriData || [],
        ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899']
    );
    mkDoughnut('chartKasMasukSumber',
        statistikChartData.kasMasukSumberLabel || [],
        statistikChartData.kasMasukSumberData || [],
        ['#10b981','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899']
    );
    mkDoughnut('chartKasKeluarJenis',
        statistikChartData.kasKeluarJenisLabel || [],
        statistikChartData.kasKeluarJenisData || [],
        ['#ef4444','#f59e0b','#3b82f6','#10b981','#8b5cf6','#06b6d4','#ec4899']
    );

    /* ── ⑤ Jenis Zakat horizontal bar ───────────── */
    const zakatLabels = statistikChartData.zakatJenisLabel || [];
    const zakatData   = statistikChartData.zakatJenisData || [];
    const allZeroZ    = !zakatData || zakatData.every(v => v === 0);

    new Chart(document.getElementById('chartJenisZakat'), {
        type: 'bar',
        data: {
            labels: allZeroZ ? ['Belum ada data'] : zakatLabels,
            datasets: [{
                data: allZeroZ ? [0] : zakatData,
                backgroundColor: ['#8b5cf6','#0ea5e9','#f59e0b','#10b981','#ef4444','#ec4899'],
                borderRadius: 8,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f3f4f6',
                    bodyColor: '#d1d5db',
                    padding: 10,
                    callbacks: { label: c => ' ' + rp(c.parsed.x) }
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: { color: 'rgba(229,231,235,0.8)' },
                    ticks: {
                        callback: v => v >= 1e6 ? (v/1e6).toFixed(1)+'Jt'
                                      : v >= 1e3 ? (v/1e3).toFixed(0)+'Rb'
                                      : v
                    }
                },
                y: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush
