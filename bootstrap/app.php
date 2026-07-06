<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // --- Konfigurasi Middleware ---
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Daftarkan alias middleware agar 'role' dan 'prevent.back' bisa dipanggil di web.php
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'prevent.back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // 🔥 Percayai semua proxy (untuk ngrok/HTTPS)
        $middleware->trustProxies(at: '*');

        // 🔥 Pengecualian CSRF agar proses upload file tidak ditolak oleh Laravel
        $middleware->validateCsrfTokens(except: [
            'login',
            'staff/editor/upload-attachment',
            'staff/editor/upload-image',
        ]);
    })
    // --- Konfigurasi Exception & Error Handling ---
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();