@extends('layouts.admin')

@section('page-title', 'Laporan')

@push('styles')
<style>
.report-page { display:flex; flex-direction:column; gap:24px; padding:8px 0 28px; }
.report-hero, .report-filter-card, .report-section, .report-table-card, .report-sign-card { background:#fff; border:1px solid #e5efe9; border-radius:20px; box-shadow:0 14px 28px rgba(15,23,42,.05); }
.report-hero { background:linear-gradient(135deg,#0f8b6d 0%,#0e7a5e 60%,#085041 100%); color:#fff; padding:28px 30px; display:flex; justify-content:space-between; align-items:flex-start; gap:18px; flex-wrap:wrap; }
.report-hero-label { display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:999px; font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; background:rgba(255,255,255,.14); margin-bottom:12px; }
.report-hero-title { font-size:28px; font-weight:800; margin:0 0 8px; }
.report-hero-subtitle { font-size:13px; line-height:1.6; color:rgba(255,255,255,.82); margin:0; max-width:760px; }
.report-hero-meta { display:grid; gap:10px; min-width:250px; }
.report-meta-card { border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.12); border-radius:16px; padding:14px 16px; }
.report-meta-label { font-size:10px; letter-spacing:.08em; text-transform:uppercase; color:rgba(255,255,255,.72); margin-bottom:6px; }
.report-meta-value { font-size:15px; font-weight:700; color:#fff; }
.report-filter-card { padding:20px; }
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
@media (max-width:1180px) { .report-filter-form, .report-summary-grid, .report-table-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width:768px) {
    .report-filter-form, .report-summary-grid, .report-table-grid, .report-signature { grid-template-columns:1fr; }
    .report-actions { width:100%; }
    .report-btn { width:100%; justify-content:center; }
}
@media print {
    body { background:#fff !important; }
    .sidebar, .navbar, .sidebar-overlay, .report-filter-card { display:none !important; }
    .main, .main.expanded { margin-left:0 !important; }
    .content-scroll, .container, .content-inner { overflow:visible !important; min-width:0 !important; width:100% !important; padding:0 !important; }
    .report-page { padding:0; }
    .report-hero, .report-section, .report-summary-card, .report-table-card, .report-sign-card { box-shadow:none !important; border-color:#d1d5db !important; }
}
</style>
@endpush

@section('content')
<div class="report-page">
    <section class="report-hero">
        <div>
            <div class="report-hero-label"><i class="fa fa-file-lines"></i> Modul Laporan</div>
            <h1 class="report-hero-title">Laporan Kas, Donasi, dan Zakat</h1>
            <p class="report-hero-subtitle">Pusat laporan periode untuk meninjau transaksi masuk, transaksi keluar, saldo, dan detail data yang siap dicetak.</p>
        </div>
        <div class="report-hero-meta">
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
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="report-filter-form">
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
                <input type="text" id="jumlah_transaksi" value="{{ number_format($overallSummary['transaksi_total'], 0, ',', '.') }} transaksi" readonly>
            </div>
            <div class="report-actions">
                <button type="submit" class="report-btn report-btn-primary"><i class="fa fa-filter"></i> Tampilkan</button>
                <a href="{{ route('admin.laporan.index') }}" class="report-btn report-btn-light"><i class="fa fa-rotate-left"></i> Reset</a>
                <button type="button" class="report-btn report-btn-light" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
            </div>
        </form>
    </section>

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
            <div class="report-summary-note">Jumlah seluruh transaksi yang masuk ke modul laporan periode ini.</div>
        </div>
    </section>

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
