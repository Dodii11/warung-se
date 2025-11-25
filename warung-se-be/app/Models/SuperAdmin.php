<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    protected $table = 'super_admin';
    protected $primaryKey = 'id_super';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_super', 'email_super', 'nama_super', 'no_telp', 'password'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($superadmin) {
            if (empty($superadmin->id_super)) {
                $superadmin->id_super = 'SA' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
