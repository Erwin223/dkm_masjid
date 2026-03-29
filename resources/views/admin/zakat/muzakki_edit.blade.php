@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Muzakki</h3>
    <form action="{{ route('zakat.muzakki.update', $muzakki->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $muzakki->nama) }}" required>
            @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ old('alamat', $muzakki->alamat) }}</textarea>
            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $muzakki->no_hp) }}">
            @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('zakat.muzakki.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
