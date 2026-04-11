@extends('layouts.admin')
@section('content')
@include('admin.berita._styles')


<div class="form-box">
    <h3><i class="fa fa-plus" style="color:#0f8b6d;"></i> Tambah Berita</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>
            </div>
            <div class="form-group">
                <label>Penulis <span style="color:red;">*</span></label>
                <input type="text" name="penulis" value="{{ old('penulis') }}" required placeholder="Nama penulis">
            </div>
        </div>

        <div class="form-group">
            <label>Judul <span style="color:red;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Masukkan judul berita">
        </div>

        <div class="form-group">
            <label>Sinopsis</label>
            <textarea name="sinopsis" placeholder="Ringkas isi berita dalam satu atau dua kalimat">{{ old('sinopsis') }}</textarea>
        </div>

        <div class="form-group">
            <label>Isi Berita <span style="color:red;">*</span></label>
            <textarea name="isi_berita" required placeholder="Tuliskan isi berita">{{ old('isi_berita') }}</textarea>
        </div>
 <div class="form-group">
            <label>Gambar (Opsional)</label>
            <input type="file" name="gambar" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:6px;">
                *Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Berita</button>
            <a href="{{ route('berita.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection

