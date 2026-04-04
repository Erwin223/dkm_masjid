@extends('layouts.admin')
@section('content')
@include('admin.donasi._styles')

@php
    $selectedJenis = old('jenis_donasi', $donasi->jenis_donasi);
    $isBarang = in_array($selectedJenis, ['Barang', 'Makanan', 'Pakaian'], true);
    $jumlahValue = (float) old('jumlah', $donasi->jumlah);
    $nominalValue = (float) old('nominal', $donasi->nominal ?? 0);
@endphp

<div class="don-nav">
    <a href="{{ route('donasi.masuk') }}"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}" class="active"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Donasi Keluar</h3>

    <form action="{{ route('donasi.keluar.update', $donasi->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $donasi->tanggal->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Jenis Donasi <span style="color:red;">*</span></label>
                <select name="jenis_donasi" id="jenisDonasiKeluar" required onchange="toggleDonasiKeluarMode()">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Uang','Barang','Makanan','Pakaian','Lainnya'] as $j)
                        <option value="{{ $j }}" {{ $selectedJenis == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_donasi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Tujuan <span style="color:red;">*</span></label>
            <input type="text" name="tujuan" value="{{ old('tujuan', $donasi->tujuan) }}" required>
            @error('tujuan') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="mode-box" id="uangBoxKeluar" @if($isBarang) hidden @endif>
            <div class="mode-title">Input Donasi Keluar Uang</div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Jumlah (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="jumlahUangKeluarDisplay"
                        value="{{ $isBarang ? '' : number_format($jumlahValue, 0, ',', '.') }}"
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
                        value="{{ $isBarang ? $jumlahValue : '' }}" placeholder="Contoh: 5" oninput="syncDonasiKeluarBarang()">
                </div>
                <div class="form-group">
                    <label>Satuan <span style="color:red;">*</span></label>
                    <input type="text" name="satuan" id="satuanKeluar" value="{{ old('satuan', $donasi->satuan) }}"
                        placeholder="Contoh: dus, kg, paket">
                    @error('satuan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Nominal (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="nominalBarangKeluarDisplay"
                        value="{{ $isBarang ? number_format($nominalValue, 0, ',', '.') : '' }}"
                        placeholder="0" style="padding-left:32px;" oninput="formatRupiahKeluar(this, 'nominalKeluarHidden')">
                </div>
                <div class="mode-note"><i class="fa fa-box-open"></i> Catat jumlah fisik barang dan nilai nominal penyalurannya.</div>
            </div>
        </div>

        <input type="hidden" name="jumlah" id="jumlahKeluarHidden" value="{{ $isBarang ? $jumlahValue : round($jumlahValue) }}">
        <input type="hidden" name="nominal" id="nominalKeluarHidden" value="{{ round($nominalValue) }}">
        @error('jumlah') <span class="invalid-feedback">{{ $message }}</span> @enderror
        @error('nominal') <span class="invalid-feedback">{{ $message }}</span> @enderror

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $donasi->keterangan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('donasi.keluar') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function isBarangJenisKeluar() {
    return ['Barang', 'Makanan', 'Pakaian'].includes(document.getElementById('jenisDonasiKeluar').value);
}

function formatRupiahKeluar(el, hiddenId) {
    let val = el.value.toString();
    val = val.split(',')[0];
    val = val.replace(/\.\d{1,2}$/, '');

    let raw = val.replace(/[^0-9]/g, '');
    let num = parseInt(raw || '0', 10);
    el.value = raw ? num.toLocaleString('id-ID', { maximumFractionDigits: 0 }) : '';
    document.getElementById(hiddenId).value = num;
}

function syncDonasiKeluarBarang() {
    if (!isBarangJenisKeluar()) {
        return;
    }

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

        let displayVal = document.getElementById('jumlahUangKeluarDisplay').value.toString();
        displayVal = displayVal.split(',')[0].replace(/\.\d{1,2}$/, '');

        const uangRaw = parseInt(displayVal.replace(/[^0-9]/g, '') || '0', 10);
        document.getElementById('jumlahKeluarHidden').value = uangRaw;
        document.getElementById('nominalKeluarHidden').value = 0;
    }
}

window.onload = function() {
    toggleDonasiKeluarMode();
};
</script>

@endsection
