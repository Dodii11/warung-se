<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Menggunakan ini jika admin juga login

class Admin extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_admin';
    protected $table = 'admins'; // Opsional, tapi disarankan
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_admin',
        'no_telp',
        'password',
    ];

    // Kolom yang disembunyikan saat dikonversi ke array/JSON
    protected $hidden = [
        'password',
    ];
}