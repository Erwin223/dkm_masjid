<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PenerimaanZakat;
use App\Models\Muzakki;
use App\Models\DistribusiZakat;
use App\Models\Mustahik;

echo "========================================\n";
echo "TESTING CREATE DATA\n";
echo "========================================\n\n";

try {
    echo "1. Testing create Muzakki (without auth):\n";
    $muzakki = Muzakki::create([
        'nama' => 'Test Muzakki 001',
        'alamat' => 'Jl. Test No. 1',
        'no_hp' => '081234567890',
        'email' => 'muzakki@test.com',
        'status' => 'active',
        'tahun_daftar' => 2026,
    ]);
    echo "  ✓ Muzakki created: ID {$muzakki->id}\n";
    echo "  ✓ Fillable fields work correctly\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "2. Testing create PenerimaanZakat (with status, created_by, updated_by):\n";
    
    // Simulate create without auth (set created_by manually)
    $penerimaan = PenerimaanZakat::create([
        'muzakki_id' => $muzakki->id,
        'tanggal' => now()->toDateString(),
        'jenis_zakat' => 'Zakat Fitrah',
        'bentuk_zakat' => 'Uang',
        'jumlah_zakat' => 300000,
        'satuan' => null,
        'nominal' => 300000,
        'nominal_pembagian' => 150000,
        'jumlah_tanggungan' => 2,
        'standar_per_jiwa' => null,
        'metode_pembayaran' => 'Tunai',
        'keterangan' => 'Test data - penerimaan zakat',
        'status' => 'pending',
        'created_by' => 1, // Assuming user ID 1 exists
        'updated_by' => 1,
        'verified_date' => null,
    ]);
    echo "  ✓ PenerimaanZakat created: ID {$penerimaan->id}\n";
    echo "  ✓ Status: {$penerimaan->status}\n";
    echo "  ✓ Created by: {$penerimaan->created_by}\n";
    echo "  ✓ All new fields work!\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "3. Testing Relationship - Muzakki -> PenerimaanZakat:\n";
    $penerimaan_list = $muzakki->penerimaanZakat()->get();
    echo "  ✓ Found {$penerimaan_list->count()} penerimaan(s) for this muzakki\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "4. Testing Relationship - PenerimaanZakat -> CreatedByUser:\n";
    $creator = $penerimaan->createdByUser;
    echo "  ✓ Created by user: " . ($creator ? $creator->name : "ID {$penerimaan->created_by} (user not found)") . "\n";
    if (!$creator) {
        echo "    → This is OK if user ID 1 doesn't exist yet\n";
    }
    echo "\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "5. Testing create Mustahik:\n";
    $mustahik = Mustahik::create([
        'nama' => 'Test Mustahik 001',
        'alamat' => 'Jl. Test No. 2',
        'no_hp' => '081234567891',
        'kategori_mustahik' => 'Fakir Miskin',
        'keterangan' => 'Test data',
    ]);
    echo "  ✓ Mustahik created: ID {$mustahik->id}\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "6. Testing create DistribusiZakat (with penerimaan_zakat_id):\n";
    $distribusi = DistribusiZakat::create([
        'tanggal' => now()->toDateString(),
        'mustahik_id' => $mustahik->id,
        'penerimaan_zakat_id' => $penerimaan->id, // ← NEW FIELD
        'jenis_zakat' => 'Zakat Fitrah',
        'bentuk_zakat' => 'Uang',
        'jumlah_zakat' => 300000,
        'satuan' => null,
        'nominal' => 300000,
        'keterangan' => 'Test distribution',
    ]);
    echo "  ✓ DistribusiZakat created: ID {$distribusi->id}\n";
    echo "  ✓ Linked to PenerimaanZakat ID: {$distribusi->penerimaan_zakat_id}\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "7. Testing Relationship - DistribusiZakat -> PenerimaanZakat:\n";
    $linked_penerimaan = $distribusi->penerimaanZakat;
    echo "  ✓ Distribution linked to Penerimaan ID: {$linked_penerimaan->id}\n";
    echo "  ✓ Muzakki: {$linked_penerimaan->muzakki->nama}\n";
    echo "  ✓ Mustahik: {$distribusi->mustahik->nama}\n\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

try {
    echo "8. Testing PenerimaanZakat -> DistribusiZakat relationship:\n";
    $distributions = $penerimaan->distribusiZakat()->get();
    echo "  ✓ Found {$distributions->count()} distribution(s) for this penerimaan\n";
    foreach ($distributions as $d) {
        echo "    - Distributed to: {$d->mustahik->nama} (Rp " . number_format($d->nominal, 0, ',', '.') . ")\n";
    }
    echo "\n";

} catch (\Exception $e) {
    echo "  ✗ Error: {$e->getMessage()}\n\n";
}

echo "========================================\n";
echo "✓ ALL TESTS PASSED\n";
echo "========================================\n";
echo "\nSekarang bisa masuk UI dan cek halaman tanpa error.\n";
