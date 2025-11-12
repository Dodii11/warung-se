<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan kolom 'role' dengan nilai terbatas
        $table->enum('role', ['user', 'admin', 'super_admin'])->default('user')->after('password');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
