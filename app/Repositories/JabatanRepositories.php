<?php

namespace App\Repositories;

use App\Http\Requests\JabatanRequest;
use App\Interfaces\JabatanInterfaces;
use App\Models\JabatanModel;
use App\Traits\HttpResponseTraits;

class JabatanRepositories implements JabatanInterfaces
{
    use HttpResponseTraits;
    protected $jabatanModel;
    public function __construct(JabatanModel $jabatanModel)
    {
        $this->jabatanModel = $jabatanModel;
    }
    public function getAllData()
    {
        $data = $this->jabatanModel::all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function getDataById($id)
    {
        $data = $this->jabatanModel::find($id);
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function createData(JabatanRequest $request)
    {
        try {
            $data = new $this->jabatanModel;
            $data->nama_jabatan = $request->input('nama_jabatan');
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(JabatanRequest $request, $id)
    {
        try {
            $data = $this->jabatanModel::where('id', $id)->first();
            $data->nama_jabatan = $request->input('nama_jabatan');
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function deleteData($id)
    {
        try {
            $data = $this->jabatanModel::where('id', $id)->first();
            $data->delete();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
