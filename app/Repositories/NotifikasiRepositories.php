<?php

namespace App\Repositories;

use App\Interfaces\NotifikasiInterfaces;
use App\Models\NotifikasiModel;
use App\Traits\HttpResponseTraits;
use Carbon\Carbon; // Import Carbon
use Illuminate\Support\Facades\Auth;

class NotifikasiRepositories implements NotifikasiInterfaces
{
    use HttpResponseTraits;
    protected $notifikasi;

    public function __construct(NotifikasiModel $notifikasi)
    {
        $this->notifikasi = $notifikasi;
    }


    public function getAllData()
    {
        try {
            $user = Auth::user();
            $query = $this->notifikasi::with('user');

            if ($user->role != 'admin') {
                $query->where('user_id', $user->id);
            }

            $data = $query->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            if ($data->isEmpty()) {
                return $this->dataNotFound('Tidak ada data notifikasi.');
            }

            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function markAllAsRead(string $userId)
    {
        $updated = $this->notifikasi::where('user_id', $userId)
            ->where('is_dibaca', false)
            ->update(['is_dibaca' => true]);

        $updated = $this->notifikasi::where('is_dibaca', false)->update(['is_dibaca' => true]);

        if ($updated === 0) {
            return $this->dataNotFound('Semua notifikasi sudah dibaca.');
        }

        return $this->success(null, 'Semua notifikasi berhasil ditandai sudah dibaca.');
    }
}
