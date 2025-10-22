<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_driver';
    protected $table = 'drivers';

    protected $fillable = [
        'nama_driver',
        'no_telp',
    ];
}