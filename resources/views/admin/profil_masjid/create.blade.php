@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:900px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing:border-box; }
    .form-group input:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    textarea { min-height: 110px; resize: vertical; }
    @media(max-width:600px){ .form-box { padding:18px; } }
</style>

<div class="form-box">
    <h3><i class="fa fa-plus" style="color:#0f8b6d;"></i> Tambah Profil Masjid</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('profil_masjid.store') }}">
        @csrf

        <div class="form-group">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama masjid">
        </div>

        <div class="form-group">
            <label>Visi <span style="color:red;">*</span></label>
            <textarea name="visi" required placeholder="Tuliskan visi masjid">{{ old('visi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Misi <span style="color:red;">*</span></label>
            <textarea name="misi" required placeholder="Tuliskan misi masjid">{{ old('misi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Sejarah <span style="color:red;">*</span></label>
            <textarea name="sejarah" required placeholder="Tuliskan sejarah singkat masjid">{{ old('sejarah') }}</textarea>
        </div>

        <div class="form-group">
            <label>Alamat <span style="color:red;">*</span></label>
            <textarea name="alamat" required placeholder="Masukkan alamat masjid">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Profil</button>
            <a href="{{ route('profil_masjid.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection

