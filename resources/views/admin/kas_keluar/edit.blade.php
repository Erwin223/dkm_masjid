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
color: #dc3545;
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
background: #dc3545;
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

.input-group:focus-within {
border-color: #dc3545;
box-shadow: 0 0 5px rgba(220, 53, 69, 0.4);
}

textarea {
resize: none;
height: 80px;
}

.btn-submit {
width: 100%;
padding: 14px;
background: #dc3545;
color: white;
border: none;
border-radius: 8px;
font-weight: bold;
cursor: pointer;
transition: 0.3s;
}

.btn-submit:hover {
background: #b02a37;
}

/* ERROR */
.error-text {
color: red;
font-size: 13px;
margin-top: 5px;
}
</style>

<div class="form-container">

<div class="form-title">
<i class="fa fa-pen"></i> Edit Kas Keluar
</div>

<form method="POST" action="{{ route('kas.keluar.update', $data->id) }}">
@csrf
@method('PUT')

<!-- TANGGAL -->
<div class="form-group">
<label>Tanggal</label>
<div class="input-group">
<i class="fa fa-calendar"></i>
<input type="date" name="tanggal" value="{{ $data->tanggal }}" required>
</div>
@error('tanggal') <div class="error-text">{{ $message }}</div> @enderror
</div>

<!-- JENIS -->
<div class="form-group">
<label>Jenis Pengeluaran</label>
<div class="input-group">
<i class="fa fa-tag"></i>
<input type="text" name="jenis_pengeluaran"
value="{{ $data->jenis_pengeluaran }}"
placeholder="Contoh: Pembelian karpet"
required>
</div>
@error('jenis_pengeluaran') <div class="error-text">{{ $message }}</div> @enderror
</div>

<!-- JUMLAH -->
<div class="form-group">
<label>Jumlah</label>
<div class="input-group">
<i class="fa fa-box"></i>
<input type="number" name="jumlah"
value="{{ $data->jumlah }}"
required>
</div>
@error('jumlah') <div class="error-text">{{ $message }}</div> @enderror
</div>

<!-- NOMINAL -->
<div class="form-group">
<label>Nominal (Rp)</label>
<div class="input-group">
<i class="fa fa-money-bill"></i>
<input type="text" name="nominal"
value="{{ number_format($data->nominal,0,',','.') }}"
onkeyup="formatRupiah(this)"
onblur="bersihkanRupiah(this)"
required>
</div>
@error('nominal') <div class="error-text">{{ $message }}</div> @enderror
</div>

<!-- KETERANGAN -->
<div class="form-group">
<label>Keterangan</label>
<div class="input-group">
<i class="fa fa-note-sticky"></i>
<textarea name="keterangan">{{ $data->keterangan }}</textarea>
</div>
</div>

<button type="submit" class="btn-submit">
<i class="fa fa-save"></i> Update Data
</button>

</form>

</div>

<!-- SCRIPT FORMAT RUPIAH -->
<script>
function formatRupiah(input){
let angka = input.value.replace(/[^,\d]/g, '').toString();
let split = angka.split(',');
let sisa = split[0].length % 3;
let rupiah = split[0].substr(0, sisa);
let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

if(ribuan){
let separator = sisa ? '.' : '';
rupiah += separator + ribuan.join('.');
}

input.value = rupiah;
}

function bersihkanRupiah(input){
input.value = input.value.replace(/\./g, '');
}
</script>

@endsection
