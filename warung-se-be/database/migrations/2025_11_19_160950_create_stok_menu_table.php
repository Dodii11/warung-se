<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stok_menu', function (Blueprint $table) {
            $table->id('id_stok');
            $table->integer('id_menu');
            $table->integer('jumlah_stok')->default(0);
            $table->timestamps();

            $table->foreign('id_menu')
                  ->references('id_menu')
                  ->on('menu')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('stok_menu');
    }
};
