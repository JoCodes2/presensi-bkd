<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\JabatanRequest;
use App\Repositories\JabatanRepositories;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    protected $jabatanRepo;
    public function __construct(JabatanRepositories $jabatanRepo)
    {
        $this->jabatanRepo = $jabatanRepo;
    }
    public function getAllData()
    {
        return $this->jabatanRepo->getAllData();
    }
    public function getDataById($id)
    {
        return $this->jabatanRepo->getDataById($id);
    }
    public function createData(JabatanRequest $request)
    {
        return $this->jabatanRepo->createData($request);
    }
    public function updateData(JabatanRequest $request, $id)
    {
        return $this->jabatanRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->jabatanRepo->deleteData($id);
    }
}
