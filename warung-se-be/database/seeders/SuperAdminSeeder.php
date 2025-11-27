<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // cek apakah sudah ada superadmin
        if (!SuperAdmin::where('email_super', 'admin@gmail.com')->exists()) {
            SuperAdmin::create([
                'email_super' => 'admin@gmail.com',
                'nama_super' => 'Super Admin',
                'no_telp' => '081234567890',
                'password' => Hash::make('admin'),
            ]);
        }
    }
}
