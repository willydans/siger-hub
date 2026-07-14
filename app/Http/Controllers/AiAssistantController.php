<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiAssistantController extends Controller
{
    public function chat(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $message = strtolower(trim($request->message));

        // 🔒 1. CEK KATA KUNCI SENSITIF (RESTRICTED)
        $bannedKeywords = ['password', 'email', 'telepon', 'no hp', 'nik', 'ktp', 'politik', 'presiden', 'sara', 'agama', 'suku', 'ras', 'antargolongan', 'pejabat', 'gubernur', 'bupati', 'walikota'];
        foreach ($bannedKeywords as $word) {
            if (str_contains($message, $word)) {
                return response()->json([
                    'reply' => "Maaf, saya tidak diizinkan untuk membahas topik sensitif atau data pribadi. Silakan ajukan pertanyaan seputar pengetahuan dan dokumentasi publik AKSARA."
                ]);
            }
        }

        // 🛠️ 2. LOGIKA PENCARIAN YANG FLEKSIBEL
        // Hapus kata sambung yang tidak penting. Pertahankan kata inti (seperti 'web', 'server', 'sop').
        $stopWords = ['yang', 'di', 'ke', 'pada', 'untuk', 'dengan', 'dan', 'atau', 'adalah', 'nya', 'sebagai', 'kepada', 'dari', 'dalam'];
        
        // Pecah kalimat menjadi array kata
        $rawKeywords = explode(' ', $message);
        
        // Filter kata-kata yang tidak penting
        $keywords = array_filter($rawKeywords, function($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 2; // Hanya ambil kata dengan panjang > 2 huruf (misal: 'web' tetap diambil)
        });

        // 3. LAKUKAN PENCARIAN DI DATABASE BERDASARKAN KATA KUNCI
        $query = Article::where('status', 'published')
            ->whereNotNull('published_at');

        // Jika pengguna mengetik sapaan (Halo, Hai, Assalamualaikum), berikan sapaan balik.
        $greetings = ['halo', 'hai', 'hi', 'assalamualaikum', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'];
        if (in_array($message, $greetings)) {
            return response()->json([
                'reply' => "Halo! Selamat datang di Asisten Siger AI. Saya siap membantu Anda mencari dokumentasi publik, SOP, pedoman TI, dan basis pengetahuan AKSARA. Silakan tanyakan sesuatu!"
            ]);
        }

        // Jalankan pencarian
        if (!empty($keywords)) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('title', 'like', "%{$word}%")
                      ->orWhere('content', 'like', "%{$word}%")
                      ->orWhere('category', 'like', "%{$word}%")
                      ->orWhere('excerpt', 'like', "%{$word}%")
                      ->orWhere('tags', 'like', "%{$word}%");
                }
            })->limit(5);
        } else {
            // Jika tidak ada kata kunci yang valid (misal user cuma ngetik "apa"), AI memberikan saran umum.
            return response()->json([
                'reply' => "Hmm, pertanyaan Anda sepertinya terlalu umum. Untuk membantu saya menemukan informasi, silakan tambahkan kata kunci seperti **'SOP', 'Pedoman SPBE', 'Infrastruktur TI', 'Kebijakan', atau 'Keamanan Jaringan'**."
            ]);
        }

        // Ambil hasil
        $results = $query->get(['title', 'excerpt', 'category', 'slug']);

        // 4. HASIL PENELUSURAN
        if ($results->isNotEmpty()) {
            $reply = "Saya menemukan beberapa dokumentasi yang mungkin relevan dengan pertanyaan Anda di database AKSARA:\n\n";
            foreach ($results as $index => $article) {
                $reply .= "📄 **" . ($index + 1) . ". {$article->title}**\n";
                $reply .= "Kategori: {$article->category}\n";
                $reply .= "Deskripsi: " . ($article->excerpt ? \Illuminate\Support\Str::limit($article->excerpt, 100) : '-') . "\n";
                $reply .= "🔗 Baca selengkapnya di: " . route('document.detail', $article->slug) . "\n\n";
            }
            
            return response()->json([
                'reply' => $reply
            ]);
        }

        // 5. RESPONS FALLBACK (JIKA TIDAK ADA DATA YANG COCOK)
        return response()->json([
            'reply' => "Mohon maaf, saya belum menemukan dokumen yang spesifik membahas tentang **'{$request->message}'** di dalam database AKSARA. \n\nNamun, AKSARA memiliki beragam dokumentasi publik, SOP, dan pedoman teknis yang bisa Anda eksplorasi. \n\n💡 **Saran:** Cobalah mencari dengan kata kunci yang lebih spesifik seperti:\n• 'SOP Keamanan Siber'\n• 'Pedoman Infrastruktur'\n• 'Tutorial Server'\n• 'Dokumen SPBE'\n\nAtau Anda bisa langsung mengunjungi halaman Knowledge Base kami: " . route('knowledge-base')
        ]);
    }
}