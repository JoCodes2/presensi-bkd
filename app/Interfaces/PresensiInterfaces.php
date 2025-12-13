<?php

namespace App\Interfaces;

interface PresensiInterfaces
{
    public function getAllData();
    public function presensiIn($userId, $lat, $long);
    public function presensiOut($userId, $lat, $long);
}
