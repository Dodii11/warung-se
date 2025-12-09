<?php

// database/migrations/2025_12_04_000003_create_account_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('email_user')->unique();
            $table->string('nama_user');
            $table->foreignId('id_role')->constrained('role', 'id_role');
            $table->enum('status', ['aktif','tidak aktif'])->default('aktif');
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account');
    }
};

