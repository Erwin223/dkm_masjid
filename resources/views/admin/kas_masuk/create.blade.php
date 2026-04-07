@extends('layouts.admin')

@section('content')

@include('admin.kas_masuk._styles')

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
