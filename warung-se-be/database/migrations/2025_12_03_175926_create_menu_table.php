<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('menu');
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->enum('kategori', ['makanan','minuman','paket']);
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->integer('stok')->default(0);
            $table->binary('gambar_menu')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
