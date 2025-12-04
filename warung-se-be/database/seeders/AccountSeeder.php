<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        // Ambil role berdasarkan role_name
        $roleUser = \App\Models\Role::where('role_name', 'user')->first()->id_role;
        $roleAdmin = \App\Models\Role::where('role_name', 'admin')->first()->id_role;
        $roleSuper = \App\Models\Role::where('role_name', 'super admin')->first()->id_role;

        // Buat akun user
        Account::create([
            'nama_user' => 'User Biasa',
            'email_user' => 'user@example.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleUser,
            'status' => 'aktif'
        ]);

        // Buat akun admin
        Account::create([
            'nama_user' => 'Admin',
            'email_user' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleAdmin,
            'status' => 'aktif'
        ]);

        // Buat akun super admin
        Account::create([
            'nama_user' => 'Super Admin',
            'email_user' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleSuper,
            'status' => 'aktif'
        ]);
    }
}
