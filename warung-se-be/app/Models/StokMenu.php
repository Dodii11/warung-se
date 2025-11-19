<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMenu extends Model
{
    use HasFactory;

    protected $table = 'stok_menu';
    protected $primaryKey = 'id_stok';
    public $timestamps = true;

    protected $fillable = ['id_menu', 'jumlah_stok'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
}
