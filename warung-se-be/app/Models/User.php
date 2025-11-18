<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- tambahkan ini jika pakai Sanctum

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <--- gunakan trait HasApiTokens

    protected $primaryKey = 'id_user';
    protected $table = 'users';
    
    protected $fillable = [
        'nama_user',
        'email',      // tambahkan jika ingin pakai email
        'no_telp',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    public function username()
    {
        return 'nama_user';
    }
}
