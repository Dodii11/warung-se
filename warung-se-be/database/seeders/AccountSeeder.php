<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\Alamat;
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
        $user = Account::create([
            'nama_user' => 'User Biasa',
            'email_user' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleUser,
            'status' => 'aktif',
            'no_telp' => '081234567890',
        ]);

        // Tambahkan alamat untuk user
        Alamat::create([
            'id_user' => $user->id_user,
            'alamat' => 'Jl. Merdeka No.1',
            'kecamatan' => 'Gajah Mungkur',
            'kota' => 'Surakarta',
            'data_lokasi' => '{"lat":-7.565, "lng":110.831}',
            'is_default' => true,
        ]);

        // Buat akun admin
        Account::create([
            'nama_user' => 'Admin',
            'email_user' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleAdmin,
            'status' => 'aktif'
        ]);

        // Buat akun super admin
        Account::create([
            'nama_user' => 'Super Admin',
            'email_user' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
            'id_role' => $roleSuper,
            'status' => 'aktif'
        ]);
    }
}
