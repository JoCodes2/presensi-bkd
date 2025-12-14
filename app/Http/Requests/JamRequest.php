<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class JamRequest extends FormRequest
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
            'nama_shift' => 'required|string|max:100',

            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',

            'batas_terlambat' => 'nullable|date_format:H:i',

            'senin_kerja' => 'nullable|boolean',
            'selasa_kerja' => 'nullable|boolean',
            'rabu_kerja' => 'nullable|boolean',
            'kamis_kerja' => 'nullable|boolean',
            'jumat_kerja' => 'nullable|boolean',
            'sabtu_kerja' => 'nullable|boolean',
            'minggu_kerja' => 'nullable|boolean',

            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_shift.required' => 'Nama shift wajib diisi.',
            'nama_shift.string'   => 'Nama shift harus berupa teks.',
            'nama_shift.max'      => 'Nama shift maksimal 100 karakter.',

            'jam_masuk.required'    => 'Jam masuk wajib diisi.',
            'jam_masuk.date_format' => 'Format jam masuk harus HH:MM (contoh: 08:00).',

            'jam_keluar.required'    => 'Jam keluar wajib diisi.',
            'jam_keluar.date_format' => 'Format jam keluar harus HH:MM (contoh: 17:00).',
            'jam_keluar.after'       => 'Jam keluar harus lebih besar dari jam masuk.',

            'batas_terlambat.date_format' =>
            'Format batas keterlambatan harus HH:MM (contoh: 08:15).',

            'senin_kerja.boolean'  => 'Status kerja hari Senin tidak valid.',
            'selasa_kerja.boolean' => 'Status kerja hari Selasa tidak valid.',
            'rabu_kerja.boolean'  => 'Status kerja hari Rabu tidak valid.',
            'kamis_kerja.boolean' => 'Status kerja hari Kamis tidak valid.',
            'jumat_kerja.boolean' => 'Status kerja hari Jumat tidak valid.',
            'sabtu_kerja.boolean' => 'Status kerja hari Sabtu tidak valid.',
            'minggu_kerja.boolean' => 'Status kerja hari Minggu tidak valid.',

            'is_active.boolean' => 'Status aktif tidak valid.',
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
