@extends('layouts.admin')

@section('content')

@include('admin.pengurus._styles')

<div class="form-box">
    <h3><i class="fa fa-user-edit" style="color:#0f8b6d;"></i> Edit Data Pengurus</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('pengurus.update',$data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- FOTO SAAT INI -->
        <div class="preview">
            @if($data->foto)
            <img src="{{ asset('storage/'.$data->foto) }}">
            @else
            <div style="width:70px; height:70px; border-radius:50%; background:#e1f5ee; border:2px solid #9fe1cb; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:600; color:#0f6e56;">
                {{ strtoupper(substr($data->nama, 0, 1)) }}
            </div>
            @endif
            <div class="preview-info">
                <div>Foto Profil Saat Ini</div>
                <span>Anda dapat membiarkan ini kosong jika tidak ingin mengubah foto.</span>
            </div>
        </div>

        <div class="form-group">
            <label>Nama Lengkap <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $data->nama) }}" required placeholder="Masukkan nama pengurus">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jabatan <span style="color:red;">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $data->jabatan) }}" required placeholder="Contoh: Ketua DKM">
            </div>

            <div class="form-group">
                <label>No HP <span style="color:red;">*</span></label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $data->no_hp) }}" required placeholder="Contoh: 08123456789">
            </div>
        </div>

        <div class="form-group">
            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="foto" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:6px;">
                *Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update Data</button>
            <a href="{{ route('pengurus.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
