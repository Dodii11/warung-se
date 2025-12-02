<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user', function (Blueprint $table) {
            $table->integer('id_user', 11)->primary();
            $table->string('email_user', 255)->unique();
            $table->string('nama_user', 255);
            $table->bigInteger('no_telp');
            $table->string('password', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user');
    }
};
