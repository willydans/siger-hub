<?php

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        // Cek apakah model Setting ada, agar tidak error
        if (class_exists('App\Models\Setting')) {
            $setting = \App\Models\Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        }
        return $default;
    }
}