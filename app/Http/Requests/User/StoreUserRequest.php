<?php

// FILE: app/Http/Requests/User/StoreUserRequest.php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'in:user,staff,admin'],
            'opd_id'   => ['nullable', 'integer', 'exists:opds,id'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'nip'      => ['nullable', 'string', 'max:30', 'unique:users,nip'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role harus user, staff, atau admin.',
            'opd_id.exists'     => 'OPD tidak ditemukan.',
            'nip.unique'        => 'NIP sudah terdaftar.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors(),
        ], 422));
    }
}