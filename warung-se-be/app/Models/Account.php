<?php

namespace App\Models;

// TAMBAH INI
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

//TAMBAH IMPLEMENTS
class Account extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email_user',
        'nama_user',
        'id_role',
        'no_telp',
        'status',
        'password'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    public function Cart()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }
}

