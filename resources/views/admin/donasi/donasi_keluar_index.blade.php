@extends('layouts.admin')

@section('content')

<style>
    .don-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .don-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .don-icon   { width:38px; height:38px; background:#faeeda; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .don-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .don-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .don-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .don-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
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
    .summary-row { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px; }
    .summary-card { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:16px; }
    .summary-card .s-label { font-size:12px; color:#999; margin-bottom:6px; }
    .summary-card .s-value { font-size:20px; font-weight:700; }
    .badge-jenis { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:#faeeda; color:#633806; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:768px){ .summary-row { grid-template-columns:1fr 1fr; } }
    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input,.btn-tambah { width:100%; justify-content:center; } .summary-row { grid-template-columns:1fr; } }
</style>

<div class="don-header">
    <div class="don-title">
        <div class="don-icon"><i class="fa fa-hand-holding-dollar" style="color:#854f0b;font-size:16px;"></i></div>
        Donasi
    </div>
</div>

<div class="don-nav">
    <a href="{{ route('donasi.masuk') }}" {{ request()->routeIs('donasi.masuk*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Donasi Masuk
    </a>
    <a href="{{ route('donasi.keluar') }}" {{ request()->routeIs('donasi.keluar*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Donasi Keluar
    </a>
</div>

<div class="summary-row">
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Total Donasi Keluar</div>
        <div class="s-value" style="color:#fd7e14;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $data->count() }} transaksi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-bullseye" style="color:#6f42c1;"></i> Tujuan Unik</div>
        <div class="s-value" style="color:#6f42c1;">{{ $data->pluck('tujuan')->unique()->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">tujuan penyaluran</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">{{ $data->filter(fn($d) => \Carbon\Carbon::parse($d->tanggal)->isCurrentMonth())->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Daftar Donasi Keluar</h3>
            <span style="font-size:12px;color:#633806;background:#faeeda;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari jenis / tujuan..." onkeyup="cariData()">
            <a href="{{ route('donasi.keluar.create') }}" class="btn-tambah">
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
                    <th>Jenis Donasi</th>
                    <th>Tujuan</th>
                    <th>Jumlah</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="badge-jenis">{{ $d->jenis_donasi }}</span></td>
                    <td style="font-weight:500;color:#111;">{{ $d->tujuan }}</td>
                    <td>{{ $d->label_jumlah }}</td>
                    <td style="font-weight:600;color:#fd7e14;">Rp.{{ number_format($d->nilai_dana, 0, ',', '.') }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-dk-{{ $d->id }}" action="{{ route('donasi.keluar.delete', $d->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-dk-{{ $d->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('donasi.keluar.edit', $d->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data donasi keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->count())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total Keseluruhan: Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
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
