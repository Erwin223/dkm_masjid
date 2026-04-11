@extends('layouts.admin')
@section('content')
@include('admin.kas_keluar._styles')

<div class="form-box">
    <h3><i class="fa fa-arrow-up" style="color:#dc3545;"></i> Tambah Kas Keluar</h3>

    @if ($errors->any())
    <div class="error-list">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('kas.keluar.store') }}">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal <span style="color:red;">*</span></label>
                <input type="date" name="tanggal" required value="{{ old('tanggal', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label>Jenis Pengeluaran <span style="color:red;">*</span></label>
                <input type="text" name="jenis_pengeluaran" placeholder="Contoh: Listrik, Konsumsi" required value="{{ old('jenis_pengeluaran') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Nominal (Rp) <span style="color:red;">*</span></label>
            <div style="position:relative;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                <input type="text" name="nominal" onkeyup="formatRupiah(this)" required style="padding-left:32px;" value="{{ old('nominal') }}">
            </div>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" placeholder="Opsional">{{ old('keterangan') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Data</button>
            <a href="{{ route('kas.keluar.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
    function formatRupiah(el) {
        let angka = el.value.replace(/[^0-9]/g, '');
        el.value = new Intl.NumberFormat('id-ID').format(angka);
    }
</script>

@endsection
