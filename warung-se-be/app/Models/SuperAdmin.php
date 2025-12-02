<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SuperAdmin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'super_admin';
    protected $primaryKey = 'id_super';

    protected $fillable = [
        'email_super',
        'nama_super',
        'no_telp',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}
