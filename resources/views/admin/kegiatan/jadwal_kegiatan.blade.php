@extends('layouts.admin')
@section('content')
<style>
    .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:500px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:left; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:10px 12px; font-size:13px; border-bottom:1px solid #f5f5f5; vertical-align:middle; }
    table tbody tr:hover { background:#f7fdf9; }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:9px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
    .btn-tambah:hover { background:#0c6d55; color:#fff; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; min-width:200px; }
    .search-input:focus { border-color:#0f8b6d; }
    .badge-status  { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .badge-akan    { background:#fff3cd; color:#856404; }
    .badge-selesai { background:#d1e7dd; color:#0f5132; }
    .badge-berjalan{ background:#cfe2ff; color:#084298; }
    .anggaran-pill { background:#faeeda; color:#633806; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .anggaran-none { color:#ccc; font-size:12px; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input { width:100%; } .btn-tambah { width:100%; justify-content:center; } }
</style>
<div class="keg-header">
    <div class="keg-title">
        <div class="keg-icon">
            <i class="fa fa-calendar" style="color:#0f6e56;font-size:16px;"></i>
        </div>
        Kegiatan Masjid
    </div>
</div>

<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}" {{ request()->routeIs('kegiatan.jadwal*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-check"></i> Jadwal Kegiatan
    </a>
    <a href="{{ route('imam.data') }}" {{ request()->routeIs('imam.data*') ? 'class=active' : '' }}>
        <i class="fa fa-user-tie"></i> Data Imam
    </a>
    <a href="{{ route('kegiatan.imam') }}" {{ request()->routeIs('kegiatan.imam*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-days"></i> Jadwal Imam
    </a>
    <a href="{{ route('kegiatan.sholat') }}" {{ request()->routeIs('kegiatan.sholat*') ? 'class=active' : '' }}>
        <i class="fa fa-mosque"></i> Jadwal Sholat
    </a>
</div>
<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-calendar-check" style="color:#0f8b6d;"></i> Daftar Jadwal Kegiatan</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ count($kegiatan) }} kegiatan</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari kegiatan..." onkeyup="cariData()">
            <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Nama Kegiatan</th><th>Tanggal</th>
                    <th>Waktu</th><th>Tempat</th><th>Penanggung Jawab</th>
                    <th>Anggaran</th><th>Keterangan</th><th>Status</th>
                    <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($kegiatan as $i => $k)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><b>{{ $k->nama_kegiatan }}</b></td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $k->waktu ?? '-' }}</td>
                    <td>{{ $k->tempat ?? '-' }}</td>
                    <td>{{ $k->penanggung_jawab ?? '-' }}</td>
                    <td>
                        @if($k->kasKeluar)
                            <span class="anggaran-pill">
                                <i class="fa fa-money-bill" style="font-size:10px;"></i>
                                Rp.{{ number_format($k->kasKeluar->nominal, 0, ',', '.') }}
                            </span>
                            <div style="font-size:10px;color:#999;margin-top:2px;">{{ $k->kasKeluar->jenis_pengeluaran }}</div>
                        @else
                            <span class="anggaran-none">— belum ada —</span>
                        @endif
                    </td>
                    <td>{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        @php $tgl = \Carbon\Carbon::parse($k->tanggal); @endphp
                        @if($tgl->isToday())
                            <span class="badge-status badge-berjalan">Hari Ini</span>
                        @elseif($tgl->isFuture())
                            <span class="badge-status badge-akan">Akan Datang</span>
                        @else
                            <span class="badge-status badge-selesai">Selesai</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <form id="del-keg-{{ $k->id }}" action="{{ route('kegiatan.jadwal.delete', $k->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-keg-{{ $k->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('kegiatan.jadwal.edit', $k->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada jadwal kegiatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' kegiatan';
}
</script>
@endsection
