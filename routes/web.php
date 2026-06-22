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

// Route untuk Halaman Login & Register
Route::get('/login', function () {
    return view('login'); 
});

// Route untuk Halaman Staf (Author CMS)
Route::get('/staff/dashboard', function () { return view('staff-dashboard'); });
Route::get('/staff/articles', function () { return view('staff-articles'); }); // Manajemen Edit/Hapus
Route::get('/staff/editor', function () { return view('staff-editor'); }); // Tulis/Edit Artikel
Route::get('/staff/profile', function () { return view('staff-profile'); });

// Route untuk Admin Dashboard & Manajemen
Route::get('/admin/dashboard', function () { return view('admin-dashboard'); });
Route::get('/admin/articles', function () { return view('admin-articles'); }); // Verifikasi & CMS
Route::get('/admin/users', function () { return view('admin-users'); }); // Manajemen Role
Route::get('/admin/reports', function () { return view('admin-reports'); }); // Audit Trail & Laporan
// Tambahkan di bawah route admin lainnya
Route::get('/admin/editor', function () { 
    return view('admin-editor'); 
});