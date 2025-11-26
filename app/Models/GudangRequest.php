<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GudangRequest extends Model
{
    protected $fillable = [
        'kode',
        'status',
        'catatan',
        'requested_by'
    ];

    public function items()
    {
        return $this->hasMany(GudangRequestItem::class, 'request_id');
    }

    public function obatItems()
    {
        return $this->belongsToMany(Obat::class, 'gudang_request_items', 'request_id', 'obat_id')
            ->withPivot(['qty_diminta', 'qty_dikirim'])
            ->withTimestamps();
    }

    // Generate unique request code
    public static function generateKode()
    {
        do {
            $kode = 'REQ-GDG-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('kode', $kode)->exists());

        return $kode;
    }
}