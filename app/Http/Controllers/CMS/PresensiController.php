<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresensiRequest;
use App\Repositories\PresensiRepositories;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    protected $presensiRepo;

    public function __construct(PresensiRepositories $presensiRepo)
    {
        $this->presensiRepo = $presensiRepo;
    }

    public function getAllData()
    {
        return $this->presensiRepo->getAllData();
    }

    public function presensiIn(PresensiRequest $request)
    {
        $idUser = Auth::user();
        $userId = $idUser->id;
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiIn($userId, $lat, $long);
    }

    public function presensiOut(PresensiRequest $request)
    {
        $idUser = Auth::user();
        $userId = $idUser->id;
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiOut($userId, $lat, $long);
    }
}
