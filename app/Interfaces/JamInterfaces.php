<?php

namespace App\Interfaces;

use App\Http\Requests\JamRequest;

interface JamInterfaces
{
    public function getAllData();
    public function getDataById($id);
    public function createData(JamRequest $request);
    public function updateData(JamRequest $request, $id);
    public function deleteData($id);
}
