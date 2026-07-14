<?php

// FILE: bootstrap/app.php
// Update dari CORS step — tambah alias middleware untuk integrasi frontend

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

        // ── Middleware aliases ─────────────────────────────────────
        $middleware->alias([
            // Spatie Permission
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            // Frontend temanmu — CheckRole cek $user->role (dijembatani accessor)
            'checkrole'          => \App\Http\Middleware\CheckRole::class,

            // Prevent back button setelah logout
            'prevent.back'       => \App\Http\Middleware\PreventBackHistory::class,
        ]);

        // ── Global web middleware ──────────────────────────────────
        // ShareAppName — inject $appName ke semua view Blade
        $middleware->web(\App\Http\Middleware\ShareAppName::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Format semua error API jadi JSON konsisten
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk mengakses resource ini.',
                ], 403);
            }
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk mengakses resource ini.',
                ], 401);
            }
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint atau resource tidak ditemukan.',
                ], 404);
            }
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'HTTP method tidak diizinkan untuk endpoint ini.',
                ], 405);
            }
        });

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

        // Rate limiting
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => 'Terlalu banyak percobaan login. Silakan tunggu 1 menit.',
                ], 429);
            });
        });

        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(30)->by($request->ip());
        });

        RateLimiter::for('admin-api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?? $request->ip());
        });

    })->create();