<?php

namespace App\Repositories;

use App\Interfaces\PresensiInterfaces;
use App\Mail\AlphaWarning;
use App\Mail\DailyViolationWarning;
use App\Models\NotifikasiModel;
use App\Models\PresensiModel;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PresensiRepositories implements PresensiInterfaces
{
    use HttpResponseTraits;

    protected $presensi;
    protected $userModel;
    protected $nottif;

    public function __construct(PresensiModel $presensi, User $userModel, NotifikasiModel $nottif)
    {
        $this->presensi = $presensi;

        $this->nottif = $nottif;

        $this->userModel = $userModel;
    }

    public function getAllData()
    {
        try {
            $user = Auth::user();
            $query = $this->presensi->with(['user']);

            if ($user->role !== 'admin') {
                $query->where('id_user', $user->id);
            }
            $data = $query->orderBy('tanggal', 'desc')->get();

            return $this->success($data);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    // Di dalam class Repository Anda

    public function presensiIn($userId, $lat, $long)
    {
        try {
            $user = $this->userModel->with('lokasiKantor')->find($userId);
            $jamKerja = DB::table('jam_kerja')->where('is_active', true)->first();

            // Ambil waktu saat ini (Pastikan timezone di config/app.php adalah Asia/Makassar)
            $currentTime = now();
            $today = $currentTime->toDateString();
            $nowTimeStr = $currentTime->format('H:i:s');

            if ($jamKerja->jam_keluar && $nowTimeStr >= $jamKerja->jam_keluar) {
                $waktuPulang = substr($jamKerja->jam_keluar, 0, 5);
                return $this->error(
                    'Anda tidak bisa presensi masuk. Waktu sudah melewati jam pulang kantor (' . $waktuPulang . ').',
                    403
                );
            }

            // 2. Cek apakah user sudah presensi masuk hari ini
            $presensiExisting = $this->presensi
                ->where('id_user', $userId)
                ->where('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->first();

            if ($presensiExisting) {
                return $this->error('Anda sudah presensi masuk hari ini.', 400);
            }

            // 3. Validasi Radius
            $cekRadius = $this->validasiRadius($lat, $long, $user->lokasiKantor);
            if (!$cekRadius['valid']) {
                return $this->error(
                    'Di luar radius kantor. Jarak: ' . round($cekRadius['jarak']) .
                        ' m, Maks: ' . $cekRadius['radius'] . ' m',
                    403
                );
            }

            $deadlineTerlambat = $jamKerja->batas_terlambat;

            $statusMasuk = 'tepat_waktu';
            if ($nowTimeStr > $deadlineTerlambat) {
                $statusMasuk = 'terlambat';
                if (method_exists($this, 'sendViolationAlert')) {
                    $this->sendViolationAlert($userId, 'terlambat');
                }
            }

            // --- SIMPAN DATA KE DATABASE ---
            $data = $this->presensi->updateOrCreate(
                [
                    'id_user' => $userId,
                    'tanggal' => $today,
                ],
                [
                    'jam_masuk' => $nowTimeStr,
                    'lokasi_masuk_lat' => $lat,
                    'lokasi_masuk_long' => $long,
                    'status_masuk' => $statusMasuk,
                ]
            );

            $pesan = $statusMasuk === 'terlambat'
                ? 'Presensi masuk berhasil (Terlambat)'
                : 'Presensi masuk berhasil (Tepat Waktu)';

            return $this->success($data, $pesan);
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
                return $this->error('Anda belum presensi masuk hari ini.', 400);
            }

            $user = $this->userModel->with('lokasiKantor')->find($userId);
            $jamKerja = DB::table('jam_kerja')->where('is_active', true)->first();


            $cekRadius = $this->validasiRadius($lat, $long, $user->lokasiKantor);
            if (!$cekRadius['valid']) {
                return $this->error(
                    'Di luar radius kantor. Jarak: ' . round($cekRadius['jarak']) .
                        ' m, Maks: ' . $cekRadius['radius'] . ' m',
                    403
                );
            }

            $now = now()->format('H:i:s');

            if ($jamKerja->jam_keluar && $now < $jamKerja->jam_keluar) {
                $waktuPulangTerjadwal = substr($jamKerja->jam_keluar, 0, 5);
                return $this->error('Anda belum bisa presensi pulang. Waktu pulang terjadwal adalah ' . $waktuPulangTerjadwal . '.', 403);
            }

            $presensi->update([
                'jam_keluar' => $now,
                'lokasi_keluar_lat' => $lat,
                'lokasi_keluar_long' => $long,
                'status_keluar' => 'tepat_waktu',
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


    // notif presensi
    private function sendViolationAlert(string $userId, string $violationType)
    {
        $user = $this->userModel::find($userId);
        if (!$user) {
            return;
        }

        $pesan = "Anda tercatat " . str_replace('_', ' ', $violationType) . " pada hari ini.";

        $notifJenis = $violationType;

        $this->createNotificationRecord($userId, $notifJenis, $pesan);


        Mail::to($user->email)->send(new DailyViolationWarning($user, $violationType));
    }





    private function createNotificationRecord(string $userId, string $jenis, string $pesan, array $metadata = null)
    {
        try {
            return $this->nottif::create([
                'user_id'   => $userId,
                'jenis'     => $jenis,
                'pesan'     => $pesan,
                'metadata'  => $metadata,
                'is_dibaca' => false,
            ]);
        } catch (\Exception $e) {
            return null;
        }
    }


    public function processSingleAlphaUser(string $userId, string $date, string $type = 'total')
    {
        $user = User::find($userId);
        if (!$user) return;

        $existingPresensi = PresensiModel::where('id_user', $userId)
            ->where('tanggal', $date)
            ->first();

        if ($existingPresensi) {
            if ($existingPresensi->jam_masuk && is_null($existingPresensi->status_keluar)) {
                $existingPresensi->update([
                    'status_keluar' => 'tidak_absen',
                    'keterangan' => 'Sistem: Tidak Absen Pulang (Lupa)'
                ]);

                $this->createNotificationRecord($userId, 'lupa_absen_pulang', "Anda lupa absen pulang pada tanggal $date.", [
                    'tanggal' => $date,
                ]);

                $this->sendAlphaAlert($user, $date, 'pulang');
            }
        } else if ($type === 'total') {
            // Kasus Alpha Total
            PresensiModel::create([
                'id_user' => $userId,
                'tanggal' => $date,
                'status_masuk' => 'tidak_absen',
                'status_keluar' => 'tidak_absen',
                'keterangan' => 'Sistem: Alpha (Tidak Masuk & Pulang)'
            ]);
            $this->createNotificationRecord($userId, 'alpha', "Anda tercatat Alpha (Tidak Hadir) pada tanggal $date.", [
                'tanggal' => $date,
            ]);

            $this->sendAlphaAlert($user, $date, 'total');
        }
    }


    private function sendAlphaAlert(User $user, string $date, string $type)
    {
        try {
            $pesan = ($type === 'pulang')
                ? "Anda lupa absen pulang pada $date"
                : "Anda tercatat Alpha (Tidak Hadir) pada $date";

            Mail::to($user->email)->send(new AlphaWarning($user, $date, $type));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email Alpha ke " . $user->email . ": " . $e->getMessage());
        }
    }
}
