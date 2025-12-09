<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';

    protected $fillable = [
        'id_user',
        'data_lokasi',
        'alamat',
        'kecamatan',
        'kota',
    ];

    public function user()
    {
        return $this->belongsTo(Account::class, 'id_user', 'id');
    }
}
