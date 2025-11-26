<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'bentuk',
        'jumlah',
        'kategori',
        'harga_jual',
        'status_aktif',
        'stok_gudang',
        'lokasi_rak',
        'supplier_id',
    ];

    public function stokFarmasi()
    {
        return $this->hasOne(StokFarmasi::class, 'obat_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactionHistories()
    {
        return $this->hasMany(TransactionHistory::class, 'obat_id');
    }

    public function gudangRequests()
    {
        return $this->belongsToMany(GudangRequest::class, 'gudang_request_items', 'obat_id', 'request_id')
            ->withPivot(['qty_diminta', 'qty_dikirim'])
            ->withTimestamps();
    }

    // Helper methods for stock management
    public function getTotalStokAttribute()
    {
        return $this->jumlah + $this->stok_gudang;
    }

    public function updateStokGudang($qty, $aksi, $keterangan = null, $referenceCode = null)
    {
        $stokSebelum = $this->stok_gudang;

        if ($aksi === 'receive_from_supplier' || $aksi === 'manual_adjustment') {
            $this->increment('stok_gudang', $qty);
        } elseif ($aksi === 'send_to_farmasi') {
            $this->decrement('stok_gudang', $qty);
        }

        $this->refresh();
        $stokSesudah = $this->stok_gudang;

        // Log transaction
        TransactionHistory::logTransaction(
            $this->id,
            $aksi,
            $qty,
            $stokSebelum,
            $stokSesudah,
            $keterangan,
            $referenceCode
        );

        return $this;
    }
}
