<?php

namespace App\Interfaces;

use App\Http\Requests\LokasiKantorRequest;

interface LokasiKantorInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function createData(LokasiKantorRequest $request);
    public function updateData(LokasiKantorRequest $request, $id);
    public function deleteData($id);
}
