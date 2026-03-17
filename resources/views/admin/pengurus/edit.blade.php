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

/* FOTO PREVIEW */
.preview{
text-align:center;
margin-bottom:15px;
}

.preview img{
width:90px;
height:90px;
border-radius:50%;
object-fit:cover;
border:3px solid #0f8b6d;
}

/* BUTTON */
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
<i class="fa fa-user-edit"></i> Edit Pengurus
</div>

<form method="POST" action="{{ route('pengurus.update',$data->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<!-- FOTO SAAT INI -->
<div class="preview">
@if($data->foto)
<img src="{{ asset('storage/'.$data->foto) }}">
@else
<img src="https://via.placeholder.com/90">
@endif
</div>

<div class="form-group">
<label>Nama</label>
<div class="input-group">
<i class="fa fa-user"></i>
<input type="text" name="nama" value="{{ $data->nama }}">
</div>
</div>

<div class="form-group">
<label>Jabatan</label>
<div class="input-group">
<i class="fa fa-briefcase"></i>
<input type="text" name="jabatan" value="{{ $data->jabatan }}" required>
</div>
</div>

<div class="form-group">
<label>No HP</label>
<div class="input-group">
<i class="fa fa-phone"></i>
<input type="text" name="no_hp" value="{{ $data->no_hp }}">
</div>
</div>

<div class="form-group">
<label>Ganti Foto</label>
<div class="input-group">
<i class="fa fa-image"></i>
<input type="file" name="foto">
</div>
</div>

<button type="submit" class="btn-submit">
<i class="fa fa-save"></i> Update Data
</button>

</form>

</div>

@endsection
