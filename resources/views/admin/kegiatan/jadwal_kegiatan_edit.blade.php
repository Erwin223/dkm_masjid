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
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Jadwal Kegiatan</h3>
    <div style="margin:0 0 16px;padding:12px 14px;border-radius:10px;background:#f8fafc;color:#334155;font-size:13px;">
        Hanya kegiatan berstatus <b>pending</b> yang bisa diubah. Setelah di-approve atau di-reject, data otomatis terkunci.
    </div>

    <form action="{{ route('kegiatan.jadwal.update', $kegiatan->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nama Kegiatan <span style="color:red;">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                @error('nama_kegiatan') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $kegiatan->penanggung_jawab) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Mulai <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($kegiatan->tanggal)->format('Y-m-d')) }}" required>
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Tanggal Berakhir <span style="font-size:11px;color:#999;font-weight:400;">(opsional)</span></label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai ? \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('Y-m-d') : '') }}">
                @error('tanggal_selesai') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label>Waktu <span style="font-size:11px;color:#999;font-weight:400;">Contoh: 19:00 – 20:00 WIB</span></label>
                <input type="text" name="waktu" value="{{ old('waktu', $kegiatan->waktu) }}" placeholder="Contoh: 19:00 – 20:00 WIB">
                @error('waktu') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Tempat</label>
            <input type="text" name="tempat" value="{{ old('tempat', $kegiatan->tempat) }}">
        </div>

        <div class="form-group">
            <label><i class="fa fa-wallet" style="color:#0f8b6d;font-size:12px;"></i> Estimasi Anggaran</label>
            <input type="text" name="estimasi_anggaran" id="estimasiAnggaran" value="{{ old('estimasi_anggaran', $kegiatan->estimasi_anggaran) ? number_format((float) old('estimasi_anggaran', $kegiatan->estimasi_anggaran), 0, ',', '.') : '' }}" inputmode="numeric" autocomplete="off" placeholder="Contoh: 1.500.000">
            <div class="field-hint">Nominal ini dipakai sebagai rencana anggaran kegiatan dan otomatis memakai pemisah ribuan.</div>
            @error('estimasi_anggaran') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>



        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $kegiatan->keterangan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('kegiatan.jadwal') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>

function formatEstimasiAnggaran(){
    const input = document.getElementById('estimasiAnggaran');
    if(!input) return;
    const digits = input.value.replace(/\D/g, '');
    input.value = digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
}
document.getElementById('estimasiAnggaran')?.addEventListener('input', formatEstimasiAnggaran);
window.onload = function () {
    formatEstimasiAnggaran();
};
</script>

@endsection
