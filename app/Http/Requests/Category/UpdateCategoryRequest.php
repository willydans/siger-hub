<?php

// FILE: app/Http/Requests/Category/UpdateCategoryRequest.php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'        => ['sometimes', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($id)],
            'parent_id'   => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'icon'        => ['sometimes', 'nullable', 'string', 'max:50'],
            'color'       => ['sometimes', 'nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'description' => ['sometimes', 'nullable', 'string', 'max:500'],
            'order'       => ['sometimes', 'nullable', 'integer', 'min:0'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique'      => 'Nama kategori sudah digunakan.',
            'parent_id.exists' => 'Kategori induk tidak ditemukan.',
            'color.regex'      => 'Format warna harus berupa hex color (contoh: #3B82F6).',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false, 'message' => 'Validasi gagal.', 'errors' => $validator->errors(),
        ], 422));
    }
}