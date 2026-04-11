@extends('layouts.admin')
@section('content')
@include('admin.donatur._styles')

<div class="don-nav">
    <a href="{{ route('donatur.index') }}" class="active"><i class="fa fa-users"></i> Data Donatur</a>
    <a href="{{ route('donasi.masuk') }}"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Donatur</h3>

    <form action="{{ route('donatur.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Nama <span style="color:red;">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap / nama lembaga" required>
                @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Jenis Donatur <span style="color:red;">*</span></label>
                <select name="jenis_donatur" required>
                    <option value="Individu" {{ old('jenis_donatur') == 'Individu' ? 'selected' : '' }}>Individu</option>
                    <option value="Lembaga"  {{ old('jenis_donatur') == 'Lembaga'  ? 'selected' : '' }}>Lembaga</option>
                </select>
                @error('jenis_donatur') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com">
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Daftar <span style="color:red;">*</span></label>
            <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', date('Y-m-d')) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('donatur.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
