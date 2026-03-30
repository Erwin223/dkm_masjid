@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-group textarea { resize:vertical; min-height:80px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="form-box">
    <h3><i class="fa fa-arrow-down" style="color:#28a745;"></i> Tambah Kas Masuk</h3>

    {{-- VALIDASI ERROR --}}
    @if ($errors->any())
    <div class="error-list">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('kas.masuk.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label>Sumber <span style="color:red;">*</span></label>
                  <select name="sumber" class="form-control" required>
                    <option value="" disabled {{ old('sumber') ? '' : 'selected' }}> Pilih Sumber </option>
                    <option value="Infaq Langsung" {{ old('sumber') == 'Infaq Langsung' ? 'selected' : '' }}>Infaq Langsung</option>
                    <option value="Transfer" {{ old('sumber') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="Donasi" {{ old('sumber') == 'Donasi' ? 'selected' : '' }}>Donasi</option>
                </select>
            </div>
            
        </div>

        <div class="form-group">
            <label>Jumlah (Rp) <span style="color:red;">*</span></label>
            <div style="position:relative;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                <input type="text" name="jumlah" id="jumlahInput"
                    onkeyup="formatRupiah(this)"
                    placeholder="0" required style="padding-left:32px;" value="{{ old('jumlah') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Data</button>
            <a href="{{ route('kas.masuk.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

{{-- SCRIPT FORMAT RUPIAH --}}
<script>
function formatRupiah(el){
    let angka = el.value.replace(/[^0-9]/g, '');
    el.value = new Intl.NumberFormat('id-ID').format(angka);
}

// Format saat disubmit akan dihandle di controller (str_replace('.', '', $request->jumlah))
// Jadi kita tidak perlu onblur="bersihkanRupiah" karena controller sudah siap menerima format dengan titik
</script>

@endsection
