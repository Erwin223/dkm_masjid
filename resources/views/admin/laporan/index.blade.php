@extends('layouts.admin')

@section('page-title', 'Laporan')
@section('title', $reportDocumentTitle)

@push('styles')
<style>
.report-page { display:flex; flex-direction:column; gap:24px; padding:8px 0 28px; }
.report-hero, .report-filter-card, .report-section, .report-table-card, .report-sign-card { background:#fff; border:1px solid #e5efe9; border-radius:20px; box-shadow:0 14px 28px rgba(15,23,42,.05); }
.report-hero { background:linear-gradient(135deg,#0f8b6d 0%,#0e7a5e 60%,#085041 100%); color:#fff; padding:28px 30px; display:flex; justify-content:space-between; align-items:flex-start; gap:18px; flex-wrap:wrap; }
.report-hero-label { display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:999px; font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; background:rgba(255,255,255,.14); margin-bottom:12px; }
.report-hero-title { font-size:28px; font-weight:800; margin:0 0 8px; }
.report-hero-subtitle { font-size:13px; line-height:1.6; color:rgba(255,255,255,.82); margin:0; max-width:760px; }
.report-hero-meta { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:10px; min-width:320px; }
.report-meta-card { border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.12); border-radius:16px; padding:14px 16px; }
.report-meta-label { font-size:10px; letter-spacing:.08em; text-transform:uppercase; color:rgba(255,255,255,.72); margin-bottom:6px; }
.report-meta-value { font-size:15px; font-weight:700; color:#fff; }
.report-filter-card { padding:20px; }
.report-module-nav { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:12px; margin-bottom:16px; }
.report-module-link { border:1px solid #dbe4de; border-radius:16px; padding:14px 16px; text-decoration:none; background:#fff; color:#111827; transition:.2s ease; }
.report-module-link:hover { border-color:#0f8b6d; background:#f6fcf9; transform:translateY(-1px); }
.report-module-link.active { border-color:#0f8b6d; background:#0f8b6d; color:#fff; box-shadow:0 14px 24px rgba(15,139,109,.18); }
.report-module-label { font-size:10px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; opacity:.72; margin-bottom:6px; }
.report-module-title { font-size:14px; font-weight:800; margin-bottom:4px; }
.report-module-note { font-size:12px; line-height:1.45; color:#6b7280; }
.report-module-link.active .report-module-note { color:rgba(255,255,255,.82); }
.report-filter-form { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:14px; align-items:end; }
.report-field { display:flex; flex-direction:column; gap:8px; }
.report-field label { font-size:12px; font-weight:700; color:#374151; }
.report-field input, .report-field select { height:42px; border:1px solid #d1d5db; border-radius:12px; padding:0 14px; font-size:13px; background:#fff; color:#111827; }
.report-actions { display:flex; gap:10px; flex-wrap:wrap; }
.report-btn { height:42px; border-radius:12px; border:none; padding:0 16px; font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px; text-decoration:none; cursor:pointer; }
.report-btn-primary { background:#0f8b6d; color:#fff; }
.report-btn-primary:hover { background:#0c6d55; }
.report-btn-light { background:#f3f4f6; color:#111827; }
.report-btn-light:hover { background:#e5e7eb; }
.report-btn-accent { background:#eef6ff; color:#1d4ed8; }
.report-btn-accent:hover { background:#dbeafe; }
.report-summary-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:14px; }
.report-summary-card { background:#fff; border:1px solid #e5efe9; border-radius:18px; padding:18px 20px; box-shadow:0 14px 28px rgba(15,23,42,.05); }
.report-summary-label { font-size:11px; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:#9ca3af; margin-bottom:8px; }
.report-summary-value { font-size:24px; font-weight:800; color:#111827; margin-bottom:6px; line-height:1.2; }
.report-summary-note { font-size:12px; color:#6b7280; }
.is-positive { color:#198754; }
.is-negative { color:#dc3545; }
.report-section { padding:22px; display:flex; flex-direction:column; gap:18px; }
.report-section-head { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap; }
.report-section-label { font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#9ca3af; margin-bottom:5px; }
.report-section-title { font-size:20px; font-weight:800; color:#111827; margin:0; }
.report-section-subtitle { font-size:13px; color:#6b7280; margin:6px 0 0; }
.report-chip-row { display:flex; gap:10px; flex-wrap:wrap; }
.report-chip { border-radius:999px; padding:8px 12px; font-size:12px; font-weight:700; }
.report-chip-green { background:#e8f6ee; color:#198754; }
.report-chip-red { background:#fdecec; color:#b02a37; }
.report-chip-blue { background:#eef0fd; color:#4361ee; }
.report-table-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; }
.report-table-card { padding:18px; }
.report-table-head { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:14px; flex-wrap:wrap; }
.report-table-title { font-size:16px; font-weight:800; color:#111827; margin:0; }
.report-table-total { font-size:12px; font-weight:700; color:#0f8b6d; background:#e8f6ee; border-radius:999px; padding:7px 12px; }
.report-table-total.is-outgoing { color:#b02a37; background:#fdecec; }
.report-table-wrap { overflow-x:auto; }
.report-table { width:100%; min-width:620px; border-collapse:collapse; }
.report-table th, .report-table td { padding:10px 12px; border-bottom:1px solid #eef2f7; font-size:13px; text-align:left; vertical-align:top; white-space:nowrap; }
.report-table th { font-size:12px; font-weight:700; color:#6b7280; background:#f8fafc; }
.report-empty, .is-muted { color:#9ca3af; }
.report-empty { text-align:center; padding:22px 12px; font-size:13px; }
.report-signature { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
.report-sign-card { padding:22px; min-height:150px; border-style:dashed; }
.report-sign-title { font-size:13px; font-weight:700; color:#374151; margin-bottom:14px; }
.report-sign-space { height:56px; }
.report-sign-line { border-top:1px solid #9ca3af; padding-top:8px; font-size:12px; color:#6b7280; }
.report-print-note { font-size:11px; color:#6b7280; margin-top:10px; }
@media (max-width:1180px) { .report-module-nav, .report-filter-form, .report-summary-grid, .report-table-grid, .report-hero-meta { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width:768px) {
    .report-module-nav, .report-filter-form, .report-summary-grid, .report-table-grid, .report-signature, .report-hero-meta { grid-template-columns:1fr; }
    .report-actions { width:100%; }
    .report-btn { width:100%; justify-content:center; }
}
</style>
@endpush

@section('content')
<div class="report-page">
    <section class="report-hero">
        <div>
            <div class="report-hero-label"><i class="fa fa-file-lines"></i> Modul Laporan</div>
            <h1 class="report-hero-title">{{ $activeReport['title'] }} {{ $namaMasjid }}</h1>
            <p class="report-hero-subtitle">Halaman ringkasan semua laporan, sedangkan laporan kas, donasi, zakat, dan kegiatan dipisahkan menjadi halaman khusus yang masih memakai tampilan yang sama.</p>
        </div>
        <div class="report-hero-meta">
            <div class="report-meta-card">
                <div class="report-meta-label">Jenis Laporan</div>
                <div class="report-meta-value">{{ $activeReport['title'] }}</div>
            </div>
            <div class="report-meta-card">
                <div class="report-meta-label">Periode Laporan</div>
                <div class="report-meta-value">{{ $periodLabel }}</div>
            </div>
            <div class="report-meta-card">
                <div class="report-meta-label">Dibuat Pada</div>
                <div class="report-meta-value">{{ $generatedAt->translatedFormat('d M Y H:i') }}</div>
            </div>
        </div>
    </section>

    <section class="report-filter-card">
        <div class="report-module-nav">
            <a href="{{ route('admin.laporan.index', request()->except('page')) }}" class="report-module-link {{ $reportType === 'ringkasan' ? 'active' : '' }}">
                <div class="report-module-label">Modul Laporan</div>
                <div class="report-module-title">Ringkasan</div>
                <div class="report-module-note">Halaman index tetap merangkum seluruh laporan dalam satu tampilan.</div>
            </a>
            <a href="{{ route('admin.laporan.kas', request()->except('page')) }}" class="report-module-link {{ $reportType === 'kas' ? 'active' : '' }}">
                <div class="report-module-label">Modul Laporan</div>
                <div class="report-module-title">Laporan Kas</div>
                <div class="report-module-note">Fokus pada kas masuk, kas keluar, dan saldo kas masjid.</div>
            </a>
            <a href="{{ route('admin.laporan.donasi', request()->except('page')) }}" class="report-module-link {{ $reportType === 'donasi' ? 'active' : '' }}">
                <div class="report-module-label">Modul Laporan</div>
                <div class="report-module-title">Laporan Donasi</div>
                <div class="report-module-note">Menampilkan donasi masuk, donasi keluar, dan saldonya.</div>
            </a>
            <a href="{{ route('admin.laporan.zakat', request()->except('page')) }}" class="report-module-link {{ $reportType === 'zakat' ? 'active' : '' }}">
                <div class="report-module-label">Modul Laporan</div>
                <div class="report-module-title">Laporan Zakat</div>
                <div class="report-module-note">Menampilkan penerimaan dan distribusi zakat dalam halaman khusus.</div>
            </a>
            <a href="{{ route('admin.laporan.kegiatan', request()->except('page')) }}" class="report-module-link {{ $reportType === 'kegiatan' ? 'active' : '' }}">
                <div class="report-module-label">Modul Laporan</div>
                <div class="report-module-title">Laporan Kegiatan</div>
                <div class="report-module-note">Menampilkan daftar kegiatan, estimasi anggaran, dan realisasi.</div>
            </a>
        </div>

        <form method="GET" action="{{ $reportType === 'ringkasan' ? route('admin.laporan.index') : route('admin.laporan.' . $reportType) }}" class="report-filter-form">
            <div class="report-field">
                <label for="preset">Preset Periode</label>
                <select name="preset" id="preset">
                    <option value="today" {{ $preset === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="this_month" {{ $preset === 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="this_year" {{ $preset === 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="last_30_days" {{ $preset === 'last_30_days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="custom" {{ $preset === 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
            </div>
            <div class="report-field">
                <label for="date_from">Tanggal Awal</label>
                <input type="date" name="date_from" id="date_from" value="{{ $dateFrom->format('Y-m-d') }}">
            </div>
            <div class="report-field">
                <label for="date_to">Tanggal Akhir</label>
                <input type="date" name="date_to" id="date_to" value="{{ $dateTo->format('Y-m-d') }}">
            </div>
            <div class="report-field">
                <label for="jumlah_transaksi">Total Transaksi</label>
                <input type="text" id="jumlah_transaksi" value="{{ number_format($activeReport['transaksi_total'], 0, ',', '.') }} transaksi" readonly>
            </div>
            <div class="report-actions">
                <button type="submit" class="report-btn report-btn-primary"><i class="fa fa-filter"></i> Tampilkan</button>
                <a href="{{ $reportType === 'ringkasan' ? route('admin.laporan.index') : route('admin.laporan.' . $reportType) }}" class="report-btn report-btn-light"><i class="fa fa-rotate-left"></i> Reset</a>
                <button type="button" class="report-btn {{ $reportType === 'kegiatan' ? 'report-btn-accent' : 'report-btn-light' }}" onclick="printReportMode()">
                    <i class="fa {{ $reportType === 'kegiatan' ? 'fa-table' : 'fa-print' }}"></i>
                    Print {{ $activeReport['title'] }}
                </button>
            </div>
        </form>
        <div class="report-print-note">Gunakan halaman `Ringkasan` untuk melihat semua laporan sekaligus. Pilih modul di atas jika ingin laporan kas, donasi, zakat, atau kegiatan secara terpisah.</div>
    </section>

    @if($reportType === 'ringkasan')
    <section class="report-summary-grid">
        <div class="report-summary-card">
            <div class="report-summary-label">Total Pemasukan</div>
            <div class="report-summary-value is-positive">Rp {{ number_format($overallSummary['masuk_total'], 0, ',', '.') }}</div>
            <div class="report-summary-note">Akumulasi kas masuk, donasi masuk, dan penerimaan zakat.</div>
        </div>
        <div class="report-summary-card">
            <div class="report-summary-label">Total Pengeluaran</div>
            <div class="report-summary-value is-negative">Rp {{ number_format($overallSummary['keluar_total'], 0, ',', '.') }}</div>
            <div class="report-summary-note">Akumulasi kas keluar, donasi keluar, dan distribusi zakat.</div>
        </div>
        <div class="report-summary-card">
            <div class="report-summary-label">Saldo Bersih</div>
            <div class="report-summary-value {{ $overallSummary['saldo'] >= 0 ? 'is-positive' : 'is-negative' }}">
                {{ $overallSummary['saldo'] < 0 ? '-Rp ' : 'Rp ' }}{{ number_format(abs($overallSummary['saldo']), 0, ',', '.') }}
            </div>
            <div class="report-summary-note">Selisih seluruh pemasukan dan pengeluaran pada periode laporan.</div>
        </div>
        <div class="report-summary-card">
            <div class="report-summary-label">Total Transaksi</div>
            <div class="report-summary-value">{{ number_format($overallSummary['transaksi_total'], 0, ',', '.') }}</div>
            <div class="report-summary-note">Jumlah seluruh transaksi yang masuk laporan periode ini.</div>
        </div>
    </section>
    @endif

    @if(in_array($reportType, ['ringkasan', 'kas']))
    <section class="report-section" id="laporan-kas">
        <div class="report-section-head">
            <div>
                <div class="report-section-label">Laporan Keuangan</div>
                <h2 class="report-section-title">Kas Masjid</h2>
                <p class="report-section-subtitle">Ringkasan transaksi kas masuk dan kas keluar pada periode terpilih.</p>
            </div>
            <div class="report-chip-row">
                <span class="report-chip report-chip-green">{{ $kasSummary['masuk_count'] }} kas masuk</span>
                <span class="report-chip report-chip-red">{{ $kasSummary['keluar_count'] }} kas keluar</span>
                <span class="report-chip report-chip-blue">{{ $kasSummary['saldo'] < 0 ? '-Rp ' : 'Rp ' }}{{ number_format(abs($kasSummary['saldo']), 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="report-table-grid">
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Kas Masuk</h3>
                    <div class="report-table-total">Rp {{ number_format($kasSummary['masuk_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Sumber</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            @forelse($kasMasuk as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $item->sumber }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="{{ $item->keterangan ? '' : 'is-muted' }}">{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="report-empty">Belum ada data kas masuk pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Kas Keluar</h3>
                    <div class="report-table-total is-outgoing">Rp {{ number_format($kasSummary['keluar_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Jenis</th><th>Nominal</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            @forelse($kasKeluar as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $item->jenis_pengeluaran }}</td>
                                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="{{ $item->keterangan ? '' : 'is-muted' }}">{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="report-empty">Belum ada data kas keluar pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(in_array($reportType, ['ringkasan', 'donasi']))
    <section class="report-section" id="laporan-donasi">
        <div class="report-section-head">
            <div>
                <div class="report-section-label">Laporan Donasi</div>
                <h2 class="report-section-title">Donasi Masuk dan Donasi Keluar</h2>
                <p class="report-section-subtitle">Menampilkan transaksi donasi per periode lengkap dengan nilai dana dan keterangan.</p>
            </div>
            <div class="report-chip-row">
                <span class="report-chip report-chip-green">{{ $donasiSummary['masuk_count'] }} donasi masuk</span>
                <span class="report-chip report-chip-red">{{ $donasiSummary['keluar_count'] }} donasi keluar</span>
                <span class="report-chip report-chip-blue">{{ $donasiSummary['saldo'] < 0 ? '-Rp ' : 'Rp ' }}{{ number_format(abs($donasiSummary['saldo']), 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="report-table-grid">
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Donasi Masuk</h3>
                    <div class="report-table-total">Rp {{ number_format($donasiSummary['masuk_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Donatur</th><th>Jenis</th><th>Kategori</th><th>Jumlah</th><th>Nilai</th></tr></thead>
                        <tbody>
                            @forelse($donasiMasuk as $item)
                            <tr>
                                <td>{{ optional($item->tanggal)->translatedFormat('d M Y') ?? '-' }}</td>
                                <td>{{ $item->nama_donatur }}</td>
                                <td>{{ $item->jenis_donasi }}</td>
                                <td>{{ $item->kategori_donasi ?: '-' }}</td>
                                <td>{{ $item->label_jumlah }}</td>
                                <td>Rp {{ number_format($item->nilai_dana, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="report-empty">Belum ada data donasi masuk pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Donasi Keluar</h3>
                    <div class="report-table-total is-outgoing">Rp {{ number_format($donasiSummary['keluar_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Tujuan</th><th>Jenis</th><th>Jumlah</th><th>Nilai</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            @forelse($donasiKeluar as $item)
                            <tr>
                                <td>{{ optional($item->tanggal)->translatedFormat('d M Y') ?? '-' }}</td>
                                <td>{{ $item->tujuan }}</td>
                                <td>{{ $item->jenis_donasi }}</td>
                                <td>{{ $item->label_jumlah }}</td>
                                <td>Rp {{ number_format($item->nilai_dana, 0, ',', '.') }}</td>
                                <td class="{{ $item->keterangan ? '' : 'is-muted' }}">{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="report-empty">Belum ada data donasi keluar pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(in_array($reportType, ['ringkasan', 'zakat']))
    <section class="report-section" id="laporan-zakat">
        <div class="report-section-head">
            <div>
                <div class="report-section-label">Laporan Zakat</div>
                <h2 class="report-section-title">Penerimaan dan Distribusi Zakat</h2>
                <p class="report-section-subtitle">Rekap pemasukan dan penyaluran zakat yang dapat ditinjau per periode sebelum dicetak.</p>
            </div>
            <div class="report-chip-row">
                <span class="report-chip report-chip-green">{{ $zakatSummary['masuk_count'] }} penerimaan</span>
                <span class="report-chip report-chip-red">{{ $zakatSummary['keluar_count'] }} distribusi</span>
                <span class="report-chip report-chip-blue">{{ $zakatSummary['saldo'] < 0 ? '-Rp ' : 'Rp ' }}{{ number_format(abs($zakatSummary['saldo']), 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="report-table-grid">
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Penerimaan Zakat</h3>
                    <div class="report-table-total">Rp {{ number_format($zakatSummary['masuk_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Muzakki</th><th>Jenis</th><th>Bentuk</th><th>Jumlah</th><th>Nilai</th><th>Metode</th></tr></thead>
                        <tbody>
                            @forelse($penerimaanZakat as $item)
                            <tr>
                                <td>{{ optional($item->tanggal)->translatedFormat('d M Y') ?? '-' }}</td>
                                <td>{{ $item->muzakki->nama ?? '-' }}</td>
                                <td>{{ $item->jenis_zakat }}</td>
                                <td>{{ $item->bentuk_zakat ?? 'Uang' }}</td>
                                <td>{{ $item->label_jumlah }}</td>
                                <td>Rp {{ number_format($item->nilai_dana, 0, ',', '.') }}</td>
                                <td>{{ $item->metode_pembayaran ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="report-empty">Belum ada data penerimaan zakat pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="report-table-card">
                <div class="report-table-head">
                    <h3 class="report-table-title">Distribusi Zakat</h3>
                    <div class="report-table-total is-outgoing">Rp {{ number_format($zakatSummary['keluar_total'], 0, ',', '.') }}</div>
                </div>
                <div class="report-table-wrap">
                    <table class="report-table">
                        <thead><tr><th>Tanggal</th><th>Mustahik</th><th>Jenis</th><th>Bentuk</th><th>Jumlah</th><th>Nilai</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            @forelse($distribusiZakat as $item)
                            <tr>
                                <td>{{ optional($item->tanggal)->translatedFormat('d M Y') ?? '-' }}</td>
                                <td>{{ $item->mustahik->nama ?? '-' }}</td>
                                <td>{{ $item->jenis_zakat }}</td>
                                <td>{{ $item->bentuk_zakat ?? 'Uang' }}</td>
                                <td>{{ $item->label_jumlah }}</td>
                                <td>Rp {{ number_format($item->nilai_dana, 0, ',', '.') }}</td>
                                <td class="{{ $item->keterangan ? '' : 'is-muted' }}">{{ $item->keterangan ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="report-empty">Belum ada data distribusi zakat pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if(in_array($reportType, ['ringkasan', 'kegiatan']))
    <section class="report-section" id="laporan-kegiatan">
        <div class="report-section-head">
            <div>
                <div class="report-section-label">Laporan Kegiatan</div>
                <h2 class="report-section-title">Jadwal Kegiatan Masjid</h2>
                <p class="report-section-subtitle">Daftar kegiatan pada periode terpilih beserta penanggung jawab, lokasi, dan anggaran yang terhubung.</p>
            </div>
            <div class="report-chip-row">
                <span class="report-chip report-chip-green">{{ $kegiatanSummary['count'] }} kegiatan</span>
                <span class="report-chip report-chip-blue">{{ $kegiatanSummary['today_count'] }} hari ini</span>
                <span class="report-chip report-chip-red">{{ $kegiatanSummary['upcoming_count'] }} akan datang</span>
                <span class="report-chip report-chip-blue">Estimasi Rp {{ number_format($kegiatanSummary['estimasi_total'], 0, ',', '.') }}</span>
                <span class="report-chip report-chip-green">Realisasi Rp {{ number_format($kegiatanSummary['realisasi_total'], 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="report-table-card">
            <div class="report-table-head">
                <h3 class="report-table-title">Daftar Kegiatan</h3>
                <div class="report-table-total">{{ $kegiatanSummary['completed_count'] }} selesai</div>
            </div>
            <div class="report-table-wrap">
                <table class="report-table">
                    <thead><tr><th>Tanggal</th><th>Nama Kegiatan</th><th>Waktu</th><th>Tempat</th><th>Penanggung Jawab</th><th>Estimasi</th><th>Realisasi</th><th>Status</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @forelse($kegiatan as $item)
                        @php $tanggalKegiatan = \Carbon\Carbon::parse($item->tanggal); @endphp
                        <tr>
                            <td>{{ $tanggalKegiatan->translatedFormat('d M Y') }}</td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->waktu ?: '-' }}</td>
                            <td>{{ $item->tempat ?: '-' }}</td>
                            <td>{{ $item->penanggung_jawab ?: '-' }}</td>
                            <td>{{ $item->estimasi_anggaran ? 'Rp ' . number_format($item->estimasi_anggaran, 0, ',', '.') : '-' }}</td>
                            <td>
                                @if($item->kasKeluar)
                                    Rp {{ number_format($item->kasKeluar->nominal, 0, ',', '.') }}
                                    <div class="is-muted">{{ $item->kasKeluar->jenis_pengeluaran }}</div>
                                @else
                                    <span class="is-muted">Belum direalisasikan</span>
                                @endif
                            </td>
                            <td>
                                @if($tanggalKegiatan->isToday())
                                    Hari Ini
                                @elseif($tanggalKegiatan->isFuture())
                                    Akan Datang
                                @else
                                    Selesai
                                @endif
                            </td>
                            <td class="{{ $item->keterangan ? '' : 'is-muted' }}">{{ $item->keterangan ?: '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="report-empty">Belum ada data kegiatan pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif

    <section class="report-signature">
        <div class="report-sign-card">
            <div class="report-sign-title">Disiapkan Oleh</div>
            <div class="report-sign-space"></div>
            <div class="report-sign-line">Admin / Pengelola Laporan</div>
        </div>
        <div class="report-sign-card">
            <div class="report-sign-title">Mengetahui</div>
            <div class="report-sign-space"></div>
            <div class="report-sign-line">Ketua / Bendahara DKM</div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
const reportMeta = {
    reportType: @json($reportType),
    namaMasjid: @json($namaMasjid),
    periodLabel: @json($periodLabel),
    generatedAt: @json($generatedAt->translatedFormat('d M Y H:i')),
    mainTitle: @json($reportDocumentTitle),
    summaryTitle: @json($reportSummaryDocumentTitle),
    kegiatanTitle: @json($reportKegiatanDocumentTitle),
};

function escapeHtml(value) {
    return String(value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

function buildPrintStyles(orientation) {
    const sectionGridColumns = orientation === 'landscape' ? 'repeat(2, minmax(0, 1fr))' : '1fr';
    const summaryGridColumns = orientation === 'landscape' ? 'repeat(4, minmax(0, 1fr))' : 'repeat(2, minmax(0, 1fr))';
    return `@page { size: A4 ${orientation}; margin: 12mm; } * { box-sizing: border-box; } body { margin: 0; font-family: Arial, Helvetica, sans-serif; color: #111827; background: #fff; } .print-shell { display: flex; flex-direction: column; gap: 18px; } .print-header,.report-summary-card,.report-section,.report-table-card,.report-sign-card { background: #fff; border: 1px solid #d1d5db; border-radius: 18px; box-shadow: none; } .print-header { padding: 22px; } .print-title { font-size: 24px; font-weight: 800; text-align: center; margin: 0 0 6px; } .print-subtitle { font-size: 13px; color: #4b5563; text-align: center; margin: 0 0 18px; } .print-meta { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; } .print-meta-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 12px 14px; } .print-meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; margin-bottom: 6px; } .print-meta-value { font-size: 13px; font-weight: 700; color: #111827; } .report-summary-grid { display: grid; grid-template-columns: ${summaryGridColumns}; gap: 12px; } .report-summary-card { padding: 16px 18px; } .report-summary-label { font-size: 10px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #9ca3af; margin-bottom: 7px; } .report-summary-value { font-size: 21px; font-weight: 800; color: #111827; margin-bottom: 5px; line-height: 1.2; } .report-summary-note { font-size: 11px; color: #6b7280; } .is-positive { color: #198754; } .is-negative { color: #dc3545; } .report-section { padding: 18px; display: flex; flex-direction: column; gap: 16px; break-inside: avoid-page; page-break-inside: avoid; } .report-section + .report-section { break-before: page; page-break-before: always; } .report-section-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; flex-wrap: wrap; } .report-section-label { font-size: 10px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #9ca3af; margin-bottom: 4px; } .report-section-title { font-size: 18px; font-weight: 800; color: #111827; margin: 0; } .report-section-subtitle { font-size: 12px; color: #6b7280; margin: 6px 0 0; } .report-chip-row { display: flex; gap: 8px; flex-wrap: wrap; } .report-chip { border-radius: 999px; padding: 6px 10px; font-size: 11px; font-weight: 700; } .report-chip-green { background: #e8f6ee; color: #198754; } .report-chip-red { background: #fdecec; color: #b02a37; } .report-chip-blue { background: #eef0fd; color: #4361ee; } .report-table-grid { display: grid; grid-template-columns: ${sectionGridColumns}; gap: 14px; } .report-table-card { padding: 16px; break-inside: avoid-page; page-break-inside: avoid; } .report-table-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 12px; flex-wrap: wrap; } .report-table-title { font-size: 15px; font-weight: 800; color: #111827; margin: 0; } .report-table-total { font-size: 11px; font-weight: 700; color: #0f8b6d; background: #e8f6ee; border-radius: 999px; padding: 6px 10px; } .report-table-total.is-outgoing { color: #b02a37; background: #fdecec; } .report-table-wrap { overflow: visible; } .report-table { width: 100%; border-collapse: collapse; min-width: 0; } .report-table th,.report-table td { padding: 9px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; text-align: left; vertical-align: top; white-space: normal; } .report-table th { font-size: 10px; font-weight: 700; color: #6b7280; background: #f8fafc; } .report-empty,.is-muted { color: #9ca3af; } .report-empty { text-align: center; padding: 18px 10px; font-size: 12px; } .report-signature { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; } .report-sign-card { padding: 20px; min-height: 130px; border-style: dashed; } .report-sign-title { font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 12px; } .report-sign-space { height: 52px; } .report-sign-line { border-top: 1px solid #9ca3af; padding-top: 8px; font-size: 11px; color: #6b7280; }`;
}

function buildPrintHeader(title) {
    return `<section class="print-header"><h1 class="print-title">${escapeHtml(title)}</h1><p class="print-subtitle">Dokumen laporan resmi ${escapeHtml(reportMeta.namaMasjid)}</p><div class="print-meta"><div class="print-meta-card"><div class="print-meta-label">Nama Masjid</div><div class="print-meta-value">${escapeHtml(reportMeta.namaMasjid)}</div></div><div class="print-meta-card"><div class="print-meta-label">Periode</div><div class="print-meta-value">${escapeHtml(reportMeta.periodLabel)}</div></div><div class="print-meta-card"><div class="print-meta-label">Dibuat Pada</div><div class="print-meta-value">${escapeHtml(reportMeta.generatedAt)}</div></div></div></section>`;
}

function openPrintWindow(title, orientation, contentHtml) {
    const html = `<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>${escapeHtml(title)}</title><style>${buildPrintStyles(orientation)}</style></head><body><div class="print-shell">${buildPrintHeader(title)}${contentHtml}</div></body></html>`;
    const existingFrame = document.getElementById('reportPrintFrame');
    if (existingFrame) existingFrame.remove();
    const iframe = document.createElement('iframe');
    iframe.id = 'reportPrintFrame';
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = '0';
    document.body.appendChild(iframe);
    const frameDoc = iframe.contentWindow.document;
    frameDoc.open();
    frameDoc.write(html);
    frameDoc.close();
    const triggerPrint = function () { try { iframe.contentWindow.focus(); iframe.contentWindow.print(); } catch (error) { console.error('Gagal membuka dialog print:', error); } };
    iframe.onload = function () { setTimeout(triggerPrint, 300); };
    iframe.contentWindow.onafterprint = function () { setTimeout(function () { iframe.remove(); }, 300); };
    setTimeout(triggerPrint, 700);
}

function printReportMode() {
    const reportPage = document.querySelector('.report-page');
    if (!reportPage) return;
    const summaryGrid = reportPage.querySelector('.report-summary-grid')?.outerHTML ?? '';
    const signature = reportPage.querySelector('.report-signature')?.outerHTML ?? '';
    if (reportMeta.reportType === 'kegiatan') {
        const kegiatanSection = reportPage.querySelector('#laporan-kegiatan')?.outerHTML ?? '';
        openPrintWindow(reportMeta.kegiatanTitle, 'landscape', `${kegiatanSection}${signature}`);
        return;
    }
    const visibleSections = Array.from(reportPage.querySelectorAll('.report-section')).map((section) => section.outerHTML).join('');
    const printableContent = reportMeta.reportType === 'ringkasan' ? `${summaryGrid}${visibleSections}${signature}` : `${visibleSections}${signature}`;
    const printableTitle = reportMeta.reportType === 'ringkasan' ? reportMeta.summaryTitle : reportMeta.mainTitle;
    openPrintWindow(printableTitle, 'portrait', printableContent);
}
</script>
@endpush
