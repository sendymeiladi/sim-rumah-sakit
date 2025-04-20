<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionsCreateRequest extends FormRequest
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
            'name' => ['required', 'min:1'],
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
            'name.required' => 'Nama Perumahan Harus diisi',
            'name.min' => 'Nama Perumahan minimal harus memiliki :min karakter',
        ];
    }
}
