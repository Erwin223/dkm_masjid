@extends('layouts.admin')

@section('content')

<style>
    .form-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:28px; max-width:750px; margin:auto; }
    .form-box h3 { font-size:16px; font-weight:600; margin-bottom:20px; color:#111; display:flex; align-items:center; gap:8px; }
    .form-group { margin-bottom:18px; }
    .form-group label { display:block; font-size:13px; font-weight:500; color:#444; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px; color:#333; outline:none; background:#fff; transition:border 0.2s; box-sizing: border-box; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:#0f8b6d; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .form-actions { display:flex; gap:10px; margin-top:24px; flex-wrap:wrap; }
    .btn-simpan { background:#0f8b6d; color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-simpan:hover { background:#0c6d55; }
    .btn-batal { background:#fff; color:#555; border:1px solid #ddd; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-batal:hover { background:#f5f5f5; }
    .invalid-feedback { font-size:12px; color:#dc3545; margin-top:4px; display:block; }
    .error-list { background:#fff5f5; border:1px solid #feb2b2; padding:15px; border-radius:8px; margin-bottom:20px; color:#c53030; font-size:13px; }
    .error-list ul { margin:0; padding-left:20px; }
    .info-text { font-size: 12px; color: #666; margin-top: 5px; }
    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 40px !important; }
    .password-wrapper .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777; }
    @media(max-width:600px){ .form-row { grid-template-columns:1fr; } .form-box { padding:18px; } }
</style>

<div class="form-box">
    <h3><i class="fa fa-user-edit" style="color:#0f8b6d;"></i> Edit Data Admin</h3>

    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap <span style="color:red;">*</span></label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Masukkan nama admin">
        </div>

        <div class="form-group">
            <label>Alamat Email <span style="color:red;">*</span></label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Masukkan email aktif">
        </div>

        @if(Auth::id() == $user->id)
        <div class="form-group" style="background:#f0f9ff; padding:15px; border-radius:8px; border:1px solid #bae6fd;">
            <label style="color:#0369a1;">Konfirmasi Keamanan <span style="color:red;">*</span></label>
            <div class="password-wrapper">
                <input type="password" name="current_password" id="current_password" placeholder="Masukkan Kata Sandi Saat Ini" required>
                <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('current_password', this)"></i>
            </div>
            <p class="info-text" style="color:#0369a1; margin-bottom:0;">*Wajib diisi untuk memverifikasi identitas Anda sebelum mengubah data profil.</p>
        </div>
        @endif

        <div class="form-row">
            <div class="form-group">
                <label>Password Baru (Opsional)</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah">
                    <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
                </div>
                <p class="info-text">*Isi jika ingin mengganti password admin ini.</p>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru">
                    <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)"></i>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Perbarui Admin</button>
            <a href="{{ route('admin.users.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>

<script>
function togglePasswordVisibility(inputId, iconElement) {
    const passwordInput = document.getElementById(inputId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        iconElement.classList.remove("fa-eye");
        iconElement.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        iconElement.classList.remove("fa-eye-slash");
        iconElement.classList.add("fa-eye");
    }
}
</script>

@endsection
