@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Penerimaan Zakat</h3>
    <form action="{{ route('zakat.penerimaan.update', $penerimaan->id) }}" method="POST" id="formPenerimaan">
        @csrf @method('PUT')
        <input type="hidden" name="nominal" id="nominalHidden">

        <div class="form-row">
            <div class="form-group">
                <label>Muzakki <span style="color:red;">*</span></label>
                <select name="muzakki_id" required>
                    @foreach($muzakkiList as $muzakki)
                    <option value="{{ $muzakki->id }}" {{ $penerimaan->muzakki_id == $muzakki->id ? 'selected' : '' }}>{{ $muzakki->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ $penerimaan->tanggal->format('Y-m-d') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jenis Zakat</label>
                <select name="jenis_zakat" id="jenisZakatPenerimaan" onchange="togglePenerimaanZakatMode(true)">
                    @foreach(['Zakat Fitrah','Zakat Maal','Zakat Penghasilan','Lainnya'] as $jenis)
                    <option value="{{ $jenis }}" {{ $penerimaan->jenis_zakat == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Bentuk Zakat</label>
                <select name="bentuk_zakat" id="bentukZakatPenerimaan" onchange="togglePenerimaanZakatMode(true)">
                    <option value="Uang" {{ $penerimaan->bentuk_zakat == 'Uang' ? 'selected' : '' }}>Uang</option>
                    <option value="Barang" {{ $penerimaan->bentuk_zakat == 'Barang' ? 'selected' : '' }}>Barang</option>
                </select>
            </div>
        </div>

        {{-- Section Fitrah --}}
        <div class="form-row" id="fitrahConfigBox" style="display:none;">
            <div class="form-group">
                <label>Jumlah Tanggungan</label>
                <input type="number" name="jumlah_tanggungan" id="jumlahTanggunganPenerimaan" value="{{ $penerimaan->jumlah_tanggungan }}" oninput="hitungFitrahOtomatis()">
            </div>
            <div class="form-group" id="standarPerJiwaWrapper">
                <label>Standar per Jiwa (kg)</label>
                <input type="number" step="0.01" name="standar_per_jiwa" id="standarPerJiwaPenerimaan" value="{{ $penerimaan->standar_per_jiwa }}" oninput="hitungFitrahOtomatis()">
            </div>
        </div>

        {{-- SECTION MAAL EDIT --}}
        @php
            $isZakatHarta = in_array($penerimaan->jenis_zakat, ['Zakat Maal', 'Zakat Penghasilan']);
            $zakatAcuan = $penerimaan->bentuk_zakat === 'Barang' ? $penerimaan->jumlah_zakat : $penerimaan->nominal;
            $totalHartaEstimasi = $isZakatHarta && $zakatAcuan ? ($zakatAcuan / 0.025) : '';
        @endphp
        <div id="maalConfigBox" style="display: none; background: #f8fbf9; border: 1px solid #cce8de; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <h4 style="margin-top: 0; color: #0f8b6d; font-size: 14px;"><i class="fa fa-calculator"></i> Perhitungan Zakat</h4>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga Emas Saat Ini (Rp/gr)</label>
                    <input type="text" id="calcHargaEmas" value="1.200.000" oninput="formatNominalRupiah(this); hitungMaalOtomatis(true);">
                </div>
                <div class="form-group">
                    <label id="labelTotalHarta">Total Harta (Rp)</label>
                    <input type="text" id="calcTotalHarta" value="{{ $totalHartaEstimasi ? number_format($totalHartaEstimasi, 0, ',', '.') : '' }}" oninput="formatNominalRupiah(this); hitungMaalOtomatis(true);">
                </div>
            </div>
            <div id="konversiBarangBox" style="display:none; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #cce8de;">
                <div class="form-group">
                    <label style="color: #e67e22; font-weight: 600;">Harga Barang per Satuan (Rp/kg)</label>
                    <input type="text" id="calcHargaBarang" placeholder="Diisi jika bayar barang" oninput="formatNominalRupiah(this); hitungMaalOtomatis(true);">
                </div>
            </div>
            <div id="nisabAlertBox" style="padding: 12px; border-radius: 6px; font-size: 13px; margin-top: 10px; display: none;"></div>
        </div>

        <div class="form-row" id="barangFieldsPenerimaan" style="display:none;">
            <div class="form-group">
                <label>Jumlah Barang</label>
                <input type="number" step="0.01" name="jumlah_zakat" id="jumlahZakatPenerimaan" value="{{ $penerimaan->jumlah_zakat }}">
            </div>
            <div class="form-group">
                <label>Satuan <span style="color:red;">*</span></label>
                <select name="satuan" id="satuanPenerimaan">
                    <option value="kg" {{ $penerimaan->satuan == 'kg' ? 'selected' : '' }}>kg (Kilogram)</option>
                    <option value="liter" {{ $penerimaan->satuan == 'liter' ? 'selected' : '' }}>liter</option>
                    <option value="gram" {{ $penerimaan->satuan == 'gram' ? 'selected' : '' }}>gram</option>
                    <option value="paket" {{ $penerimaan->satuan == 'paket' ? 'selected' : '' }}>paket/box</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group" id="nominalFieldPenerimaan">
                <label>Nilai Rupiah</label>
                <input type="text" id="nominalDisplay" value="{{ number_format($penerimaan->nominal, 0, ',', '.') }}" oninput="formatNominalRupiah(this)">
            </div>
            <div class="form-group" id="metodePembayaranFieldPenerimaan">
                <label>Metode</label>
                <select name="metode_pembayaran" id="metodePembayaranPenerimaan">
                    @foreach(['Tunai','Transfer','QRIS'] as $m)
                    <option value="{{ $m }}" {{ $penerimaan->metode_pembayaran == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" id="keteranganPenerimaan">{{ $penerimaan->keterangan }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan" id="btnSubmitPenerimaan">Update</button>
            <a href="{{ route('zakat.penerimaan.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

<script>
const STANDAR_UANG_FITRAH = 40000;
const KADAR_ZAKAT_MAAL = 0.025;

function isFitrahPenerimaan() { return document.getElementById('jenisZakatPenerimaan').value.toLowerCase().includes('fitrah'); }
function isBarangPenerimaan() { return document.getElementById('bentukZakatPenerimaan').value === 'Barang'; }
function getAngkaMurni(str) { return parseFloat(str.replace(/\./g, '').replace(/[^0-9]/g, '')) || 0; }

function formatNominalRupiah(el) {
    const raw = el.value.replace(/[^0-9]/g, '');
    el.value = raw ? parseInt(raw, 10).toLocaleString('id-ID') : '';
}

function setTombolSimpan(aktif) {
    const btn = document.getElementById('btnSubmitPenerimaan');
    btn.disabled = !aktif;
    btn.style.opacity = aktif ? '1' : '0.5';
    btn.style.cursor = aktif ? 'pointer' : 'not-allowed';
}

function hitungMaalOtomatis(isUserAction = false) {
    const jenisZakat = document.getElementById('jenisZakatPenerimaan').value;
    const bentukZakat = document.getElementById('bentukZakatPenerimaan').value;
    if (jenisZakat !== 'Zakat Maal' && jenisZakat !== 'Zakat Penghasilan') return;

    document.getElementById('konversiBarangBox').style.display = (bentukZakat === 'Barang') ? 'block' : 'none';

    const hEmas = getAngkaMurni(document.getElementById('calcHargaEmas').value);
    const harta = getAngkaMurni(document.getElementById('calcTotalHarta').value);
    const hBarang = getAngkaMurni(document.getElementById('calcHargaBarang').value);

    const isBulanan = (jenisZakat === 'Zakat Penghasilan');
    const nisab = hEmas * (isBulanan ? (85 / 12) : 85);
    const zakatRp = harta * KADAR_ZAKAT_MAAL;

    const alertBox = document.getElementById('nisabAlertBox');
    alertBox.style.display = 'block';

    if (harta < nisab) {
        alertBox.style.background = '#f8d7da'; alertBox.innerHTML = 'BELUM NISAB.';
        setTombolSimpan(false);
    } else {
        alertBox.style.background = '#d4edda'; alertBox.innerHTML = `WAJIB: Rp ${zakatRp.toLocaleString('id-ID')}`;
        setTombolSimpan(true);
        if (isUserAction) {
            if (bentukZakat === 'Barang' && hBarang > 0) {
                document.getElementById('jumlahZakatPenerimaan').value = (zakatRp / hBarang).toFixed(2);
            } else if (bentukZakat === 'Uang') {
                document.getElementById('nominalDisplay').value = zakatRp.toLocaleString('id-ID');
            }
        }
    }
}

function hitungFitrahOtomatis() {
    if (!isFitrahPenerimaan()) return;
    const jiwa = parseFloat(document.getElementById('jumlahTanggunganPenerimaan').value || 0);
    if (isBarangPenerimaan()) {
        const std = parseFloat(document.getElementById('standarPerJiwaPenerimaan').value || 0);
        document.getElementById('jumlahZakatPenerimaan').value = jiwa > 0 ? (jiwa * std).toFixed(2) : '';
        document.getElementById('satuanPenerimaan').value = 'kg';
    } else {
        document.getElementById('nominalDisplay').value = jiwa > 0 ? (jiwa * STANDAR_UANG_FITRAH).toLocaleString('id-ID') : '';
    }
}

function togglePenerimaanZakatMode(isUserAction = false) {
    const barang = isBarangPenerimaan();
    const fitrah = isFitrahPenerimaan();
    const jenisZakat = document.getElementById('jenisZakatPenerimaan').value;

    document.getElementById('fitrahConfigBox').style.display = fitrah ? '' : 'none';
    document.getElementById('standarPerJiwaWrapper').style.display = (fitrah && barang) ? '' : 'none';
    document.getElementById('barangFieldsPenerimaan').style.display = barang ? '' : 'none';
    document.getElementById('nominalFieldPenerimaan').style.display = barang ? 'none' : '';
    document.getElementById('metodePembayaranFieldPenerimaan').style.display = barang ? 'none' : '';

    const maalBox = document.getElementById('maalConfigBox');
    if (jenisZakat === 'Zakat Maal' || jenisZakat === 'Zakat Penghasilan') {
        maalBox.style.display = 'block';
        hitungMaalOtomatis(isUserAction);
    } else {
        maalBox.style.display = 'none';
        setTombolSimpan(true);
    }
}

document.getElementById('formPenerimaan').addEventListener('submit', function (e) {
    const val = document.getElementById('nominalDisplay').value;
    if (val) document.getElementById('nominalHidden').value = val.replace(/\./g, '').replace(/[^0-9]/g, '');
});

window.onload = () => togglePenerimaanZakatMode(false);
</script>
@endsection
