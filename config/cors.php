<?php

return [
    'paths' => ['*'], // Izinkan semua path
    'allowed_methods' => ['*'], // Izinkan semua method (POST, GET, DLL)
    'allowed_origins' => ['*'], // Izinkan semua domain (termasuk ngrok)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Set true karena pakai session login staff
];