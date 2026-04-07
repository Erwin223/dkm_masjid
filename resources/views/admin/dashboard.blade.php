@extends('layouts.admin')

@section('page-title', 'Dashboard')

@push('styles')
<style>
/* ── Dashboard extra utilities ───────────────── */
.dash-page { display:flex; flex-direction:column; gap:24px; }

/* Hero */
.dash-hero {
    background: linear-gradient(135deg, #0f8b6d 0%, #085041 100%);
    border-radius: 18px; padding: 22px 28px; color: #fff;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap; position: relative; overflow: hidden;
}
.dash-hero::before {
    content:''; position:absolute; right:-40px; top:-40px;
    width:200px; height:200px; border-radius:50%;
    background:rgba(255,255,255,0.07); pointer-events:none;
}
.dash-hero-left h2 { font-size:22px; font-weight:800; margin:0 0 4px; }
.dash-hero-left p  { font-size:13px; color:rgba(255,255,255,0.8); margin:0; }
.dash-hero-btn {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,0.18); border:1px solid rgba(255,255,255,0.28);
    color:#fff; padding:10px 20px; border-radius:10px;
    font-size:13px; font-weight:600; text-decoration:none;
    transition:background .15s; z-index:1; white-space:nowrap;
}
.dash-hero-btn:hover { background:rgba(255,255,255,0.28); }

/* Cards section label */
.cards-label {
    font-size:11px; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:#9ca3af; margin-bottom:10px;
    display:flex; align-items:center; gap:8px;
}
.cards-label::after { content:''; flex:1; height:1px; background:#e5e7eb; }

/* Widget header */
.wgt-head {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:16px; gap:8px; flex-wrap:wrap;
}
.wgt-head h3 { font-size:15px; font-weight:700; color:#111827; margin:0; display:flex; align-items:center; gap:8px; }
.wgt-link { font-size:12px; color:#0f8b6d; text-decoration:none; font-weight:600; }
.wgt-link:hover { text-decoration:underline; }

/* Mini stats grid */
.mini-stats { display:grid; gap:10px; margin-bottom:12px; }
.mini-stats-2 { grid-template-columns:1fr 1fr; }
.mini-stats-3 { grid-template-columns:repeat(3,1fr); }
@media(max-width:480px){ .mini-stats-3,.mini-stats-2 { grid-template-columns:1fr 1fr; } }

.mini-stat {
    border-radius:12px; padding:12px; text-align:center;
    background:#f9fafb; border:1px solid #e5e7eb;
}
.mini-stat-val { font-size:16px; font-weight:800; line-height:1.2; margin-bottom:3px; }
.mini-stat-lbl { font-size:11px; color:#6b7280; }

/* Finance rows */
.fin-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:6px 0; border-bottom:1px solid #f3f4f6;
}
.fin-row:last-child { border-bottom:none; }
.fin-row-label { font-size:13px; color:#555; }
.fin-row-val   { font-size:13px; font-weight:700; }
.fin-divider   { height:1px; background:#e5e7eb; margin:8px 0; }

/* Person list */
.person-list { display:flex; flex-direction:column; }
.person-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 0; border-bottom:1px solid #f5f5f5;
}
.person-item:last-child { border-bottom:none; }
.person-avatar {
    width:34px; height:34px; border-radius:50%; flex-shrink:0;
    background:#e1f5ee; border:2px solid #9fe1cb;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; color:#0f6e56; object-fit:cover;
}
.person-name { font-size:13px; font-weight:600; color:#111827; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.person-sub  { font-size:11px; color:#9ca3af; margin-top:2px; }
.person-side { font-size:11px; color:#aaa; white-space:nowrap; flex-shrink:0; }

/* Kegiatan item */
.keg-item { padding:10px 0; border-bottom:1px solid #f5f5f5; }
.keg-item:last-child { border-bottom:none; }
.keg-name { font-size:13px; font-weight:600; color:#111827; margin-bottom:4px; }
.keg-meta { font-size:11px; color:#9ca3af; }
.keg-meta i { color:#0f8b6d; }

.sec-sublabel {
    font-size:11px; font-weight:700; text-transform:uppercase;
    letter-spacing:.07em; color:#9ca3af; margin-bottom:10px;
}

.delete-action-btn {
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
}

.delete-action-btn i {
    color: red;
}
</style>
@endpush

@section('content')
@include('admin._styles')

@php
    $totalMasuk       = $totalKasMasuk ?? 0;
    $totalKeluar      = $totalKasKeluar ?? 0;
    $saldo            = $totalMasuk - $totalKeluar;
    $saldoDonasi      = ($totalDonasiMasuk ?? 0) - ($totalDonasiKeluar ?? 0);
    $saldoZakat       = ($totalZakatMasuk ?? 0) - ($totalZakatKeluar ?? 0);
    $saldoBersihTotal = $saldo + $saldoDonasi;
    $jmlMasuk         = isset($kasMasuk)  ? $kasMasuk->count()  : 0;
    $jmlKeluar        = isset($kasKeluar) ? $kasKeluar->count() : 0;
    $anggaranKeg      = $totalAnggaranKegiatan ?? 0;
    $jmlJadwal        = $totalJadwal ?? 0;
    $ringkasanDonasiMasuk     = $ringkasanDonasiMasuk     ?? ['uang_total'=>0,'uang_count'=>0,'barang_count'=>0,'barang_preview'=>'Belum ada data barang','kategori_count'=>0];
    $ringkasanDonasiKeluar    = $ringkasanDonasiKeluar    ?? ['uang_total'=>0,'uang_count'=>0,'barang_count'=>0,'barang_preview'=>'Belum ada data barang','tujuan_count'=>0];
    $ringkasanPenerimaanZakat = $ringkasanPenerimaanZakat ?? ['uang_total'=>0,'uang_count'=>0,'barang_count'=>0,'barang_preview'=>'Belum ada data barang','total_jiwa'=>0,'fitrah_uang_count'=>0];
    $ringkasanDistribusiZakat = $ringkasanDistribusiZakat ?? ['uang_total'=>0,'uang_count'=>0,'barang_count'=>0,'barang_preview'=>'Belum ada data barang','jenis_count'=>0];
@endphp

<div class="dash-page">

    {{-- ① HERO ──────────────────────────────────── --}}
    <div class="dash-hero">
        <div class="dash-hero-left">
            <h2><i class="fa fa-mosque"></i> Dashboard Admin</h2>
            <p>Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}. Berikut ringkasan keuangan masjid.</p>
        </div>
        <a href="{{ route('admin.statistik') }}" class="dash-hero-btn">
            <i class="fa fa-chart-bar"></i> Lihat Statistik
        </a>
    </div>

    {{-- ② KPI CARDS ──────────────────────────────── --}}

    {{-- Kas --}}
    <div>
        <div class="cards-label">Kas Masjid</div>
        <div class="cards">
            <div class="card">
                <div>
                    <h3>Saldo Kas</h3>
                    <p class="card-value">{{ $saldo < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldo), 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $saldo >= 0 ? 'Kas positif' : 'Kas minus' }}</p>
                </div>
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Total Kas Masuk</h3>
                    <p class="card-value">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlMasuk }} transaksi</p>
                </div>
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Total Kas Keluar</h3>
                    <p class="card-value">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlKeluar }} transaksi</p>
                </div>
                <i class="fa-solid fa-money-bill-transfer"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Anggaran Kegiatan</h3>
                    <p class="card-value">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</p>
                    <p class="card-sub">dari kas keluar</p>
                </div>
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    {{-- Donasi --}}
    <div>
        <div class="cards-label">Donasi</div>
        <div class="cards">
            <div class="card">
                <div>
                    <h3>Saldo Donasi</h3>
                    <p class="card-value">{{ $saldoDonasi < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldoDonasi), 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $saldoDonasi >= 0 ? 'Donasi positif' : 'Donasi minus' }}</p>
                </div>
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Donasi Masuk</h3>
                    <p class="card-value">Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlDonasiMasuk ?? 0 }} transaksi</p>
                    <p class="card-note">{{ $latestDonasiMasuk ? 'Dari: '.$latestDonasiMasuk->nama_donatur : 'Belum ada data' }}</p>
                </div>
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Donasi Keluar</h3>
                    <p class="card-value">Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlDonasiKeluar ?? 0 }} transaksi</p>
                    <p class="card-note">{{ $latestDonasiKeluar ? 'Tujuan: '.($latestDonasiKeluar->tujuan ?: '-') : 'Belum ada data' }}</p>
                </div>
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Total Donatur</h3>
                    <p class="card-value">{{ $totalDonatur ?? 0 }}</p>
                    <p class="card-sub">donatur terdaftar</p>
                </div>
                <i class="fa-solid fa-people-group"></i>
            </div>
        </div>
    </div>

    {{-- Zakat --}}
    <div>
        <div class="cards-label">Zakat</div>
        <div class="cards">
            <div class="card">
                <div>
                    <h3>Saldo Zakat</h3>
                    <p class="card-value">{{ $saldoZakat < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldoZakat), 0, ',', '.') }}</p>
                    <p class="card-sub">{{ ($totalMuzakki ?? 0) }} muzakki · {{ ($totalMustahik ?? 0) }} mustahik</p>
                </div>
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Penerimaan Zakat</h3>
                    <p class="card-value">Rp.{{ number_format($totalZakatMasuk ?? 0, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlPenerimaanZakat ?? 0 }} transaksi</p>
                    <p class="card-note">{{ $latestPenerimaanZakat ? 'Muzakki: '.($latestPenerimaanZakat->muzakki->nama ?? '-') : 'Belum ada data' }}</p>
                </div>
                <i class="fa-solid fa-mosque"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Distribusi Zakat</h3>
                    <p class="card-value">Rp.{{ number_format($totalZakatKeluar ?? 0, 0, ',', '.') }}</p>
                    <p class="card-sub">{{ $jmlDistribusiZakat ?? 0 }} transaksi</p>
                    <p class="card-note">{{ $latestDistribusiZakat ? 'Mustahik: '.($latestDistribusiZakat->mustahik->nama ?? '-') : 'Belum ada data' }}</p>
                </div>
                <i class="fa-solid fa-hand-holding-medical"></i>
            </div>
        </div>
    </div>

    {{-- Website & Kegiatan --}}
    <div>
        <div class="cards-label">Website & Kegiatan</div>
        <div class="cards">
            <div class="card">
                <div>
                    <h3>Jadwal Kegiatan</h3>
                    <p class="card-value">{{ $jmlJadwal }}</p>
                    <p class="card-sub">kegiatan akan datang</p>
                </div>
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="card">
                <div>
                    <h3>Kelola Website</h3>
                    <p class="card-value">{{ $totalBerita ?? 0 }} Berita</p>
                    <p class="card-sub">{{ $totalGaleri ?? 0 }} Foto Galeri</p>
                </div>
                <i class="fa-solid fa-globe"></i>
            </div>
        </div>
    </div>

    {{-- ③ MAIN GRID ───────────────────────────────── --}}
    <div class="dashboard-grid-3">

        {{-- LEFT: Data Tables --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- Kas Masuk --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-table"></i> Data Kas Masuk</h3>
                        <div class="table-box-subtitle">Transaksi kas masuk terbaru — sumber, nominal, dan keterangan.</div>
                    </div>
                    <a href="{{ route('kas.masuk.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat Semua</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Total kas masuk</div>
                        <div class="summary-chip-value" style="color:#0f8b6d;">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $jmlMasuk }} transaksi</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Rata-rata transaksi</div>
                        <div class="summary-chip-value" style="color:#4361ee;">Rp.{{ number_format($jmlMasuk ? ($totalMasuk / $jmlMasuk) : 0, 0, ',', '.') }}</div>
                        <div class="summary-chip-note">Per transaksi kas masuk</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Saldo kas saat ini</div>
                        <div class="summary-chip-value {{ $saldo >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ $saldo < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldo), 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $saldo >= 0 ? 'Kas masih positif' : 'Kas sedang defisit' }}</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Sumber</th><th>Jumlah</th><th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($kasMasuk) && $kasMasuk->count())
                                @foreach($kasMasuk as $kas)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>{{ $kas->sumber }}</td>
                                    <td>Rp.{{ number_format($kas->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $kas->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-form-{{ $kas->id }}" action="{{ route('kas.masuk.delete', $kas->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-form-{{ $kas->id }}" data-title="Yakin hapus?" data-confirm-color="#0f8b6d" data-cancel-color="#d33"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('kas.masuk.edit', $kas->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</strong>
                        Seluruh pemasukan kas yang sudah tercatat.
                    </div>
                    <a href="{{ route('kas.masuk.create') }}" class="btn-tambah"><i class="fa fa-plus"></i> Tambah Kas Masuk</a>
                </div>
            </div>

            {{-- Kas Keluar --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-money-bill-wave"></i> Data Kas Keluar</h3>
                        <div class="table-box-subtitle">Pengeluaran kas terbaru — jenis, nominal, dan catatan.</div>
                    </div>
                    <a href="{{ route('kas.keluar.index') }}" class="btn-link"><span class="icon"><i class="fa fa-plus"></i></span> Tambah</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Total kas keluar</div>
                        <div class="summary-chip-value" style="color:#b02a37;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $jmlKeluar }} transaksi</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Rata-rata pengeluaran</div>
                        <div class="summary-chip-value" style="color:#fd7e14;">Rp.{{ number_format($jmlKeluar ? ($totalKeluar / $jmlKeluar) : 0, 0, ',', '.') }}</div>
                        <div class="summary-chip-note">Per transaksi kas keluar</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Anggaran kegiatan</div>
                        <div class="summary-chip-value" style="color:#4361ee;">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</div>
                        <div class="summary-chip-note">Dari kas keluar terhubung kegiatan</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Jenis Pengeluaran</th><th>Nominal</th><th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($kasKeluar) && $kasKeluar->count())
                                @foreach($kasKeluar as $keluar)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($keluar->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>{{ $keluar->jenis_pengeluaran }}</td>
                                    <td>Rp.{{ number_format($keluar->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $keluar->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-keluar-{{ $keluar->id }}" action="{{ route('kas.keluar.delete', $keluar->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-keluar-{{ $keluar->id }}" data-title="Yakin hapus?" data-confirm-color="#0f8b6d" data-cancel-color="#d33"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('kas.keluar.edit', $keluar->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="7" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
                        Seluruh pengeluaran kas yang sudah dibukukan.
                    </div>
                    <a href="{{ route('kas.keluar.create') }}" class="btn-tambah" style="background:#b02a37;"><i class="fa fa-plus"></i> Tambah Kas Keluar</a>
                </div>
            </div>

            {{-- Data Donatur --}}
            <div class="table-box">
                <div class="table-box-header">
                    <h3><i class="fa-solid fa-people-group" style="color:#20c997;"></i> Data Donatur</h3>
                    <a href="{{ route('donatur.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Donatur</th><th>No. HP</th><th>Jenis</th><th>Tgl Daftar</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dataDonatur) && $dataDonatur->count())
                                @foreach($dataDonatur as $dtr)
                                <tr>
                                    <td>{{ $dtr->nama }}</td>
                                    <td>{{ $dtr->no_hp ?? '-' }}</td>
                                    <td><span class="status-tetap-sm">{{ $dtr->jenis_donatur }}</span></td>
                                    <td>{{ $dtr->tanggal_daftar ? $dtr->tanggal_daftar->translatedFormat('d M Y') : '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-donatur-{{ $dtr->id }}" action="{{ route('donatur.delete', $dtr->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-donatur-{{ $dtr->id }}" data-title="Yakin hapus donatur?" data-text="Menghapus donatur akan mempengaruhi data donasi terkait." data-confirm-color="#0f8b6d" data-cancel-color="#d33"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('donatur.edit', $dtr->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data donatur</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Donasi Masuk --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-hand-holding-heart" style="color:#d4537e;"></i> Data Donasi Masuk</h3>
                        <div class="table-box-subtitle">Donatur, jenis, kategori, jumlah, total, dan keterangan.</div>
                    </div>
                    <a href="{{ route('donasi.masuk') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Total donasi masuk (uang)</div>
                        <div class="summary-chip-value" style="color:#d4537e;">Rp.{{ number_format($ringkasanDonasiMasuk['uang_total'], 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $ringkasanDonasiMasuk['uang_count'] }} transaksi uang</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Donasi barang</div>
                        <div class="summary-chip-value" style="color:#0f8b6d;">{{ $ringkasanDonasiMasuk['barang_count'] }} transaksi</div>
                        <div class="summary-chip-note">{{ $ringkasanDonasiMasuk['barang_preview'] }}</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Kategori aktif</div>
                        <div class="summary-chip-value" style="color:#4361ee;">{{ $ringkasanDonasiMasuk['kategori_count'] }}</div>
                        <div class="summary-chip-note">{{ $jmlDonasiMasuk ?? 0 }} total transaksi</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Donatur</th><th>Jenis</th><th>Kategori</th>
                                <th>Jumlah</th><th>Total</th><th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($donasiMasukList) && $donasiMasukList->count())
                                @foreach($donasiMasukList as $dm)
                                <tr>
                                    <td>{{ $dm->tanggal->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <div class="entity-cell">
                                            <div class="entity-avatar">{{ strtoupper(substr($dm->nama_donatur ?? 'HA', 0, 2)) }}</div>
                                            <div class="entity-body">
                                                <div class="entity-title">{{ $dm->nama_donatur }}</div>
                                                <div class="entity-subtitle">{{ $dm->donatur ? 'Terdaftar' : 'Umum' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-berjalan" style="background:#fbeaf0;color:#d4537e;border:1px solid #f4c0d1;">{{ $dm->jenis_donasi }}</span></td>
                                    <td><span class="badge-berjalan" style="background:#eef0fd;color:#4361ee;border:1px solid #c5caf7;">{{ $dm->kategori_donasi }}</span></td>
                                    <td>{{ $dm->is_barang ? $dm->label_jumlah : '-' }}</td>
                                    <td>
                                        <div class="amount-stack">
                                            <div class="amount-main" style="color:#d4537e;">Rp.{{ number_format($dm->nilai_dana, 0, ',', '.') }}</div>
                                            <div class="amount-note">{{ $dm->is_barang ? 'Valuasi barang' : 'Tunai' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $dm->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-donasi-masuk-{{ $dm->id }}" action="{{ route('donasi.masuk.delete', $dm->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-donasi-masuk-{{ $dm->id }}" data-title="Yakin hapus donasi masuk?" data-confirm-color="#d33" data-cancel-color="#6c757d"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('donasi.masuk.edit', $dm->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="9" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data donasi</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</strong>
                        Donasi uang dan valuasi donasi barang.
                    </div>
                    <a href="{{ route('donasi.masuk.create') }}" class="btn-tambah" style="background:#d4537e;"><i class="fa fa-plus"></i> Tambah Donasi Masuk</a>
                </div>
            </div>

            {{-- Donasi Keluar --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-hand-holding-dollar" style="color:#4361ee;"></i> Data Donasi Keluar</h3>
                        <div class="table-box-subtitle">Jenis donasi, tujuan penyaluran, jumlah, nominal, dan keterangan.</div>
                    </div>
                    <a href="{{ route('donasi.keluar') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Total donasi keluar (uang)</div>
                        <div class="summary-chip-value" style="color:#4361ee;">Rp.{{ number_format($ringkasanDonasiKeluar['uang_total'], 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $ringkasanDonasiKeluar['uang_count'] }} transaksi tunai</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Penyaluran barang</div>
                        <div class="summary-chip-value" style="color:#0f8b6d;">{{ $ringkasanDonasiKeluar['barang_count'] }} transaksi</div>
                        <div class="summary-chip-note">{{ $ringkasanDonasiKeluar['barang_preview'] }}</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Tujuan penyaluran</div>
                        <div class="summary-chip-value" style="color:#fd7e14;">{{ $ringkasanDonasiKeluar['tujuan_count'] }}</div>
                        <div class="summary-chip-note">{{ $jmlDonasiKeluar ?? 0 }} total transaksi</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Jenis Donasi</th><th>Tujuan</th>
                                <th>Jumlah</th><th>Nominal</th><th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($donasiKeluarList) && $donasiKeluarList->count())
                                @foreach($donasiKeluarList as $dk)
                                <tr>
                                    <td>{{ $dk->tanggal->translatedFormat('d M Y') }}</td>
                                    <td><span class="badge-berjalan" style="background:#eef0fd;color:#4361ee;border:1px solid #c5caf7;">{{ $dk->jenis_donasi }}</span></td>
                                    <td>
                                        <div class="entity-body">
                                            <div class="entity-title">{{ $dk->tujuan }}</div>
                                            <div class="entity-subtitle">{{ $dk->is_barang ? 'Barang' : 'Tunai' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $dk->label_jumlah }}</td>
                                    <td>
                                        <div class="amount-stack">
                                            <div class="amount-main" style="color:#4361ee;">Rp.{{ number_format($dk->nilai_dana, 0, ',', '.') }}</div>
                                            <div class="amount-note">{{ $dk->is_barang ? 'Valuasi barang' : 'Nominal' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $dk->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-donasi-keluar-{{ $dk->id }}" action="{{ route('donasi.keluar.delete', $dk->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-donasi-keluar-{{ $dk->id }}" data-title="Yakin hapus donasi keluar?" data-confirm-color="#d33" data-cancel-color="#6c757d"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('donasi.keluar.edit', $dk->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="8" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data donasi keluar</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</strong>
                        Penyaluran tunai dan valuasi barang keluar.
                    </div>
                    <a href="{{ route('donasi.keluar.create') }}" class="btn-tambah" style="background:#4361ee;"><i class="fa fa-plus"></i> Tambah Donasi Keluar</a>
                </div>
            </div>

            {{-- Penerimaan Zakat --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-mosque" style="color:#198754;"></i> Data Penerimaan Zakat</h3>
                        <div class="table-box-subtitle">Muzakki, jenis, bentuk, jumlah barang, nominal, pembagian, tanggungan, dan metode.</div>
                    </div>
                    <a href="{{ route('zakat.penerimaan.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Zakat uang terkumpul</div>
                        <div class="summary-chip-value" style="color:#198754;">Rp.{{ number_format($ringkasanPenerimaanZakat['uang_total'], 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $ringkasanPenerimaanZakat['uang_count'] }} transaksi uang</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Zakat barang</div>
                        <div class="summary-chip-value" style="color:#0f8b6d;">{{ $ringkasanPenerimaanZakat['barang_count'] }} transaksi</div>
                        <div class="summary-chip-note">{{ $ringkasanPenerimaanZakat['barang_preview'] }}</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Jiwa tercatat</div>
                        <div class="summary-chip-value" style="color:#b76e00;">{{ $ringkasanPenerimaanZakat['total_jiwa'] }}</div>
                        <div class="summary-chip-note">Akumulasi tanggungan</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Muzakki</th><th>Jenis</th><th>Bentuk</th>
                                <th>Jml Barang</th><th>Nominal</th><th>Pembagian</th>
                                <th>Tanggungan</th><th>Metode</th><th>Ket.</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($penerimaanZakatList) && $penerimaanZakatList->count())
                                @foreach($penerimaanZakatList as $pz)
                                <tr>
                                    <td>{{ $pz->tanggal->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <div class="entity-cell">
                                            <div class="entity-avatar">{{ strtoupper(substr($pz->muzakki->nama ?? 'MZ', 0, 2)) }}</div>
                                            <div class="entity-body">
                                                <div class="entity-title">{{ $pz->muzakki->nama ?? '-' }}</div>
                                                <div class="entity-subtitle">{{ $pz->jumlah_tanggungan ? $pz->jumlah_tanggungan.' jiwa' : 'Tanpa tanggungan' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-soft">{{ $pz->jenis_zakat }}</span></td>
                                    <td><span class="badge-warn">{{ $pz->bentuk_zakat ?? 'Uang' }}</span></td>
                                    <td>{{ $pz->is_barang ? $pz->label_jumlah : '-' }}</td>
                                    <td>
                                        <div class="amount-stack">
                                            <div class="amount-main" style="color:#198754;">{{ $pz->nominal ? 'Rp.'.number_format($pz->nominal, 0, ',', '.') : '-' }}</div>
                                            <div class="amount-note">{{ $pz->is_barang ? 'Valuasi barang' : 'Zakat uang' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $pz->label_pembagian }}</td>
                                    <td>{{ $pz->jumlah_tanggungan ?? '-' }}</td>
                                    <td>{{ $pz->metode_pembayaran ?? '-' }}</td>
                                    <td>{{ $pz->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-penerimaan-zakat-{{ $pz->id }}" action="{{ route('zakat.penerimaan.delete', $pz->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-penerimaan-zakat-{{ $pz->id }}" data-title="Yakin hapus penerimaan zakat?" data-confirm-color="#d33" data-cancel-color="#6c757d"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('zakat.penerimaan.edit', $pz->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="12" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data penerimaan zakat</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalZakatMasuk ?? 0, 0, ',', '.') }}</strong>
                        Zakat uang dan valuasi zakat barang yang diterima.
                    </div>
                    <a href="{{ route('zakat.penerimaan.create') }}" class="btn-tambah" style="background:#198754;"><i class="fa fa-plus"></i> Tambah Penerimaan</a>
                </div>
            </div>

            {{-- Distribusi Zakat --}}
            <div class="table-box">
                <div class="table-box-header">
                    <div>
                        <h3><i class="fa-solid fa-hand-holding-medical" style="color:#b02a37;"></i> Data Distribusi Zakat</h3>
                        <div class="table-box-subtitle">Mustahik, jenis, bentuk, jumlah barang, nominal, dan keterangan.</div>
                    </div>
                    <a href="{{ route('zakat.distribusi.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-box-summary summary-3">
                    <div class="summary-chip">
                        <div class="summary-chip-label">Zakat uang disalurkan</div>
                        <div class="summary-chip-value" style="color:#b02a37;">Rp.{{ number_format($ringkasanDistribusiZakat['uang_total'], 0, ',', '.') }}</div>
                        <div class="summary-chip-note">{{ $ringkasanDistribusiZakat['uang_count'] }} transaksi uang</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Zakat barang disalurkan</div>
                        <div class="summary-chip-value" style="color:#0f8b6d;">{{ $ringkasanDistribusiZakat['barang_count'] }} transaksi</div>
                        <div class="summary-chip-note">{{ $ringkasanDistribusiZakat['barang_preview'] }}</div>
                    </div>
                    <div class="summary-chip">
                        <div class="summary-chip-label">Ragam jenis zakat</div>
                        <div class="summary-chip-value" style="color:#4361ee;">{{ $ringkasanDistribusiZakat['jenis_count'] }}</div>
                        <div class="summary-chip-note">{{ $jmlDistribusiZakat ?? 0 }} total transaksi</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th><th>Mustahik</th><th>Jenis</th><th>Bentuk</th>
                                <th>Jml Barang</th><th>Nominal</th><th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($distribusiZakatList) && $distribusiZakatList->count())
                                @foreach($distribusiZakatList as $dz)
                                <tr>
                                    <td>{{ $dz->tanggal->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <div class="entity-cell">
                                            <div class="entity-avatar">{{ strtoupper(substr($dz->mustahik->nama ?? 'MS', 0, 2)) }}</div>
                                            <div class="entity-body">
                                                <div class="entity-title">{{ $dz->mustahik->nama ?? '-' }}</div>
                                                <div class="entity-subtitle">{{ $dz->mustahik->kategori_mustahik ?? 'Kategori belum diisi' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-soft" style="background:#fdecec;color:#b02a37;border-color:#f5c2c7;">{{ $dz->jenis_zakat }}</span></td>
                                    <td><span class="badge-warn">{{ $dz->bentuk_zakat ?? 'Uang' }}</span></td>
                                    <td>{{ $dz->is_barang ? $dz->label_jumlah : '-' }}</td>
                                    <td>
                                        <div class="amount-stack">
                                            <div class="amount-main" style="color:#b02a37;">{{ $dz->nominal ? 'Rp.'.number_format($dz->nominal, 0, ',', '.') : '-' }}</div>
                                            <div class="amount-note">{{ $dz->is_barang ? 'Valuasi barang' : 'Nominal' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $dz->keterangan ?? '-' }}</td>
                                    <td style="text-align:center;">
                                        <form id="delete-distribusi-zakat-{{ $dz->id }}" action="{{ route('zakat.distribusi.delete', $dz->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" class="delete-action-btn js-confirm-submit" data-form-id="delete-distribusi-zakat-{{ $dz->id }}" data-title="Yakin hapus distribusi zakat?" data-confirm-color="#d33" data-cancel-color="#6c757d"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;"><a href="{{ route('zakat.distribusi.edit', $dz->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="9" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data distribusi zakat</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-box-footer">
                    <div class="table-box-total">
                        <strong>Total: Rp.{{ number_format($totalZakatKeluar ?? 0, 0, ',', '.') }}</strong>
                        Penyaluran zakat uang dan valuasi distribusi barang.
                    </div>
                    <a href="{{ route('zakat.distribusi.create') }}" class="btn-tambah" style="background:#b02a37;"><i class="fa fa-plus"></i> Tambah Distribusi</a>
                </div>
            </div>

            {{-- Berita --}}
            <div class="table-box">
                <div class="table-box-header">
                    <h3><i class="fa-solid fa-newspaper" style="color:#f39c12;"></i> Data Berita Terbaru</h3>
                    <a href="{{ route('berita.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr><th>Tanggal</th><th>Judul</th><th>Penulis</th><th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th></tr>
                        </thead>
                        <tbody>
                            @forelse($beritaTerbaru as $b)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</td>
                                <td style="font-weight:600;color:#333;">{{ Str::limit($b->judul, 40) }}</td>
                                <td><span class="badge-selesai">{{ $b->penulis }}</span></td>
                                <td style="text-align:center;">
                                    <form action="{{ route('berita.delete', $b->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="border:none;background:none;cursor:pointer;"><i class="fa fa-trash" style="color:red;"></i></button>
                                    </form>
                                </td>
                                <td style="text-align:center;"><a href="{{ route('berita.edit', $b->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                            </tr>
                            @empty
                                <tr><td colspan="5" style="text-align:center;color:#999;padding:1.5rem;">Belum ada berita</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Galeri --}}
            <div class="table-box">
                <div class="table-box-header">
                    <h3><i class="fa-solid fa-images" style="color:#3498db;"></i> Data Galeri Terbaru</h3>
                    <a href="{{ route('galeri.index') }}" class="btn-link"><span class="icon"><i class="fa fa-eye"></i></span> Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr><th>Tanggal</th><th>Gambar</th><th>Judul</th><th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th></tr>
                        </thead>
                        <tbody>
                            @forelse($galeriTerbaru as $g)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($g->tanggal)->translatedFormat('d M Y') }}</td>
                                <td><img src="{{ asset('storage/'.$g->gambar) }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;"></td>
                                <td style="font-weight:600;color:#333;">{{ Str::limit($g->judul, 40) }}</td>
                                <td style="text-align:center;">
                                    <form action="{{ route('galeri.delete', $g->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus galeri ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="border:none;background:none;cursor:pointer;"><i class="fa fa-trash" style="color:red;"></i></button>
                                    </form>
                                </td>
                                <td style="text-align:center;"><a href="{{ route('galeri.edit', $g->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                            </tr>
                            @empty
                                <tr><td colspan="5" style="text-align:center;color:#999;padding:1.5rem;">Belum ada galeri</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- RIGHT: Widgets --}}
        <div style="display:flex;flex-direction:column;gap:16px;">

            {{-- Ringkasan Keuangan --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-scale-balanced" style="color:#0f8b6d;"></i> Ringkasan Keuangan</h3>
                    <a href="{{ route('admin.statistik') }}" class="wgt-link">Statistik →</a>
                </div>
                <div class="mini-stats mini-stats-2">
                    <div class="mini-stat" style="background:#eaf7ee;border-color:#b9e3c6;">
                        <div class="mini-stat-val" style="color:#28a745;">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Kas Masuk</div>
                    </div>
                    <div class="mini-stat" style="background:#fff1e7;border-color:#ffd2b3;">
                        <div class="mini-stat-val" style="color:#fd7e14;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Kas Keluar</div>
                    </div>
                </div>
                <div class="fin-row"><span class="fin-row-label">Saldo Kas</span><span class="fin-row-val {{ $saldo >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ $saldo < 0 ? '-' : '' }}Rp.{{ number_format(abs($saldo), 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Anggaran Kegiatan</span><span class="fin-row-val" style="color:#0f8b6d;">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Donasi Masuk</span><span class="fin-row-val" style="color:#d4537e;">Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Donasi Keluar</span><span class="fin-row-val" style="color:#4361ee;">Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Penerimaan Zakat</span><span class="fin-row-val" style="color:#198754;">Rp.{{ number_format($totalZakatMasuk ?? 0, 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Distribusi Zakat</span><span class="fin-row-val" style="color:#b02a37;">Rp.{{ number_format($totalZakatKeluar ?? 0, 0, ',', '.') }}</span></div>
                <div class="fin-divider"></div>
                <div class="fin-row"><span class="fin-row-label" style="font-weight:700;">Saldo Kas + Donasi</span><span class="fin-row-val {{ $saldoBersihTotal >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ $saldoBersihTotal < 0 ? '-' : '' }}Rp.{{ number_format(abs($saldoBersihTotal), 0, ',', '.') }}</span></div>
                <div class="fin-row"><span class="fin-row-label" style="font-weight:700;">Saldo Zakat</span><span class="fin-row-val {{ $saldoZakat >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ $saldoZakat < 0 ? '-' : '' }}Rp.{{ number_format(abs($saldoZakat), 0, ',', '.') }}</span></div>
            </div>

            {{-- Ringkasan Donasi --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-hand-holding-heart" style="color:#d4537e;"></i> Ringkasan Donasi</h3>
                    <a href="{{ route('donasi.masuk') }}" class="wgt-link">Lihat semua →</a>
                </div>
                <div class="mini-stats mini-stats-2">
                    <div class="mini-stat" style="background:#fbeaf0;border-color:#f4c0d1;">
                        <div class="mini-stat-val" style="color:#d4537e;">Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Masuk</div>
                    </div>
                    <div class="mini-stat" style="background:#eef0fd;border-color:#c5caf7;">
                        <div class="mini-stat-val" style="color:#4361ee;">Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Keluar</div>
                    </div>
                </div>
                <div class="fin-row"><span class="fin-row-label">Transaksi masuk</span><span class="fin-row-val">{{ $jmlDonasiMasuk ?? 0 }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Transaksi keluar</span><span class="fin-row-val">{{ $jmlDonasiKeluar ?? 0 }}</span></div>
                <div class="fin-divider"></div>
                <div class="fin-row"><span class="fin-row-label" style="font-weight:700;">Saldo Donasi</span><span class="fin-row-val {{ $saldoDonasi >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ $saldoDonasi < 0 ? '-' : '' }}Rp.{{ number_format(abs($saldoDonasi), 0, ',', '.') }}</span></div>
            </div>

            {{-- Ringkasan Zakat --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-mosque" style="color:#198754;"></i> Ringkasan Zakat</h3>
                    <a href="{{ route('zakat.penerimaan.index') }}" class="wgt-link">Lihat semua →</a>
                </div>
                <div class="mini-stats mini-stats-2">
                    <div class="mini-stat" style="background:#e8f6ee;border-color:#b7e4c7;">
                        <div class="mini-stat-val" style="color:#198754;">Rp.{{ number_format($totalZakatMasuk ?? 0, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Penerimaan</div>
                    </div>
                    <div class="mini-stat" style="background:#fdecec;border-color:#f5c2c7;">
                        <div class="mini-stat-val" style="color:#b02a37;">Rp.{{ number_format($totalZakatKeluar ?? 0, 0, ',', '.') }}</div>
                        <div class="mini-stat-lbl">Distribusi</div>
                    </div>
                </div>
                <div class="mini-stats mini-stats-2" style="margin-bottom:12px;">
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="color:#198754;">{{ $totalMuzakki ?? 0 }}</div>
                        <div class="mini-stat-lbl">Muzakki</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="color:#b02a37;">{{ $totalMustahik ?? 0 }}</div>
                        <div class="mini-stat-lbl">Mustahik</div>
                    </div>
                </div>
                <div class="fin-row"><span class="fin-row-label">Transaksi masuk</span><span class="fin-row-val">{{ $jmlPenerimaanZakat ?? 0 }}</span></div>
                <div class="fin-row"><span class="fin-row-label">Transaksi keluar</span><span class="fin-row-val">{{ $jmlDistribusiZakat ?? 0 }}</span></div>
                <div class="fin-divider"></div>
                <div class="fin-row"><span class="fin-row-label" style="font-weight:700;">Saldo Zakat</span><span class="fin-row-val {{ ($saldoZakat ?? 0) >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">{{ ($saldoZakat ?? 0) < 0 ? '-' : '' }}Rp.{{ number_format(abs($saldoZakat ?? 0), 0, ',', '.') }}</span></div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:14px;">
                    <a href="{{ route('zakat.penerimaan.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 12px;background:#198754;"><i class="fa fa-plus"></i> Penerimaan</a>
                    <a href="{{ route('zakat.distribusi.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 12px;background:#b02a37;"><i class="fa fa-plus"></i> Distribusi</a>
                </div>
            </div>

            {{-- Donatur Terbaru --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-people-group" style="color:#20c997;"></i> Donatur Terbaru</h3>
                    <a href="{{ route('donatur.index') }}" class="wgt-link">Lihat semua →</a>
                </div>
                @if(isset($donaturList) && $donaturList->count())
                    <div class="person-list">
                        @foreach($donaturList as $dtr)
                        <div class="person-item">
                            <div class="person-avatar">{{ strtoupper(substr($dtr->nama, 0, 2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="person-name">{{ $dtr->nama }}</div>
                                <div class="person-sub">{{ $dtr->jenis_donatur }}</div>
                            </div>
                            <div class="person-side">{{ $dtr->tanggal_daftar ? $dtr->tanggal_daftar->translatedFormat('d M Y') : '-' }}</div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align:center;padding:1rem;color:#999;font-size:13px;">Belum ada donatur</div>
                @endif
                <div style="margin-top:12px;text-align:center;">
                    <a href="{{ route('donatur.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 16px;background:#20c997;"><i class="fa fa-plus"></i> Tambah Donatur</a>
                </div>
            </div>

            {{-- Ringkasan Kegiatan --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-calendar-check" style="color:#0f8b6d;"></i> Ringkasan Kegiatan</h3>
                    <a href="{{ route('kegiatan.jadwal') }}" class="wgt-link">Lihat semua →</a>
                </div>
                <div class="mini-stats mini-stats-3">
                    <div class="mini-stat" style="background:#f7fdf9;border-color:#e0f0e8;">
                        <div class="mini-stat-val" style="color:#0f8b6d;">{{ $statKegiatan['akan_datang'] ?? 0 }}</div>
                        <div class="mini-stat-lbl">Akan Datang</div>
                    </div>
                    <div class="mini-stat" style="background:#f0f9ff;border-color:#cfe2ff;">
                        <div class="mini-stat-val" style="color:#084298;">{{ $statKegiatan['hari_ini'] ?? 0 }}</div>
                        <div class="mini-stat-lbl">Hari Ini</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-val" style="color:#444;">{{ $statKegiatan['selesai'] ?? 0 }}</div>
                        <div class="mini-stat-lbl">Selesai</div>
                    </div>
                </div>
                <div class="sec-sublabel">Kegiatan Terdekat</div>
                @if(isset($kegiatanTerdekat) && $kegiatanTerdekat->count())
                    @foreach($kegiatanTerdekat as $kg)
                    @php $tgl = \Carbon\Carbon::parse($kg->tanggal); @endphp
                    <div class="keg-item">
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                            <div style="flex:1;min-width:0;">
                                <div class="keg-name">{{ $kg->nama_kegiatan }}</div>
                                <div class="keg-meta">
                                    <i class="fa fa-calendar"></i> {{ $tgl->translatedFormat('d M Y') }}
                                    @if($kg->waktu) &nbsp;·&nbsp; <i class="fa fa-clock"></i> {{ $kg->waktu }} @endif
                                    @if($kg->tempat) &nbsp;·&nbsp; <i class="fa fa-location-dot"></i> {{ $kg->tempat }} @endif
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:3px;flex-shrink:0;">
                                @if($tgl->isToday())
                                    <span class="badge-berjalan">Hari Ini</span>
                                @else
                                    <span class="badge-akan">{{ $tgl->diffForHumans() }}</span>
                                @endif
                                @if($kg->kasKeluar)
                                    <span class="badge-anggaran">Rp.{{ number_format($kg->kasKeluar->nominal, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div style="margin-top:12px;text-align:center;">
                        <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 16px;"><i class="fa fa-plus"></i> Tambah Kegiatan</a>
                    </div>
                @else
                    <div style="text-align:center;padding:1.5rem;color:#999;font-size:13px;">
                        <i class="fa fa-calendar-xmark" style="font-size:24px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada kegiatan yang akan datang
                    </div>
                    <div style="margin-top:10px;text-align:center;">
                        <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 16px;"><i class="fa fa-plus"></i> Tambah Kegiatan</a>
                    </div>
                @endif
            </div>

            {{-- Data Pengurus --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-users" style="color:#0f8b6d;"></i> Data Pengurus</h3>
                    <a href="{{ route('pengurus.index') }}" class="wgt-link">Lihat semua →</a>
                </div>
                <div class="mini-stats mini-stats-2">
                    <div class="mini-stat" style="background:#f7fdf9;border-color:#e0f0e8;">
                        <div class="mini-stat-val" style="color:#0f8b6d;">{{ $totalPengurus ?? 0 }}</div>
                        <div class="mini-stat-lbl">Total Pengurus</div>
                    </div>
                    <div class="mini-stat" style="background:#f7fdf9;border-color:#e0f0e8;display:flex;align-items:center;justify-content:center;">
                        <a href="{{ route('pengurus.create') }}" class="btn-tambah" style="font-size:12px;padding:7px 14px;"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                @if(isset($dataPengurus) && $dataPengurus->count())
                    <div class="sec-sublabel">Daftar Pengurus</div>
                    <div class="person-list">
                        @foreach($dataPengurus->take(4) as $pgr)
                        <div class="person-item">
                            @if($pgr->foto)
                                <img src="{{ asset('storage/'.$pgr->foto) }}" class="person-avatar">
                            @else
                                <div class="person-avatar">{{ strtoupper(substr($pgr->nama, 0, 2)) }}</div>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div class="person-name">{{ $pgr->nama }}</div>
                                <div class="person-sub">{{ $pgr->jabatan ?? '-' }}</div>
                            </div>
                            @if($pgr->no_hp)
                                <div class="person-side"><i class="fa fa-phone" style="color:#0f8b6d;font-size:10px;"></i> {{ $pgr->no_hp }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @if($dataPengurus->count() > 4)
                        <div style="text-align:center;margin-top:10px;font-size:12px;color:#999;">+{{ $dataPengurus->count() - 4 }} lainnya — <a href="{{ route('pengurus.index') }}" style="color:#0f8b6d;">lihat semua</a></div>
                    @endif
                @endif
            </div>

            {{-- Data Imam --}}
            <div class="widget-box">
                <div class="wgt-head">
                    <h3><i class="fa-solid fa-user-tie" style="color:#0f8b6d;"></i> Data Imam</h3>
                    <a href="{{ route('imam.data') }}" class="wgt-link">Lihat semua →</a>
                </div>
                <div class="mini-stats mini-stats-2">
                    <div class="mini-stat" style="background:#f7fdf9;border-color:#e0f0e8;">
                        <div class="mini-stat-val" style="color:#0f8b6d;">{{ $totalImam ?? 0 }}</div>
                        <div class="mini-stat-lbl">Total Imam</div>
                    </div>
                    <div class="mini-stat" style="background:#f7fdf9;border-color:#e0f0e8;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;">
                        <div style="display:flex;gap:4px;flex-wrap:wrap;justify-content:center;">
                            <span class="status-tetap-sm">Tetap: {{ isset($dataImamList) ? $dataImamList->where('status','Tetap')->count() : 0 }}</span>
                            <span class="status-tamu-sm">Tamu: {{ isset($dataImamList) ? $dataImamList->where('status','Tamu')->count() : 0 }}</span>
                        </div>
                        <a href="{{ route('imam.data.create') }}" class="btn-tambah" style="font-size:12px;padding:5px 12px;"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                </div>
                @if(isset($dataImamList) && $dataImamList->count())
                    <div class="sec-sublabel">Daftar Imam</div>
                    <div class="person-list">
                        @foreach($dataImamList->take(4) as $im)
                        <div class="person-item">
                            <div class="person-avatar">{{ strtoupper(substr($im->nama, 0, 2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="person-name">{{ $im->nama }}</div>
                                <div class="person-sub">{{ $im->no_hp ?? '-' }}</div>
                            </div>
                            <span class="{{ $im->status == 'Tetap' ? 'status-tetap-sm' : 'status-tamu-sm' }}">{{ $im->status }}</span>
                        </div>
                        @endforeach
                    </div>
                    @if($dataImamList->count() > 4)
                        <div style="text-align:center;margin-top:10px;font-size:12px;color:#999;">+{{ $dataImamList->count() - 4 }} lainnya — <a href="{{ route('imam.data') }}" style="color:#0f8b6d;">lihat semua</a></div>
                    @endif
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') || session('welcome_message'))
<div
    id="dashboard-alert-data"
    data-success="{{ session('success') }}"
    data-welcome-message="{{ session('welcome_message') }}"
    hidden
></div>
@endif
<script>
const dashboardAlertData = document.getElementById('dashboard-alert-data');

if (dashboardAlertData?.dataset.success) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: dashboardAlertData.dataset.success,
        timer: 2000,
        showConfirmButton: false
    });
}

if (dashboardAlertData?.dataset.welcomeMessage) {
    Swal.fire({
        title: 'Selamat Datang!',
        text: dashboardAlertData.dataset.welcomeMessage,
        icon: 'success',
        confirmButtonColor: '#0f8b6d',
        confirmButtonText: 'Terima Kasih'
    });
}

document.addEventListener('click', function (event) {
    const button = event.target.closest('.js-confirm-submit');

    if (!button) {
        return;
    }

    const form = document.getElementById(button.dataset.formId);

    if (!form) {
        return;
    }

    Swal.fire({
        title: button.dataset.title || 'Yakin hapus?',
        text: button.dataset.text || '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: button.dataset.confirmColor || '#d33',
        cancelButtonColor: button.dataset.cancelColor || '#6c757d',
        confirmButtonText: button.dataset.confirmText || 'Ya, hapus!',
        cancelButtonText: button.dataset.cancelText || 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>
@endpush
