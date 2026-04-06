<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kas_masuk') && Schema::hasColumn('kas_masuk', 'jumlah')) {
            DB::statement('ALTER TABLE kas_masuk ALTER COLUMN jumlah TYPE BIGINT');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('kas_masuk') && Schema::hasColumn('kas_masuk', 'jumlah')) {
            DB::statement('ALTER TABLE kas_masuk ALTER COLUMN jumlah TYPE INTEGER');
        }
    }
};
