<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; // Karena Anda menggunakan UUID
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotifikasiModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'notifikasi';
    protected $fillable = [
        'id',
        'user_id',
        'jenis',
        'pesan',
        'is_dibaca',
        'metadata',
    ];

    protected $casts = [
        'is_dibaca' => 'boolean',
        'metadata' => 'array',
    ];


    public function user()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
