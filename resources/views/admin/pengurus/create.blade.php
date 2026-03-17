@extends('layouts.admin')

@section('content')

<style>

.form-container{
max-width:600px;
margin:auto;
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.form-title{
font-size:20px;
font-weight:bold;
text-align:center;
margin-bottom:20px;
color:#0f8b6d;
}

.form-group{
margin-bottom:15px;
}

.form-group label{
display:block;
font-weight:600;
margin-bottom:5px;
}

.input-group{
display:flex;
align-items:center;
border:1px solid #ddd;
border-radius:8px;
overflow:hidden;
}

.input-group i{
background:#0f8b6d;
color:white;
padding:12px;
min-width:40px;
text-align:center;
}

.input-group input{
border:none;
padding:12px;
width:100%;
outline:none;
}

.btn-submit{
width:100%;
padding:12px;
background:#0f8b6d;
color:white;
border:none;
border-radius:8px;
font-weight:bold;
cursor:pointer;
}

.btn-submit:hover{
background:#0c6d55;
}

</style>

<div class="form-container">

<div class="form-title">
<i class="fa fa-user-plus"></i> Tambah Pengurus
</div>

<form method="POST" action="{{ route('pengurus.store') }}" enctype="multipart/form-data">
@csrf

<div class="form-group">
<label>Nama</label>
<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" name="nama">
</div>
</div>

<div class="form-group">
<label>Jabatan</label>
<div class="input-group">
<i class="fa fa-briefcase"></i>
<input type="text" name="jabatan">
</div>
</div>

<div class="form-group">
<label>No HP</label>
<div class="input-group">
<i class="fa fa-phone"></i>
<input type="text" name="no_hp">
</div>
</div>

<div class="form-group">
<label>Foto</label>
<div class="input-group">
<i class="fa fa-image"></i>
<input type="file" name="foto">
</div>
</div>

<button type="submit" class="btn-submit">
<i class="fa fa-save"></i> Simpan
</button>


@if($errors->any())
<div style="background:#ffdddd;padding:10px;margin-bottom:15px;border-radius:6px;">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
</form>

</div>

@endsection
