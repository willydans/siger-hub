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
Route::get('/staff/articles', function () { return view('staff-articles'); });
Route::get('/staff/draft', function () { return view('staff-draft'); });
Route::get('/staff/revision', function () { return view('staff-revision'); });
Route::get('/staff/notification', function () { return view('staff-notification'); });
Route::get('/staff/editor', function () { return view('staff-editor'); });
Route::get('/staff/profile', function () { return view('staff-profile'); });

// Route untuk Admin Dashboard & Manajemen (Fitur yang sudah ada)
Route::get('/admin/dashboard', function () { return view('admin-dashboard'); });
Route::get('/admin/articles', function () { return view('admin-articles'); });
Route::get('/admin/users', function () { return view('admin-users'); });
Route::get('/admin/reports', function () { return view('admin-reports'); });
Route::get('/admin/editor', function () { return view('admin-editor'); });

// -------------------------------------------------------------
// PENAMBAHAN ROUTE ADMIN BARU (Berdasarkan file pada screenshot)
// -------------------------------------------------------------
Route::get('/admin/all-articles', function () { return view('admin-allarticles'); });
Route::get('/admin/pending-approval', function () { return view('admin-pendingapproval'); });
Route::get('/admin/draft', function () { return view('admin-draft'); });
Route::get('/admin/revision', function () { return view('admin-revision'); });
Route::get('/admin/published', function () { return view('admin-published'); });
Route::get('/admin/archive', function () { return view('admin-archive'); });
Route::get('/admin/delete', function () { return view('admin-delete'); });
Route::get('/admin/analytics', function () { return view('admin-analytics'); });
Route::get('/admin/searchlog', function () { return view('admin-searchlog'); }); // <-- Route Search Log ditambahkan disini
Route::get('/admin/feedback', function () { return view('admin-feedback'); });
Route::get('/admin/notification', function () { return view('admin-notification'); });
Route::get('/admin/activity', function () { return view('admin-activity'); });
Route::get('/admin/storage', function () { return view('admin-storage'); });
Route::get('/admin/settings', function () { return view('admin-settings'); });
Route::get('/admin/backup', function () { return view('admin-backup'); });
Route::get('/admin/category', function () { return view('admin-category'); });