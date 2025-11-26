<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicRequest extends Model
{
    use HasFactory;

    protected $table = 'clinic_requests';

    protected $fillable = [
        'nama',
        'no_hp',
        'umur',
        'jenis_kelamin',
        'alamat',
        'diagnosa',
        'dokter',
        'resep_obat',
        'status',
    ];

    protected $guarded = [
        'id'
    ];
}
