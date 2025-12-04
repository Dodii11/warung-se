<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan',20)->primary();
            $table->foreignId('id_user')->constrained('account', 'id_user');
            $table->string('id_driver',20)->nullable();
            $table->dateTime('tanggal_pesanan');
            $table->decimal('total_harga',10,2);
            $table->enum('status',['proses','diantar','selesai','batal'])->default('proses');
            $table->text('alamat');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_driver')->references('id_driver')->on('driver')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
