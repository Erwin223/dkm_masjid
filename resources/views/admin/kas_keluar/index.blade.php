@extends('layouts.admin')

@section('content')

<style>
    .kas-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .kas-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .kas-icon   { width:38px; height:38px; background:#faeeda; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .kas-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .kas-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .kas-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .kas-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .summary-row { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px; }
    .summary-card { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:16px; }
    .summary-card .s-label { font-size:12px; color:#999; margin-bottom:6px; }
    .summary-card .s-value { font-size:20px; font-weight:700; }
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }
    .jenis-pill { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:#faeeda; color:#633806; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:768px){ .summary-row { grid-template-columns:1fr 1fr; } }
    @media(max-width:600px){ .summary-row { grid-template-columns:1fr; } .top-row { flex-direction:column; align-items:flex-start; } .search-input,.btn-tambah { width:100%; justify-content:center; } }
</style>

<div class="kas-header">
    <div class="kas-title">
        <div class="kas-icon"><i class="fa fa-money-bill-wave" style="color:#854f0b;font-size:15px;"></i></div>
        Kas Masjid
    </div>
</div>

<div class="kas-nav">
    <a href="{{ route('kas.masuk.index') }}" {{ request()->routeIs('kas.masuk*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Kas Masuk
    </a>
    <a href="{{ route('kas.keluar.index') }}" {{ request()->routeIs('kas.keluar*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Kas Keluar
    </a>
</div>

<div class="summary-row">
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Total Kas Keluar</div>
        <div class="s-value" style="color:#fd7e14;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $data->count() }} transaksi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">Rp.{{ number_format($keluarBulanIni, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-list" style="color:#6f42c1;"></i> Transaksi Bulan Ini</div>
        <div class="s-value" style="color:#6f42c1;">{{ $jmlBulanIni }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">transaksi tercatat</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Daftar Kas Keluar</h3>
            <span style="font-size:12px;color:#633806;background:#faeeda;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari jenis / keterangan..." onkeyup="cariData()">
            <a href="{{ route('kas.keluar.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $kas)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="jenis-pill">{{ $kas->jenis_pengeluaran }}</span></td>
                    <td style="font-weight:600;color:#fd7e14;">Rp.{{ number_format($kas->nominal, 0, ',', '.') }}</td>
                    <td>{{ $kas->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-kk-{{ $kas->id }}" action="{{ route('kas.keluar.delete', $kas->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-kk-{{ $kas->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('kas.keluar.edit', $kas->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data kas keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->count())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total: Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' data';
}
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>

@endsection
