@extends('layouts.auth-login')

@section('title', 'Lupa Password')
@section('subtitle', 'Reset Password Admin via OTP')

@section('content')
    <h2>Lupa Password</h2>
    <p>Masukkan email akun admin Anda, kami akan mengirim kode OTP.</p>

    @if (session('status'))
        <div class="status-box">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Zm0 2v.2l8 5.2 8-5.2V8l-8 5-8-5Z"/>
                </svg>
            </span>
            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" autofocus>
        </div>

        <div class="actions">
            <a href="{{ route('login') }}" class="link">Kembali ke Login</a>
            <button type="submit" class="btn-inline">Kirim OTP</button>
        </div>
    </form>
@endsection
