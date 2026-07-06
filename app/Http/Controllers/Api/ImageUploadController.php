<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi file yang diupload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Maks 2MB
        ]);

        // 2. Simpan gambar ke folder 'public/uploads'
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Nama file unik agar tidak bentrok
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file
            $path = $file->storeAs('uploads', $fileName, 'public');

            // 3. Kembalikan response JSON yang dimengerti oleh Editor (TinyMCE/CKEditor butuh 'location')
            return response()->json([
                'location' => asset('storage/' . $path) // Mengembalikan URL lengkap gambar
            ]);
        }

        return response()->json(['error' => 'File tidak ditemukan atau gagal diupload'], 400);
    }
}