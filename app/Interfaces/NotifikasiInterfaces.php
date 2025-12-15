<?php

namespace App\Interfaces;

interface NotifikasiInterfaces
{
    public function getAllData();
    public function markAllAsRead(string $userId);
}
