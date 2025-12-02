<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'driver';
    protected $primaryKey = 'id_driver';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_driver', 'nama_driver', 'no_telp'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($driver) {
            if (empty($driver->id_driver)) {
                $driver->id_driver = 'DR' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_driver', 'id_driver');
    }
}
