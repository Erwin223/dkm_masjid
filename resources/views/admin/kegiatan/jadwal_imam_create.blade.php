@extends('layouts.admin')

@section('content')

<style>
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a { padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; border:1px solid #ddd; color:#555; background:#fff; display:inline-flex; align-items:center; gap:7px; transition:0.2s; }
    .keg-nav a:hover  { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:700px; }
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
    .btn-batal:hover { background:#f5f5f5; color:#333; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

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
