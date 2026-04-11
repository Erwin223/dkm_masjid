@extends('layouts.admin')
@section('content')
@include('admin.donatur._styles')



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
