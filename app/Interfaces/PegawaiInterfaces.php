<?php

namespace App\Interfaces;

use App\Http\Requests\PegawaiRequest;

interface PegawaiInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function createData(PegawaiRequest $request);
    public function updateData(PegawaiRequest $request, $id);
    public function deleteData($id);

    public function handleAccountStatus(string $id, string $status);
}
