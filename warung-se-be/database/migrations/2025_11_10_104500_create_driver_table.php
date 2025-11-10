<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('driver', function (Blueprint $table) {
            $table->string('id_driver', 20)->primary();
            $table->string('nama_driver', 255);
            $table->bigInteger('no_telp');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('driver');
    }
};
