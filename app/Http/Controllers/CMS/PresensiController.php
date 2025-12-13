<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresensiRequest;
use App\Repositories\PresensiRepositories;
use Illuminate\Http\Request;

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
        $userId = $request->input('id_user');
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiIn($userId, $lat, $long);
    }

    public function presensiOut(PresensiRequest $request)
    {
        $userId = $request->input('id_user');
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiOut($userId, $lat, $long);
    }
}
