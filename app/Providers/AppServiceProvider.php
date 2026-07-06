<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ KONFIGURASI WAJIB UNTUK NGORK!
        // Memberitahu Laravel bahwa ia berada di belakang proxy Ngrok
        if (app()->environment('local')) {
            Request::setTrustedProxies(
                ['*'],
                Request::HEADER_X_FORWARDED_FOR |
                Request::HEADER_X_FORWARDED_HOST |
                Request::HEADER_X_FORWARDED_PORT |
                Request::HEADER_X_FORWARDED_PROTO
            );
        }

        try {
            $appName = Setting::where('key', 'nama_aplikasi')->value('value') ?? 'SIGER-Hub';
        } catch (\Exception $e) {
            $appName = 'SIGER-Hub';
        }
        View::share('appName', $appName);
    }
}