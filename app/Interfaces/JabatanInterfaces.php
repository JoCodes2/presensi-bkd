<?php

namespace App\Interfaces;

use App\Http\Requests\JabatanRequest;

interface JabatanInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function createData(JabatanRequest $request);
    public function updateData(JabatanRequest $request, $id);
    public function deleteData($id);
}
