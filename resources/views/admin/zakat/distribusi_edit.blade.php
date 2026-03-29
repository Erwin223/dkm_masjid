@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Distribusi Zakat</h3>
    <form action="{{ route('zakat.distribusi.update', $distribusi->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($distribusi->tanggal)->format('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Mustahik <span style="color:red;">*</span></label>
                <select name="mustahik_id" required>
                    <option value="">-- Pilih Mustahik --</option>
                    @foreach($mustahikList as $mustahik)
                    <option value="{{ $mustahik->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $mustahik->id ? 'selected' : '' }}>{{ $mustahik->nama }} ({{ $mustahik->kategori_mustahik }})</option>
                    @endforeach
                </select>
                @error('mustahik_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jenis Zakat <span style="color:red;">*</span></label>
                <input type="text" name="jenis_zakat" value="{{ old('jenis_zakat', $distribusi->jenis_zakat) }}" required>
                @error('jenis_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah Zakat <span style="color:red;">*</span></label>
                <input type="number" step="0.01" min="0" name="jumlah_zakat" value="{{ old('jumlah_zakat', $distribusi->jumlah_zakat) }}" required>
                @error('jumlah_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $distribusi->keterangan) }}</textarea>
            @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('zakat.distribusi.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
