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
    color: #007bff;
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
}

.input-group i {
    background: #007bff;
    color: white;
    padding: 12px;
    min-width: 40px;
    text-align: center;
}

.input-group span {
    background: #eee;
    padding: 12px;
    font-weight: bold;
}

.input-group input,
.input-group textarea {
    border: none;
    padding: 12px;
    width: 100%;
    outline: none;
}

.input-group:focus-within {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0,123,255,0.4);
}

textarea {
    resize: none;
    height: 80px;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.btn-submit:hover {
    background: #0056b3;
}
</style>

<div class="form-container">

<div class="form-title">
<i class="fa fa-edit"></i> Edit Kas Masuk
</div>

<form method="POST" action="{{ route('kas.masuk.update', $data->id) }}">
@csrf
@method('PUT')

<!-- TANGGAL -->
<div class="form-group">
<label>Tanggal</label>
<div class="input-group">
<i class="fa fa-calendar"></i>
<input type="date" name="tanggal" value="{{ $data->tanggal }}" required>
</div>
</div>

<!-- SUMBER -->
<div class="form-group">
<label>Sumber</label>
<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" name="sumber" value="{{ $data->sumber }}" required>
</div>
</div>

<!-- JUMLAH -->
<div class="form-group">
<label>Jumlah</label>
<div class="input-group">
<span>Rp</span>
<input type="text" name="jumlah"
value="{{ number_format($data->jumlah,0,',','.') }}"
onkeyup="formatRupiah(this)"
onblur="bersihkanRupiah(this)" required>
</div>
</div>

<!-- KETERANGAN -->
<div class="form-group">
<label>Keterangan</label>
<div class="input-group">
<i class="fa fa-note-sticky"></i>
<textarea name="keterangan">{{ $data->keterangan }}</textarea>
</div>
</div>

<button class="btn-submit">
<i class="fa fa-save"></i> Update Data
</button>

</form>

</div>

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
