<?php

namespace App\Repositories;

use App\Http\Requests\AuthRequest;
use App\Interfaces\AuthInterfaces;
use App\Models\User;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthRepositories implements AuthInterfaces
{
    use HttpResponseTraits;

    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        // 1. Cek Email
        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => 'Login Gagal'
            ], 404);
        }

        // 2. Cek Password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'code' => 400,
                'message' => 'Login Gagal'
            ], 400);
        }

        if ($user->role === 'pegawai' && $user->status !== 'active') {
            return response()->json([
                'code' => 403,
                'message' => 'Akun Anda belum aktif atau ditangguhkan. Silahkan hubungi admin.'
            ], 403);
        }


        // Jika semua lolos, lakukan login
        Auth::login($user);

        return response()->json([
            'code' => 200,
            'message' => 'Login berhasil',
            'data' => [
                'redirect' => url('/')
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->success([
            'message' => 'Logout berhasil',
            'redirect' => route('login')
        ]);
    }
}
