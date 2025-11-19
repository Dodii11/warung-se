<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Data Dummy untuk User, Admin, Dan Super Admin
        User::create([
            'id_user' => 3,
            'nama_user' => 'User',
            'no_telp' => '1234567891',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'status' => 'active',
            'password' => 'user' 
        ]);

        User::create([
            'id_user' => 2,
            'nama_user' => 'Admin',
            'no_telp' => '1234567892',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'status' => 'active',
            'password' => 'admin'
        ]);

        User::create([
            'id_user' => 1,
            'nama_user' => 'Super Admin',
            'no_telp' => '1234567893',
            'email' => 'superadmin@gmail.com',
            'role' => 'super_admin',
            'status' => 'active',
            'password' => 'superadmin' 
        ]);
    }
}
