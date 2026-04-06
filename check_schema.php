<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "========================================\n";
echo "CHECKING DATABASE SCHEMA\n";
echo "========================================\n\n";

echo "1. PENERIMAAN_ZAKAT COLUMNS:\n";
echo "-----------------------------------\n";
$cols = Schema::getColumnListing('penerimaan_zakat');
foreach ($cols as $col) {
    echo "  ✓ $col\n";
}

echo "\n2. NEW FIELDS VERIFICATION:\n";
echo "-----------------------------------\n";
$hasStatus = Schema::hasColumn('penerimaan_zakat', 'status');
echo "  Status field: " . ($hasStatus ? "✓ EXISTS" : "✗ MISSING") . "\n";

$hasCreatedBy = Schema::hasColumn('penerimaan_zakat', 'created_by');
echo "  Created_by field: " . ($hasCreatedBy ? "✓ EXISTS" : "✗ MISSING") . "\n";

$hasUpdatedBy = Schema::hasColumn('penerimaan_zakat', 'updated_by');
echo "  Updated_by field: " . ($hasUpdatedBy ? "✓ EXISTS" : "✗ MISSING") . "\n";

$hasVerifiedDate = Schema::hasColumn('penerimaan_zakat', 'verified_date');
echo "  Verified_date field: " . ($hasVerifiedDate ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n3. MUZAKKI COLUMNS:\n";
echo "-----------------------------------\n";
$cols = Schema::getColumnListing('muzakki');
foreach ($cols as $col) {
    echo "  ✓ $col\n";
}

echo "\n4. NEW MUZAKKI FIELDS VERIFICATION:\n";
echo "-----------------------------------\n";
$hasEmail = Schema::hasColumn('muzakki', 'email');
echo "  Email field: " . ($hasEmail ? "✓ EXISTS" : "✗ MISSING") . "\n";

$hasStatus = Schema::hasColumn('muzakki', 'status');
echo "  Status field: " . ($hasStatus ? "✓ EXISTS" : "✗ MISSING") . "\n";

$hasTahun = Schema::hasColumn('muzakki', 'tahun_daftar');
echo "  Tahun_daftar field: " . ($hasTahun ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n5. DISTRIBUSI_ZAKAT COLUMNS:\n";
echo "-----------------------------------\n";
$cols = Schema::getColumnListing('distribusi_zakat');
foreach ($cols as $col) {
    echo "  ✓ $col\n";
}

echo "\n6. NEW DISTRIBUSI FIELD VERIFICATION:\n";
echo "-----------------------------------\n";
$hasPenerimaanFk = Schema::hasColumn('distribusi_zakat', 'penerimaan_zakat_id');
echo "  Penerimaan_zakat_id field: " . ($hasPenerimaanFk ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n7. MODEL FILLABLE TEST:\n";
echo "-----------------------------------\n";
$penerimaan = new \App\Models\PenerimaanZakat();
echo "  PenerimaanZakat fillable: " . implode(', ', $penerimaan->getFillable()) . "\n";

$muzakki = new \App\Models\Muzakki();
echo "  Muzakki fillable: " . implode(', ', $muzakki->getFillable()) . "\n";

echo "\n8. RELATIONSHIP TEST:\n";
echo "-----------------------------------\n";
$penerimaan = new \App\Models\PenerimaanZakat();
echo "  PenerimaanZakat relations exist: ";
try {
    echo (method_exists($penerimaan, 'createdByUser') ? "✓ createdByUser " : "");
    echo (method_exists($penerimaan, 'updatedByUser') ? "✓ updatedByUser " : "");
    echo (method_exists($penerimaan, 'distribusiZakat') ? "✓ distribusiZakat" : "");
    echo "\n";
} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}

echo "\n========================================\n";
echo "✓ CHECK COMPLETE\n";
echo "========================================\n";
