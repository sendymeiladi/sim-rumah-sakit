<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientsCreateRequest extends FormRequest
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
            'name' => ['required'],
            'nik' => ['required'],
            'birth_date' => ['required'],
            'gender' => ['required'],
            'address' => ['required'],
            'region_id' => ['required'],
            'phone' => ['required'],
        ];
    }

    /**
     * Get the validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Pasien Harus diisi',
            'nik.required' => 'No NIK Harus diisi',
            'birth_date.required' => 'Tanggal Lahir Harus diisi',
            'gender.required' => 'Jenis kelamin Harus diisi',
            'address.required' => 'Alamat Harus diisi',
            'region_id.required' => 'Wilayah Harus diisi',
            'phone.required' => 'Telepon Harus diisi',
        ];

    }
}
