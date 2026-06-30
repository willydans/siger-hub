<?php

// FILE: app/Http/Requests/Article/StoreArticleRequest.php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pengecekan permission sudah dihandle middleware 'permission:create-article' di route
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'content'           => ['required', 'string'],
            'visibility'        => ['required', 'in:public,restricted,private'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
            'keywords'          => ['nullable', 'string', 'max:500'],
            'references'        => ['nullable', 'string'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['string', 'max:50'], // nama tag, akan di-firstOrCreate di controller
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Judul wajib diisi.',
            'title.max'           => 'Judul maksimal 255 karakter.',
            'category_id.exists'  => 'Kategori tidak ditemukan.',
            'thumbnail.image'     => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'     => 'Format thumbnail harus jpeg, png, jpg, atau webp.',
            'thumbnail.max'       => 'Ukuran thumbnail maksimal 2MB.',
            'content.required'    => 'Isi artikel wajib diisi.',
            'visibility.required' => 'Visibilitas wajib dipilih.',
            'visibility.in'       => 'Visibilitas harus public, restricted, atau private.',
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