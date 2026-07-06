<?php

// FILE: app/Http/Requests/User/UpdateUserRequest.php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'   => ['sometimes', 'string', 'max:255'],
            'email'  => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role'   => ['sometimes', 'in:user,staff,admin'],
            'opd_id' => ['sometimes', 'nullable', 'integer', 'exists:opds,id'],
            'phone'  => ['sometimes', 'nullable', 'string', 'max:20'],
            'nip'    => ['sometimes', 'nullable', 'string', 'max:30', Rule::unique('users', 'nip')->ignore($id)],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'  => 'Email sudah digunakan.',
            'role.in'       => 'Role harus user, staff, atau admin.',
            'opd_id.exists' => 'OPD tidak ditemukan.',
            'nip.unique'    => 'NIP sudah terdaftar.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors(),
        ], 422));
    }
}