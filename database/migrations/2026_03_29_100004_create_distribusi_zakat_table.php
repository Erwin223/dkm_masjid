<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribusi_zakat', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('mustahik_id')->constrained('mustahik')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('jenis_zakat');
            $table->decimal('jumlah_zakat', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribusi_zakat');
    }
};
