@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:25px; max-width:700px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; outline:none; transition:border 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-actions { display:flex; gap:10px; margin-top:25px; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:12px 15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    .current-img { width:150px; border-radius:8px; border:1px solid #ddd; margin-bottom:10px; display:block; }
</style>

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Galeri</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('galeri.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tanggal <span style="color:red;">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}" required>
        </div>

        <div class="form-group">
            <label>Judul <span style="color:red;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $data->judul) }}" required placeholder="Masukkan judul foto">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi (opsional)">{{ old('deskripsi', $data->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar (Opsional)</label>
            @if($data->gambar)
                <img src="{{ asset('storage/'.$data->gambar) }}" class="current-img">
            @endif
            <input type="file" name="gambar" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:5px;">*Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG/PNG/JPEG. Maks 2MB.</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update Galeri</button>
            <a href="{{ route('galeri.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
