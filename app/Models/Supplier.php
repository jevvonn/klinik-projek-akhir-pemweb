<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'telp',
        'alamat'
    ];

    public function obat()
    {
        return $this->hasMany(Obat::class);
    }
}