<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

// Cek apakah email sudah ada & unlock jika locked
$existing = Admin::withoutGlobalScopes()
    ->where('is_admin', true)
    ->first();

if ($existing) {
    echo "=== Akun admin sudah ada ===\n";
    echo "Email: " . $existing->email . "\n";
    echo "Nama : " . $existing->name . "\n";
    echo "Role : " . ($existing->role ?? 'N/A') . "\n";
    echo "Locked: " . ($existing->isLocked() ? 'YA — akan di-unlock' : 'Tidak') . "\n\n";

    // Unlock jika terkunci
    if ($existing->isLocked()) {
        $existing->update([
            'locked_until' => null,
            'failed_login_attempts' => 0,
        ]);
        echo "✅ Akun berhasil di-unlock!\n";
    }

    // Reset password
    $existing->update(['password' => Hash::make('Admin1234!')]);
    echo "✅ Password direset ke: Admin1234!\n";
    echo "   Silakan login dengan email di atas dan password baru.\n";

} else {
    echo "=== Membuat akun admin baru ===\n";

    $admin = new Admin();
    $admin->name = 'Administrator';
    $admin->email = 'admin@dkm.test';
    $admin->password = Hash::make('Admin1234!');
    $admin->role = 'ketua';
    $admin->is_admin = true;
    $admin->failed_login_attempts = 0;
    $admin->save();

    echo "✅ Akun admin berhasil dibuat!\n";
    echo "   Email   : admin@dkm.test\n";
    echo "   Password: Admin1234!\n";
}
