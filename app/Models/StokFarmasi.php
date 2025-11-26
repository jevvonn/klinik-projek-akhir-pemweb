<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokFarmasi extends Model
{
    protected $table = 'stok_farmasi';

    protected $fillable = [
        'obat_id',
        'jumlah',
        'stok_minimum',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
