<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user';          // nama tabel kamu
    protected $primaryKey = 'id_user';  // primary key custom
    public $timestamps = true;          // karena ada created_at & updated_at

    protected $fillable = [
        'email_user',
        'nama_user',
        'no_telp',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
