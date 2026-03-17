@extends('layouts.admin')

@section('content')

<style>
.form-container {
    max-width: 600px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    color: #28a745;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
}

.input-group {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: 0.3s;
}

.input-group i {
    background: #28a745;
    color: white;
    padding: 12px;
    min-width: 40px;
    text-align: center;
}

.input-group input,
.input-group textarea {
    border: none;
    padding: 12px;
    width: 100%;
    outline: none;
    font-size: 14px;
}

.input-group span {
    background: #eee;
    padding: 12px;
    font-weight: bold;
}

.input-group:focus-within {
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.4);
}

textarea {
    resize: none;
    height: 80px;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #218838;
}

/* ERROR */
.error-box {
    background: #ffe0e0;
    color: #a30000;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}
</style>

<div class="form-container">

<div class="form-title">
    <i class="fa fa-arrow-down"></i> Tambah Kas Masuk
</div>

{{-- VALIDASI ERROR --}}
@if ($errors->any())
<div class="error-box">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('kas.masuk.store') }}">
@csrf

<div class="form-group">
<label>Tanggal</label>
<div class="input-group">
    <i class="fa fa-calendar"></i>
    <input type="date" name="tanggal" required>
</div>
</div>

<div class="form-group">
<label>Sumber</label>
<div class="input-group">
    <i class="fa fa-user"></i>
    <input type="text" name="sumber" placeholder="Contoh: Donatur" required>
</div>
</div>

<div class="form-group">
<label>Jumlah</label>
<div class="input-group">
    <span>Rp</span>
    <input type="text" name="jumlah"
        onkeyup="formatRupiah(this)"
        onblur="bersihkanRupiah(this)"
        placeholder="Masukkan Jumlah Kas" required>
</div>
</div>

<div class="form-group">
<label>Keterangan</label>
<div class="input-group">
    <i class="fa fa-note-sticky"></i>
    <textarea name="keterangan" placeholder="Opsional"></textarea>
</div>
</div>

<button type="submit" class="btn-submit">
    <i class="fa fa-save"></i> Simpan Data
</button>

</form>

</div>

{{-- SCRIPT FORMAT RUPIAH --}}
<script>
function formatRupiah(el){
    let angka = el.value.replace(/[^0-9]/g, '');
    el.value = new Intl.NumberFormat('id-ID').format(angka);
}

function bersihkanRupiah(el){
    el.value = el.value.replace(/\./g,'');
}
</script>

@endsection
