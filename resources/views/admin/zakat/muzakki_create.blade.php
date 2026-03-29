@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Muzakki</h3>
    <form action="{{ route('zakat.muzakki.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama muzakki" required>
            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Alamat lengkap muzakki">{{ old('alamat') }}</textarea>
            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
            @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('zakat.muzakki.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
