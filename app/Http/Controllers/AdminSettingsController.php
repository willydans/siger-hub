<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // Ambil semua setting untuk ditampilkan di form
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Kumpulkan semua input dari form (kecuali token dan method)
        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            // Jika input berasal dari dropdown multiple (array), ubah menjadi string koma
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan umum sistem berhasil disimpan!');
    }
}