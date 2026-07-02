<?php

// FILE: app/Http/Requests/Comment/StoreCommentRequest.php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body'      => ['required', 'string', 'min:3', 'max:1000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required'     => 'Komentar tidak boleh kosong.',
            'body.min'          => 'Komentar minimal 3 karakter.',
            'body.max'          => 'Komentar maksimal 1000 karakter.',
            'parent_id.exists'  => 'Komentar yang ingin dibalas tidak ditemukan.',
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