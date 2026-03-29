@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Mustahik</h3>
    <form action="{{ route('zakat.mustahik.update', $mustahik->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $mustahik->nama) }}" required>
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $mustahik->no_hp) }}">
                @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat">{{ old('alamat', $mustahik->alamat) }}</textarea>
            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Kategori Mustahik <span style="color:red;">*</span></label>
            <select name="kategori_mustahik" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach(['Fakir', 'Miskin', 'Amil', 'Muallaf', 'Riqab', 'Gharim', 'Fisabilillah', 'Ibnu Sabil'] as $kategori)
                <option value="{{ $kategori }}" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
            </select>
            @error('kategori_mustahik') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $mustahik->keterangan) }}</textarea>
            @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('zakat.mustahik.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
