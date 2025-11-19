<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = true;

    protected $fillable = [
        'menu',
        'harga',
        'kategori',
        'gambar_menu'
    ];

    // 🔥 Relasi ke tabel stok_menu
    public function stok()
    {
        return $this->hasOne(StokMenu::class, 'id_menu', 'id_menu');
    }
}
