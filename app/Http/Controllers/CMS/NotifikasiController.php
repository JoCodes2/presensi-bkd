<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\NotifikasiRepositories;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    protected $notifikasiRepo;
    public function __construct(NotifikasiRepositories $notifikasiRepo)
    {
        $this->notifikasiRepo = $notifikasiRepo;
    }
    public function getAllData()
    {
        return $this->notifikasiRepo->getAllData();
    }
    public function markAllAsRead(Request $request)
    {
        return $this->notifikasiRepo->markAllAsRead($request->user()->id ?? null);
    }
}
