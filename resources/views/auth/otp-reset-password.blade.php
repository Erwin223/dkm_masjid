@extends('layouts.auth-login')

@section('title', 'Reset Password')
@section('subtitle', 'Buat Password Baru Admin')

@section('content')
    <h2>Reset Password</h2>
    <p>Masukkan password baru untuk akun admin Anda.</p>

    @if(session('status'))
        <div class="status-box">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.otp.reset.post') }}">
        @csrf

        <div class="input-group">
            <input id="password" type="password" name="password" placeholder="Password Baru" required
                autocomplete="new-password">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password', this)">Tampilkan</button>
        </div>

        <div class="input-group">
            <input id="password_confirmation" type="password" name="password_confirmation"
                placeholder="Konfirmasi Password Baru" required autocomplete="new-password">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password_confirmation', this)">Tampilkan</button>
        </div>

        <button type="submit">Simpan Password Baru</button>
    </form>

    <div class="actions" style="margin-top:18px;margin-bottom:0;">
        <a href="{{ route('login') }}" class="link">Kembali ke Login</a>
    </div>
@endsection
