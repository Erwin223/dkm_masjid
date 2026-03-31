@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Distribusi Zakat</h3>
    <form action="{{ route('zakat.distribusi.store') }}" method="POST" id="formDistribusi">
        @csrf
        <input type="hidden" name="nominal" id="nominalHidden">

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
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
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sumber / Jenis Zakat <span style="color:red;">*</span></label>
                <select name="jenis_zakat" required>
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
                <input type="number" step="0.01" name="jumlah_zakat" id="jumlahZakatDistribusi" value="{{ old('jumlah_zakat') }}">
            </div>
            <div class="form-group">
                <label>Satuan <span style="color:red;">*</span></label>
                <input type="text" name="satuan" id="satuanDistribusi" value="{{ old('satuan', 'kg') }}" placeholder="kg/liter">
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

        // Disable input uang agar tidak dikirim ke backend
        nominalDisplay.disabled = true;
        nominalHidden.disabled = true;

        jumlahEl.disabled = false;
        satuanEl.disabled = false;

        if (isUserAction) nominalDisplay.value = '';
    } else {
        barangFields.style.display = 'none';
        nominalField.style.display = '';

        // Disable input barang agar tidak dikirim ke backend
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
