<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // ambil ID dari route parameter

        return [
            'email'              => 'required',
            'password'              => $this->isMethod('post')
                ? 'required|string|min:8'
                : 'nullable|string|min:8',
        ];
    }


    public function messages(): array
    {
        return [

            'email.required'              => 'Username wajib diisi.',


            'password.required'              => 'Password wajib diisi.',
            'password.string'                => 'Password harus berupa teks.',
            'password.min'                   => 'Password minimal 8 karakter.',
            'password.unique'                => 'Password sudah digunakan, pilih password lain.',
            'password.confirmed'             => 'Password dan konfirmasi tidak sama.',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'    => 422,
            'message' => 'Cek your validation',
            'data'    => $validator->errors()
        ], 422));
    }
}
