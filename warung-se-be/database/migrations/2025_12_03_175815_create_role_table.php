<?php

// database/migrations/2025_12_04_000001_create_roles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('role_name')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('role');
    }
};
