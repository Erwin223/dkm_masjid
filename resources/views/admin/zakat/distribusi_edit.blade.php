@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Distribusi Zakat</h3>
    <p class="form-subtitle">Perbarui detail penyaluran zakat dengan struktur input yang lebih rapi agar data mustahik, sumber zakat, dan nilai distribusi lebih mudah ditinjau.</p>
    <form action="{{ route('zakat.distribusi.update', $distribusi->id) }}" method="POST" id="formDistribusi">
        @csrf @method('PUT')
        <input type="hidden" name="nominal" id="nominalHidden">
        <input type="hidden" name="harga_barang_fitrah" id="hargaBarangFitrahHidden">

        <div class="form-section">
            <div class="form-section-title">Informasi Distribusi</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $distribusi->tanggal->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Dari Penerimaan Zakat</label>
                    <select name="penerimaan_zakat_id">
                        <option value="">-- Tidak Terhubung --</option>
                        @if(isset($penerimaanList))
                            @foreach($penerimaanList as $penerimaan)
                            <option value="{{ $penerimaan->id }}" {{ old('penerimaan_zakat_id', $distribusi->penerimaan_zakat_id) == $penerimaan->id ? 'selected' : '' }}>
                                {{ $penerimaan->muzakki->nama }} - {{ $penerimaan->jenis_zakat }} (Rp {{ number_format($penerimaan->nominal ?? $penerimaan->jumlah_zakat, 0, ',', '.') }})
                            </option>
                            @endforeach
                        @endif
                    </select>
                    <span class="field-note"><i class="fa fa-info-circle"></i> Opsional. Hubungkan bila distribusi ini berasal dari penerimaan zakat tertentu.</span>
                </div>
            </div>
            <div class="form-row-single">
                <div class="form-group">
                    <label>Mustahik (Penerima) <span style="color:red;">*</span></label>
                    <select name="mustahik_id" required>
                        <option value="">-- Pilih Mustahik --</option>
                        @foreach($mustahikList as $mustahik)
                        <option value="{{ $mustahik->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $mustahik->id ? 'selected' : '' }}>{{ $mustahik->nama }} ({{ $mustahik->kategori_mustahik }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Jenis dan Bentuk Zakat</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Sumber / Jenis Zakat</label>
                    <select name="jenis_zakat" id="jenisZakatDistribusi" required onchange="toggleDistribusiMode(true)">
                        @foreach(['Zakat Fitrah','Zakat Maal','Zakat Penghasilan','Fidyah / Kifarat', 'Lainnya'] as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_zakat', $distribusi->jenis_zakat) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Bentuk Zakat Disalurkan</label>
                    <select name="bentuk_zakat" id="bentukZakatDistribusi" required onchange="toggleDistribusiMode(true)">
                        <option value="Uang" {{ old('bentuk_zakat', $distribusi->bentuk_zakat) == 'Uang' ? 'selected' : '' }}>Uang</option>
                        <option value="Barang" {{ old('bentuk_zakat', $distribusi->bentuk_zakat) == 'Barang' ? 'selected' : '' }}>Barang</option>
                    </select>
                </div>
            </div>

            <div class="form-row" id="barangFieldsDistribusi" style="display:none;">
                <div class="form-group">
                    <label>Jumlah Riil Barang</label>
                    <input type="number" step="0.01" name="jumlah_zakat" id="jumlahZakatDistribusi" value="{{ old('jumlah_zakat', $distribusi->jumlah_zakat) }}" oninput="updateDistribusiNominal()">
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" id="satuanDistribusi">
                        <option value="kg" {{ old('satuan', $distribusi->satuan) == 'kg' ? 'selected' : '' }}>kg (Kilogram)</option>
                        <option value="liter" {{ old('satuan', $distribusi->satuan) == 'liter' ? 'selected' : '' }}>liter</option>
                        <option value="gram" {{ old('satuan', $distribusi->satuan) == 'gram' ? 'selected' : '' }}>gram</option>
                        <option value="dus" {{ old('satuan', $distribusi->satuan) == 'dus' ? 'selected' : '' }}>dus</option>
                        <option value="paket" {{ old('satuan', $distribusi->satuan) == 'paket' ? 'selected' : '' }}>paket/box</option>
                        <option value="unit" {{ old('satuan', $distribusi->satuan) == 'unit' ? 'selected' : '' }}>unit</option>
                    </select>
                </div>
                <div class="form-group" id="hargaBarangFitrahWrapper" style="display:none;">
                    <label>Harga per Unit (Rp)</label>
                    <input type="text" id="hargaBarangFitrahDisplay" value="{{ old('harga_barang_fitrah', $distribusi->harga_barang_fitrah) ? number_format(old('harga_barang_fitrah', $distribusi->harga_barang_fitrah), 0, ',', '.') : '' }}" placeholder="Contoh: 15.000" oninput="formatNominalRupiah(this); updateDistribusiNominal()">
                    <span class="field-note">Dipakai untuk menghitung nilai rupiah distribusi zakat fitrah berbentuk barang.</span>
                </div>
            </div>

            <div class="form-row-single" id="nominalFieldDistribusi">
                <div class="form-group">
                    <label>Nilai Rupiah</label>
                    <input type="text" id="nominalDisplay" value="{{ number_format(old('nominal', $distribusi->nominal), 0, ',', '.') }}" oninput="formatNominalRupiah(this)" placeholder="Contoh: 250.000">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Catatan</div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" id="keteranganDistribusi" placeholder="Tambahkan catatan penyaluran bila diperlukan...">{{ old('keterangan', $distribusi->keterangan) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('zakat.distribusi.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
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
