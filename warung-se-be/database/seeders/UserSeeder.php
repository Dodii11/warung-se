<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan mengimpor model User
use Illuminate\Support\Facades\Hash; // Digunakan untuk mengenkripsi password

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat satu pengguna Admin (jika ada peran yang spesifik)
        // ID_USER akan dibuat otomatis oleh fungsi boot() di model
        User::create([
            'email_user' => 'user@gmail.com',
            'nama_user' => 'User',
            'no_telp' => '081234567890',
            // Gunakan Hash::make() untuk enkripsi password seperti yang dilakukan di Seeder sebelumnya
            'password' => Hash::make('password123'), 
        ]);
    }
}