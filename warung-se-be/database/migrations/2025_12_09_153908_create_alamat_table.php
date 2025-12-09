<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamat', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_user');
            $table->text('data_lokasi')->nullable();
            $table->text('alamat');
            $table->string('kecamatan')->nullable();
            $table->string('kota')->nullable();

            $table->timestamps();

            // Foreign Key
            $table->foreign('id_user')->references('id')->on('account')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
