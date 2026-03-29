<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerimaan_zakat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('muzakki_id')->constrained('muzakki')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('tanggal');
            $table->string('jenis_zakat');
            $table->decimal('jumlah_zakat', 15, 2)->default(0);
            $table->unsignedInteger('jumlah_tanggungan')->nullable();
            $table->string('metode_pembayaran');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_zakat');
    }
};
