<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_menu';
    protected $table = 'menus';

    protected $fillable = [
        'menu',
        'harga',
        'kategori',
    ];

    /**
     * Relasi: Menu memiliki banyak DetailPesanan
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }
}