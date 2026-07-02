<?php

// FILE: routes/api.php
// Ganti seluruh isi file ini

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\StaffArticleController;
use App\Http\Controllers\Api\AdminArticleController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\AttachmentController;

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

        // Komentar bisa dibaca tanpa login
        Route::get('{slug}/comments', [InteractionController::class, 'getComments']);
        Route::get('{slug}/attachments',  [AttachmentController::class, 'listByArticle']);
    });

    // ── ATTACHMENT — download & preview (publik dengan cek visibility) ──
    // Route ini di luar auth middleware karena guest bisa download artikel public
    Route::get('attachments/{id}/download', [AttachmentController::class, 'download'])
        ->name('attachments.download');
    Route::get('attachments/{id}/preview',  [AttachmentController::class, 'preview'])
        ->name('attachments.preview');

    // ── PROTECTED ROUTES (butuh token Sanctum) ────────────────────
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
 
        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('logout',     [AuthController::class, 'logout']);
            Route::post('logout-all', [AuthController::class, 'logoutAll']);
            Route::get('me',          [AuthController::class, 'me']);
            Route::put('profile',     [AuthController::class, 'updateProfile']);
            Route::put('password',    [AuthController::class, 'changePassword']);
        });

        // ── INTERAKSI ARTIKEL (butuh login) ───────────────────────
        Route::prefix('articles')->group(function () {
            // Bookmark (toggle)
            Route::post('{slug}/bookmark', [InteractionController::class, 'toggleBookmark'])
                ->middleware('permission:bookmark-article');
 
            // Komentar
            Route::post('{slug}/comments', [InteractionController::class, 'storeComment'])
                ->middleware('permission:comment-article');
 
            // Rating
            Route::post('{slug}/rating',   [InteractionController::class, 'storeRating'])
                ->middleware('permission:rate-article');
            Route::delete('{slug}/rating', [InteractionController::class, 'destroyRating'])
                ->middleware('permission:rate-article');
        });

        // Hapus komentar (user = milik sendiri, admin = semua)
        Route::delete('comments/{id}', [InteractionController::class, 'destroyComment']);
 
        // ── USER PERSONAL DATA ─────────────────────────────────────
        Route::prefix('user')->group(function () {
            Route::get('bookmarks',    [InteractionController::class, 'myBookmarks']);
            Route::get('history',      [InteractionController::class, 'myHistory']);
 
            // Notifikasi
            Route::get('notifications',              [InteractionController::class, 'myNotifications']);
            Route::put('notifications/read-all',     [InteractionController::class, 'markAllNotificationsRead']);
            Route::put('notifications/{id}/read',    [InteractionController::class, 'markNotificationRead']);
        });

        Route::prefix('staff/articles')->middleware('permission:create-article')->group(function () {
            Route::get('/',           [StaffArticleController::class, 'index']);
            Route::post('/',          [StaffArticleController::class, 'store']);
            Route::get('{id}',        [StaffArticleController::class, 'show']);
            Route::put('{id}',        [StaffArticleController::class, 'update']);
            Route::delete('{id}',     [StaffArticleController::class, 'destroy']);
            Route::post('{id}/submit',[StaffArticleController::class, 'submit']);

            // Attachment upload & delete (khusus staff/admin)
            Route::post('{id}/attachments',              [AttachmentController::class, 'upload'])
                ->middleware('permission:upload-attachment');
            Route::delete('{id}/attachments/{attachmentId}', [AttachmentController::class, 'destroy'])
                ->middleware('permission:upload-attachment');
        });

         Route::prefix('admin/articles')
            ->middleware(['permission:approve-article', 'throttle:admin-api'])
            ->group(function () {
                Route::get('/',              [AdminArticleController::class, 'index']);
                Route::get('pending',        [AdminArticleController::class, 'pending']);
                Route::get('{id}',           [AdminArticleController::class, 'show']);
                Route::post('{id}/approve',  [AdminArticleController::class, 'approve']);
                Route::post('{id}/revision', [AdminArticleController::class, 'revision']);
                Route::post('{id}/reject',   [AdminArticleController::class, 'reject']);
                Route::put('{id}/archive',   [AdminArticleController::class, 'archive']);
                Route::post('{id}/restore',  [AdminArticleController::class, 'restore']);
                Route::delete('{id}',        [AdminArticleController::class, 'destroy']);
                Route::post('{id}/rollback', [AdminArticleController::class, 'rollback']);

                Route::post('{id}/attachments',              [AttachmentController::class, 'upload']);
                Route::delete('{id}/attachments/{attachmentId}', [AttachmentController::class, 'destroy']);
            });

        /*
        |--------------------------------------------------------------
        | PLACEHOLDER — step berikutnya:
        |--------------------------------------------------------------
        | STEP 7 — Categories & Tags (admin CRUD)
        | STEP 8 — User management (admin)
        | STEP 9 — Analytics & Search logs
        |--------------------------------------------------------------
        */

    });

});