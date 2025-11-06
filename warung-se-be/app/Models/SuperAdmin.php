<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Menggunakan ini jika super admin juga login

class SuperAdmin extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_super_admin';
    protected $table = 'super_admins'; // Opsional, tapi disarankan
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_super_admin',
        'no_telp',
        'password',
    ];

    // Kolom yang disembunyikan saat dikonversi ke array/JSON
    protected $hidden = [
        'password',
    ];
}