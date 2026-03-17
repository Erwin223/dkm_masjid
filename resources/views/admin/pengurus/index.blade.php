@extends('layouts.admin')

@section('content')

<style>
.pgr-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;}
.pgr-title{font-size:20px;font-weight:500;color:#111 !important;display:flex;align-items:center;gap:10px;}
.pgr-icon{width:38px;height:38px;background:#e1f5ee;border-radius:10px;display:flex;align-items:center;justify-content:center;}
.pgr-btn-tambah{background:#0f8b6d;color:#fff;border:none;padding:10px 18px;border-radius:9px;font-size:14px;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;}
.pgr-btn-tambah:hover{background:#0c6d55;color:#fff;}

.pgr-search-row{display:flex;align-items:center;gap:10px;margin-bottom:1rem;}
.pgr-search{flex:1;height:40px;border:1px solid #ddd;border-radius:9px;padding:0 14px;font-size:14px;outline:none;color:#333;background:#fff;}
.pgr-search:focus{border-color:#0f8b6d;}
.pgr-badge{font-size:13px;color:#085041;background:#e1f5ee;padding:5px 14px;border-radius:20px;font-weight:500;white-space:nowrap;}

.pgr-table-wrap{background:#fff;border:1px solid #e5e5e5;border-radius:14px;overflow:hidden;}
.pgr-table{width:100%;border-collapse:collapse;table-layout:fixed;}
.pgr-table thead{background:#f0fbf6;}
.pgr-table thead th{padding:14px 18px;text-align:left;font-size:12px;font-weight:500;color:#0f6e56;text-transform:uppercase;letter-spacing:0.06em;border-bottom:1px solid #e0f0e8;}
.pgr-table tbody tr{border-bottom:1px solid #f0f0f0;transition:background 0.15s;}
.pgr-table tbody tr:last-child{border-bottom:none;}
.pgr-table tbody tr:hover{background:#f7fdf9;}
.pgr-table td{padding:18px 18px;vertical-align:middle;}

.pgr-avatar-cell{display:flex;align-items:center;gap:16px;}
.pgr-avatar-img{width:60px;height:60px;border-radius:50%;object-fit:cover;border:3px solid #9fe1cb;flex-shrink:0;}
.pgr-avatar-initials{width:60px;height:60px;border-radius:50%;background:#e1f5ee;border:3px solid #9fe1cb;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:500;color:#0f6e56 !important;flex-shrink:0;}
.pgr-nama{font-weight:500;color:#111 !important;font-size:17px;display:block !important;opacity:1 !important;}
.pgr-id{font-size:12px;color:#999 !important;display:block !important;margin-top:3px;}

.pgr-jabatan-pill{display:inline-block;background:#e1f5ee;color:#085041;padding:5px 14px;border-radius:20px;font-size:14px;font-weight:500;}

.pgr-hp{color:#666 !important;font-size:15px;display:flex !important;align-items:center;gap:8px;opacity:1 !important;}

.pgr-actions{display:flex;align-items:center;justify-content:center;gap:8px;}
.pgr-btn-edit{width:38px;height:38px;border-radius:8px;border:1px solid #b5d4f4;background:#e6f1fb;color:#185fa5;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:background 0.15s;}
.pgr-btn-edit:hover{background:#b5d4f4;}
.pgr-btn-hapus{width:38px;height:38px;border-radius:8px;border:1px solid #f7c1c1;background:#fcebeb;color:#a32d2d;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background 0.15s;}
.pgr-btn-hapus:hover{background:#f7c1c1;}

.pgr-empty{text-align:center;padding:3rem;color:#999;font-size:14px;}
.pgr-footer{display:flex;justify-content:space-between;align-items:center;padding:0.75rem 0 0;font-size:13px;color:#999;}
</style>

<div class="pgr-header">
    <div class="pgr-title">
        <div class="pgr-icon">
            <i class="fa fa-users" style="color:#0f6e56;font-size:16px;"></i>
        </div>
        Data Pengurus
    </div>
    <a href="{{ route('pengurus.create') }}" class="pgr-btn-tambah">
        <i class="fa fa-plus" style="font-size:12px;"></i> Tambah Pengurus
    </a>
</div>

<div class="pgr-search-row">
    <input class="pgr-search" type="text" id="pgrSearch" placeholder="Cari nama atau jabatan..." onkeyup="pgrFilter()">
    <span class="pgr-badge" id="pgrBadge">{{ count($data) }} anggota</span>
</div>

<div class="pgr-table-wrap">
    <table class="pgr-table">
        <thead>
            <tr>
                <th style="width:38%">Anggota</th>
                <th style="width:24%">Jabatan</th>
                <th style="width:26%">No. HP</th>
                <th style="width:12%;text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody id="pgrTableBody">
            @forelse($data as $p)
            <tr>
                <td>
                    <div class="pgr-avatar-cell">
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" class="pgr-avatar-img">
                        @else
                            <div class="pgr-avatar-initials">
                                {{ strtoupper(substr($p->nama, 0, 2)) }}
                            </div>
                        @endif
                        <div>
                            <span class="pgr-nama">{{ $p->nama }}</span>
                            <span class="pgr-id">#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="pgr-jabatan-pill">{{ $p->jabatan }}</span>
                </td>
                <td>
                    <div class="pgr-hp">
                        <i class="fa fa-phone" style="font-size:13px;color:#aaa;"></i>
                        {{ $p->no_hp }}
                    </div>
                </td>
                <td>
                    <div class="pgr-actions">
                        <a href="{{ route('pengurus.edit', $p->id) }}" class="pgr-btn-edit" title="Edit">
                            <i class="fa fa-edit" style="font-size:14px;"></i>
                        </a>
                        <form id="delete-{{ $p->id }}" action="{{ route('pengurus.delete', $p->id) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="hapus({{ $p->id }})" class="pgr-btn-hapus" title="Hapus">
                                <i class="fa fa-trash" style="font-size:14px;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="pgr-empty">
                    <i class="fa fa-inbox" style="font-size:28px;color:#ccc;display:block;margin-bottom:10px;"></i>
                    Belum ada data pengurus
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pgr-footer">
    <span id="pgrFooter">Menampilkan {{ count($data) }} data</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil!',
    text:'{{ session("success") }}',
    timer:2000,
    showConfirmButton:false
});
</script>
@endif

<script>
function pgrFilter(){
    const q=document.getElementById('pgrSearch').value.toLowerCase();
    const rows=document.querySelectorAll('#pgrTableBody tr');
    let v=0;
    rows.forEach(r=>{
        if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;}
        else r.style.display='none';
    });
    document.getElementById('pgrBadge').textContent=v+' anggota';
    document.getElementById('pgrFooter').textContent='Menampilkan '+v+' data';
}

function hapus(id){
    Swal.fire({
        title:'Yakin hapus?',
        text:'Data tidak bisa dikembalikan!',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#0f8b6d',
        cancelButtonColor:'#d33',
        confirmButtonText:'Ya, hapus!',
        cancelButtonText:'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('delete-'+id).submit();
        }
    });
}
</script>

@endsection
