<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('driver', function (Blueprint $table) {
            $table->string('id_driver', 20)->primary();
            $table->string('nama_driver');
            $table->bigInteger('no_telp')->nullable();
            $table->enum('status', ['aktif','tidak aktif'])->default('aktif');
            $table->enum('tipe_kendaraan', ['motor','pick up']);
            $table->string('plat_kendaraan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('driver');
    }
};
