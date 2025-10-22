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
        Schema::create('menus', function (Blueprint $table) {
            $table->id('id_menu'); // INT(11), PK
            $table->string('menu', 255); // VARCHAR(255)
            $table->integer('harga', false, true)->length(11); // INT(11)
            // ENUM(makanan, minum, paket)
            $table->enum('kategori', ['makanan', 'minuman', 'paket']); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};