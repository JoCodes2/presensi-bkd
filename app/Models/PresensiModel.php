<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\HasDatabaseNotifications;

class PresensiModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_user',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'lokasi_masuk_lat',
        'lokasi_masuk_long',
        'lokasi_keluar_lat',
        'lokasi_keluar_long',
        'status_masuk',
        'status_keluar',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
