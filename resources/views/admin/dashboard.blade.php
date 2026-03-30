@extends('layouts.admin')

@section('content')

    <style>
        .notif-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            z-index: 999;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 25px;
        }

        .card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card h3 {
            font-size: 13px;
            margin-bottom: 6px;
            opacity: .9;
            font-weight: 500;
        }

        .card .card-value {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .card .card-sub {
            font-size: 11px;
            margin-top: 3px;
            opacity: .75;
        }

        .card i {
            font-size: 28px;
            opacity: .7;
        }

        .green {
            background: #28a745;
        }

        .blue {
            background: #17a2b8;
        }

        .orange {
            background: #fd7e14;
        }

        .red {
            background: #dc3545;
        }

        .purple {
            background: #6f42c1;
        }

        .teal {
            background: #0f8b6d;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .dashboard-grid-3 {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 20px;
            align-items: start;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .table-box h3 {
            font-size: 15px;
            margin-bottom: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }

        table th {
            background: #f3f3f3;
            padding: 10px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
            border-bottom: 1px solid #e5e5e5;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            white-space: nowrap;
        }

        .total-box {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }

        .btn-tambah {
            background: #0f8b6d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-tambah:hover {
            background: #0c6d55;
            color: white;
        }

        .widget-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            font-size: 13px;
        }

        .saldo-positif {
            color: #28a745;
            font-weight: 700;
        }

        .badge-akan {
            background: #fff3cd;
            color: #856404;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-selesai {
            background: #d1e7dd;
            color: #0f5132;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-berjalan {
            background: #cfe2ff;
            color: #084298;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-anggaran {
            background: #faeeda;
            color: #633806;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .pgr-avatar-sm {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e1f5ee;
            border: 2px solid #9fe1cb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: #0f6e56;
            flex-shrink: 0;
            object-fit: cover;
        }

        .status-tetap-sm {
            background: #e1f5ee;
            color: #085041;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .status-tamu-sm {
            background: #fff3cd;
            color: #856404;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            display: inline-block;
        }

        .saldo-negatif {
            color: #dc3545;
            font-weight: 700;
        }

        td i {
            transition: 0.2s;
        }

        .fa-edit:hover {
            color: darkblue;
            transform: scale(1.2);
        }

        .fa-trash:hover {
            color: darkred;
            transform: scale(1.2);
        }

        @media(max-width:1200px) {
            .cards {
                grid-template-columns: repeat(4, 1fr);
            }

            .dashboard-grid-3 {
                grid-template-columns: 1fr 360px;
            }
        }

        @media(max-width:900px) {
            .dashboard-grid-3 {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .card {
                padding: 14px 12px;
            }

            .card h3 {
                font-size: 12px;
            }

            .card .card-value {
                font-size: 15px;
            }

            .card i {
                font-size: 22px;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }

            h2 {
                font-size: 18px;
            }
        }

        .pink {
            background: #d4537e;
        }

        .indigo {
            background: #4361ee;
        }
    </style>

    <h2><i class="fa-solid fa-chart-line"></i> Dashboard Admin</h2>

    @php
        $totalMasuk = $totalKasMasuk ?? 0;
        $totalKeluar = $totalKasKeluar ?? 0;
        $saldo = $totalMasuk - $totalKeluar;
        $saldoDonasi = ($totalDonasiMasuk ?? 0) - ($totalDonasiKeluar ?? 0);
        $saldoBersihTotal = $saldo + $saldoDonasi;
        $jmlMasuk = isset($kasMasuk) ? $kasMasuk->count() : 0;
        $jmlKeluar = isset($kasKeluar) ? $kasKeluar->count() : 0;
        $anggaranKeg = $totalAnggaranKegiatan ?? 0;
        $jmlJadwal = $totalJadwal ?? 0;
    @endphp

    <div class="cards">

        <div class="card {{ $saldo >= 0 ? 'blue' : 'red' }}">
            <div>
                <h3>Saldo Kas</h3>
                <p class="card-value">{{ $saldo < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldo), 0, ',', '.') }}</p>
                <p class="card-sub">{{ $saldo >= 0 ? 'Kas positif' : 'Kas minus' }}</p>
            </div>
            <i class="fa-solid fa-wallet"></i>
        </div>

        <div class="card {{ $saldoDonasi >= 0 ? 'pink' : 'red' }}">
            <div>
                <h3>Saldo Donasi</h3>
                <p class="card-value">{{ $saldoDonasi < 0 ? '-Rp.' : 'Rp.' }}{{ number_format(abs($saldoDonasi), 0, ',', '.') }}</p>
                <p class="card-sub">{{ $saldoDonasi >= 0 ? 'Donasi positif' : 'Donasi minus' }}</p>
            </div>
            <i class="fa-solid fa-scale-balanced"></i>
        </div>

        <div class="card green">
            <div>
                <h3>Total Kas Masuk</h3>
                <p class="card-value">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</p>
                <p class="card-sub">{{ $jmlMasuk }} transaksi</p>
            </div>
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>

        <div class="card orange">
            <div>
                <h3>Total Kas Keluar</h3>
                <p class="card-value">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</p>
                <p class="card-sub">{{ $jmlKeluar }} transaksi</p>
            </div>
            <i class="fa-solid fa-money-bill-transfer"></i>
        </div>

        <div class="card pink">
            <div>
                <h3>Donasi Masuk</h3>
                <p class="card-value">Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</p>
                <p class="card-sub">{{ $jmlDonasiMasuk ?? 0 }} transaksi</p>
            </div>
            <i class="fa-solid fa-hand-holding-heart"></i>
        </div>

        <div class="card indigo">
            <div>
                <h3>Donasi Keluar</h3>
                <p class="card-value">Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</p>
                <p class="card-sub">{{ $jmlDonasiKeluar ?? 0 }} transaksi</p>
            </div>
            <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>

        <div class="card teal">
            <div>
                <h3>Anggaran Kegiatan</h3>
                <p class="card-value">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</p>
                <p class="card-sub">dari kas keluar</p>
            </div>
            <i class="fa-solid fa-calendar-check"></i>
        </div>

        <div class="card teal" style="background:#20c997;">
            <div>
                <h3>Total Donatur</h3>
                <p class="card-value">{{ $totalDonatur ?? 0 }}</p>
                <p class="card-sub">donatur terdaftar</p>
            </div>
            <i class="fa-solid fa-people-group"></i>
        </div>

        <div class="card purple">
            <div>
                <h3>Jadwal Kegiatan</h3>
                <p class="card-value">{{ $jmlJadwal }}</p>
                <p class="card-sub">kegiatan akan datang</p>
            </div>
            <i class="fa-solid fa-calendar-days"></i>
        </div>

        <div class="card" style="background:#34495e;">
            <div>
                <h3>Kelola Website</h3>
                <p class="card-value">{{ $totalBerita ?? 0 }} Berita</p>
                <p class="card-sub">{{ $totalGaleri ?? 0 }} Foto Galeri</p>
            </div>
            <i class="fa-solid fa-globe"></i>
        </div>

    </div>
    <div class="dashboard-grid-3">

        {{-- KOLOM KIRI --}}
        <div style="display:flex;flex-direction:column;gap:20px;">
            <div class="table-box">
                <h3><i class="fa-solid fa-table"></i> Data Kas Masuk</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sumber</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
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
                                            <form id="delete-form-{{ $kas->id }}" action="{{ route('kas.masuk.delete', $kas->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $kas->id }})"
                                                    style="border:none;background:none;cursor:pointer;">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('kas.masuk.edit', $kas->id) }}">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="total-box">
                    <strong>Total Kas Masuk : Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</strong><br><br>
                    <a href="{{ route('kas.masuk.create') }}" class="btn-tambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>
            <div class="table-box">
                <h3><i class="fa-solid fa-money-bill-wave"></i> Data Kas Keluar</h3>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Pengeluaran</th>
                                <th>Jumlah</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($kasKeluar) && $kasKeluar->count())
                                @foreach($kasKeluar as $keluar)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($keluar->tanggal)->translatedFormat('d M Y') }}</td>
                                        <td>{{ $keluar->jenis_pengeluaran }}</td>
                                        <td>{{ $keluar->jumlah }}</td>
                                        <td>Rp.{{ number_format($keluar->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $keluar->keterangan ?? '-' }}</td>
                                        <td style="text-align:center;">
                                            <form id="delete-keluar-{{ $keluar->id }}"
                                                action="{{ route('kas.keluar.delete', $keluar->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDeleteKeluar({{ $keluar->id }})"
                                                    style="border:none;background:none;cursor:pointer;">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('kas.keluar.edit', $keluar->id) }}">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="total-box">
                    <strong>Total Kas Keluar : Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong><br><br>
                    <a href="{{ route('kas.keluar.create') }}" class="btn-tambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                </div>
            </div>

            {{-- DATA DONATUR --}}
            <div class="table-box">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-people-group" style="color:#20c997;"></i> Data Donatur</h3>
                    <a href="{{ route('donatur.index') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Donatur</th>
                                <th>No. HP</th>
                                <th>Jenis Donatur</th>
                                <th>Tgl Daftar</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($dataDonatur) && $dataDonatur->count())
                                @foreach($dataDonatur as $dtr)
                                    <tr>
                                        <td>{{ $dtr->nama }}</td>
                                        <td>{{ $dtr->no_hp ?? '-' }}</td>
                                        <td><span class="status-tetap-sm"
                                                style="background:#e6fcf5;color:#0ca678;">{{ $dtr->jenis_donatur }}</span></td>
                                        <td>{{ $dtr->tanggal_daftar ? $dtr->tanggal_daftar->translatedFormat('d M Y') : '-' }}</td>
                                        <td style="text-align:center;">
                                            <form id="delete-donatur-{{ $dtr->id }}"
                                                action="{{ route('donatur.delete', $dtr->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDeleteDonatur({{ $dtr->id }})"
                                                    style="border:none;background:none;cursor:pointer;">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('donatur.edit', $dtr->id) }}">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data donatur
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DATA DONASI MASUK --}}
            <div class="table-box">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-hand-holding-heart" style="color:#d4537e;"></i> Data Donasi
                        Masuk</h3>
                    <a href="{{ route('donasi.masuk') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Donatur</th>
                                <th>Jenis</th>
                                <th>Total</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($donasiMasukList) && $donasiMasukList->count())
                                @foreach($donasiMasukList as $dm)
                                    <tr>
                                        <td>{{ $dm->tanggal->translatedFormat('d M Y') }}</td>
                                        <td>{{ $dm->nama_donatur }}</td>
                                        <td><span class="badge-berjalan"
                                                style="background:#fbeaf0;color:#d4537e;border:1px solid #f4c0d1;">{{ $dm->jenis_donasi }}</span>
                                        </td>
                                        <td style="font-weight:600;color:#d4537e;">Rp.{{ number_format($dm->total, 0, ',', '.') }}
                                        </td>
                                        <td style="text-align:center;">
                                            <form id="delete-donasi-masuk-{{ $dm->id }}"
                                                action="{{ route('donasi.masuk.delete', $dm->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDeleteDonasiMasuk({{ $dm->id }})"
                                                    style="border:none;background:none;cursor:pointer;">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('donasi.masuk.edit', $dm->id) }}">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data donasi
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DATA DONASI KELUAR --}}
            <div class="table-box">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-hand-holding-dollar" style="color:#4361ee;"></i> Data Donasi
                        Keluar</h3>
                    <a href="{{ route('donasi.keluar') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tujuan</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($donasiKeluarList) && $donasiKeluarList->count())
                                @foreach($donasiKeluarList as $dk)
                                    <tr>
                                        <td>{{ $dk->tanggal->translatedFormat('d M Y') }}</td>
                                        <td>{{ $dk->tujuan }}</td>
                                        <td><span class="badge-berjalan"
                                                style="background:#eef0fd;color:#4361ee;border:1px solid #c5caf7;">{{ $dk->jenis_donasi }}</span>
                                        </td>
                                        <td style="font-weight:600;color:#4361ee;">Rp.{{ number_format($dk->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td style="text-align:center;">
                                            <form id="delete-donasi-keluar-{{ $dk->id }}"
                                                action="{{ route('donasi.keluar.delete', $dk->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="button" onclick="confirmDeleteDonasiKeluar({{ $dk->id }})"
                                                    style="border:none;background:none;cursor:pointer;">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('donasi.keluar.edit', $dk->id) }}">
                                                <i class="fa fa-edit" style="color:blue;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data
                                        pengeluaran donasi</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-newspaper" style="color:#f39c12;"></i> Data Berita Terbaru
                    </h3>
                    <a href="{{ route('berita.index') }}"
                        style="font-size:12px; color:#0f8b6d; text-decoration:none; font-weight:500;">Lihat semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($beritaTerbaru as $b)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td style="font-weight:600; color:#333;">{{ Str::limit($b->judul, 40) }}</td>
                                    <td><span class="badge-selesai">{{ $b->penulis }}</span></td>
                                    <td style="text-align:center;">
                                        <form action="{{ route('berita.delete', $b->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Yakin hapus berita ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="border:none;background:none;cursor:pointer;"><i
                                                    class="fa fa-trash" style="color:red;"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('berita.edit', $b->id) }}"><i class="fa fa-edit"
                                                style="color:blue;"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;color:#999;padding:1.5rem;">Belum ada berita</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-images" style="color:#3498db;"></i> Data Galeri Terbaru</h3>
                    <a href="{{ route('galeri.index') }}"
                        style="font-size:12px; color:#0f8b6d; text-decoration:none; font-weight:500;">Lihat semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th style="text-align:center;">Hapus</th>
                                <th style="text-align:center;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galeriTerbaru as $g)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($g->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td><img src="{{ asset('storage/' . $g->gambar) }}"
                                            style="width:40px;height:40px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                                    </td>
                                    <td style="font-weight:600; color:#333;">{{ Str::limit($g->judul, 40) }}</td>
                                    <td style="text-align:center;">
                                        <form action="{{ route('galeri.delete', $g->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Yakin hapus galeri ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="border:none;background:none;cursor:pointer;"><i
                                                    class="fa fa-trash" style="color:red;"></i></button>
                                        </form>
                                    </td>
                                    <td style="text-align:center;">
                                        <a href="{{ route('galeri.edit', $g->id) }}"><i class="fa fa-edit"
                                                style="color:blue;"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;color:#999;padding:1.5rem;">Belum ada galeri</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        {{-- KOLOM KANAN --}}
        <div style="display:flex;flex-direction:column;gap:20px;">

            {{-- RINGKASAN KEUANGAN --}}
            <div class="widget-box">
                <h3><i class="fa-solid fa-scale-balanced"></i> Ringkasan Keuangan</h3>
                <table style="min-width:unset;margin-top:15px;">
                    <tr>
                        <td style="border:none;padding:8px 0;color:#555;">Total Kas Masuk</td>
                        <td style="border:none;padding:8px 0;text-align:right;color:#28a745;font-weight:600;">
                            Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;color:#555;">Total Kas Keluar</td>
                        <td style="border:none;padding:8px 0;text-align:right;color:#fd7e14;font-weight:600;">
                            Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;color:#555;">Anggaran Kegiatan</td>
                        <td style="border:none;padding:8px 0;text-align:right;color:#0f8b6d;font-weight:600;">
                            Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;color:#555;">Donasi Masuk</td>
                        <td style="border:none;padding:8px 0;text-align:right;color:#d4537e;font-weight:600;">
                            Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;color:#555;">Donasi Keluar</td>
                        <td style="border:none;padding:8px 0;text-align:right;color:#4361ee;font-weight:600;">
                            Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none;border-top:1px solid #eee;padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:10px 0;font-weight:700;">Saldo Bersih</td>
                        <td style="border:none;padding:10px 0;text-align:right;"
                            class="{{ $saldoBersihTotal >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                            {{ $saldoBersihTotal >= 0 ? '' : '-' }}Rp.{{ number_format(abs($saldoBersihTotal), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- RINGKASAN KAS --}}
            <div class="widget-box">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-wallet" style="color:#17a2b8;"></i> Ringkasan Kas</h3>
                    <a href="{{ route('kas.keluar.index') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua <i class="fa fa-arrow-right" style="font-size:10px;"></i></a>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                    <div
                        style="background:#eaf7ee;border-radius:8px;padding:12px;text-align:center;border:1px solid #b9e3c6;">
                        <div style="font-size:18px;font-weight:700;color:#28a745;">
                            Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Kas Masuk</div>
                    </div>
                    <div
                        style="background:#fff1e7;border-radius:8px;padding:12px;text-align:center;border:1px solid #ffd2b3;">
                        <div style="font-size:18px;font-weight:700;color:#fd7e14;">
                            Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Kas Keluar</div>
                    </div>
                </div>
                <div style="margin-bottom:12px;">
                    <div
                        style="background:#e7f7f3;border-radius:8px;padding:12px;text-align:center;border:1px solid #b8e7d9;">
                        <div style="font-size:18px;font-weight:700;color:#0f8b6d;">
                            Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Anggaran</div>
                    </div>
                </div>
                <table style="min-width:unset;width:100%;">
                    <tr>
                        <td style="border:none;padding:6px 0;color:#555;font-size:13px;">Total Kas Masuk</td>
                        <td
                            style="border:none;padding:6px 0;text-align:right;color:#28a745;font-weight:600;font-size:13px;">
                            Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:6px 0;color:#555;font-size:13px;">Total Kas Keluar</td>
                        <td
                            style="border:none;padding:6px 0;text-align:right;color:#fd7e14;font-weight:600;font-size:13px;">
                            Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:6px 0;color:#555;font-size:13px;">Anggaran Kegiatan</td>
                        <td
                            style="border:none;padding:6px 0;text-align:right;color:#0f8b6d;font-weight:600;font-size:13px;">
                            Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none;border-top:1px solid #eee;padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;font-weight:700;font-size:13px;">Saldo Kas</td>
                        <td
                            style="border:none;padding:8px 0;text-align:right;font-weight:700;font-size:13px;color:{{ $saldo >= 0 ? '#28a745' : '#dc3545' }};">
                            {{ $saldo >= 0 ? '' : '-' }}Rp.{{ number_format(abs($saldo), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- RINGKASAN DONASI --}}
            <div class="widget-box">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-hand-holding-heart" style="color:#d4537e;"></i> Ringkasan
                        Donasi</h3>
                    <a href="{{ route('donasi.masuk') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua <i class="fa fa-arrow-right" style="font-size:10px;"></i></a>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px;">
                    <div
                        style="background:#fbeaf0;border-radius:8px;padding:12px;text-align:center;border:1px solid #f4c0d1;">
                        <div style="font-size:18px;font-weight:700;color:#d4537e;">
                            Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Donasi Masuk</div>
                    </div>
                    <div
                        style="background:#eef0fd;border-radius:8px;padding:12px;text-align:center;border:1px solid #c5caf7;">
                        <div style="font-size:18px;font-weight:700;color:#4361ee;">
                            Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Donasi Keluar</div>
                    </div>
                </div>
                <table style="min-width:unset;width:100%;">
                    <tr>
                        <td style="border:none;padding:6px 0;color:#555;font-size:13px;">Total Donasi Masuk</td>
                        <td
                            style="border:none;padding:6px 0;text-align:right;color:#d4537e;font-weight:600;font-size:13px;">
                            Rp.{{ number_format($totalDonasiMasuk ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:6px 0;color:#555;font-size:13px;">Total Donasi Keluar</td>
                        <td
                            style="border:none;padding:6px 0;text-align:right;color:#4361ee;font-weight:600;font-size:13px;">
                            Rp.{{ number_format($totalDonasiKeluar ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none;border-top:1px solid #eee;padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding:8px 0;font-weight:700;font-size:13px;">Saldo Donasi</td>
                        <td
                            style="border:none;padding:8px 0;text-align:right;font-weight:700;font-size:13px;color:{{ ($totalDonasiMasuk ?? 0) >= ($totalDonasiKeluar ?? 0) ? '#28a745' : '#dc3545' }};">
                            Rp.{{ number_format(abs(($totalDonasiMasuk ?? 0) - ($totalDonasiKeluar ?? 0)), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- RINGKASAN DONATUR --}}
            <div class="widget-box">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-people-group" style="color:#20c997;"></i> Data Donatur
                        Terbaru</h3>
                    <a href="{{ route('donatur.index') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">Lihat
                        semua</a>
                </div>
                @if(isset($donaturList) && $donaturList->count())
                    @foreach($donaturList as $dtr)
                        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f5f5f5;">
                            <div
                                style="width:34px;height:34px;border-radius:50%;background:#e6fcf5;border:2px solid #b2f2bb;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#0ca678;flex-shrink:0;">
                                {{ strtoupper(substr($dtr->nama, 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-weight:500;font-size:13px;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $dtr->nama }}</div>
                                <div style="font-size:11px;color:#999;margin-top:1px;">{{ $dtr->jenis_donatur }}</div>
                            </div>
                            <div style="font-size:11px;color:#aaa;white-space:nowrap;flex-shrink:0;">
                                {{ $dtr->tanggal_daftar ? $dtr->tanggal_daftar->translatedFormat('d M Y') : '-' }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align:center;padding:1rem;color:#999;font-size:13px;">Belum ada </div>
                @endif
                <div style="margin-top:12px;text-align:center;">
                    <a href="{{ route('donatur.create') }}" class="btn-tambah"
                        style="font-size:12px;padding:7px 16px;background:#20c997;">
                        <i class="fa fa-plus"></i> Tambah Donatur
                    </a>
                </div>
            </div>

            {{-- RINGKASAN KEGIATAN --}}
            <div class="widget-box">
                <div
                    style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;flex-wrap:wrap;gap:8px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-calendar-check" style="color:#0f8b6d;"></i> Ringkasan
                        Kegiatan</h3>
                    <a href="{{ route('kegiatan.jadwal') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">
                        Lihat semua <i class="fa fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>
                {{-- STAT MINI --}}
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:15px;">
                    <div
                        style="background:#f7fdf9;border-radius:8px;padding:12px;text-align:center;border:1px solid #e0f0e8;">
                        <div style="font-size:20px;data donaturfont-weight:700;color:#0f8b6d;">
                            {{ $statKegiatan['akan_datang'] ?? 0 }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Akan Datang</div>
                    </div>
                    <div
                        style="background:#f0f9ff;border-radius:8px;padding:12px;text-align:center;border:1px solid #cfe2ff;">
                        <div style="font-size:20px;font-weight:700;color:#084298;">{{ $statKegiatan['hari_ini'] ?? 0 }}
                        </div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Hari Ini</div>
                    </div>
                    <div
                        style="background:#f8f8f8;border-radius:8px;padding:12px;text-align:center;border:1px solid #e5e5e5;">
                        <div style="font-size:20px;font-weight:700;color:#444;">{{ $statKegiatan['selesai'] ?? 0 }}</div>
                        <div style="font-size:11px;color:#666;margin-top:3px;">Selesai</div>
                    </div>
                </div>

                {{-- LIST KEGIATAN TERDEKAT --}}
                <div
                    style="font-size:11px;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                    Kegiatan Terdekat
                </div>
                @if(isset($kegiatanTerdekat) && $kegiatanTerdekat->count())
                    @foreach($kegiatanTerdekat as $kg)
                        <div style="padding:10px 0;border-bottom:1px solid #f5f5f5;">
                            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;">
                                <div style="flex:1;min-width:0;">
                                    <div style="font-weight:500;font-size:13px;color:#111;">{{ $kg->nama_kegiatan }}</div>
                                    <div style="font-size:11px;color:#999;margin-top:3px;">
                                        <i class="fa fa-calendar" style="color:#0f8b6d;"></i>
                                        {{ \Carbon\Carbon::parse($kg->tanggal)->translatedFormat('d M Y') }}
                                        @if($kg->waktu) &nbsp;·&nbsp; <i class="fa fa-clock" style="color:#0f8b6d;"></i>
                                        {{ $kg->waktu }} @endif
                                        @if($kg->tempat) &nbsp;·&nbsp; <i class="fa fa-location-dot" style="color:#0f8b6d;"></i>
                                        {{ $kg->tempat }} @endif
                                    </div>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:3px;flex-shrink:0;">
                                    @php $tgl = \Carbon\Carbon::parse($kg->tanggal); @endphp
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
                        <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah"
                            style="font-size:12px;padding:7px 16px;">
                            <i class="fa fa-plus"></i> Tambah Kegiatan
                        </a>
                    </div>
                @else
                    <div style="text-align:center;padding:1.5rem;color:#999;font-size:13px;">
                        <i class="fa fa-calendar-xmark" style="font-size:24px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada kegiatan yang akan datang
                    </div>
                    <div style="margin-top:10px;text-align:center;">
                        <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah"
                            style="font-size:12px;padding:7px 16px;">
                            <i class="fa fa-plus"></i> Tambah Kegiatan
                        </a>
                    </div>
                @endif
            </div>

            {{-- RINGKASAN PENGURUS --}}
            <div class="widget-box">
                <div
                    style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;flex-wrap:wrap;gap:8px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-users" style="color:#0f8b6d;"></i> Data Pengurus</h3>
                    <a href="{{ route('pengurus.index') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">
                        Lihat semua <i class="fa fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>

                {{-- STAT --}}
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:15px;">
                    <div
                        style="background:#f7fdf9;border-radius:8px;padding:16px;text-align:center;border:1px solid #e0f0e8;">
                        <div style="font-size:32px;font-weight:700;color:#0f8b6d;">{{ $totalPengurus ?? 0 }}</div>
                        <div style="font-size:12px;color:#666;margin-top:4px;">Total Pengurus</div>
                    </div>
                    <div
                        style="background:#f7fdf9;border-radius:8px;padding:16px;border:1px solid #e0f0e8;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                        <div style="font-size:11px;color:#999;">Kelola Pengurus</div>
                        <a href="{{ route('pengurus.create') }}" class="btn-tambah"
                            style="font-size:12px;padding:7px 14px;">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                {{-- LIST --}}
                @if(isset($dataPengurus) && $dataPengurus->count())
                    <div
                        style="font-size:11px;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                        Daftar Pengurus</div>
                    @foreach($dataPengurus->take(4) as $pgr)
                        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f5f5f5;">
                            @if($pgr->foto)
                                <img src="{{ asset('storage/' . $pgr->foto) }}"
                                    style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #9fe1cb;flex-shrink:0;">
                            @else
                                <div
                                    style="width:34px;height:34px;border-radius:50%;background:#e1f5ee;border:2px solid #9fe1cb;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#0f6e56;flex-shrink:0;">
                                    {{ strtoupper(substr($pgr->nama, 0, 2)) }}
                                </div>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-weight:500;font-size:13px;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $pgr->nama }}</div>
                                <div style="font-size:11px;color:#999;margin-top:1px;">{{ $pgr->jabatan ?? '-' }}</div>
                            </div>
                            @if($pgr->no_hp)
                                <div style="font-size:11px;color:#aaa;white-space:nowrap;flex-shrink:0;">
                                    <i class="fa fa-phone" style="font-size:10px;color:#0f8b6d;"></i> {{ $pgr->no_hp }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if($dataPengurus->count() > 4)
                        <div style="text-align:center;margin-top:10px;font-size:12px;color:#999;">
                            +{{ $dataPengurus->count() - 4 }} pengurus lainnya —
                            <a href="{{ route('pengurus.index') }}" style="color:#0f8b6d;">lihat semua</a>
                        </div>
                    @endif
                @endif
            </div>

            {{-- RINGKASAN IMAM --}}
            <div class="widget-box">
                <div
                    style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px;flex-wrap:wrap;gap:8px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-user-tie" style="color:#0f8b6d;"></i> Data Imam</h3>
                    <a href="{{ route('imam.data') }}" style="font-size:12px;color:#0f8b6d;text-decoration:none;">
                        Lihat semua <i class="fa fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                </div>

                {{-- STAT --}}
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:15px;">
                    <div
                        style="background:#f7fdf9;border-radius:8px;padding:16px;text-align:center;border:1px solid #e0f0e8;">
                        <div style="font-size:32px;font-weight:700;color:#0f8b6d;">{{ $totalImam ?? 0 }}</div>
                        <div style="font-size:12px;color:#666;margin-top:4px;">Total Imam</div>
                    </div>
                    <div
                        style="background:#f7fdf9;border-radius:8px;padding:16px;border:1px solid #e0f0e8;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;">
                        <div style="display:flex;gap:6px;flex-wrap:wrap;justify-content:center;">
                            <span
                                style="background:#e1f5ee;color:#085041;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                Tetap: {{ isset($dataImamList) ? $dataImamList->where('status', 'Tetap')->count() : 0 }}
                            </span>
                            <span
                                style="background:#fff3cd;color:#856404;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">
                                Tamu: {{ isset($dataImamList) ? $dataImamList->where('status', 'Tamu')->count() : 0 }}
                            </span>
                        </div>
                        <a href="{{ route('imam.data.create') }}" class="btn-tambah"
                            style="font-size:12px;padding:7px 14px;">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                {{-- LIST --}}
                @if(isset($dataImamList) && $dataImamList->count())
                    <div
                        style="font-size:11px;font-weight:600;color:#999;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">
                        Daftar Imam</div>
                    @foreach($dataImamList->take(4) as $im)
                        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f5f5f5;">
                            <div
                                style="width:34px;height:34px;border-radius:50%;background:#e1f5ee;border:2px solid #9fe1cb;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#0f6e56;flex-shrink:0;">
                                {{ strtoupper(substr($im->nama, 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-weight:500;font-size:13px;color:#111;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $im->nama }}</div>
                                <div style="font-size:11px;color:#999;margin-top:1px;">{{ $im->no_hp ?? '-' }}</div>
                            </div>
                            <span
                                style="background:{{ $im->status == 'Tetap' ? '#e1f5ee' : '#fff3cd' }};color:{{ $im->status == 'Tetap' ? '#085041' : '#856404' }};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;flex-shrink:0;">
                                {{ $im->status }}
                            </span>
                        </div>
                    @endforeach
                    @if($dataImamList->count() > 4)
                        <div style="text-align:center;margin-top:10px;font-size:12px;color:#999;">
                            +{{ $dataImamList->count() - 4 }} imam lainnya —
                            <a href="{{ route('imam.data') }}" style="color:#0f8b6d;">lihat semua</a>
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('success')), timer: 2000, showConfirmButton: false });</script>
    @endif

    @if(session('welcome_message'))
        <script>
            Swal.fire({
                title: 'Selamat Datang!',
                text: @json(session('welcome_message')),
                icon: 'success',
                confirmButtonColor: '#0f8b6d',
                confirmButtonText: 'Terima Kasih'
            });
        </script>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({ title: 'Yakin hapus?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#0f8b6d', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' })
                .then(r => { if (r.isConfirmed) document.getElementById('delete-form-' + id).submit(); });
        }
        function confirmDeleteKeluar(id) {
            Swal.fire({ title: 'Yakin hapus?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#0f8b6d', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' })
                .then(r => { if (r.isConfirmed) document.getElementById('delete-keluar-' + id).submit(); });
        }
        function confirmDeleteDonatur(id) {
            Swal.fire({ title: 'Yakin hapus donatur?', text: 'Menghapus donatur akan mempengaruhi data donasi terkait.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#0f8b6d', cancelButtonColor: '#d33', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' })
                .then(r => { if (r.isConfirmed) document.getElementById('delete-donatur-' + id).submit(); });
        }
        function confirmDeleteDonasiMasuk(id) {
            Swal.fire({ title: 'Yakin hapus donasi masuk?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' })
                .then(r => { if (r.isConfirmed) document.getElementById('delete-donasi-masuk-' + id).submit(); });
        }
        function confirmDeleteDonasiKeluar(id) {
            Swal.fire({ title: 'Yakin hapus donasi keluar?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal' })
                .then(r => { if (r.isConfirmed) document.getElementById('delete-donasi-keluar-' + id).submit(); });
        }
    </script>

@endsection
