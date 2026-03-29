@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Mustahik</h3>
    <form action="{{ route('zakat.mustahik.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama mustahik" required>
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
                @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Alamat lengkap mustahik">{{ old('alamat') }}</textarea>
            @error('alamat') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Kategori Mustahik <span style="color:red;">*</span></label>
            <select name="kategori_mustahik" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach(['Fakir', 'Miskin', 'Amil', 'Muallaf', 'Riqab', 'Gharim', 'Fisabilillah', 'Ibnu Sabil'] as $kategori)
                <option value="{{ $kategori }}" {{ old('kategori_mustahik') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                @endforeach
            </select>
            @error('kategori_mustahik') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
            @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('zakat.mustahik.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
