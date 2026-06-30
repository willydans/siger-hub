<?php

// FILE: app/Http/Requests/Auth/UpdateProfileRequest.php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['sometimes', 'string', 'max:255'],
            'phone'  => ['sometimes', 'nullable', 'string', 'max:20'],
            // email unique tapi kecualikan user saat ini
            'email'  => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'avatar' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // max 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'name.max'       => 'Nama maksimal 255 karakter.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan.',
            'avatar.image'   => 'Avatar harus berupa gambar.',
            'avatar.mimes'   => 'Format avatar harus jpeg, png, jpg, atau webp.',
            'avatar.max'     => 'Ukuran avatar maksimal 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}