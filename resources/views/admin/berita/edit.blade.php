@extends('layouts.admin')

@section('content')

@include('admin.berita._styles')

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Berita</h3>

    @if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('berita.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}" required>
            </div>
            <div class="form-group">
                <label>Penulis <span style="color:red;">*</span></label>
                <input type="text" name="penulis" value="{{ old('penulis', $data->penulis) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Judul <span style="color:red;">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $data->judul) }}" required>
        </div>

        <div class="form-group">
            <label>Sinopsis</label>
            <textarea name="sinopsis" placeholder="Ringkas isi berita dalam satu atau dua kalimat">{{ old('sinopsis', $data->sinopsis) }}</textarea>
        </div>

        <div class="form-group">
            <label>Isi Berita <span style="color:red;">*</span></label>
            <textarea name="isi_berita" required>{{ old('isi_berita', $data->isi_berita) }}</textarea>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            @if($data->gambar)
                <div style="margin-bottom:10px;">
                    <img class="thumb" src="{{ asset('storage/'.$data->gambar) }}" alt="gambar">
                </div>
            @endif
            <input type="file" name="gambar" accept="image/*">
            <div style="font-size:12px;color:#999;margin-top:6px;">
                *Kosongkan jika tidak ingin mengganti gambar.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('berita.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

@endsection

