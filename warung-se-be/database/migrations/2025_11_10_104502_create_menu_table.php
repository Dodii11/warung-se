<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menu', function (Blueprint $table) {
            $table->integer('id_menu')->autoIncrement()->primary();
            $table->string('menu', 255);
            $table->integer('harga');
            $table->enum('kategori', ['makanan', 'minum', 'paket']);
            $table->binary('gambar_menu')->nullable(); // simpan binary blob
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('menu');
    }
};
