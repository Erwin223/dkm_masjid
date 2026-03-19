@extends('layouts.admin')

@section('content')

<style>
    .notif-success { position:fixed; top:20px; right:20px; background:#28a745; color:white; padding:12px 18px; border-radius:8px; z-index:999; animation:fadeIn 0.5s; }
    @keyframes fadeIn { from{opacity:0;transform:translateY(-10px);} to{opacity:1;transform:translateY(0);} }

    .cards { display:grid; grid-template-columns:repeat(5,1fr); gap:15px; margin-bottom:25px; }
    .card { padding:20px; border-radius:8px; color:white; display:flex; justify-content:space-between; align-items:center; }
    .card h3 { font-size:13px; margin-bottom:6px; opacity:.9; font-weight:500; }
    .card .card-value { font-size:18px; font-weight:700; margin:0; }
    .card .card-sub   { font-size:11px; margin-top:3px; opacity:.75; }
    .card i  { font-size:28px; opacity:.7; }
    .green  { background:#28a745; }
    .blue   { background:#17a2b8; }
    .orange { background:#fd7e14; }
    .purple { background:#6f42c1; }
    .teal   { background:#0f8b6d; }

    .dashboard-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .table-box { background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,.1); }
    .table-box h3 { font-size:15px; margin-bottom:5px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px; text-align:left; font-size:13px; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px; border-bottom:1px solid #eee; font-size:13px; white-space:nowrap; }
    .total-box { text-align:center; margin-top:15px; font-size:13px; }
    .btn-tambah { background:#0f8b6d; color:white; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:white; }
    .widget-box { background:white; padding:20px; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,.1); font-size:13px; }
    .saldo-positif { color:#28a745; font-weight:700; }
    .saldo-negatif { color:#dc3545; font-weight:700; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }

    @media(max-width:1200px){ .cards { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:900px) { .dashboard-grid { grid-template-columns:1fr; } .cards { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:600px) { .cards { grid-template-columns:repeat(2,1fr); gap:10px; } .card { padding:14px 12px; } .card h3 { font-size:12px; } .card .card-value { font-size:15px; } .card i { font-size:22px; } .btn-tambah { width:100%; justify-content:center; margin-top:8px; } h2 { font-size:18px; } }
</style>

<h2><i class="fa-solid fa-chart-line"></i> Dashboard Admin</h2>

@php
    $totalMasuk  = $totalKasMasuk  ?? 0;
    $totalKeluar = $totalKasKeluar ?? 0;
    $saldo       = $totalMasuk - $totalKeluar;
    $jmlMasuk    = isset($kasMasuk)  ? $kasMasuk->count()  : 0;
    $jmlKeluar   = isset($kasKeluar) ? $kasKeluar->count() : 0;
    $anggaranKeg = $totalAnggaranKegiatan ?? 0;
    $jmlJadwal   = $totalJadwal ?? 0;
@endphp

<div class="cards">

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

    <div class="card {{ $saldo >= 0 ? 'blue' : 'red' }}">
        <div>
            <h3>Saldo Kas</h3>
            <p class="card-value">Rp.{{ number_format(abs($saldo), 0, ',', '.') }}</p>
            <p class="card-sub">{{ $saldo >= 0 ? 'Kas positif' : 'Kas minus' }}</p>
        </div>
        <i class="fa-solid fa-wallet"></i>
    </div>

    <div class="card teal">
        <div>
            <h3>Anggaran Kegiatan</h3>
            <p class="card-value">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</p>
            <p class="card-sub">dari kas keluar</p>
        </div>
        <i class="fa-solid fa-calendar-check"></i>
    </div>

    <div class="card purple">
        <div>
            <h3>Jadwal Kegiatan</h3>
            <p class="card-value">{{ $jmlJadwal }}</p>
            <p class="card-sub">kegiatan akan datang</p>
        </div>
        <i class="fa-solid fa-calendar-days"></i>
    </div>

</div>

<div class="dashboard-grid">

    <div class="table-box">
        <h3><i class="fa-solid fa-table"></i> Data Kas Masuk</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th><th>Sumber</th><th>Jumlah</th>
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
                                <form id="delete-form-{{ $kas->id }}" action="{{ route('kas.masuk.delete', $kas->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $kas->id }})" style="border:none;background:none;cursor:pointer;">
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
                        <tr><td colspan="6" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td></tr>
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
                        <th>Tanggal</th><th>Jenis Pengeluaran</th><th>Jumlah</th>
                        <th>Nominal</th><th>Keterangan</th>
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
                                <form id="delete-keluar-{{ $keluar->id }}" action="{{ route('kas.keluar.delete', $keluar->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDeleteKeluar({{ $keluar->id }})" style="border:none;background:none;cursor:pointer;">
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
                        <tr><td colspan="7" style="text-align:center;color:#999;padding:1.5rem;">Belum ada data</td></tr>
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

    <div class="widget-box">
        <h3><i class="fa-solid fa-scale-balanced"></i> Ringkasan Keuangan</h3>
        <table style="min-width:unset;margin-top:15px;">
            <tr>
                <td style="border:none;padding:8px 0;color:#555;">Total Kas Masuk</td>
                <td style="border:none;padding:8px 0;text-align:right;color:#28a745;font-weight:600;">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border:none;padding:8px 0;color:#555;">Total Kas Keluar</td>
                <td style="border:none;padding:8px 0;text-align:right;color:#fd7e14;font-weight:600;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border:none;padding:8px 0;color:#555;">Anggaran Kegiatan</td>
                <td style="border:none;padding:8px 0;text-align:right;color:#0f8b6d;font-weight:600;">Rp.{{ number_format($anggaranKeg, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border:none;border-top:1px solid #eee;padding:0;"></td>
            </tr>
            <tr>
                <td style="border:none;padding:10px 0;font-weight:700;">Saldo Bersih</td>
                <td style="border:none;padding:10px 0;text-align:right;" class="{{ $saldo >= 0 ? 'saldo-positif' : 'saldo-negatif' }}">
                    {{ $saldo >= 0 ? '' : '-' }}Rp.{{ number_format(abs($saldo), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif

<script>
function confirmDelete(id){
    Swal.fire({ title:'Yakin hapus?', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById('delete-form-'+id).submit(); });
}
function confirmDeleteKeluar(id){
    Swal.fire({ title:'Yakin hapus?', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById('delete-keluar-'+id).submit(); });
}
</script>

@endsection
