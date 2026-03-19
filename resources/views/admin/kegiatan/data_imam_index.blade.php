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

    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }

    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input { width:100%; } .btn-tambah { width:100%; justify-content:center; } }
</style>
<style>
    .status-tetap { background:#e1f5ee; color:#085041; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .status-tamu  { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .avatar-initials { width:36px; height:36px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#0f6e56; }
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
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-user-tie" style="color:#0f8b6d;"></i> Data Imam</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ count($imam) }} imam</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari nama imam..." onkeyup="cariData()">
            <a href="{{ route('imam.data.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah Imam
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Nama</th><th>Alamat</th><th>No HP</th>
                    <th>Status</th><th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($imam as $i => $im)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="avatar-initials">{{ strtoupper(substr($im->nama, 0, 2)) }}</div>
                            <span style="font-weight:500;color:#111;">{{ $im->nama }}</span>
                        </div>
                    </td>
                    <td>{{ $im->alamat ?? '-' }}</td>
                    <td>
                        @if($im->no_hp)
                            <i class="fa fa-phone" style="color:#aaa;font-size:11px;margin-right:4px;"></i>{{ $im->no_hp }}
                        @else - @endif
                    </td>
                    <td><span class="{{ $im->status == 'Tetap' ? 'status-tetap' : 'status-tamu' }}">{{ $im->status }}</span></td>
                    <td>{{ $im->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-imam-{{ $im->id }}" action="{{ route('imam.data.delete', $im->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-imam-{{ $im->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('imam.data.edit', $im->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data imam
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });
</script>
@endif

<script>
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>
<script>
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' imam';
}
</script>

@endsection
