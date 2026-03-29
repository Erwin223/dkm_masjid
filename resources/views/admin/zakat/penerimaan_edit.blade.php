@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Penerimaan Zakat</h3>
    <form action="{{ route('zakat.penerimaan.update', $penerimaan->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label>Muzakki <span style="color:red;">*</span></label>
                <select name="muzakki_id" required>
                    <option value="">-- Pilih Muzakki --</option>
                    @foreach($muzakkiList as $muzakki)
                    <option value="{{ $muzakki->id }}" {{ old('muzakki_id', $penerimaan->muzakki_id) == $muzakki->id ? 'selected' : '' }}>{{ $muzakki->nama }}</option>
                    @endforeach
                </select>
                @error('muzakki_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($penerimaan->tanggal)->format('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jenis Zakat <span style="color:red;">*</span></label>
                <input type="text" name="jenis_zakat" value="{{ old('jenis_zakat', $penerimaan->jenis_zakat) }}" required>
                @error('jenis_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Jumlah Zakat <span style="color:red;">*</span></label>
                <input type="number" step="0.01" min="0" name="jumlah_zakat" value="{{ old('jumlah_zakat', $penerimaan->jumlah_zakat) }}" required>
                @error('jumlah_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Jumlah Tanggungan</label>
                <input type="number" min="0" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $penerimaan->jumlah_tanggungan) }}">
                @error('jumlah_tanggungan') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Metode Pembayaran <span style="color:red;">*</span></label>
                <select name="metode_pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    @foreach(['Tunai', 'Transfer', 'QRIS'] as $metode)
                    <option value="{{ $metode }}" {{ old('metode_pembayaran', $penerimaan->metode_pembayaran) == $metode ? 'selected' : '' }}>{{ $metode }}</option>
                    @endforeach
                </select>
                @error('metode_pembayaran') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $penerimaan->keterangan) }}</textarea>
            @error('keterangan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('zakat.penerimaan.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
