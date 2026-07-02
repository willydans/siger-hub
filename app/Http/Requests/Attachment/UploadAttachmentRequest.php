<?php

// FILE: app/Http/Requests/Attachment/UploadAttachmentRequest.php

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                // Tipe MIME yang diizinkan:
                // Image: jpeg, png, webp
                // Dokumen: pdf, ppt, pptx
                'mimes:jpeg,jpg,png,webp,pdf,ppt,pptx',
                // Max size dalam KB:
                // Image: 2MB = 2048KB
                // PDF/PPT: 10MB = 10240KB
                // Kita pakai max terbesar (10MB), validasi per-tipe di dalam validator
                'max:10240',
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File wajib dipilih.',
            'file.file'     => 'Upload harus berupa file.',
            'file.mimes'    => 'Format file tidak didukung. Gunakan: JPG, PNG, WebP, PDF, PPT, atau PPTX.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
        ];
    }

    // Validasi tambahan per tipe file (image max 2MB, dokumen max 10MB)
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('file') && $this->file('file')->isValid()) {
                $file     = $this->file('file');
                $mime     = $file->getMimeType();
                $sizeInKb = $file->getSize() / 1024;

                $imageTypes = ['image/jpeg', 'image/png', 'image/webp'];

                if (in_array($mime, $imageTypes) && $sizeInKb > 2048) {
                    $validator->errors()->add('file', 'Ukuran gambar maksimal 2MB.');
                }
            }
        });
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