<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder 3 Role: SuperAdmin, Admin, User
        $this->call([
            SuperAdminSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
        ]);
    }
}
