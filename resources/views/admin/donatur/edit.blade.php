@extends('layouts.admin')
@section('content')

<style>
    .don-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .don-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .don-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .don-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="don-nav">
    <a href="{{ route('donatur.index') }}" class="active"><i class="fa fa-users"></i> Data Donatur</a>
    <a href="{{ route('donasi.masuk') }}"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Donatur</h3>

    <form action="{{ route('donatur.update', $donatur->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $donatur->nama) }}" required>
            </div>
            <div class="form-group">
                <label>Jenis Donatur <span style="color:red;">*</span></label>
                <select name="jenis_donatur" required>
                    <option value="Individu" {{ old('jenis_donatur', $donatur->jenis_donatur) == 'Individu' ? 'selected' : '' }}>Individu</option>
                    <option value="Lembaga"  {{ old('jenis_donatur', $donatur->jenis_donatur) == 'Lembaga'  ? 'selected' : '' }}>Lembaga</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $donatur->no_hp) }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $donatur->email) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ old('alamat', $donatur->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Daftar <span style="color:red;">*</span></label>
            <input type="date" name="tanggal_daftar"
                value="{{ old('tanggal_daftar', \Carbon\Carbon::parse($donatur->tanggal_daftar)->format('Y-m-d')) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('donatur.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
