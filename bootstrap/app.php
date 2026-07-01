<?php

// FILE: bootstrap/app.php
// Ganti seluruh isi file ini
// Update dari Step 1: tambah Rate Limiting untuk API endpoints

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Sanctum stateful domains
        $middleware->statefulApi();

        // Alias middleware Spatie
        $middleware->alias([
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        // ── FORMAT SEMUA ERROR JADI JSON KONSISTEN ─────────────────
        // Ini mengatasi masalah: error 403 dari Spatie keluar sebagai HTML/exception dump
        // bukan format ApiResponse kita. Sekarang semua error selalu JSON.

        // 403 dari Spatie Permission
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengakses resource ini.',
                ], 403);
            }
        });

        // 401 Unauthenticated (akses endpoint protected tanpa token)
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk mengakses resource ini.',
                ], 401);
            }
        });

        // 404 Not Found (route tidak ditemukan)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint atau resource tidak ditemukan.',
                ], 404);
            }
        });

        // 405 Method Not Allowed
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'HTTP method tidak diizinkan untuk endpoint ini.',
                ], 405);
            }
        });

        // 429 Too Many Requests (rate limiter)
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak permintaan. Silakan coba lagi dalam beberapa saat.',
                ], 429);
            }
        });

    })
    ->booted(function () {

        // ── RATE LIMITING ──────────────────────────────────────────
        // Dibagi 3 kategori berbeda supaya lebih fair & aman

        // 1. Auth endpoints (login, register) — lebih ketat, cegah brute force
        //    Max 10 request per menit per IP
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.',
                ], 429);
            });
        });

        // 2. API umum (artikel, search, dll) — lebih longgar untuk user normal
        //    Max 60 request per menit per user (jika login) atau per IP (jika guest)
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(30)->by($request->ip()); // guest lebih ketat
        });

        // 3. Admin endpoints — lebih longgar karena aktivitas admin memang banyak
        //    Max 120 request per menit per user
        RateLimiter::for('admin-api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?? $request->ip());
        });

    })->create();