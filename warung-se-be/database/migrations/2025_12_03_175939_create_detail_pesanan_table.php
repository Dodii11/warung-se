<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->string('id_detail',20)->primary();
            $table->string('id_pesanan',20);
            $table->foreignId('id_menu')->constrained('menu', 'id_menu');
            $table->integer('jumlah');
            $table->decimal('subtotal',10,2);
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
