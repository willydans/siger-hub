<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageUploadController; // Tambahkan ini

// Contoh Route Test untuk memastikan API menyala
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API AKSARA sudah siap digunakan!'
    ]);
});

// ==========================================
// RUTE UPLOAD GAMBAR (Menggunakan Controller)
// ==========================================
Route::post('/upload-image', [ImageUploadController::class, 'store']);