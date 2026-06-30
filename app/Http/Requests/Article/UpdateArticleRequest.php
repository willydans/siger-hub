<?php

// FILE: app/Http/Requests/Article/UpdateArticleRequest.php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'sometimes' — semua field opsional saat update (partial update)
            'title'             => ['sometimes', 'string', 'max:255'],
            'category_id'       => ['sometimes', 'nullable', 'exists:categories,id'],
            'thumbnail'         => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'content'           => ['sometimes', 'string'],
            'visibility'        => ['sometimes', 'in:public,restricted,private'],
            'meta_title'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'meta_description'  => ['sometimes', 'nullable', 'string', 'max:500'],
            'keywords'          => ['sometimes', 'nullable', 'string', 'max:500'],
            'references'        => ['sometimes', 'nullable', 'string'],
            'tags'              => ['sometimes', 'array'],
            'tags.*'            => ['string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max'          => 'Judul maksimal 255 karakter.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'thumbnail.image'    => 'Thumbnail harus berupa gambar.',
            'visibility.in'      => 'Visibilitas harus public, restricted, atau private.',
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