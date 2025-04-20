<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicinesCreateRequest extends FormRequest
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
            'unit' => ['required'],
            'stock' => ['required'],
            'price' => ['required'],
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
            'name.required' => 'Nama Obat Harus diisi',
            'unit.required' => 'Satuan Harus diisi',
            'stock_date.required' => 'Stock Harus diisi',
            'price.required' => 'harga Harus diisi',
            'address.required' => 'Alamat Harus diisi',
        ];
    }
}
