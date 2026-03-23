@extends('layouts.admin')

@section('content')

<style>
    .form-container {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 25px;
        color: #0f8b6d;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .input-group {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .input-group i {
        background: #0f8b6d;
        color: white;
        padding: 12px;
        min-width: 45px;
        text-align: center;
    }

    .input-group input {
        border: none;
        padding: 12px;
        width: 100%;
        outline: none;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #0f8b6d;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: #0c6d55;
    }

    .error-list {
        background: #fff5f5;
        border: 1px solid #feb2b2;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: #c53030;
        font-size: 13px;
    }

    .error-list ul {
        margin: 0;
        padding-left: 20px;
    }

    .info-text {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <div class="form-title">
        <i class="fa fa-user-edit"></i> Edit Data Admin
    </div>

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
            <label>Nama Lengkap</label>
            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required placeholder="Masukkan nama admin">
            </div>
        </div>

        <div class="form-group">
            <label>Alamat Email</label>
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Masukkan email aktif">
            </div>
        </div>

        @if(Auth::id() == $user->id)
        <div class="form-group" style="background:#f0f9ff; padding:15px; border-radius:8px; border:1px solid #bae6fd;">
            <label style="color:#0369a1;">Konfirmasi Keamanan</label>
            <div class="input-group">
                <i class="fa fa-key" style="background:#0369a1;"></i>
                <input type="password" name="current_password" placeholder="Masukkan Kata Sandi Saat Ini" required>
            </div>
            <p class="info-text" style="color:#0369a1;">*Wajib diisi untuk memverifikasi identitas Anda sebelum mengubah data profil.</p>
        </div>
        @endif

        <div class="form-group">
            <label>Password Baru (Opsional)</label>
            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>
            <p class="info-text">*Isi jika ingin mengganti password admin ini.</p>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <div class="input-group">
                <i class="fa fa-shield-halved"></i>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:30px;">
            <a href="{{ route('admin.users.index') }}" style="flex:1; text-align:center; padding:12px; background:#6c757d; color:white; text-decoration:none; border-radius:8px; font-weight:bold;">
                <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn-submit" style="flex:2;">
                <i class="fa fa-save"></i> Perbarui Admin
            </button>
        </div>
    </form>
</div>

@endsection
