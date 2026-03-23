@extends('layouts.auth-login')

@section('title', 'Lupa Password')
@section('subtitle', 'Reset Password Admin via OTP')

@section('content')
<h2><i class="fa-solid fa-key"></i> Lupa Password</h2>
<p>Masukkan email akun admin Anda, kami akan mengirim kode OTP.</p>

@if(session('status'))
<div class="status-box">{{ session('status') }}</div>
@endif

@if ($errors->any())
<div class="error-box">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="input-group">
<i class="fa fa-envelope"></i>
<input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" autofocus>
</div>

<div class="actions">
<a href="{{ route('login') }}" class="link">Kembali ke Login</a>
<button type="submit" class="btn-inline"><i class="fa fa-paper-plane"></i> Kirim OTP</button>
</div>
</form>
@endsection
