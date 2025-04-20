<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeesUpdateRequest extends FormRequest
{
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
            'nip' => ['required'],
            'name' => ['required'],
            'position' => ['required'],
            'joined_date' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
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
            'nip.required' => 'No NIP Harus diisi',
            'name.required' => 'Nama Karyawan Harus diisi',
            'position.required' => 'Posisi Harus diisi',
            'joined_date.required' => 'Tanggal Masuk Harus diisi',
            'phone.required' => 'Telepon Harus diisi',
            'address.required' => 'Alamat Perumahan Harus diisi',
        ];
    }
}
