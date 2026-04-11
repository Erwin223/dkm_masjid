@extends('layouts.admin')

@section('content')

@include('admin.users._styles')

<div class="form-box">
    <h3><i class="fa fa-user-plus" style="color:#0f8b6d;"></i> Tambah Admin Baru</h3>

    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap <span style="color:red;">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama admin">
        </div>

        <div class="form-group">
            <label>Alamat Email <span style="color:red;">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email aktif">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Password <span style="color:red;">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" required placeholder="Buat password">
                    <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password <span style="color:red;">*</span></label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password">
                    <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)"></i>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Simpan Admin</button>
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
