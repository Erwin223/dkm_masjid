@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:900px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing:border-box; }
    .form-group input:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    textarea { min-height: 150px; resize: vertical; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

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

