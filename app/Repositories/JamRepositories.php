<?php

namespace App\Repositories;

use App\Http\Requests\JamRequest;
use App\Interfaces\JamInterfaces;
use App\Models\JamModel;
use App\Traits\HttpResponseTraits;

class JamRepositories implements JamInterfaces
{
    use HttpResponseTraits;
    protected $JamModel;
    public function __construct(JamModel $JamModel)
    {
        $this->JamModel = $JamModel;
    }
    public function getAllData()
    {
        $data = $this->JamModel::all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function getDataById($id)
    {
        $data = $this->JamModel::find($id);
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function createData(JamRequest $request)
    {
        try {

            $data = new $this->JamModel;

            $data->nama_shift      = $request->input('nama_shift');
            $data->jam_masuk       = $request->input('jam_masuk');
            $data->jam_keluar      = $request->input('jam_keluar');

            $data->senin_kerja  = $request->boolean('senin_kerja');
            $data->selasa_kerja = $request->boolean('selasa_kerja');
            $data->rabu_kerja   = $request->boolean('rabu_kerja');
            $data->kamis_kerja  = $request->boolean('kamis_kerja');
            $data->jumat_kerja  = $request->boolean('jumat_kerja');
            $data->sabtu_kerja  = $request->boolean('sabtu_kerja');
            $data->minggu_kerja = $request->boolean('minggu_kerja');

            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function updateData(JamRequest $request, $id)
    {
        try {
            $data = $this->JamModel::where('id', $id)->first();
            $data->nama_shift      = $request->input('nama_shift');
            $data->jam_masuk       = $request->input('jam_masuk');
            $data->jam_keluar      = $request->input('jam_keluar');
            $data->batas_terlambat = $request->input('batas_terlambat');

            $data->senin_kerja  = $request->boolean('senin_kerja');
            $data->selasa_kerja = $request->boolean('selasa_kerja');
            $data->rabu_kerja   = $request->boolean('rabu_kerja');
            $data->kamis_kerja  = $request->boolean('kamis_kerja');
            $data->jumat_kerja  = $request->boolean('jumat_kerja');
            $data->sabtu_kerja  = $request->boolean('sabtu_kerja');
            $data->minggu_kerja = $request->boolean('minggu_kerja');

            $data->is_active = $request->boolean('is_active', true);
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function deleteData($id)
    {
        try {
            $data = $this->JamModel::where('id', $id)->first();
            $data->delete();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
