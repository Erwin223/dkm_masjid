<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_masjid', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('visi');
            $table->text('misi');
            $table->text('sejarah');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_masjid');
    }
};
