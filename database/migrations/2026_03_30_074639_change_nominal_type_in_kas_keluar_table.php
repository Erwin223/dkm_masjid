<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->decimal('nominal', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kas_keluar', function (Blueprint $table) {
            $table->bigInteger('nominal')->change();
        });
    }
};

