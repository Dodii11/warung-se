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
    Schema::table('users', function (Blueprint $table) {
        // Hanya tambah kolom kalau belum ada
        if (!Schema::hasColumn('users', 'email')) {
            $table->string('email')->after('id_user');
        }
        if (!Schema::hasColumn('users', 'email')) {
    $table->string('email')->unique()->nullable()->after('id_user');
}
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}
};
