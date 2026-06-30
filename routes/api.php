<?php

// FILE: routes/api.php
// Ganti seluruh isi file ini

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\StaffArticleController;

/*
|--------------------------------------------------------------------------
| AKSARA API Routes — v1
|--------------------------------------------------------------------------
| Semua route di sini otomatis prefix /api (dari Laravel)
| Kita tambahkan prefix v1 di dalam supaya versioning rapi
|
| Format response selalu JSON:
|   { "success": true/false, "message": "...", "data": {...} }
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ── AUTH (tidak butuh login) ───────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('register',           [AuthController::class, 'register']);
        Route::post('login',              [AuthController::class, 'login']);
        Route::post('resend-verification',[AuthController::class, 'resendVerification']);
 
        // Named route 'verification.verify' dipakai oleh Laravel saat generate signed URL
        Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
            ->middleware('signed')
            ->name('verification.verify');
    });
 
    // ── ARTICLES PUBLIC (guest bisa akses, optional auth utk personalisasi) ──
    Route::prefix('articles')->group(function () {
        Route::get('/',         [ArticleController::class, 'index']);
        Route::get('popular',   [ArticleController::class, 'popular']);
        Route::get('recent',    [ArticleController::class, 'recent']);
        Route::get('{slug}',    [ArticleController::class, 'show']);
    });

    // ── PROTECTED ROUTES (butuh token Sanctum) ────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('logout',      [AuthController::class, 'logout']);
            Route::post('logout-all',  [AuthController::class, 'logoutAll']);
            Route::get('me',           [AuthController::class, 'me']);
            Route::put('profile',      [AuthController::class, 'updateProfile']);
            Route::put('password',     [AuthController::class, 'changePassword']);
        });

        Route::prefix('staff/articles')->middleware('permission:create-article')->group(function () {
            Route::get('/',           [StaffArticleController::class, 'index']);
            Route::post('/',          [StaffArticleController::class, 'store']);
            Route::get('{id}',        [StaffArticleController::class, 'show']);
            Route::put('{id}',        [StaffArticleController::class, 'update']);
            Route::delete('{id}',     [StaffArticleController::class, 'destroy']);
            Route::post('{id}/submit',[StaffArticleController::class, 'submit']);
        });

        /*
        |--------------------------------------------------------------
        | PLACEHOLDER — step berikutnya akan ditambahkan di sini:
        |--------------------------------------------------------------
        | STEP 3 — Articles (public + staff CRUD)
        | STEP 4 — Approval workflow (admin)
        | STEP 5 — Bookmarks, comments, ratings
        | STEP 6 — Attachments
        | STEP 7 — Categories & Tags
        | STEP 8 — User management (admin)
        | STEP 9 — Analytics & Search
        | STEP 10 — Notifications
        |--------------------------------------------------------------
        */

    });

});