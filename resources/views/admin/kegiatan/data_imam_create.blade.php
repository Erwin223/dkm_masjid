@extends('layouts.admin')
@section('content')
@include('admin.kegiatan._styles')


<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}"><i class="fa fa-calendar-check"></i> Jadwal Kegiatan</a>
    <a href="{{ route('imam.data') }}" class="active"><i class="fa fa-user-tie"></i> Data Imam</a>
    <a href="{{ route('kegiatan.imam') }}"><i class="fa fa-calendar-days"></i> Jadwal Imam</a>
    <a href="{{ route('kegiatan.sholat') }}"><i class="fa fa-mosque"></i> Jadwal Sholat</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Data Imam</h3>

    <form action="{{ route('imam.data.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap imam" required>
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat lengkap">
        </div>

        <div class="form-group">
            <label>Status <span style="color:red;">*</span></label>
            <select name="status" required>
                <option value="Tetap" {{ old('status') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Tamu"  {{ old('status') == 'Tamu'  ? 'selected' : '' }}>Tamu</option>
            </select>
            @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('imam.data') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
