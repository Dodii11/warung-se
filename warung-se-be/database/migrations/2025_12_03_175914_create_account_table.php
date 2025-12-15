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

            // Contoh di tabel users (atau tabel terpisah)
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
        });
    }

    public function down()
    {
        // TAMBAHAN
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn(['otp_code', 'otp_expires_at']);
        });
    }
};

