<?php

// FILE: routes/api.php
// Ganti seluruh isi file ini

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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
        Route::post('login', [AuthController::class, 'login']);
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