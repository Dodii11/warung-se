<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'driver';
    protected $primaryKey = 'id_driver';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_driver',
        'nama_driver',
        'no_telp',
        'status',
        'tipe_kendaraan',
        'plat_kendaraan',
        'gambar_driver'
    ];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar_driver
            ? asset('storage/' . $this->gambar_driver)
            : null;
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_driver', 'id_driver');
    }
}
