<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('data_imam', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('alamat')->nullable();
        $table->string('no_hp')->nullable();
        $table->enum('status', ['Tetap', 'Tamu'])->default('Tetap');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('data_imam');
}
};
