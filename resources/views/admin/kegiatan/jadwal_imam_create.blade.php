@extends('layouts.admin')

@section('content')

@include('admin.kegiatan._styles')

<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}"><i class="fa fa-calendar-check"></i> Jadwal Kegiatan</a>
    <a href="{{ route('imam.data') }}"><i class="fa fa-user-tie"></i> Data Imam</a>
    <a href="{{ route('kegiatan.imam') }}" class="active"><i class="fa fa-calendar-days"></i> Jadwal Imam</a>
    <a href="{{ route('kegiatan.sholat') }}"><i class="fa fa-mosque"></i> Jadwal Sholat</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-plus-circle" style="color:#0f8b6d;"></i> Tambah Jadwal Imam</h3>

    <form action="{{ route('kegiatan.imam.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Nama Imam <span style="color:red;">*</span></label>
                <select name="imam_id" required>
                    <option value="">-- Pilih Imam --</option>
                    @foreach($dataImam as $im)
                        <option value="{{ $im->id }}" {{ old('imam_id') == $im->id ? 'selected' : '' }}>
                            {{ $im->nama }} ({{ $im->status }})
                        </option>
                    @endforeach
                </select>
                @error('imam_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Waktu Sholat <span style="color:red;">*</span></label>
                <select name="waktu_sholat" required>
                    <option value="">-- Pilih Waktu --</option>
                    @foreach(['Subuh','Dzuhur','Ashar','Maghrib','Isya'] as $w)
                        <option value="{{ $w }}" {{ old('waktu_sholat') == $w ? 'selected' : '' }}>{{ $w }}</option>
                    @endforeach
                </select>
                @error('waktu_sholat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required oninput="isiHari(this.value)">
                @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Hari</label>
                <input type="text" name="hari" id="hariInput" value="{{ old('hari') }}" placeholder="Otomatis terisi" readonly
                    style="background:#f9f9f9;color:#666;">
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Contoh: Imam pengganti">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('kegiatan.imam') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
const HARI = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
function isiHari(val){
    if(val){ document.getElementById('hariInput').value = HARI[new Date(val).getDay()]; }
}
</script>

@endsection
