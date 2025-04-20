<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'username' => ['required', 'min:3'],
            'password' => ['required', 'min:6'],
            'role' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Harus diisi',
            'username.required' => 'Username Harus diisi',
            'password.required' => 'Password Harus diisi',
            'role.required' => 'Role Harus diisi',
        ];
    }
}
