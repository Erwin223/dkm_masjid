@extends('layouts.auth-login')

@section('title', 'Verifikasi Login')
@section('subtitle', 'Masukkan kode verifikasi email untuk menyelesaikan login')

@section('content')
    <h2>Verifikasi Login</h2>
    <p>Masukkan 6 digit kode verifikasi yang baru saja dikirim ke email admin Anda.</p>

    @if (session('status'))
        <div class="status-box">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.otp.verify') }}">
        @csrf

        <div class="input-group">
            <input id="otp" type="text" name="otp" placeholder="Kode Verifikasi" required autofocus maxlength="6"
                autocomplete="one-time-code" inputmode="numeric" style="text-align:center;letter-spacing:6px;">
        </div>

        <button type="submit">Verifikasi dan Masuk</button>
    </form>

    <div class="actions" style="margin-top:18px;margin-bottom:0;">
        <a href="{{ route('login') }}" class="link">Kembali ke Login</a>

        <form method="POST" action="{{ route('login.otp.resend') }}" style="margin:0;">
            @csrf
            <button id="resendBtn" type="submit" class="btn-inline btn-secondary">
                Kirim Ulang Kode <span id="cooldownText"></span>
            </button>
        </form>
    </div>

    <script>
        (function () {
            var cooldown = {{ (int) ($cooldownRemaining ?? 0) }};
            var btn = document.getElementById('resendBtn');
            var text = document.getElementById('cooldownText');

            function render() {
                if (cooldown > 0) {
                    text.textContent = ' (' + cooldown + 's)';
                    if (btn) btn.setAttribute('disabled', 'disabled');
                } else {
                    text.textContent = '';
                    if (btn) btn.removeAttribute('disabled');
                }
            }

            render();

            if (cooldown > 0) {
                setInterval(function () {
                    if (cooldown > 0) cooldown--;
                    render();
                }, 1000);
            }
        })();
    </script>
@endsection
