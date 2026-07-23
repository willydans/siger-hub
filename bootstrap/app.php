<?php

// FILE: bootstrap/app.php

use Illuminate\Cache\RateLimiting\Limit; // Tambahan dari teman
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter; // Tambahan dari teman
use Spatie\Permission\Exceptions\UnauthorizedException; // Tambahan dari teman

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // --- Konfigurasi Middleware ---
    ->withMiddleware(function (Middleware $middleware) {
        
        // ✅ Sanctum stateful domains (Tambahan dari teman)
        $middleware->statefulApi();

        // ✅ Daftarkan alias middleware
        $middleware->alias([
            // Spatie Permission (Tambahan dari teman)
            'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            // Middleware custom (Milikmu dan temanmu)
            // PERHATIAN: 'role' milikmu sebelumnya diubah jadi 'checkrole' agar tidak bentrok dengan Spatie
            'checkrole'          => \App\Http\Middleware\CheckRole::class,
            'prevent.back'       => \App\Http\Middleware\PreventBackHistory::class,
            
            // Middleware jaga-jaga OTP (Milik asli kamu)
            'verified.otp'       => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        // ✅ Global web middleware (Tambahan dari teman)
        $middleware->web(\App\Http\Middleware\ShareAppName::class);

        // 🔥 Percayai semua proxy (Milik asli kamu - untuk ngrok/HTTPS)
        $middleware->trustProxies(at: '*');

        // 🔥 Pengecualian CSRF (Milik asli kamu - upload file)
        $middleware->validateCsrfTokens(except: [
            'login',
            'staff/editor/upload-attachment',
            'staff/editor/upload-image',
        ]);
    })
    // --- Konfigurasi Exception & Error Handling ---
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Milik asli kamu: Paksa response API ke JSON
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // ✅ Tambahan dari teman: Format JSON yang rapi untuk error tertentu
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
    // --- Rate Limiting (Tambahan dari teman) ---
    ->booted(function () {
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