<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GudangRequestItem extends Model
{
    protected $fillable = [
        'request_id',
        'obat_id',
        'qty_diminta',
        'qty_dikirim'
    ];

    public function request()
    {
        return $this->belongsTo(GudangRequest::class, 'request_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}