@extends('layouts.admin')

@section('content')

@include('admin.users._styles')

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
