<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKantorModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'lokasi_kantor';
    protected $fillable = [
        'id',
        'nama_kantor',
        'alamat',
        'latitude',
        'longtitude',
        'radius_meter',
        'is_aktif',
        'created_at',
        'updated_at'
    ];
}
