<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';

    // Agar primaryKey tidak auto increment (karena type bigInt)
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'data_lokasi',
        'alamat',
        'kecamatan',
        'kota',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(Account::class, 'id_user', 'id_user');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIC: SET DEFAULT ADDRESS
    |--------------------------------------------------------------------------
    */

    /**
     * Jadikan alamat ini menjadi default untuk user.
     */
    public function setAsDefault()
    {
        // Ubah alamat lain milik user menjadi non-default
        Alamat::where('id_user', $this->id_user)
            ->where('id_alamat', '!=', $this->id_alamat)
            ->update(['is_default' => false]);

        // Jadikan current sebagai default
        $this->is_default = true;
        $this->save();
    }
}
