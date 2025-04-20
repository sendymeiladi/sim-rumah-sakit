<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitTreatmentUpdateRequest extends FormRequest
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
            'treatment_id' => ['required'],
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
            'treatment_id.required' => 'Tidakan  Harus diisi',
        ];
    }
}
