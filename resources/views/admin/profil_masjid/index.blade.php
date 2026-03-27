@extends('layouts.admin')

@section('content')

<style>
    .table-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table th { background: #f3f3f3; padding: 10px; text-align: left; font-size: 13px; }
    table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; vertical-align: top; }
    .btn-tambah { background: #0f8b6d; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-tambah:hover { background: #0c6d55; color: white; }
    .badge { font-size: 12px; color: #085041; background: #e1f5ee; padding: 4px 12px; border-radius: 20px; font-weight: 500; }
    .muted { color: #888; }
    .wrap { white-space: pre-wrap; }
    .top-row { display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
</style>

<h2>
    <i class="fa fa-mosque"></i> Profil Masjid
</h2>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;"><i class="fa fa-id-card"></i> Data Profil Masjid</h3>
            <span class="badge">{{ $profil ? 'Tersimpan' : 'Belum ada data' }}</span>
        </div>
        <div>
            @if($profil)
                <a href="{{ route('profil_masjid.edit', $profil->id) }}" class="btn-tambah">
                    <i class="fa fa-edit"></i> Edit Profil
                </a>
            @else
                <a href="{{ route('profil_masjid.create') }}" class="btn-tambah">
                    <i class="fa fa-plus"></i> Tambah Profil
                </a>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th>Nama</th>
                <th>Visi</th>
                <th>Misi</th>
                <th>Sejarah</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @if($profil)
                <tr>
                    <td>1</td>
                    <td>{{ $profil->nama }}</td>
                    <td class="wrap">{{ $profil->visi }}</td>
                    <td class="wrap">{{ $profil->misi }}</td>
                    <td class="wrap">{{ $profil->sejarah }}</td>
                    <td class="wrap">{{ $profil->alamat }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="6" style="text-align:center;color:#999;padding:2rem;">
                        <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        <span class="muted">Profil masjid belum diisi</span>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
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

@endsection

