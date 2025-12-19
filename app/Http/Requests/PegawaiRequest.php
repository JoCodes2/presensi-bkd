<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ambil ID user dari parameter route (misal: /update/{id})
        $userId = $this->route('id');

        return [
            'name'     => 'required|string|max:150',

            // Tambahkan pengecualian ID agar tidak terkena error "Email/NIK sudah terdaftar" milik sendiri
            'email'    => 'required|email|max:150|unique:users,email,' . $userId,
            'nik'      => 'required|string|max:20|unique:users,nik,' . $userId,

            // Buat password menjadi nullable agar tidak wajib diisi saat update
            'password' => 'nullable|min:8',
            'password_confirmation' => 'required_with:password|same:password',

            'nip'      => 'nullable|string|max:20',
            'tempat_lahir'  => 'nullable|string|max:80',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat'  => 'nullable|string',
            'no_hp'   => 'nullable|string|max:20',

            'agama'   => 'nullable|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'status_ikatan_kerja' => 'nullable|in:pns,non_pns',

            // Pastikan ini dikirim via hidden input di frontend
            'jabatan_id'       => 'required|uuid|exists:jabatan,id',
            'lokasi_kantor_id' => 'nullable|uuid|exists:lokasi_kantor,id',

            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email sudah terdaftar',
            'nik.unique'   => 'NIK sudah terdaftar',
            'nik.required' => 'NIK wajib diisi',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code'    => 422,
                'status'  => 'validation_failed',
                'message' => 'Check your input data',
                'data'    => $validator->errors(),
            ], 422)
        );
    }
}
