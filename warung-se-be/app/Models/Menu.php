<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'menu',
        'harga',
        'kategori',
        'stok',
        'gambar_menu'
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_menu', 'id_menu');
    }


    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_menu', 'id_menu');
    }
}
