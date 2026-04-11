@extends('layouts.admin')
@section('content')
<style>
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .kas-info { background:#faeeda; border:1px solid #f0c070; border-radius:8px; padding:10px 14px; font-size:12px; color:#633806; margin-top:6px; display:none; }
    .field-hint { font-size:11px; color:#6b7280; margin-top:5px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}" class="active"><i class="fa fa-calendar-check"></i> Jadwal Kegiatan</a>
    <a href="{{ route('imam.data') }}"><i class="fa fa-user-tie"></i> Data Imam</a>
    <a href="{{ route('kegiatan.imam') }}"><i class="fa fa-calendar-days"></i> Jadwal Imam</a>
    <a href="{{ route('kegiatan.sholat') }}"><i class="fa fa-mosque"></i> Jadwal Sholat</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Jadwal Kegiatan</h3>

    <form action="{{ route('kegiatan.jadwal.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Nama Kegiatan <span style="color:red;">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Pengajian Rutin" required>
                @error('nama_kegiatan') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" placeholder="Contoh: Ustadz Ahmad">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Waktu</label>
                <input type="time" name="waktu" value="{{ old('waktu') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Tempat</label>
            <input type="text" name="tempat" value="{{ old('tempat') }}" placeholder="Contoh: Aula Masjid">
        </div>

        <div class="form-group">
            <label><i class="fa fa-wallet" style="color:#0f8b6d;font-size:12px;"></i> Estimasi Anggaran</label>
            <input type="text" name="estimasi_anggaran" id="estimasiAnggaran" value="{{ old('estimasi_anggaran') ? number_format((float) old('estimasi_anggaran'), 0, ',', '.') : '' }}" inputmode="numeric" autocomplete="off" placeholder="Contoh: 1.500.000">
            <div class="field-hint">Isi nominal rencana anggaran kegiatan. Angka akan otomatis memakai pemisah ribuan.</div>
            @error('estimasi_anggaran') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>
                <i class="fa fa-money-bill" style="color:#0f8b6d;font-size:12px;"></i>
                Realisasi Anggaran
                <span style="font-size:11px;color:#999;font-weight:400;">(opsional, ambil dari kas keluar)</span>
            </label>
            <select name="kas_keluar_id" id="kasSelect" onchange="tampilInfoKas()">
                <option value="">Belum ada realisasi anggaran</option>
                @foreach($kasKeluar as $kas)
                    <option value="{{ $kas->id }}"
                        data-nominal="{{ $kas->nominal }}"
                        data-jenis="{{ $kas->jenis_pengeluaran }}"
                        data-tgl="{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}"
                        {{ old('kas_keluar_id') == $kas->id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }} -
                        {{ $kas->jenis_pengeluaran }} -
                        Rp.{{ number_format($kas->nominal, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            <div class="kas-info" id="kasInfo"></div>
            <div class="field-hint">Pilih transaksi kas keluar jika dana kegiatan sudah benar-benar direalisasikan.</div>
            @error('kas_keluar_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('kegiatan.jadwal') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function tampilInfoKas(){
    const sel = document.getElementById('kasSelect');
    const opt = sel.options[sel.selectedIndex];
    const box = document.getElementById('kasInfo');
    if(sel.value){
        const nominal = parseInt(opt.dataset.nominal).toLocaleString('id-ID');
        box.innerHTML = '<i class="fa fa-circle-info"></i> <b>' + opt.dataset.jenis + '</b> | Rp.' + nominal + ' | ' + opt.dataset.tgl;
        box.style.display = 'block';
    } else {
        box.style.display = 'none';
    }
}
function formatEstimasiAnggaran(){
    const input = document.getElementById('estimasiAnggaran');
    if(!input) return;
    const digits = input.value.replace(/\D/g, '');
    input.value = digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
}
document.getElementById('estimasiAnggaran')?.addEventListener('input', formatEstimasiAnggaran);
window.onload = function () {
    tampilInfoKas();
    formatEstimasiAnggaran();
};
</script>

@endsection
