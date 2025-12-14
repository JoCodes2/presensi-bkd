<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\JamRequest;
use App\Repositories\JamRepositories;
use Illuminate\Http\Request;

class JamController extends Controller
{
    protected $JamRepo;
    public function __construct(JamRepositories $JamRepo)
    {
        $this->JamRepo = $JamRepo;
    }
    public function getAllData()
    {
        return $this->JamRepo->getAllData();
    }
    public function getDataById($id)
    {
        return $this->JamRepo->getDataById($id);
    }
    public function createData(JamRequest $request)
    {
        return $this->JamRepo->createData($request);
    }
    public function updateData(JamRequest $request, $id)
    {
        return $this->JamRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->JamRepo->deleteData($id);
    }
}
