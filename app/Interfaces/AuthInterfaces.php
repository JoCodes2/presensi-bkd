<?php

namespace App\Interfaces;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request; // <-- HARUS INI, BUKAN SYMFONY

interface AuthInterfaces
{


    public function login(AuthRequest $request);
    public function logout(Request $request);
}
