@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Distribusi Zakat</h3>
    <form action="{{ route('zakat.distribusi.update', $distribusi->id) }}" method="POST" id="formDistribusi">
        @csrf @method('PUT')
        <input type="hidden" name="nominal" id="nominalHidden">

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $distribusi->tanggal->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Mustahik <span style="color:red;">*</span></label>
                <select name="mustahik_id" required>
                    <option value="">-- Pilih Mustahik --</option>
                    @foreach($mustahikList as $mustahik)
                    <option value="{{ $mustahik->id }}" {{ old('mustahik_id', $distribusi->mustahik_id) == $mustahik->id ? 'selected' : '' }}>{{ $mustahik->nama }} ({{ $mustahik->kategori_mustahik }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sumber / Jenis Zakat</label>
                <select name="jenis_zakat" required>
                    @foreach(['Zakat Fitrah','Zakat Maal','Zakat Penghasilan','Fidyah / Kifarat', 'Lainnya'] as $jenis)
                    <option value="{{ $jenis }}" {{ $distribusi->jenis_zakat == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Bentuk Zakat Disalurkan</label>
                <select name="bentuk_zakat" id="bentukZakatDistribusi" required onchange="toggleDistribusiMode(true)">
                    <option value="Uang" {{ $distribusi->bentuk_zakat == 'Uang' ? 'selected' : '' }}>Uang</option>
                    <option value="Barang" {{ $distribusi->bentuk_zakat == 'Barang' ? 'selected' : '' }}>Barang</option>
                </select>
            </div>
        </div>

        {{-- Section Barang --}}
        <div class="form-row" id="barangFieldsDistribusi" style="display:none;">
            <div class="form-group">
                <label>Jumlah Riil Barang</label>
                <input type="number" step="0.01" name="jumlah_zakat" id="jumlahZakatDistribusi" value="{{ $distribusi->jumlah_zakat }}">
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" id="satuanDistribusi" value="{{ $distribusi->satuan }}">
            </div>
        </div>

        {{-- Section Uang --}}
        <div class="form-row" id="nominalFieldDistribusi">
            <div class="form-group">
                <label>Nilai Rupiah</label>
                <input type="text" id="nominalDisplay" value="{{ number_format($distribusi->nominal, 0, ',', '.') }}" oninput="formatNominalRupiah(this)">
            </div>
            <div class="form-group"></div>
        </div>

        <div class="form-group">
            <label>Keterangan Tambahan</label>
            <textarea name="keterangan" id="keteranganDistribusi">{{ $distribusi->keterangan }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan">Update</button>
            <a href="{{ route('zakat.distribusi.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
function formatNominalRupiah(el) {
    const raw = el.value.replace(/[^0-9]/g, '');
    el.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
}

function toggleDistribusiMode(isUserAction = false) {
    const isBarang = document.getElementById('bentukZakatDistribusi').value === 'Barang';
    const barangFields = document.getElementById('barangFieldsDistribusi');
    const nominalField = document.getElementById('nominalFieldDistribusi');

    const jumlahEl = document.getElementById('jumlahZakatDistribusi');
    const satuanEl = document.getElementById('satuanDistribusi');
    const nominalDisplay = document.getElementById('nominalDisplay');
    const nominalHidden = document.getElementById('nominalHidden');

    if (isBarang) {
        barangFields.style.display = '';
        nominalField.style.display = 'none';

        nominalDisplay.disabled = true;
        nominalHidden.disabled = true;
        jumlahEl.disabled = false;
        satuanEl.disabled = false;

        if (isUserAction) nominalDisplay.value = '';
    } else {
        barangFields.style.display = 'none';
        nominalField.style.display = '';

        jumlahEl.disabled = true;
        satuanEl.disabled = true;
        nominalDisplay.disabled = false;
        nominalHidden.disabled = false;

        if (isUserAction) {
            jumlahEl.value = '';
            satuanEl.value = 'kg';
        }
    }
}

document.getElementById('formDistribusi').addEventListener('submit', function (e) {
    const isBarang = document.getElementById('bentukZakatDistribusi').value === 'Barang';

    if (isBarang) {
        const jumlah = document.getElementById('jumlahZakatDistribusi').value.trim();
        const satuan = document.getElementById('satuanDistribusi').value.trim();
        if (!jumlah || !satuan) {
            e.preventDefault();
            alert('Jumlah Riil Barang dan Satuan wajib diisi!');
            return;
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
