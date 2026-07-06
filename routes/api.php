<?php

// FILE: routes/api.php
// FINAL — Step 9 (Analytics + Logs) ditambahkan
// Ini adalah versi routes LENGKAP dari Step 1 sampai Step 9

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\StaffArticleController;
use App\Http\Controllers\Api\AdminArticleController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\AttachmentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\LogController;

Route::prefix('v1')->group(function () {

    // ── AUTH PUBLIC ────────────────────────────────────────────────
    Route::prefix('auth')->middleware('throttle:auth')->group(function () {
        Route::post('register',            [AuthController::class, 'register']);
        Route::post('login',               [AuthController::class, 'login']);
        Route::post('resend-verification', [AuthController::class, 'resendVerification']);
        Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
            ->middleware('signed')->name('verification.verify');
    });

    // ── PUBLIC ENDPOINTS ───────────────────────────────────────────
    Route::middleware('throttle:api')->group(function () {
        Route::prefix('articles')->group(function () {
            Route::get('/',       [ArticleController::class, 'index']);
            Route::get('popular', [ArticleController::class, 'popular']);
            Route::get('recent',  [ArticleController::class, 'recent']);
            Route::get('{slug}',  [ArticleController::class, 'show']);
            Route::get('{slug}/comments',    [InteractionController::class, 'getComments']);
            Route::get('{slug}/attachments', [AttachmentController::class, 'listByArticle']);
        });

        Route::get('categories',      [CategoryController::class, 'index']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);
        Route::get('tags',            [TagController::class, 'index']);

        Route::get('attachments/{id}/download', [AttachmentController::class, 'download'])
            ->name('attachments.download');
        Route::get('attachments/{id}/preview',  [AttachmentController::class, 'preview'])
            ->name('attachments.preview');
    });

    // ── PROTECTED ROUTES ───────────────────────────────────────────
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('logout',     [AuthController::class, 'logout']);
            Route::post('logout-all', [AuthController::class, 'logoutAll']);
            Route::get('me',          [AuthController::class, 'me']);
            Route::put('profile',     [AuthController::class, 'updateProfile']);
            Route::put('password',    [AuthController::class, 'changePassword']);
        });

        // Interaksi artikel
        Route::prefix('articles')->group(function () {
            Route::post('{slug}/bookmark', [InteractionController::class, 'toggleBookmark'])
                ->middleware('permission:bookmark-article');
            Route::post('{slug}/comments', [InteractionController::class, 'storeComment'])
                ->middleware('permission:comment-article');
            Route::post('{slug}/rating',   [InteractionController::class, 'storeRating'])
                ->middleware('permission:rate-article');
            Route::delete('{slug}/rating', [InteractionController::class, 'destroyRating'])
                ->middleware('permission:rate-article');
        });

        Route::delete('comments/{id}', [InteractionController::class, 'destroyComment']);

        // User personal data
        Route::prefix('user')->group(function () {
            Route::get('bookmarks',              [InteractionController::class, 'myBookmarks']);
            Route::get('history',                [InteractionController::class, 'myHistory']);
            Route::get('notifications',          [InteractionController::class, 'myNotifications']);
            Route::put('notifications/read-all', [InteractionController::class, 'markAllNotificationsRead']);
            Route::put('notifications/{id}/read',[InteractionController::class, 'markNotificationRead']);
        });

        // ── STAFF ARTICLES ─────────────────────────────────────────
        Route::prefix('staff/articles')->middleware('permission:create-article')->group(function () {
            Route::get('/',            [StaffArticleController::class, 'index']);
            Route::post('/',           [StaffArticleController::class, 'store']);
            Route::get('{id}',         [StaffArticleController::class, 'show']);
            Route::put('{id}',         [StaffArticleController::class, 'update']);
            Route::delete('{id}',      [StaffArticleController::class, 'destroy']);
            Route::post('{id}/submit', [StaffArticleController::class, 'submit']);
            Route::post('{id}/attachments', [AttachmentController::class, 'upload'])
                ->middleware('permission:upload-attachment');
            Route::delete('{id}/attachments/{attachmentId}', [AttachmentController::class, 'destroy'])
                ->middleware('permission:upload-attachment');
        });

        // ── ADMIN ──────────────────────────────────────────────────
        Route::middleware(['permission:approve-article', 'throttle:admin-api'])->group(function () {

            // Admin articles
            Route::prefix('admin/articles')->group(function () {
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
                Route::post('{id}/attachments', [AttachmentController::class, 'upload']);
                Route::delete('{id}/attachments/{attachmentId}', [AttachmentController::class, 'destroy']);
            });

            // Admin categories
            Route::prefix('admin/categories')->middleware('permission:manage-categories')->group(function () {
                Route::post('/',      [CategoryController::class, 'store']);
                Route::put('{id}',    [CategoryController::class, 'update']);
                Route::delete('{id}',[CategoryController::class, 'destroy']);
            });

            // Admin tags
            Route::prefix('admin/tags')->middleware('permission:manage-tags')->group(function () {
                Route::post('/',      [TagController::class, 'store']);
                Route::delete('{id}',[TagController::class, 'destroy']);
            });

            // Admin user management
            Route::prefix('admin/users')->middleware('permission:manage-users')->group(function () {
                Route::get('/',                    [AdminUserController::class, 'index']);
                Route::post('/',                   [AdminUserController::class, 'store']);
                Route::get('{id}',                 [AdminUserController::class, 'show']);
                Route::put('{id}',                 [AdminUserController::class, 'update']);
                Route::put('{id}/toggle-active',   [AdminUserController::class, 'toggleActive']);
                Route::post('{id}/reset-password', [AdminUserController::class, 'resetPassword']);
                Route::delete('{id}',              [AdminUserController::class, 'destroy']);
            });

            Route::get('admin/opds', [AdminUserController::class, 'listOpds'])
                ->middleware('permission:manage-users');

            // ── ANALYTICS ──────────────────────────────────────────
            Route::prefix('admin/analytics')->middleware('permission:view-analytics')->group(function () {
                Route::get('overview',          [AnalyticsController::class, 'overview']);
                Route::get('top-search',        [AnalyticsController::class, 'topSearch']);
                Route::get('knowledge-gap',     [AnalyticsController::class, 'knowledgeGap']);
                Route::get('top-contributors',  [AnalyticsController::class, 'topContributors']);
                Route::get('popular-articles',  [AnalyticsController::class, 'popularArticles']);
                Route::get('views-chart',       [AnalyticsController::class, 'viewsChart']);
            });

            // ── LOGS ───────────────────────────────────────────────
            Route::prefix('admin/logs')->group(function () {
                Route::get('search',           [LogController::class, 'searchLogs'])
                    ->middleware('permission:view-search-logs');
                Route::get('activity',         [LogController::class, 'activityLogs'])
                    ->middleware('permission:view-activity-logs');
                Route::get('activity/types',   [LogController::class, 'activityTypes'])
                    ->middleware('permission:view-activity-logs');
            });
        });
    });
});