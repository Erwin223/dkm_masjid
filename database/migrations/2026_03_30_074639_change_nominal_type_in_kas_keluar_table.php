<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            // Mengubah tipe data menjadi decimal dengan total 15 digit dan 2 digit di belakang koma
            $table->decimal('nominal', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            // Mengembalikan ke bigint jika migration di-rollback
            $table->bigInteger('nominal')->change();
        });
    }
};

