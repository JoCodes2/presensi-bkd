<?php

namespace App\Http\Controllers\CMS;

use App\Exports\PresensiExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresensiRequest;
use App\Models\User;
use App\Repositories\PresensiRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// GANTI BAGIAN ATAS CONTROLLER ANDA
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    protected $presensiRepo;

    public function __construct(PresensiRepositories $presensiRepo)
    {
        $this->presensiRepo = $presensiRepo;
    }

    public function getAllData()
    {
        return $this->presensiRepo->getAllData();
    }

    public function presensiIn(PresensiRequest $request)
    {
        $idUser = Auth::user();
        $userId = $idUser->id;
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiIn($userId, $lat, $long);
    }

    public function presensiOut(PresensiRequest $request)
    {
        $idUser = Auth::user();
        $userId = $idUser->id;
        $lat = $request->input('latitude');
        $long = $request->input('longitude');

        return $this->presensiRepo->presensiOut($userId, $lat, $long);
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        $fileName = "Rekap_Presensi_Semua_Pegawai_" . $request->from_date . "_sd_" . $request->to_date . ".xlsx";

        return Excel::download(
            new PresensiExport($request->from_date, $request->to_date),
            $fileName
        );
    }
}
