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
        Schema::create('super_admins', function (Blueprint $table) {
            $table->id('id_super_admin'); // INT(11), PK  | SING ID AWALE INTEGER, TUR TAK GENTI ID
            $table->string('nama_super_admin', 255); // VARCHAR(255)
            $table->bigInteger('no_telp'); // BIGINT(20)
            $table->string('password', 255); // VARCHAR(255)
            $table->timestamps(); // Opsional, tapi disarankan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_admins');
    }
};
