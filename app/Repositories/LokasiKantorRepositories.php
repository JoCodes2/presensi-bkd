<?php

namespace App\Repositories;

use App\Http\Requests\LokasiKantorRequest;
use App\Interfaces\LokasiKantorInterfaces;
use App\Models\LokasiKantorModel;
use App\Traits\HttpResponseTraits;

class LokasiKantorRepositories implements LokasiKantorInterfaces
{
    use HttpResponseTraits;
    protected $kantorModel;
    public function __construct(LokasiKantorModel $kantorModel)
    {
        $this->kantorModel = $kantorModel;
    }
    public function getAllData()
    {
        $data = $this->kantorModel::all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function getDataById($id)
    {
        $data = $this->kantorModel::find($id);
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function createData(LokasiKantorRequest $request)
    {
        try {
            $data = new $this->kantorModel;
            $data->nama_lokasi = $request->input('nama_lokasi');
            $data->alamat = $request->input('alamat');
            $data->latitude = $request->input('latitude');
            $data->longitude = $request->input('longitude');
            $data->radius_meter = $request->input('radius_meter');
            $data->is_aktif = true;
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(LokasiKantorRequest $request, $id)
    {
        try {
            $data = $this->kantorModel::where('id', $id)->first();
            $data->nama_lokasi = $request->input('nama_lokasi');
            $data->alamat = $request->input('alamat');
            $data->latitude = $request->input('latitude');
            $data->longitude = $request->input('longitude');
            $data->radius_meter = $request->input('radius_meter');
            $data->is_aktif = $request->input('is_aktif');
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function deleteData($id)
    {
        try {
            $data = $this->kantorModel::where('id', $id)->first();
            $data->delete();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
