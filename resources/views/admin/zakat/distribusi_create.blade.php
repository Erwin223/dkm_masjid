@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Distribusi Zakat</h3>
    <form action="{{ route('zakat.distribusi.store') }}" method="POST" id="formDistribusi">
        @csrf
        <input type="hidden" name="nominal" id="nominalHidden">
        <input type="hidden" name="harga_barang_fitrah" id="hargaBarangFitrahHidden">

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Dari Penerimaan Zakat (Optional)</label>
                <select name="penerimaan_zakat_id">
                    <option value="">-- Tidak Terhubung --</option>
                    @if(isset($penerimaanList))
                        @foreach($penerimaanList as $penerimaan)
                        <option value="{{ $penerimaan->id }}" {{ old('penerimaan_zakat_id') == $penerimaan->id ? 'selected' : '' }}>
                            {{ $penerimaan->muzakki->nama }} - {{ $penerimaan->jenis_zakat }} (Rp {{ number_format($penerimaan->nominal ?? $penerimaan->jumlah_zakat, 0, ',', '.') }})
                        </option>
                        @endforeach
                    @endif
                </select>
                <small style="color: #666; font-size: 11px; margin-top: 4px; display: block;">
                    <i class="fa fa-info-circle"></i> Pilih untuk menghubungkan distribusi dengan penerimaan zakat tertentu.
                </small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Mustahik (Penerima) <span style="color:red;">*</span></label>
                <select name="mustahik_id" required>
                    <option value="">-- Pilih Mustahik --</option>
                    @foreach($mustahikList as $mustahik)
                    <option value="{{ $mustahik->id }}" {{ old('mustahik_id') == $mustahik->id ? 'selected' : '' }}>{{ $mustahik->nama }} ({{ $mustahik->kategori_mustahik }})</option>
                    @endforeach
                </select>
                @error('mustahik_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group"></div> {{-- Spacer --}}
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sumber / Jenis Zakat <span style="color:red;">*</span></label>
                <select name="jenis_zakat" id="jenisZakatDistribusi" required onchange="toggleDistribusiMode(true)">
                    <option value="">-- Pilih --</option>
                    @foreach(['Zakat Fitrah','Zakat Maal','Zakat Penghasilan','Fidyah / Kifarat', 'Lainnya'] as $jenis)
                    <option value="{{ $jenis }}" {{ old('jenis_zakat') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
                @error('jenis_zakat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Bentuk Zakat Disalurkan <span style="color:red;">*</span></label>
                <select name="bentuk_zakat" id="bentukZakatDistribusi" required onchange="toggleDistribusiMode(true)">
                    <option value="Uang" {{ old('bentuk_zakat', 'Uang') == 'Uang' ? 'selected' : '' }}>Uang</option>
                    <option value="Barang" {{ old('bentuk_zakat') == 'Barang' ? 'selected' : '' }}>Barang</option>
                </select>
            </div>
        </div>

        {{-- Section Barang --}}
        <div class="form-row" id="barangFieldsDistribusi" style="display:none;">
            <div class="form-group">
                <label>Jumlah Riil Barang <span style="color:red;">*</span></label>
                <input type="number" step="0.01" name="jumlah_zakat" id="jumlahZakatDistribusi" value="{{ old('jumlah_zakat') }}" oninput="updateDistribusiNominal()">
            </div>
            <div class="form-group">
                <label>Satuan <span style="color:red;">*</span></label>
                <select name="satuan" id="satuanDistribusi">
                    <option value="kg" {{ old('satuan', 'kg') == 'kg' ? 'selected' : '' }}>kg (Kilogram)</option>
                    <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>liter</option>
                    <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>gram</option>
                    <option value="dus" {{ old('satuan') == 'dus' ? 'selected' : '' }}>dus</option>
                    <option value="paket" {{ old('satuan') == 'paket' ? 'selected' : '' }}>paket/box</option>
                    <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>unit</option>
                </select>
            </div>
            <div class="form-group" id="hargaBarangFitrahWrapper" style="display:none;">
                <label>Harga per Unit (Rp)</label>
                <input type="text" id="hargaBarangFitrahDisplay" value="{{ old('harga_barang_fitrah') ? number_format(old('harga_barang_fitrah'), 0, ',', '.') : '' }}" placeholder="Contoh: 15.000" oninput="formatNominalRupiah(this); updateDistribusiNominal()">
                <small style="color: #7a7a7a;">Isi untuk menghitung nilai rupiah distribusi zakat fitrah barang.</small>
            </div>
        </div>

        {{-- Section Uang --}}
        <div class="form-row" id="nominalFieldDistribusi">
            <div class="form-group">
                <label>Nilai Rupiah <span style="color:red;">*</span></label>
                <input type="text" id="nominalDisplay" oninput="formatNominalRupiah(this)">
            </div>
            <div class="form-group"></div> {{-- Spacer --}}
        </div>

        <div class="form-group">
            <label>Keterangan Tambahan</label>
            <textarea name="keterangan" id="keteranganDistribusi">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-paper-plane"></i> Salurkan</button>
            <a href="{{ route('zakat.distribusi.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
function formatNominalRupiah(el) {
    const raw = el.value.replace(/[^0-9]/g, '');
    el.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
}

function getAngkaMurni(value) {
    return parseFloat(value.replace(/\./g, '').replace(/[^0-9]/g, '')) || 0;
}

function isFitrahDistribusi() {
    return document.getElementById('jenisZakatDistribusi').value.toLowerCase().includes('fitrah');
}

function updateDistribusiNominal() {
    const isBarang = document.getElementById('bentukZakatDistribusi').value === 'Barang';
    const isFitrah = isFitrahDistribusi();
    const jumlah = parseFloat(document.getElementById('jumlahZakatDistribusi').value || 0);
    const harga = getAngkaMurni(document.getElementById('hargaBarangFitrahDisplay').value || '');
    const nominalHidden = document.getElementById('nominalHidden');
    const hargaHidden = document.getElementById('hargaBarangFitrahHidden');

    if (isBarang && isFitrah && jumlah > 0 && harga > 0) {
        nominalHidden.value = (jumlah * harga).toFixed(2);
        hargaHidden.value = harga;
    } else if (isBarang) {
        nominalHidden.value = '';
        hargaHidden.value = harga > 0 ? harga : '';
    } else {
        hargaHidden.value = '';
    }
}

function toggleDistribusiMode(isUserAction = false) {
    const isBarang = document.getElementById('bentukZakatDistribusi').value === 'Barang';
    const isFitrah = isFitrahDistribusi();
    const barangFields = document.getElementById('barangFieldsDistribusi');
    const nominalField = document.getElementById('nominalFieldDistribusi');
    const hargaWrapper = document.getElementById('hargaBarangFitrahWrapper');

    const jumlahEl = document.getElementById('jumlahZakatDistribusi');
    const satuanEl = document.getElementById('satuanDistribusi');
    const nominalDisplay = document.getElementById('nominalDisplay');
    const nominalHidden = document.getElementById('nominalHidden');
    const hargaDisplay = document.getElementById('hargaBarangFitrahDisplay');

    if (isBarang) {
        barangFields.style.display = '';
        nominalField.style.display = 'none';
        hargaWrapper.style.display = isFitrah ? '' : 'none';

        nominalDisplay.disabled = true;
        nominalHidden.disabled = false;

        jumlahEl.disabled = false;
        satuanEl.disabled = false;
        hargaDisplay.disabled = false;

        if (isUserAction) {
            nominalDisplay.value = '';
            updateDistribusiNominal();
        }
    } else {
        barangFields.style.display = 'none';
        nominalField.style.display = '';
        hargaWrapper.style.display = 'none';
        jumlahEl.disabled = true;
        satuanEl.disabled = true;
        hargaDisplay.disabled = true;

        nominalDisplay.disabled = false;
        nominalHidden.disabled = false;

        if (isUserAction) {
            jumlahEl.value = '';
            satuanEl.value = 'kg';
            hargaDisplay.value = '';
        }
    }
}

document.getElementById('formDistribusi').addEventListener('submit', function (e) {
    const isBarang = document.getElementById('bentukZakatDistribusi').value === 'Barang';
    const isFitrah = isFitrahDistribusi();

    if (isBarang) {
        const jumlah = document.getElementById('jumlahZakatDistribusi').value.trim();
        const satuan = document.getElementById('satuanDistribusi').value.trim();
        if (!jumlah || !satuan) {
            e.preventDefault();
            alert('Jumlah Riil Barang dan Satuan wajib diisi!');
            return;
        }

        if (isFitrah) {
            const harga = document.getElementById('hargaBarangFitrahDisplay').value.trim();
            if (!harga) {
                e.preventDefault();
                alert('Harga Barang wajib diisi untuk distribusi zakat fitrah barang!');
                return;
            }
            updateDistribusiNominal();
        }
    } else {
        const displayVal = document.getElementById('nominalDisplay').value.trim();
        if (!displayVal) {
            e.preventDefault();
            alert('Nilai Rupiah wajib diisi untuk zakat Uang!');
            return;
        }
        document.getElementById('nominalHidden').value = displayVal.replace(/\./g, '').replace(/[^0-9]/g, '');
    }
});

window.onload = function () {
    toggleDistribusiMode(false);
    const displayEl = document.getElementById('nominalDisplay');
    if (displayEl && displayEl.value) formatNominalRupiah(displayEl);
};
</script>
@endsection
