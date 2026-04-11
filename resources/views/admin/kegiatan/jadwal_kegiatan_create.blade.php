@extends('layouts.admin')
@section('content')
@include('admin.kegiatan._styles')

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
