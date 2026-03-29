@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Penerimaan Zakat</h3>
    <form action="{{ route('zakat.penerimaan.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Muzakki <span style="color:red;">*</span></label>
                <select name="muzakki_id" required>
                    <option value="">-- Pilih Muzakki --</option>
                    @foreach($muzakkiList as $muzakki)
                    <option value="{{ $muzakki->id }}" {{ old('muzakki_id') == $muzakki->id ? 'selected' : '' }}>{{ $muzakki->nama }}</option>
                    @endforeach
                </select>
                @error('muzakki_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jenis Zakat <span style="color:red;">*</span></label>
                <input type="text" name="jenis_zakat" value="{{ old('jenis_zakat') }}" placeholder="Contoh: Zakat Fitrah" required>
                @error('jenis_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah Zakat <span style="color:red;">*</span></label>
                <input type="number" step="0.01" min="0" name="jumlah_zakat" value="{{ old('jumlah_zakat') }}" placeholder="0" required>
                @error('jumlah_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jumlah Tanggungan</label>
                <input type="number" min="0" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan') }}" placeholder="Contoh: 4">
                @error('jumlah_tanggungan') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Metode Pembayaran <span style="color:red;">*</span></label>
                <select name="metode_pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    @foreach(['Tunai', 'Transfer', 'QRIS'] as $metode)
                    <option value="{{ $metode }}" {{ old('metode_pembayaran') == $metode ? 'selected' : '' }}>{{ $metode }}</option>
                    @endforeach
                </select>
                @error('metode_pembayaran') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
            @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('zakat.penerimaan.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
