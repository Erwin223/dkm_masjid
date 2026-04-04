@extends('layouts.admin')
@section('content')

<style>
    .don-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .don-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .don-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .don-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing:border-box; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .donatur-info { background:#f0fbf6; border:1px solid #9fe1cb; border-radius:8px; padding:8px 12px; font-size:12px; color:#085041; margin-top:6px; display:none; }
    .mode-box { border:1px dashed #cfe9df; background:#f8fdfb; border-radius:10px; padding:16px; margin-bottom:18px; }
    .mode-title { font-size:12px; font-weight:600; color:#0f8b6d; margin-bottom:12px; text-transform:uppercase; letter-spacing:.04em; }
    .mode-note { font-size:12px; color:#0f8b6d; margin-top:6px; }
    [hidden] { display:none !important; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

@php
    $oldJenis = old('jenis_donasi');
    $isBarang = in_array($oldJenis, ['Barang', 'Makanan', 'Pakaian'], true);
    $jumlahValue = (float) old('jumlah', 0);
    $totalValue = (float) old('total', old('jumlah', 0));
@endphp

<div class="don-nav">
    <a href="{{ route('donatur.index') }}"><i class="fa fa-users"></i> Data Donatur</a>
    <a href="{{ route('donasi.masuk') }}" class="active"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Donasi Masuk</h3>

    <form action="{{ route('donasi.masuk.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Donatur</label>
                <select name="donatur_id" id="donaturSelect" onchange="pilihDonatur()">
                    <option value="">-- Hamba Allah (default) --</option>
                    @foreach($donaturList as $don)
                        <option value="{{ $don->id }}" data-nama="{{ $don->nama }}" data-hp="{{ $don->no_hp ?? '' }}"
                            data-jenis="{{ $don->jenis_donatur }}" {{ old('donatur_id') == $don->id ? 'selected' : '' }}>
                            {{ $don->nama }} ({{ $don->jenis_donatur }})
                        </option>
                    @endforeach
                </select>
                <div class="donatur-info" id="donaturInfo"></div>
                <div style="margin-top:6px;font-size:12px;color:#999;">
                    Tidak ada di daftar?
                    <input type="text" name="donatur_nama" id="donaturNama" value="{{ old('donatur_nama', 'Hamba Allah') }}"
                        placeholder="Ketik nama donatur manual"
                        style="display:inline-block;width:auto;padding:4px 8px;font-size:12px;border:1px solid #ddd;border-radius:6px;margin-left:6px;">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Jenis Donasi <span style="color:red;">*</span></label>
                <select name="jenis_donasi" id="jenisDonasiMasuk" required onchange="toggleDonasiMasukMode()">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Uang','Barang','Makanan','Pakaian','Lainnya'] as $j)
                        <option value="{{ $j }}" {{ old('jenis_donasi') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_donasi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Kategori Donasi <span style="color:red;">*</span></label>
                <select name="kategori_donasi" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['Infak','Sedekah','Zakat Fitrah','Zakat Maal','Wakaf','Donasi Umum','Lainnya'] as $k)
                        <option value="{{ $k }}" {{ old('kategori_donasi') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                @error('kategori_donasi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mode-box" id="uangBoxMasuk" @if($isBarang) hidden @endif>
            <div class="mode-title">Input Donasi Uang</div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Jumlah (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="jumlahUangMasukDisplay"
                        value="{{ $isBarang ? '' : ($jumlahValue ? number_format($jumlahValue, 0, ',', '.') : '') }}"
                        placeholder="0" style="padding-left:32px;" oninput="formatRupiah(this, 'jumlahMasukHidden')">
                </div>
                <div class="mode-note"><i class="fa fa-circle-info"></i> Untuk donasi uang, total otomatis sama dengan jumlah.</div>
            </div>
        </div>

        <div class="mode-box" id="barangBoxMasuk" @if(! $isBarang) hidden @endif>
            <div class="mode-title">Input Donasi Barang</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Barang <span style="color:red;">*</span></label>
                    <input type="number" step="0.01" min="0" id="jumlahBarangMasukDisplay"
                        value="{{ $isBarang && $jumlahValue ? $jumlahValue : '' }}" placeholder="Contoh: 10" oninput="syncDonasiMasukBarang()">
                </div>
                <div class="form-group">
                    <label>Satuan <span style="color:red;">*</span></label>
                    <input type="text" name="satuan" id="satuanMasuk" value="{{ old('satuan') }}"
                        placeholder="Contoh: dus, kg, paket">
                    @error('satuan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Nominal (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="nominalBarangMasukDisplay"
                        value="{{ $isBarang && $totalValue ? number_format($totalValue, 0, ',', '.') : '' }}"
                        placeholder="0" style="padding-left:32px;" oninput="formatRupiah(this, 'totalMasukHidden')">
                </div>
                <div class="mode-note"><i class="fa fa-box"></i> Simpan jumlah fisik barang beserta estimasi nilai rupiahnya.</div>
            </div>
        </div>

        <input type="hidden" name="jumlah" id="jumlahMasukHidden" value="{{ $isBarang ? $jumlahValue : round($jumlahValue) }}">
        <input type="hidden" name="total" id="totalMasukHidden" value="{{ round($totalValue) }}">
        @error('jumlah') <span class="invalid-feedback">{{ $message }}</span> @enderror
        @error('total') <span class="invalid-feedback">{{ $message }}</span> @enderror

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('donasi.masuk') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function pilihDonatur() {
    const sel = document.getElementById('donaturSelect');
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('donaturInfo');
    const namaInput = document.getElementById('donaturNama');
    
    if (sel.value) {
        const hp = opt.dataset.hp ? ' · ' + opt.dataset.hp : '';
        info.innerHTML = `<i class="fa fa-circle-check" style="color:#0f8b6d;"></i> <b>${opt.dataset.nama}</b> (${opt.dataset.jenis})${hp}`;
        info.style.display = 'block';
        
        namaInput.value = opt.dataset.nama;
        namaInput.readOnly = true;
        namaInput.style.background = '#f0f0f0';
    } else {
        info.style.display = 'none';
        namaInput.value = 'Hamba Allah';
        namaInput.readOnly = false;
        namaInput.style.background = '#fff';
    }
}

function formatRupiah(el, hiddenId) {
    // 1. Ambil nilai string dari input
    let val = el.value.toString();
    
    // 2. POTONG DESIMAL (Ini kunci agar tidak membengkak)
    // Hapus desimal koma (format ID, misal: 50.000,00 -> 50.000)
    val = val.split(',')[0]; 
    // Hapus desimal titik jika ada dari raw database (misal: 50000.00 -> 50000)
    val = val.replace(/\.\d{1,2}$/, ''); 

    // 3. Bersihkan karakter non-angka dan parsing
    let raw = val.replace(/[^0-9]/g, '');
    let num = parseInt(raw || '0', 10);
    
    // 4. Format kembali ke Rupiah, paksa tanpa desimal
    el.value = raw ? num.toLocaleString('id-ID', { maximumFractionDigits: 0 }) : '';
    
    // 5. Simpan nilai murni ke form yang disembunyikan
    document.getElementById(hiddenId).value = num;
    if (hiddenId === 'jumlahMasukHidden' && !isBarangJenisMasuk()) {
        document.getElementById('totalMasukHidden').value = num;
    }
}

function syncDonasiMasukBarang() {
    const qty = document.getElementById('jumlahBarangMasukDisplay').value;
    document.getElementById('jumlahMasukHidden').value = qty || 0;
}

function toggleDonasiMasukMode() {
    const isBarang = isBarangJenisMasuk();
    document.getElementById('uangBoxMasuk').hidden = isBarang;
    document.getElementById('barangBoxMasuk').hidden = !isBarang;
    
    if (isBarang) {
        document.getElementById('jumlahUangMasukDisplay').value = '';
        syncDonasiMasukBarang();
    } else {
        document.getElementById('satuanMasuk').value = '';
        document.getElementById('jumlahBarangMasukDisplay').value = '';
        document.getElementById('nominalBarangMasukDisplay').value = '';
        
        // POTONG DESIMAL saat pindah mode/load pertama kali
        let displayVal = document.getElementById('jumlahUangMasukDisplay').value.toString();
        displayVal = displayVal.split(',')[0].replace(/\.\d{1,2}$/, '');
        
        let uangRaw = parseInt(displayVal.replace(/[^0-9]/g, '') || '0', 10);
        document.getElementById('jumlahMasukHidden').value = uangRaw;
        document.getElementById('totalMasukHidden').value = uangRaw;
    }
}

function isBarangJenisMasuk() {
    return ['Barang', 'Makanan', 'Pakaian'].includes(document.getElementById('jenisDonasiMasuk').value);
}

window.onload = function() {
    const sel = document.getElementById('donaturSelect');
    if (sel && sel.value) pilihDonatur();
    toggleDonasiMasukMode();
};
</script>

@endsection
