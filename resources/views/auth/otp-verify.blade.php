@extends('layouts.auth-login')

@section('title', 'Verifikasi OTP')
@section('subtitle', 'Verifikasi OTP Reset Password')

@section('content')
<h2><i class="fa-solid fa-shield-halved"></i> Verifikasi OTP</h2>
<p>Masukkan 6 digit kode OTP yang dikirim ke email Anda.</p>

@if(session('status'))
<div class="status-box">{{ session('status') }}</div>
@endif

@if ($errors->any())
<div class="error-box">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.otp.verify.post') }}">
@csrf

<div class="input-group">
<i class="fa fa-key"></i>
<input id="otp" type="text" name="otp" placeholder="Kode OTP" required autofocus maxlength="6" autocomplete="off" inputmode="numeric" style="text-align:center;letter-spacing:6px;">
</div>

<button type="submit"><i class="fa fa-circle-check"></i> Verifikasi OTP</button>
</form>

<div class="actions" style="margin-top:18px;margin-bottom:0;">
<a href="{{ route('password.request') }}" class="link">Ganti Email</a>

<form method="POST" action="{{ route('password.otp.resend') }}" style="margin:0;">
@csrf
<button id="resendBtn" type="submit" class="btn-inline btn-secondary">
<i class="fa fa-rotate"></i> Kirim Ulang OTP <span id="cooldownText"></span>
</button>
</form>
</div>

<script>
(function () {
var cooldown = {{ (int) ($cooldownRemaining ?? 0) }};
var locked = {{ (int) ($lockRemainingSeconds ?? 0) }};
var btn = document.getElementById('resendBtn');
var text = document.getElementById('cooldownText');

function render() {
var remaining = Math.max(cooldown, locked);
if (remaining > 0) {
text.textContent = ' (' + remaining + 's)';
if (btn) btn.setAttribute('disabled', 'disabled');
} else {
text.textContent = '';
if (btn) btn.removeAttribute('disabled');
}
}

render();

if (cooldown > 0 || locked > 0) {
setInterval(function () {
if (cooldown > 0) cooldown--;
if (locked > 0) locked--;
render();
}, 1000);
}
})();
</script>
@endsection
