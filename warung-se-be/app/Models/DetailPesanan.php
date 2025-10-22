<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail';
    protected $table = 'detail_pesanans';

    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'jumlah',
        'subtotal',
    ];

    /**
     * Relasi: DetailPesanan dimiliki oleh satu Pesanan
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Relasi: DetailPesanan milik satu Menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
}