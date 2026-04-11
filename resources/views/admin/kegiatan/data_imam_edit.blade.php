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
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Data Imam</h3>

    <form action="{{ route('imam.data.update', $imam->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $imam->nama) }}" required>
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $imam->no_hp) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', $imam->alamat) }}">
        </div>

        <div class="form-group">
            <label>Status <span style="color:red;">*</span></label>
            <select name="status" required>
                <option value="Tetap" {{ old('status', $imam->status) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                <option value="Tamu"  {{ old('status', $imam->status) == 'Tamu'  ? 'selected' : '' }}>Tamu</option>
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $imam->keterangan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('imam.data') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
