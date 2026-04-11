@extends('layouts.admin')
@section('content')
@include('admin.profil_masjid._styles')
@include('admin._styles_website')


<div class="galeri-header">
    <div class="galeri-title">
        <div class="galeri-icon"><i class="fa fa-globe" style="color:#0f6e56;font-size:15px;"></i></div>
        Kelola Website
    </div>
</div>
<div class="website-nav">
    <a href="{{ route('profil_masjid.index') }}" {{ request()->routeIs('profil_masjid*') ? 'class=active' : '' }}>
        <i class="fa fa-building"></i> Profil Masjid
    </a>
    <a href="{{ route('berita.index') }}" {{ request()->routeIs('berita*') ? 'class=active' : '' }}>
        <i class="fa fa-newspaper"></i> Berita
    </a>
    <a href="{{ route('galeri.index') }}" {{ request()->routeIs('galeri*') ? 'class=active' : '' }}>
        <i class="fa fa-images"></i> Galeri
    </a>
</div>

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

