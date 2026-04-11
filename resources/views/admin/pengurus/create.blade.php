@extends('layouts.admin')

@section('content')

@include('admin.pengurus._styles')

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
