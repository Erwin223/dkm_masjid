@extends('layouts.admin')
@section('content')
@include('admin.galeri._styles')

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Galeri</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Tanggal <span style="color:red;">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label>Judul <span style="color:red;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Masukkan judul foto">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar <span style="color:red;">*</span></label>
            <input type="file" name="gambar" accept="image/*" required>
            <div style="font-size:12px;color:#999;margin-top:5px;">*Format: JPG/PNG/JPEG. Maks 2MB.</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Galeri</button>
            <a href="{{ route('galeri.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
