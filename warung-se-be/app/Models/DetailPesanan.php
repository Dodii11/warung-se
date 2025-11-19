<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_detail', 'id_pesanan', 'id_menu', 'jumlah', 'subtotal'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            if (empty($detail->id_detail)) {
                $detail->id_detail = 'DP' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
}
