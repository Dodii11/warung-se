<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan'); // INT(11), PK
            
            // Kolom FK (id_user - user)
            $table->foreignId('id_user')->constrained('users', 'id_user'); // INT(11), FK

            $table->dateTime('tanggal_pesanan'); // DATETIME
            $table->decimal('total_harga', 10, 2); // DECIMAL(10,2)
            // ENUM(proses, diantar, selesai, batal)
            $table->enum('status', ['proses', 'diantar', 'selesai', 'batal'])->default('proses');
            $table->string('metode_bayar', 50); // VARCHAR(50)
            $table->text('alamat'); // TEXT
            $table->text('catatan')->nullable(); // TEXT
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};