<?php

use Illuminate\Support\Facades\Route;

// Route untuk Halaman Utama (Home)
Route::get('/', function () {
    return view('welcome'); 
});

// Route untuk Halaman Knowledge Base
Route::get('/knowledge-base', function () {
    return view('knowledge-base'); 
});

// Route untuk Halaman Detail SOP
Route::get('/document/sop-siber', function () {
    return view('document-detail'); 
});