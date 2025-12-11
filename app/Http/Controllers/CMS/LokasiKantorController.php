<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\LokasiKantorRequest;
use App\Repositories\LokasiKantorRepositories;
use Illuminate\Http\Request;

class LokasiKantorController extends Controller
{
    protected $kantorRepo;
    public function __construct(LokasiKantorRepositories $kantorRepo)
    {
        $this->kantorRepo = $kantorRepo;
    }
    public function getAllData()
    {
        return $this->kantorRepo->getAllData();
    }
    public function getDataById($id)
    {
        return $this->kantorRepo->getDataById($id);
    }
    public function createData(LokasiKantorRequest $request)
    {
        return $this->kantorRepo->createData($request);
    }
    public function updateData(LokasiKantorRequest $request, $id)
    {
        return $this->kantorRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->kantorRepo->deleteData($id);
    }
}
