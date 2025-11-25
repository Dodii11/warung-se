<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat satu pengguna Admin (jika ada peran yang spesifik)
        // ID_USER akan dibuat otomatis oleh fungsi boot() di model
        Admin::create([
            'email_admin' => 'adminstaff@gmail.com',
            'nama_admin' => 'Admin',
            'no_telp' => '081234567890',
            // Gunakan Hash::make() untuk enkripsi password seperti yang dilakukan di Seeder sebelumnya
            'password' => Hash::make('password123'), 
        ]);
    }
}