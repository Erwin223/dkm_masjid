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
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="don-nav">
    <a href="{{ route('donasi.masuk') }}"><i class="fa fa-arrow-down"></i> Donasi Masuk</a>
    <a href="{{ route('donasi.keluar') }}" class="active"><i class="fa fa-arrow-up"></i> Donasi Keluar</a>
</div>

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Donasi Keluar</h3>

    <form action="{{ route('donasi.keluar.update', $donasi->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($donasi->tanggal)->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Jenis Donasi <span style="color:red;">*</span></label>
                <select name="jenis_donasi" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Uang','Barang','Makanan','Pakaian','Lainnya'] as $j)
                        <option value="{{ $j }}" {{ old('jenis_donasi', $donasi->jenis_donasi) == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tujuan <span style="color:red;">*</span></label>
                <input type="text" name="tujuan" value="{{ old('tujuan', $donasi->tujuan) }}" required>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" id="jumlahDisplay"
                        value="{{ number_format(old('jumlah', $donasi->jumlah), 0, ',', '.') }}"
                        placeholder="0" required style="padding-left:32px;"
                        oninput="formatRupiah(this, 'jumlahHidden')">
                </div>
                <input type="hidden" name="jumlah" id="jumlahHidden" value="{{ old('jumlah', $donasi->jumlah) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan">{{ old('keterangan', $donasi->keterangan) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update</button>
            <a href="{{ route('donasi.keluar') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function formatRupiah(el, hiddenId) {
    let raw = el.value.replace(/[^0-9]/g, '');
    let num = parseInt(raw) || 0;
    el.value = num.toLocaleString('id-ID');
    document.getElementById(hiddenId).value = num;
}
</script>

@endsection
