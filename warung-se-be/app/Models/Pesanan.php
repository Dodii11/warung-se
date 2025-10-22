<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';
    protected $table = 'pesanans';

    protected $fillable = [
        'id_user',
        'tanggal_pesanan',
        'total_harga',
        'status',
        'metode_bayar',
        'alamat',
        'catatan',
    ];

    /**
     * Relasi: Pesanan dimiliki oleh satu User
     */
    public function user()
    {
        // Parameter ke-2: FK di tabel 'pesanans', Parameter ke-3: PK di tabel 'users'
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi: Pesanan memiliki banyak DetailPesanan
     */
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}