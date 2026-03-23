@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="form-box">
    <h3><i class="fa fa-user-plus" style="color:#0f8b6d;"></i> Tambah Pengurus</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('pengurus.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama pengurus">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jabatan <span style="color:red;">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" required placeholder="Contoh: Ketua DKM">
            </div>

            <div class="form-group">
                <label>No HP <span style="color:red;">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 08123456789">
            </div>
        </div>

        <div class="form-group">
            <label>Foto (Opsional)</label>
            <input type="file" name="foto" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:6px;">
                *Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Pengurus</button>
            <a href="{{ route('pengurus.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
