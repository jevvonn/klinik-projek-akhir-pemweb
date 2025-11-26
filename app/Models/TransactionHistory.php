<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    protected $fillable = [
        'obat_id',
        'aksi',
        'qty',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'reference_code'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    // Helper untuk log transaksi
    public static function logTransaction($obatId, $aksi, $qty, $stokSebelum, $stokSesudah, $keterangan = null, $referenceCode = null)
    {
        return self::create([
            'obat_id' => $obatId,
            'aksi' => $aksi,
            'qty' => $qty,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $stokSesudah,
            'keterangan' => $keterangan,
            'reference_code' => $referenceCode,
        ]);
    }
}