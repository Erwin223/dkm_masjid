@extends('layouts.admin')
@section('content')
@include('admin.kegiatan._styles')


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
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-calendar-days" style="color:#0f8b6d;"></i> Daftar Jadwal Imam</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ count($imam) }} jadwal</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari nama imam..." onkeyup="cariData()">
            <a href="{{ route('kegiatan.imam.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Nama Imam</th><th>Status</th><th>Tanggal</th>
                    <th>Hari</th><th>Waktu Sholat</th><th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($imam as $i => $im)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="avatar-initials">{{ strtoupper(substr($im->imam->nama ?? '??', 0, 2)) }}</div>
                            <span style="font-weight:500;color:#111;">{{ $im->imam->nama ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        @php $st = $im->imam->status ?? ''; @endphp
                        @if($st == 'Tetap')
                            <span class="status-tetap">Tetap</span>
                        @elseif($st == 'Tamu')
                            <span class="status-tamu">Tamu</span>
                        @else - @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($im->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $im->hari ?? '-' }}</td>
                    <td><span class="sholat-pill">{{ $im->waktu_sholat }}</span></td>
                    <td>{{ $im->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-jadwal-{{ $im->id }}" action="{{ route('kegiatan.imam.delete', $im->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-jadwal-{{ $im->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('kegiatan.imam.edit', $im->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada jadwal imam
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
    document.getElementById('jmlBadge').textContent=v+' jadwal';
}
</script>

@endsection
