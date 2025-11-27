<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 20)->primary();

            $table->integer('id_user');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            $table->string('id_driver', 20)->nullable();
            $table->foreign('id_driver')->references('id_driver')->on('driver')->nullOnDelete();

            $table->dateTime('tanggal_pesanan');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['proses', 'diantar', 'selesai', 'batal'])->default('proses');

            $table->binary('foto_pembayaran')->nullable(); // simpan gambar binary
            $table->string('metode_bayar', 50);
            $table->text('alamat');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanan');
    }
};
