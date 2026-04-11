@extends('layouts.admin')
@section('content')
@include('admin.profil_masjid._styles')
<div class="form-box">
    <h3><i class="fa fa-plus" style="color:#0f8b6d;"></i> Tambah Profil Masjid</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('profil_masjid.store') }}">
        @csrf

        <div class="form-group">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama masjid">
        </div>

        <div class="form-group">
            <label>Visi <span style="color:red;">*</span></label>
            <textarea name="visi" required placeholder="Tuliskan visi masjid">{{ old('visi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Misi <span style="color:red;">*</span></label>
            <textarea name="misi" required placeholder="Tuliskan misi masjid">{{ old('misi') }}</textarea>
        </div>

        <div class="form-group">
            <label>Sejarah <span style="color:red;">*</span></label>
            <textarea name="sejarah" required placeholder="Tuliskan sejarah singkat masjid">{{ old('sejarah') }}</textarea>
        </div>

        <div class="form-group">
            <label>Alamat <span style="color:red;">*</span></label>
            <textarea name="alamat" required placeholder="Masukkan alamat masjid">{{ old('alamat') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Profil</button>
            <a href="{{ route('profil_masjid.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection

