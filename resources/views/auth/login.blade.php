@extends('layouts.auth-login')

@section('title', 'Login Admin')
@section('subtitle', 'Login Admin Website DKM')

@section('content')
     
    <h2>Login Admin</h2>
    <p>Silakan login untuk mengelola sistem informasi masjid.</p>

    @if (session('error') || $errors->any())
        <div style="background: #fff3cd; color: #856404; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: left; border: 1px solid #ffeeba; line-height: 1.4;">
            <strong>⚠️ Peringatan:</strong> Demi keamanan, jika Anda salah memasukkan password sebanyak 5 kali berturut-turut, akun Anda akan dikunci sementara selama 15 menit.
        </div>
    @endif

    @if (session('error'))
        <div class="error-box">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-box">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                </svg>
            </span>
            <input type="text" name="login" placeholder="Email atau Username" required value="{{ old('login') }}" autocomplete="username">
        </div>

        <div class="input-group">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M17 9h-1V7a4 4 0 1 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-7-2a2 2 0 1 1 4 0v2h-4Z"/>
                </svg>
            </span>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password', this)" aria-label="Tampilkan password">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </button>
        </div>

        <div style="text-align: right; margin-bottom: 20px;">
            <a href="{{ route('password.request') }}" class="link">Lupa Password?</a>
        </div>

        <button type="submit">Lanjutkan Login</button>
    </form>
@endsection
