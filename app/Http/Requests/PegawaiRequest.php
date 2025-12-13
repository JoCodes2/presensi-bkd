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
        return [
            'name'             => 'required|string|max:150',
            'email'            => 'required|email|max:150|unique:users,email,' . $this->id . ',id',
            'password'         => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password',

            'nik'              => 'required|string|max:20',
            'nip'              => 'nullable|string|max:20',
            'tempat_lahir'     => 'nullable|string|max:80',
            'tanggal_lahir'    => 'nullable|date',
            'jenis_kelamin'    => 'nullable|in:L,P',
            'alamat'           => 'nullable|string',
            'no_hp'            => 'nullable|string|max:20',

            'agama'            => 'nullable|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',

            'jabatan_id'       => 'required|uuid|exists:jabatan,id',
            'lokasi_kantor_id' => 'nullable|uuid|exists:lokasi_kantor,id',

            'foto_profile'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'status'           => 'nullable|in:pending,active,rejected',
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
