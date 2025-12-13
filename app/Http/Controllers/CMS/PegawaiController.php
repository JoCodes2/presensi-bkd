<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRequest;
use App\Repositories\PegawaiRepositories;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    protected $pegawaiRepo;
    public function __construct(PegawaiRepositories $pegawaiRepo)
    {
        $this->pegawaiRepo = $pegawaiRepo;
    }
    public function getAllData()
    {
        return $this->pegawaiRepo->getAllData();
    }
    public function getDataById($id)
    {
        return $this->pegawaiRepo->getDataById($id);
    }
    public function createData(PegawaiRequest $request)
    {
        return $this->pegawaiRepo->createData($request);
    }
    public function updateData(PegawaiRequest $request, $id)
    {
        return $this->pegawaiRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->pegawaiRepo->deleteData($id);
    }

    // notif aktivasi akun
    public function activateAccount($id)
    {
        return $this->pegawaiRepo->activateAccount($id);
    }
}
