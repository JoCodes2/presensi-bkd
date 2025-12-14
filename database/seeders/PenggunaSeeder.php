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
        $jabatan1 = JabatanModel::create(['nama_jabatan' => 'Kepala Dinas']);
        $jabatan2 = JabatanModel::create(['nama_jabatan' => 'Sekretaris']);
        $jabatan3 = JabatanModel::create(['nama_jabatan' => 'Kepala Bidang']);
        $jabatan4 = JabatanModel::create(['nama_jabatan' => 'Staff Administrasi']);
        $jabatan5 = JabatanModel::create(['nama_jabatan' => 'Pegawai']);

        // Seed Lokasi Kantor
        $lokasi1 = LokasiKantorModel::create([
            'nama_lokasi' => 'Kantor Pusat BKD',
            'alamat' => 'Jl. Sudirman No. 1, Jakarta',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'radius_meter' => 100,
            'is_aktif' => true
        ]);
        $lokasi2 = LokasiKantorModel::create([
            'nama_lokasi' => 'Kantor Cabang BKD',
            'alamat' => 'Jl. Thamrin No. 2, Jakarta',
            'latitude' => -6.1944,
            'longitude' => 106.8227,
            'radius_meter' => 100,
            'is_aktif' => true
        ]);

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
            'lokasi_kantor_id' => $lokasi1->id,
            'role' => 'admin',
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Pegawai 1',
            'email' => 'pegawai1@bkd.go.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123457',
            'nip' => '198501012010011002',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Thamrin No. 2, Jakarta',
            'no_hp' => '081234567891',
            'agama' => 'Kristen',
            'status_ikatan_kerja' => 'pns',
            'jabatan_id' => $jabatan2->id,
            'lokasi_kantor_id' => $lokasi1->id,
            'role' => 'pegawai',
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Pegawai 2',
            'email' => 'pegawai2@bkd.go.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123458',
            'nip' => '199001012010011003',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Sudirman No. 3, Jakarta',
            'no_hp' => '081234567892',
            'agama' => 'Hindu',
            'status_ikatan_kerja' => 'non_pns',
            'jabatan_id' => $jabatan3->id,
            'lokasi_kantor_id' => $lokasi2->id,
            'role' => 'pegawai',
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Pegawai 3',
            'email' => 'pegawai3@bkd.go.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123459',
            'nip' => null,
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '1995-01-01',
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Malioboro No. 4, Yogyakarta',
            'no_hp' => '081234567893',
            'agama' => 'Budha',
            'status_ikatan_kerja' => 'non_pns',
            'jabatan_id' => $jabatan4->id,
            'lokasi_kantor_id' => $lokasi1->id,
            'role' => 'pegawai',
            'status' => 'pending'
        ]);

        User::create([
            'name' => 'Pegawai 4',
            'email' => 'pegawai4@bkd.go.id',
            'password' => Hash::make('password'),
            'nik' => '1234567890123460',
            'nip' => '199201012010011004',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1992-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Thamrin No. 5, Medan',
            'no_hp' => '081234567894',
            'agama' => 'Konghucu',
            'status_ikatan_kerja' => 'pns',
            'jabatan_id' => $jabatan5->id,
            'lokasi_kantor_id' => $lokasi2->id,
            'role' => 'pegawai',
            'status' => 'active'
        ]);
    }
}
