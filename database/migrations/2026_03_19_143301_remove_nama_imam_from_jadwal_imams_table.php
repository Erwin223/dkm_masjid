<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->dropColumn('nama_imam');
    });
}

public function down()
{
    Schema::table('jadwal_imams', function (Blueprint $table) {
        $table->string('nama_imam')->nullable();
    });
}
};
