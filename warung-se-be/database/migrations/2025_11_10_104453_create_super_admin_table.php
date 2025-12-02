<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('super_admin', function (Blueprint $table) {
            $table->integer('id_super', 11)->primary();
            $table->string('email_super', 255)->unique();
            $table->string('nama_super', 255);
            $table->bigInteger('no_telp');
            $table->string('password', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('super_admin');
    }
};
