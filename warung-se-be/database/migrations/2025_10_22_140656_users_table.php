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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user'); // INT(11), PK
            $table->string('nama_user', 255); // VARCHAR(255)
            $table->bigInteger('no_telp'); // BIGINT(20)
            $table->string('email', 255)->unique(); // VARCHAR(255), UNIQUE
            $table->timestamp('email_verified_at')->nullable(); // TIMESTAMP, NULLABLE
            $table->string('password', 255); // VARCHAR(255)
            $table->enum('role', ['user', 'admin', 'super_admin']) -> default('user');
            $table->enum('status', ['verify', 'active', 'banned']);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};