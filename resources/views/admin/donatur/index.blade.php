@extends('layouts.admin')
@section('content')

<style>
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
    .badge-individu { background:#e1f5ee; color:#085041; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .badge-lembaga  { background:#e6f1fb; color:#0c447c; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; }
    .avatar-init { width:34px; height:34px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:inline-flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:#0f6e56; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:darkblue; transform:scale(1.2); }
    .fa-trash:hover { color:darkred;  transform:scale(1.2); }
    @media(max-width:600px){ .top-row { flex-direction:column; align-items:flex-start; } .search-input,.btn-tambah { width:100%; justify-content:center; } }
</style>

<div class="don-nav">
    <a href="{{ route('donatur.index') }}" {{ request()->routeIs('donatur*') ? 'class=active' : '' }}>
        <i class="fa fa-users"></i> Data Donatur
    </a>
    <a href="{{ route('donasi.masuk') }}" {{ request()->routeIs('donasi.masuk*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Donasi Masuk
    </a>
    <a href="{{ route('donasi.keluar') }}" {{ request()->routeIs('donasi.keluar*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Donasi Keluar
    </a>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-users" style="color:#0f8b6d;"></i> Data Donatur</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} donatur</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari nama / email..." onkeyup="cariData()">
            <a href="{{ route('donatur.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Jenis</th>
                    <th>Tgl Daftar</th>
                    <th>Total Donasi</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="avatar-init">{{ strtoupper(substr($d->nama, 0, 2)) }}</div>
                            <div>
                                <div style="font-weight:500;color:#111;">{{ $d->nama }}</div>
                                @if($d->alamat)
                                <div style="font-size:11px;color:#999;">{{ Str::limit($d->alamat, 30) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($d->no_hp)
                            <i class="fa fa-phone" style="color:#0f8b6d;font-size:11px;"></i> {{ $d->no_hp }}
                        @else — @endif
                    </td>
                    <td>{{ $d->email ?? '—' }}</td>
                    <td>
                        <span class="{{ $d->jenis_donatur == 'Individu' ? 'badge-individu' : 'badge-lembaga' }}">
                            {{ $d->jenis_donatur }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal_daftar)->translatedFormat('d M Y') }}</td>
                    <td style="font-weight:600;color:#0f8b6d;">
                        Rp.{{ number_format($d->totalDonasi(), 0, ',', '.') }}
                    </td>
                    <td style="text-align:center;">
                        <form id="del-don-{{ $d->id }}" action="{{ route('donatur.delete', $d->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-don-{{ $d->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('donatur.edit', $d->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-users" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data donatur
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
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' donatur';
}
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>

@endsection
