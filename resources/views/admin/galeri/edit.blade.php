@extends('layouts.admin')
@section('content')
@include('admin.galeri._styles')


<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Galeri</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('galeri.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tanggal <span style="color:red;">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}" required>
        </div>

        <div class="form-group">
            <label>Judul <span style="color:red;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $data->judul) }}" required placeholder="Masukkan judul foto">
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" placeholder="Masukkan deskripsi (opsional)">{{ old('deskripsi', $data->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar (Opsional)</label>
            @if($data->gambar)
                <img src="{{ asset('storage/'.$data->gambar) }}" class="current-img">
            @endif
            <input type="file" name="gambar" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:5px;">*Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG/PNG/JPEG. Maks 2MB.</div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update Galeri</button>
            <a href="{{ route('galeri.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

@endsection
