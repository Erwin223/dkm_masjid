@extends('layouts.admin')
@section('content')
@include('admin.donasi._styles')


@php
    $oldJenis = old('jenis_donasi');
    $isBarang = in_array($oldJenis, ['Barang', 'Makanan', 'Pakaian'], true);
@endphp

<div class="don-nav">
    <a href="{{ route('donasi.masuk') }}"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}" class="active"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Donasi Keluar</h3>

    <form action="{{ route('donasi.keluar.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Jenis Donasi <span style="color:red;">*</span></label>
                <select name="jenis_donasi" id="jenisDonasiKeluar" required onchange="toggleDonasiKeluarMode()">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Uang','Barang','Makanan','Pakaian','Lainnya'] as $j)
                        <option value="{{ $j }}" {{ old('jenis_donasi') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_donasi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Tujuan <span style="color:red;">*</span></label>
            <input type="text" name="tujuan" value="{{ old('tujuan') }}" placeholder="Contoh: Fakir miskin / Pembangunan masjid" required>
            @error('tujuan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mode-box" id="uangBoxKeluar" @if($isBarang) hidden @endif>
            <div class="mode-title">Input Donasi Keluar Uang</div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Jumlah (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="jumlahUangKeluarDisplay"
                        value="{{ $isBarang ? '' : (old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '') }}"
                        placeholder="0" style="padding-left:32px;" oninput="formatRupiahKeluar(this, 'jumlahKeluarHidden')">
                </div>
            </div>
        </div>

        <div class="mode-box" id="barangBoxKeluar" @if(! $isBarang) hidden @endif>
            <div class="mode-title">Input Donasi Keluar Barang</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Barang <span style="color:red;">*</span></label>
                    <input type="number" step="0.01" min="0" id="jumlahBarangKeluarDisplay"
                        value="{{ $isBarang ? old('jumlah') : '' }}" placeholder="Contoh: 5" oninput="syncDonasiKeluarBarang()">
                </div>
                <div class="form-group">
                    <label>Satuan <span style="color:red;">*</span></label>
                    <input type="text" name="satuan" id="satuanKeluar" value="{{ old('satuan') }}"
                        placeholder="Contoh: dus, kg, paket">
                    @error('satuan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Nominal (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="nominalBarangKeluarDisplay"
                        value="{{ $isBarang ? (old('nominal') ? number_format(old('nominal'), 0, ',', '.') : '') : '' }}"
                        placeholder="0" style="padding-left:32px;" oninput="formatRupiahKeluar(this, 'nominalKeluarHidden')">
                </div>
                <div class="mode-note"><i class="fa fa-box-open"></i> Catat jumlah fisik barang dan nilai nominal penyalurannya.</div>
            </div>
        </div>

        <input type="hidden" name="jumlah" id="jumlahKeluarHidden" value="{{ old('jumlah', 0) }}">
        <input type="hidden" name="nominal" id="nominalKeluarHidden" value="{{ old('nominal', 0) }}">
        @error('jumlah') <span class="invalid-feedback">{{ $message }}</span> @enderror
        @error('nominal') <span class="invalid-feedback">{{ $message }}</span> @enderror

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('donasi.keluar') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function isBarangJenisKeluar() {
    return ['Barang', 'Makanan', 'Pakaian'].includes(document.getElementById('jenisDonasiKeluar').value);
}

function formatRupiahKeluar(el, hiddenId) {
    let raw = el.value.replace(/[^0-9]/g, '');
    let num = parseInt(raw || '0', 10);
    el.value = raw ? num.toLocaleString('id-ID') : '';
    document.getElementById(hiddenId).value = num;
}

function syncDonasiKeluarBarang() {
    document.getElementById('jumlahKeluarHidden').value = document.getElementById('jumlahBarangKeluarDisplay').value || 0;
}

function toggleDonasiKeluarMode() {
    const isBarang = isBarangJenisKeluar();
    document.getElementById('uangBoxKeluar').hidden = isBarang;
    document.getElementById('barangBoxKeluar').hidden = !isBarang;
    if (isBarang) {
        document.getElementById('jumlahUangKeluarDisplay').value = '';
        syncDonasiKeluarBarang();
    } else {
        document.getElementById('satuanKeluar').value = '';
        document.getElementById('jumlahBarangKeluarDisplay').value = '';
        document.getElementById('nominalBarangKeluarDisplay').value = '';
        const uangRaw = document.getElementById('jumlahUangKeluarDisplay').value.replace(/[^0-9]/g, '');
        document.getElementById('jumlahKeluarHidden').value = uangRaw || 0;
        document.getElementById('nominalKeluarHidden').value = 0;
    }
}

window.onload = function() {
    toggleDonasiKeluarMode();
    syncDonasiKeluarBarang();
};
</script>

@endsection
