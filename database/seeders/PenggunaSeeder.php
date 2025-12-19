<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JabatanModel;
use App\Models\LokasiKantorModel;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Jabatan
        $jabatan1 = JabatanModel::create(['nama_jabatan' => 'Staff Kepegawaian']);
        // Seed Users
        User::create([
            'name' => 'Admin BKD',
            'email' => 'admin@bkd.go.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123456',
            'nip' => '198001012010011001',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            'no_hp' => '081234567890',
            'agama' => 'Islam',
            'status_ikatan_kerja' => 'pns',
            'jabatan_id' => $jabatan1->id,
            'lokasi_kantor_id' => null,
            'role' => 'admin',
            'status' => 'pending'
        ]);
    }
}
