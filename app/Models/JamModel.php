<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JamModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'jam_kerja';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama_shift',
        'jam_masuk',
        'jam_keluar',
        'batas_terlambat',
        'senin_kerja',
        'selasa_kerja',
        'rabu_kerja',
        'kamis_kerja',
        'jumat_kerja',
        'sabtu_kerja',
        'minggu_kerja',
        'is_active',
    ];

    protected $casts = [
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
        'batas_terlambat' => 'datetime:H:i',

        'senin_kerja' => 'boolean',
        'selasa_kerja' => 'boolean',
        'rabu_kerja' => 'boolean',
        'kamis_kerja' => 'boolean',
        'jumat_kerja' => 'boolean',
        'sabtu_kerja' => 'boolean',
        'minggu_kerja' => 'boolean',
        'is_active' => 'boolean',
    ];
}
