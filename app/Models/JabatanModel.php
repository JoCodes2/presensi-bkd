<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'jabatan';
    protected $fillable = ['id', 'nama_jabatan', 'created_at', 'updated_at'];
    public function pegawai()
    {
        return $this->hasMany(User::class, 'id_jabatan', 'id');
    }
}
