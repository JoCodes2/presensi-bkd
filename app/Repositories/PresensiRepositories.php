<?php

namespace App\Repositories;

use App\Interfaces\PresensiInterfaces;
use App\Models\PresensiModel;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\DB;

class PresensiRepositories implements PresensiInterfaces
{
    use HttpResponseTraits;

    protected $presensi;
    protected $userModel;

    public function __construct(PresensiModel $presensi, User $userModel)
    {
        $this->presensi = $presensi;
        $this->userModel = $userModel;
    }

    public function getAllData()
    {
        try {
            $data = $this->presensi
                ->with(['user'])
                ->orderBy('tanggal', 'desc')
                ->get();

            return $this->success($data);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function presensiIn($userId, $lat, $long)
    {
        try {
            $user = $this->userModel->with('lokasiKantor')->find($userId);

            $jamKerja = DB::table('jam_kerja')
                ->where('is_active', true)
                ->first();
            if (!$this->cekHariKerja($jamKerja)) {
                return $this->error('Hari ini bukan hari kerja', 403);
            }

            $today = now()->toDateString();

            $presensi = $this->presensi
                ->where('id_user', $userId)
                ->where('tanggal', $today)
                ->first();

            $cekRadius = $this->validasiRadius($lat, $long, $user->lokasiKantor);
            if (!$cekRadius['valid']) {
                return $this->error(
                    'Di luar radius kantor. Jarak: ' . round($cekRadius['jarak']) .
                        ' m, Maks: ' . $cekRadius['radius'] . ' m',
                    403
                );
            }

            $now = now()->format('H:i:s');

            $statusMasuk = 'tepat_waktu';
            if ($jamKerja->batas_terlambat && $now > $jamKerja->batas_terlambat) {
                $statusMasuk = 'terlambat';
            }

            $data = $this->presensi->updateOrCreate(
                [
                    'id_user' => $userId,
                    'tanggal' => $today,
                ],
                [
                    'jam_masuk' => $now,
                    'lokasi_masuk_lat' => $lat,
                    'lokasi_masuk_long' => $long,
                    'status_masuk' => $statusMasuk,
                ]
            );

            return $this->success($data, 'Presensi masuk berhasil');
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function presensiOut($userId, $lat, $long)
    {
        try {
            $today = now()->toDateString();

            $presensi = $this->presensi
                ->where('id_user', $userId)
                ->where('tanggal', $today)
                ->first();

            if (!$presensi || !$presensi->jam_masuk) {
                return $this->error('Anda belum presensi masuk', 400);
            }

            if ($presensi->jam_keluar) {
                return $this->error('Anda sudah presensi pulang', 400);
            }

            $user = $this->userModel->with('lokasiKantor')->find($userId);

            $cekRadius = $this->validasiRadius($lat, $long, $user->lokasiKantor);
            if (!$cekRadius['valid']) {
                return $this->error(
                    'Di luar radius kantor. Jarak: ' . round($cekRadius['jarak']) .
                        ' m, Maks: ' . $cekRadius['radius'] . ' m',
                    403
                );
            }

            $jamKerja = DB::table('jam_kerja')
                ->where('is_active', true)
                ->first();


            $now = now()->format('H:i:s');

            $statusKeluar = 'tepat_waktu';
            if ($now < $jamKerja->jam_keluar) {
                $statusKeluar = 'pulang_cepat';
            }

            $presensi->update([
                'jam_keluar' => $now,
                'lokasi_keluar_lat' => $lat,
                'lokasi_keluar_long' => $long,
                'status_keluar' => $statusKeluar,
            ]);

            return $this->success($presensi, 'Presensi pulang berhasil');
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    private function cekHariKerja($jamKerja)
    {
        $hariSekarang = now()->format('l');

        $mapHari = [
            'Monday'    => 'senin_kerja',
            'Tuesday'   => 'selasa_kerja',
            'Wednesday' => 'rabu_kerja',
            'Thursday'  => 'kamis_kerja',
            'Friday'    => 'jumat_kerja',
            'Saturday'  => 'sabtu_kerja',
            'Sunday'    => 'minggu_kerja',
        ];

        $kolom = $mapHari[$hariSekarang] ?? null;

        if (!$kolom) {
            return false;
        }

        return (bool) $jamKerja->$kolom;
    }

    private function validasiRadius($latUser, $longUser, $lokasiKantor)
    {
        $jarak = $this->hitungJarak(
            $latUser,
            $longUser,
            $lokasiKantor->latitude,
            $lokasiKantor->longitude
        );

        return [
            'valid'  => $jarak <= $lokasiKantor->radius_meter,
            'jarak'  => $jarak,
            'radius' => $lokasiKantor->radius_meter,
        ];
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
