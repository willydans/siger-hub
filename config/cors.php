<?php

// FILE: config/cors.php
// Ganti seluruh isi file ini

return [

    /*
    |--------------------------------------------------------------------------
    | CORS — Cross-Origin Resource Sharing
    |--------------------------------------------------------------------------
    | Konfigurasi ini mengatur domain mana saja yang boleh mengakses API kita.
    | Saat development: semua domain diizinkan (origins = '*')
    | Saat production: ganti dengan domain frontend yang spesifik
    |--------------------------------------------------------------------------
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    // DEVELOPMENT: izinkan semua origin
    // PRODUCTION: ganti dengan domain spesifik, contoh:
    // ['https://aksara.lampung.go.id', 'https://www.aksara.lampung.go.id']
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'Authorization',
        'Accept',
        'X-Requested-With',
        'X-CSRF-TOKEN',
    ],

    'exposed_headers' => [],

    // Cache preflight request selama 2 jam (mengurangi request OPTIONS berulang dari browser)
    'max_age' => 7200,

    // Wajib true agar Sanctum cookie bisa dikirim lintas domain (untuk SPA)
    'supports_credentials' => true,

];