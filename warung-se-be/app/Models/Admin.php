<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable {
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_admin', 'email_admin', 'nama_admin', 'no_telp', 'password'];

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $count = self::count() + 1;
            $model->id_admin = 'AD' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
}
