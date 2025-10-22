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
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detail'); // INT(11), PK
            
            // Kolom FK (id_pesanan - pesanan)
            $table->foreignId('id_pesanan')->constrained('pesanans', 'id_pesanan')->onDelete('cascade'); // INT(11), FK
            
            // Kolom FK (id_menu - menu)
            $table->foreignId('id_menu')->constrained('menus', 'id_menu')->onDelete('restrict'); // INT(11), FK
            
            $table->integer('jumlah', false, true)->length(11); // INT(11)
            $table->decimal('subtotal', 10, 2); // DECIMAL(10,2)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};