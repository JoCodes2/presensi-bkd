<?php

namespace App\Repositories;

use App\Http\Requests\PegawaiRequest;
use App\Interfaces\PegawaiInterfaces;
use App\Mail\VerifikasiMail;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PegawaiRepositories implements PegawaiInterfaces
{
    use HttpResponseTraits;
    protected $modelUser;
    public function __construct(User $modelUser)
    {
        $this->modelUser = $modelUser;
    }
    public function getAllData()
    {
        $data = $this->modelUser::with(['jabatan', 'lokasi_kantor'])->get();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function verifyEmail($token)
    {
        $user = $this->modelUser::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token verifikasi tidak valid atau sudah digunakan.'
            ], 400);
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Email berhasil diverifikasi. Silakan login.'
        ], 200);
    }

    public function createData(PegawaiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nik' => $request->nik,
                'nip' => $request->nip,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_ikatan_kerja' => $request->status_ikatan_kerja,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'agama' => $request->agama,
                'jabatan_id' => $request->jabatan_id,
                'lokasi_kantor_id' => $request->lokasi_kantor_id,
                'role' => 'pegawai',
                'status' => 'pending',
            ]);

            if ($request->hasFile('foto_profile')) {
                $foto     = $request->file('foto_profile');
                $fotoName = time() . '_' . $foto->getClientOriginalName();

                $foto->move(public_path('profile'), $fotoName);

                $data->foto_profile = 'profile/' . $fotoName;
                $data->save();
            }


            DB::commit();

            return $this->success($data);
        } catch (\Exception $th) {
            DB::rollBack();

            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function getDataById($id)
    {
        try {
            $data = $this->modelUser::find($id);

            if (!$data) {
                return $this->dataNotFound();
            }

            return $this->success($data);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function updateData(PegawaiRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->modelUser::find($id);

            if (!$data) {
                return $this->idOrDataNotFound();
            }

            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'nik' => $request->nik,
                'nip' => $request->nip,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_ikatan_kerja' => $request->status_ikatan_kerja,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'agama' => $request->agama,
                'jabatan_id' => $request->jabatan_id,
                'lokasi_kantor_id' => $request->lokasi_kantor_id,
            ]);

            if ($request->filled('password')) {
                $data->password = Hash::make($request->password);
                $data->save();
            }

            if ($request->hasFile('foto_profile')) {
                if ($data->foto_profile && file_exists(public_path($data->foto_profile))) {
                    unlink(public_path($data->foto_profile));
                }

                $foto     = $request->file('foto_profile');
                $fotoName = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('profile'), $fotoName);

                $data->foto_profile = 'profile/' . $fotoName;
                $data->save();
            }

            DB::commit();

            return $this->success($data);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);

            if (!$data) {
                return $this->idOrDataNotFound();
            }
            if ($data->foto_profile && file_exists(public_path($data->foto_profile))) {
                unlink(public_path($data->foto_profile));
            }

            $data->delete();

            DB::commit();

            return $this->success(null, 'Data pegawai berhasil dihapus');
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
