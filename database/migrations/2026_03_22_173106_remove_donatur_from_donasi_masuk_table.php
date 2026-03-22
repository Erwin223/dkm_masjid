<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('donasi_masuk', function (Blueprint $table) {
        $table->dropColumn('donatur');
    });
}

public function down()
{
    Schema::table('donasi_masuk', function (Blueprint $table) {
        $table->string('donatur')->nullable();
    });
}
};
