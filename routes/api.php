<?php

use Illuminate\Support\Facades\Route;

// Contoh Route Test untuk memastikan API menyala
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API AKSARA sudah siap digunakan!'
    ]);
});