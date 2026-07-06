<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class ShareAppName
{
    public function handle($request, Closure $next)
    {
        $appName = \App\Models\Setting::where('key', 'nama_aplikasi')->value('value') ?? 'Aksara';
        View::share('appName', $appName);
        return $next($request);
    }
}