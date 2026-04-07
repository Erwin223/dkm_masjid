@extends('layouts.admin')

@section('content')

@include('admin.profil_masjid._styles')


<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Profil Masjid</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('profil_masjid.update', $profil->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama <span style="color:red;">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $profil->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Visi <span style="color:red;">*</span></label>
            <textarea name="visi" required>{{ old('visi', $profil->visi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Misi <span style="color:red;">*</span></label>
            <textarea name="misi" required>{{ old('misi', $profil->misi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Sejarah <span style="color:red;">*</span></label>
            <textarea name="sejarah" required>{{ old('sejarah', $profil->sejarah) }}</textarea>
        </div>

        <div class="form-group">
            <label>Alamat <span style="color:red;">*</span></label>
            <textarea name="alamat" required>{{ old('alamat', $profil->alamat) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('profil_masjid.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

@endsection

