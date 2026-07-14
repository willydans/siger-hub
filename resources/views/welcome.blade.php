<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKSARA | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#111827',
                        gold: '#EAB308',
                        goldhover: '#CA8A04',
                        lightbg: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .scroll-hidden { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .scroll-visible { opacity: 1; transform: translateY(0); }
        .chat-scroll::-webkit-scrollbar { width: 4px; }
        .chat-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .pupil { transition: transform 0.1s ease-out; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .card-img-wrapper { aspect-ratio: 16 / 9; overflow: hidden; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-lightbg overflow-x-hidden">

    <!-- NAVBAR -->
    <nav id="navbar" class="bg-darkbg text-gray-300 py-4 px-8 flex justify-between items-center border-b border-gray-800 sticky top-0 z-50 transition-all duration-300">
        <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold transition-transform duration-300 group-hover:scale-110">A</div>
            <div class="flex flex-col">
                <span id="logo-text" class="font-bold text-white leading-tight transition-colors duration-300">AKSARA</span>
                <span class="text-[10px] text-gray-400">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden lg:flex gap-8 font-medium text-sm">
            <a href="#beranda" class="nav-link text-white hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Beranda</a>
            <a href="#dokumen-publik" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Dokumen Publik</a>
            <a href="/knowledge-base" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Knowledge Base</a>
            <a href="#statistik" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Statistik</a>
            <a href="#tentang" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Tentang</a>
            <a href="#kontak" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Kontak</a>
        </div>
        <div>
            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-300 hover:text-white transition-colors duration-300 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=EAB308&color=0f172a' }}" 
                             alt="Avatar" 
                             class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-gold transition-all duration-300">
                        <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right group-hover:scale-100 scale-95 z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('user.profil') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-3 transition-colors duration-200">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block border-t border-gray-100">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-3 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="/login" id="login-btn" class="bg-white/10 border border-gray-600 text-white hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-[0_0_15px_rgba(234,179,8,0.2)]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span class="hidden sm:inline">Login Portal</span>
                </a>
            @endauth
        </div>
    </nav>

    <!-- FOTO 1: BERANDA -->
    <section id="beranda" class="relative bg-darkbg text-center py-24 px-4 sm:px-8 overflow-hidden scroll-mt-20" 
             style="background-image: radial-gradient(circle at 10% 20%, rgba(234, 179, 8, 0.08) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(234, 179, 8, 0.05) 0%, transparent 40%);">
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-50">
            <svg class="absolute -top-10 -left-10 w-[500px] h-[500px] text-gold animate-float" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.6"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.4"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.2"/>
            </svg>
            <svg class="absolute -bottom-20 -right-10 w-[600px] h-[600px] text-gold transform rotate-180 animate-float-delayed" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.5"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.3"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.1"/>
            </svg>
        </div>
        <div class="max-w-4xl mx-auto relative z-10 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="inline-flex items-center gap-2 border border-gold/30 bg-gold/10 text-gold px-4 py-1.5 rounded-full text-xs font-semibold mb-8 hover:bg-gold/20 transition duration-300">
                <span>✦ Platform Manajemen Pengetahuan Resmi Pemprov Lampung</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-4 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                Aplikasi Kolaborasi & Sistem <br> Arsip Referensi Akuntabel <br>
                <span class="text-gold">Pemprov Lampung</span>
            </h1>
            <p class="text-gray-400 text-sm sm:text-lg max-w-2xl mx-auto mb-10 opacity-0 animate-fade-in-up" style="animation-delay: 0.5s;">
                Akses ribuan dokumen publik, SOP, pedoman teknis, dan basis pengetahuan terintegrasi untuk mendukung tata kelola pemerintahan yang transparan dan cerdas di Provinsi Lampung.
            </p>
            <div class="max-w-2xl mx-auto flex flex-col sm:flex-row bg-gray-800/50 border border-gray-700 rounded-lg p-1 mb-8 opacity-0 animate-fade-in-up hover:border-gray-500 transition-colors duration-300" style="animation-delay: 0.7s;">
                <div class="hidden sm:flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Cari dokumen publik, SOP, pedoman, atau regulasi..." class="w-full bg-transparent px-4 py-3 sm:py-3 outline-none text-white text-sm focus:ring-0">
                <button class="bg-gold text-darkbg px-6 py-3 sm:py-2 rounded-md font-semibold text-sm hover:bg-goldhover hover:scale-105 transition-all duration-300 shadow-lg w-full sm:w-auto mt-2 sm:mt-0">Cari Dokumen</button>
            </div>
            <a href="/login" class="bg-gold text-darkbg px-6 py-2.5 rounded-md font-bold text-sm hover:bg-goldhover hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-2 shadow-lg shadow-gold/20 opacity-0 animate-fade-in-up" style="animation-delay: 0.9s;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Masuk ke Portal AKSARA
            </a>
        </div>
    </section>

    <!-- FOTO 2: STATISTIK -->
    <section id="statistik" class="py-16 px-4 sm:px-8 max-w-7xl mx-auto bg-lightbg scroll-mt-20">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2 scroll-hidden obs-element">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Real-Time Government<br>Knowledge Metrics</h2>
                <p class="text-gray-500 mb-8 text-sm">Data statistik terkini yang mencerminkan aktivitas dan pertumbuhan ekosistem manajemen pengetahuan di lingkungan Pemerintah Provinsi Lampung.</p>
                <div class="grid grid-cols-2 gap-6 sm:gap-8">
                    <div class="scroll-hidden obs-element" style="transition-delay: 100ms;">
                        <div class="text-2xl sm:text-3xl font-bold text-gold"><span class="cnt" id="stat-docs">0</span><span class="text-xl">+</span></div>
                        <div class="text-xs sm:text-sm text-gray-800 font-medium mt-1">Total Public Documents</div>
                        <div class="text-[10px] sm:text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 200ms;">
                        <div class="text-2xl sm:text-3xl font-bold text-gold"><span class="cnt" id="stat-opd">0</span></div>
                        <div class="text-xs sm:text-sm text-gray-800 font-medium mt-1">Active Regional IT Assets</div>
                        <div class="text-[10px] sm:text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 300ms;">
                        <div class="text-2xl sm:text-3xl font-bold text-gold"><span class="cnt" id="stat-downloads">0</span><span class="text-xl">+</span></div>
                        <div class="text-xs sm:text-sm text-gray-800 font-medium mt-1">Total Downloads</div>
                        <div class="text-[10px] sm:text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 400ms;">
                        <div class="text-2xl sm:text-3xl font-bold text-gold"><span class="cnt" id="stat-views">0</span></div>
                        <div class="text-xs sm:text-sm text-gray-800 font-medium mt-1">Gov Agencies Connected</div>
                        <div class="text-[10px] sm:text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 bg-gray-100 rounded-3xl p-8 sm:p-12 flex justify-center items-center relative h-64 sm:h-80 scroll-hidden obs-element hover:shadow-xl transition duration-500" style="transition-delay: 300ms;">
                <div class="absolute w-32 h-32 sm:w-40 sm:h-40 bg-white rounded-full shadow-lg flex flex-col items-center justify-center z-20 animate-float">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gold rounded text-darkbg flex items-center justify-center font-bold mb-2">=</div>
                    <div class="text-xs font-bold text-gray-800">System Online</div>
                    <div class="text-[10px] text-gray-500">99.9% Uptime</div>
                </div>
                <div class="absolute top-10 right-5 sm:right-10 w-20 h-20 sm:w-24 sm:h-24 bg-gray-200 rounded-2xl animate-float-delayed"></div>
                <div class="absolute bottom-10 left-5 sm:left-10 w-24 h-24 sm:w-32 sm:h-32 bg-gray-200 rounded-full animate-float" style="animation-duration: 8s;"></div>
            </div>
        </div>
    </section>

    <!-- KATEGORI -->
    <section class="py-10 px-4 sm:px-8 max-w-7xl mx-auto scroll-hidden obs-element border-t border-b border-gray-100 mb-8 bg-white/50">
        <h3 class="text-center text-base font-bold text-gray-500 uppercase tracking-wider mb-8">Eksplorasi Berdasarkan Kategori</h3>
        <div class="flex flex-wrap justify-center items-center gap-6 sm:gap-8">
            @foreach($categories as $category)
            <a href="#" class="flex flex-col items-center gap-3 group">
                <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-md group-hover:shadow-xl group-hover:scale-110">
                    {!! $category->icon ?? '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>' !!}
                </div>
                <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">{{ $category->name }}</span>
            </a>
            @endforeach
        </div>
    </section>

    <!-- PUBLIC SOPS & GUIDELINES (Tinggi Kartu Disamakan) -->
    <section id="dokumen-publik" class="py-8 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20">
        <div class="flex justify-between items-end mb-8 scroll-hidden obs-element">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Public SOPs & Guidelines</h2>
                <p class="text-gray-500 mt-2 text-xs sm:text-sm">Akses dokumen Standar Operasional Prosedur dan pedoman publik.</p>
            </div>
            <a href="/knowledge-base" class="text-gray-600 font-medium text-xs sm:text-sm flex items-center gap-1 hover:text-gold transition-colors duration-300">Lihat Semua <span class="group-hover:translate-x-1 transition-transform duration-300">→</span></a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            @foreach($latestArticles as $article)
            @php
                $thumbUrl = asset('images/placeholder-article.png');
                if (!empty($article->thumbnail)) {
                    if (str_starts_with($article->thumbnail, 'http')) {
                        $thumbUrl = $article->thumbnail;
                    } else {
                        $thumbUrl = \Illuminate\Support\Facades\Storage::url($article->thumbnail);
                    }
                }
                $authorAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name ?? 'A') . '&background=f3f4f6&color=1e3a8a&size=32';
                if ($article->user && !empty($article->user->avatar)) {
                    if (str_starts_with($article->user->avatar, 'http')) {
                        $authorAvatar = $article->user->avatar;
                    } else {
                        $authorAvatar = \Illuminate\Support\Facades\Storage::url($article->user->avatar);
                    }
                }
                $visClass = 'bg-gray-500 text-white';
                $visLabel = $article->visibility ?? 'public';
                if ($article->visibility === 'public') { $visClass = 'bg-green-600 text-white'; }
                elseif ($article->visibility === 'internal') { $visClass = 'bg-blue-600 text-white'; }
                elseif ($article->visibility === 'private') { $visClass = 'bg-red-600 text-white'; }
            @endphp
            <a href="{{ route('document.detail', $article->slug ?? $article->id) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 scroll-hidden obs-element flex flex-col h-full" style="transition-delay: {{ $loop->iteration * 100 }}ms;">
                <div class="h-32 bg-gray-200 relative overflow-hidden group card-img-wrapper flex-shrink-0">
                    <img src="{{ $thumbUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='{{ asset('images/placeholder-article.png') }}'">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
                        {{ ucfirst($article->status) }}
                    </span>
                    <span class="absolute bottom-3 right-3 {{ $visClass }} text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm uppercase z-10">
                        {{ ucfirst($visLabel) }}
                    </span>
                </div>
                <div class="p-5 flex flex-col flex-grow">
                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded self-start">
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                    <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug hover:text-gold transition-colors">{{ $article->title }}</h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                    
                    <div class="mt-auto pt-4 flex flex-col gap-3">
                        <div class="flex items-center text-yellow-400 text-[10px]">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= round($article->rating_avg)) ⭐ @else ☆ @endif
                            @endfor
                            <span class="text-gray-400 ml-1 font-medium">({{ number_format($article->rating_avg, 1) }})</span>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $authorAvatar }}" alt="Author" class="w-6 h-6 rounded-full" onerror="this.src='https://ui-avatars.com/api/?name=Author&background=f3f4f6&color=1e3a8a&size=32'">
                                <span class="text-[10px] font-medium text-gray-600 truncate max-w-[80px]">{{ $article->user->name ?? 'Admin' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-400">
                                <button class="hover:text-blue-500 transition-colors" title="Like">
                                    <span class="text-[10px] mr-1">{{ $article->likes ?? 0 }}</span>
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                </button>
                                <button class="hover:text-gold transition-colors" title="Bookmark"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg></button>
                                <button class="hover:text-green-500 transition-colors" title="Download"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                <button class="hover:text-purple-500 transition-colors" title="Share"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- KNOWLEDGE TRENDING (💥 FIX: FIXED WIDTH UNTUK CAROUSEL) -->
    <section class="py-8 px-4 sm:px-8 max-w-7xl mx-auto border-t border-gray-100 scroll-hidden obs-element relative group section-carousel">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            <h2 class="text-2xl font-bold text-gray-900">Knowledge Trending</h2>
        </div>
        <div class="relative px-4 sm:px-8">
            <button data-scroll-prev class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button data-scroll-next class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            
            <div data-scroll-container class="flex overflow-x-auto gap-6 scroll-smooth no-scrollbar py-2 flex-nowrap">
                @foreach($trendingArticles as $article)
                @php
                    $thumbUrl = asset('images/placeholder-article.png');
                    if (!empty($article->thumbnail)) {
                        $thumbUrl = str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : \Illuminate\Support\Facades\Storage::url($article->thumbnail);
                    }
                @endphp
                {{-- 💥 FIX: Tambahkan w-[280px] sm:w-[260px] flex-shrink-0 agar tidak stretch --}}
                <a href="{{ route('document.detail', $article->slug ?? $article->id) }}" class="block w-[280px] sm:w-[260px] flex-shrink-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="h-32 bg-gray-200 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='{{ asset('images/placeholder-article.png') }}'">
                        <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Trending</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded self-start">HOT TREND</span>
                        <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug group-hover:text-gold transition-colors">{{ $article->title }}</h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                        <div class="mt-auto pt-4 flex flex-col gap-3">
                            <div class="flex items-center text-yellow-400 text-[10px]">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= round($article->rating_avg)) ⭐ @else ☆ @endif
                                @endfor
                                <span class="text-gray-400 ml-1 font-medium">({{ number_format($article->rating_avg, 1) }})</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}" class="w-6 h-6 rounded-full">
                                    <span class="text-[10px] font-medium text-gray-600 truncate max-w-[60px]">{{ $article->user->name ?? 'Admin' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400">
                                    <button class="hover:text-blue-500 transition-colors" title="Like"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg></button>
                                    <button class="hover:text-gold transition-colors" title="Bookmark"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg></button>
                                    <button class="hover:text-green-500 transition-colors" title="Download"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                                    <button class="hover:text-purple-500 transition-colors" title="Share"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- KNOWLEDGE TERPOPULER (💥 FIX: FIXED WIDTH UNTUK CAROUSEL) -->
    <section class="py-8 px-4 sm:px-8 max-w-7xl mx-auto border-t border-gray-100 scroll-hidden obs-element relative group section-carousel">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            <h2 class="text-2xl font-bold text-gray-900">Knowledge Terpopuler</h2>
        </div>
        <div class="relative px-4 sm:px-8">
            <button data-scroll-prev class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button data-scroll-next class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div data-scroll-container class="flex overflow-x-auto gap-6 scroll-smooth no-scrollbar py-2 flex-nowrap">
                @foreach($popularArticles as $article)
                @php
                    $thumbUrl = asset('images/placeholder-article.png');
                    if (!empty($article->thumbnail)) {
                        $thumbUrl = str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : \Illuminate\Support\Facades\Storage::url($article->thumbnail);
                    }
                @endphp
                {{-- 💥 FIX: Tambahkan w-[280px] sm:w-[260px] flex-shrink-0 agar tidak stretch --}}
                <a href="{{ route('document.detail', $article->slug ?? $article->id) }}" class="block w-[280px] sm:w-[260px] flex-shrink-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="h-32 bg-gray-200 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='{{ asset('images/placeholder-article.png') }}'">
                        <span class="absolute top-3 right-3 bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Populer</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded self-start">{{ $article->category->name ?? 'Umum' }}</span>
                        <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug group-hover:text-gold transition-colors">{{ $article->title }}</h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                        <div class="mt-auto pt-4 flex flex-col gap-3">
                            <div class="flex items-center text-yellow-400 text-[10px]">
                                @for($i=1; $i<=5; $i++) @if($i <= round($article->rating_avg)) ⭐ @else ☆ @endif @endfor
                                <span class="text-gray-400 ml-1 font-medium">({{ number_format($article->rating_avg, 1) }})</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}" class="w-6 h-6 rounded-full">
                                    <span class="text-[10px] font-medium text-gray-600 truncate max-w-[60px]">{{ $article->user->name ?? 'Admin' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400">
                                    <button class="hover:text-blue-500 transition-colors" title="Like"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- KNOWLEDGE TERBARU (💥 FIX: FIXED WIDTH UNTUK CAROUSEL) -->
    <section class="py-8 px-4 sm:px-8 max-w-7xl mx-auto border-t border-gray-100 scroll-hidden obs-element relative group section-carousel mb-10">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="text-2xl font-bold text-gray-900">Knowledge Terbaru</h2>
        </div>
        <div class="relative px-4 sm:px-8">
            <button data-scroll-prev class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button data-scroll-next class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 hidden sm:block transition-all duration-300 hover:scale-110 border border-gray-200">
                <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div data-scroll-container class="flex overflow-x-auto gap-6 scroll-smooth no-scrollbar py-2 flex-nowrap">
                @foreach($latestArticles as $article)
                @php
                    $thumbUrl = asset('images/placeholder-article.png');
                    if (!empty($article->thumbnail)) {
                        $thumbUrl = str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : \Illuminate\Support\Facades\Storage::url($article->thumbnail);
                    }
                @endphp
                {{-- 💥 FIX: Tambahkan w-[280px] sm:w-[260px] flex-shrink-0 agar tidak stretch --}}
                <a href="{{ route('document.detail', $article->slug ?? $article->id) }}" class="block w-[280px] sm:w-[260px] flex-shrink-0 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group">
                    <div class="h-32 bg-gray-200 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" onerror="this.src='{{ asset('images/placeholder-article.png') }}'">
                        <span class="absolute top-3 right-3 bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Baru</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded self-start">{{ $article->category->name ?? 'Umum' }}</span>
                        <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug group-hover:text-gold transition-colors">{{ $article->title }}</h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $article->excerpt }}</p>
                        <div class="mt-auto pt-4 flex flex-col gap-3">
                            <div class="flex items-center text-yellow-400 text-[10px]">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= round($article->rating_avg)) ⭐ @else ☆ @endif
                                @endfor
                                <span class="text-gray-400 ml-1 font-medium">({{ number_format($article->rating_avg, 1) }})</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                                <div class="flex items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name ?? 'Admin') }}" class="w-6 h-6 rounded-full">
                                    <span class="text-[10px] font-medium text-gray-600 truncate max-w-[60px]">{{ $article->user->name ?? 'Admin' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-400">
                                    <button class="hover:text-blue-500 transition-colors" title="Like"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TENTANG & TESTIMONIALS -->
    <section id="tentang" class="py-16 px-4 sm:px-8 max-w-7xl mx-auto scroll-mt-20">
        <div class="mb-10 scroll-hidden obs-element">
            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full mb-4">Community Voices</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">What Our Officials Say <br> About AKSARA</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 100ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Ratna+Dewi&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Dr. Hj. Ratna Dewi, M.Si.</h4><p class="text-[11px] text-gray-500">Kepala Dinas Kominfotik</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"AKSARA telah mentransformasi cara kami mengelola pengetahuan organisasi. SOP kini terpusat."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 200ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Ahmad Fauzi, S.E., M.M.</h4><p class="text-[11px] text-gray-500">Sekretaris Daerah Lampung</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"AKSARA menjadi tulang punggung manajemen pengetahuan yang transparan dan akuntabel."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 300ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Hendra+Gunawan&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Ir. Hendra Gunawan</h4><p class="text-[11px] text-gray-500">Kepala Bappeda Lampung</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Integrasi data sektoral melalui AKSARA memungkinkan perencanaan yang lebih evidence-based."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 400ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Lukman+Hakim&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Drs. Lukman Hakim, M.Pd.</h4><p class="text-[11px] text-gray-500">Kepala Dinas Pendidikan</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Platform ini sangat membantu dalam menyediakan referensi ajar dan administrasi pendidikan terpadu."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 500ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Siti+Aisyah&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Dra. Siti Aisyah, M.M.</h4><p class="text-[11px] text-gray-500">Kepala Biro Hukum</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Sangat membantu dalam proses harmonisasi regulasi daerah dan dokumentasi kebijakan hukum."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 600ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Irwan+Setiawan&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Irwan Setiawan, S.Kom., M.T.I.</h4><p class="text-[11px] text-gray-500">Ketua Bidang Aptika</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Infrastruktur digital dan tata kelola IT di Lampung semakin mantap berkat ekosistem AKSARA."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 700ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Agus+Widodo&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">Dr. H. Agus Widodo, M.M.</h4><p class="text-[11px] text-gray-500">Kepala BPKAD Lampung</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Transparansi pengelolaan keuangan daerah semakin terbuka dengan adanya integrasi data di AKSARA."</p></div>
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 800ms;"><div class="flex items-center gap-4 mb-4"><img src="https://ui-avatars.com/api/?name=Siti+Nurhayati&background=f3f4f6" class="w-12 h-12 rounded-full"><div><h4 class="font-bold text-gray-900 text-sm">dr. Hj. Siti Nurhayati, Sp.PD.</h4><p class="text-[11px] text-gray-500">Kepala Dinas Kesehatan</p></div></div><p class="text-gray-700 italic text-sm leading-relaxed">"Sistem ini mempermudah koordinasi data kesehatan antar puskesmas dan rumah sakit secara digital."</p></div>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="max-w-7xl mx-auto bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-100 mb-16 flex flex-col md:flex-row mt-8 scroll-mt-24 scroll-hidden obs-element mx-4 sm:mx-8">
        <div class="w-full md:w-1/2 bg-gray-800 text-white p-8 sm:p-12 relative overflow-hidden flex flex-col justify-end min-h-[250px] sm:min-h-[300px] group">
            <div class="absolute inset-0 bg-darkbg opacity-90 group-hover:scale-105 transition-transform duration-700"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold tracking-wider text-gray-300 mb-2 block">PORTAL AKSES</span>
                <h2 class="text-2xl sm:text-3xl font-bold">Siap Berkontribusi<br>untuk Lampung?</h2>
            </div>
        </div>
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center items-center text-center">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Masuk ke Portal<br>Internal AKSARA</h3>
            <p class="text-gray-500 text-sm mb-8 max-w-sm">Akses dashboard internal untuk mengelola dokumen, melakukan review, berkolaborasi dalam forum, dan berkontribusi.</p>
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                <a href="/login" class="bg-darkbg text-white px-6 py-3 sm:py-2 rounded-md font-medium text-sm hover:bg-gray-800 hover:-translate-y-1 transition-all duration-300 shadow-md">Portal Pegawai →</a>
                <a href="/login" class="border border-gray-300 text-gray-700 px-6 py-3 sm:py-2 rounded-md font-medium text-sm hover:bg-gray-50 hover:-translate-y-1 transition-all duration-300">Portal Admin ⚙</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-black text-white py-16">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12">
            <div class="col-span-1 sm:col-span-2 md:col-span-1 scroll-hidden obs-element" style="transition-delay: 100ms;">
                <div class="flex items-center gap-3 mb-4"><div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-black font-bold">A</div><span class="font-bold text-lg">AKSARA</span></div>
                <p class="text-gray-400 text-xs leading-relaxed">Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung.</p>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay: 200ms;">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Update terbaru seputar dokumen & kebijakan.</p>
                <div class="flex"><input type="text" placeholder="Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold transition-colors"><button class="bg-gold hover:bg-goldhover transition-colors px-3 py-2 rounded-r text-[#0B1120]">→</button></div>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay: 300ms;">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li><a href="#dokumen-publik" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="#statistik" class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Bantuan</a></li>
                </ul>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay: 400ms;">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2 cursor-default"><span>📍</span> Jl. Wolter Monginsidi No.5, Lampung</li>
                    <li class="flex gap-2 cursor-default"><span>📞</span> (0721) 486711</li>
                    <li class="flex gap-2 text-gold"><span>✉</span> aksara@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex flex-col sm:flex-row justify-between items-center gap-4 scroll-hidden obs-element" style="transition-delay: 500ms;">
            <p>&copy; 2026 AKSARA — Pemprov Lampung.</p>
            <div class="flex gap-4"><a href="#" class="hover:text-gold transition-all duration-300">F</a><a href="#" class="hover:text-gold transition-all duration-300">X</a><a href="#" class="hover:text-gold transition-all duration-300">IG</a></div>
        </div>
    </footer>

    <!-- AI CHAT BOT WIDGET -->
    <div class="fixed bottom-6 right-6 z-[100] flex flex-col items-end">
        <div id="ai-chat-window" class="bg-white w-80 sm:w-96 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden mb-4 transition-all duration-300 origin-bottom-right scale-0 opacity-0 hidden flex-col">
            <div class="bg-darkbg text-white p-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-gold rounded-lg flex items-center justify-center text-darkbg relative overflow-hidden">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4,8 C4,2 8,0 12,1 C16,-1 20,3 20,8" stroke="currentColor" fill="none"/><path d="M6,10 C6,6 9,4 12,5 C15,4 18,6 18,10" stroke="currentColor" fill="none"/><rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" fill="none"/><circle cx="9" cy="14" r="1.5" fill="currentColor"/><circle cx="15" cy="14" r="1.5" fill="currentColor"/></svg>
                </div>
                <div><h4 class="font-bold text-sm">Asisten Siger AI</h4><p class="text-[10px] text-gray-400">Terbatas pada basis pengetahuan</p></div>
            </div>
            <div id="ai-chat-body" class="p-4 bg-gray-50 flex-1 h-64 overflow-y-auto chat-scroll flex flex-col gap-4">
                <div class="flex gap-2 items-start">
                    <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1"><svg class="w-3 h-3 text-darkbg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg></div>
                    <div class="bg-white border border-gray-200 p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700">
                        Halo! Saya Asisten AI AKSARA. Saya hanya dapat menjawab pertanyaan seputar dokumentasi yang ada di database AKSARA. Ada yang bisa saya bantu?
                    </div>
                </div>
                <div id="ai-message-container"></div>
            </div>
            <div class="p-4 bg-white border-t border-gray-100 flex gap-2">
                <input id="ai-input" type="text" placeholder="Ketik pertanyaan anda..." class="flex-1 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm outline-none focus:border-gold transition-colors">
                <button id="ai-send-btn" class="bg-gold hover:bg-goldhover text-darkbg w-10 h-10 rounded-lg flex items-center justify-center transition-colors shadow-md">
                    <svg class="w-4 h-4 transform rotate-45 -mt-1 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </div>
        </div>

        <button id="ai-toggle-btn" class="w-16 h-16 bg-gold hover:bg-goldhover text-darkbg rounded-full flex items-center justify-center shadow-2xl hover:scale-110 transition-transform duration-300 relative group z-50">
            <svg id="robot-icon" class="w-9 h-9 absolute transition-opacity duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4,6 C4,2 8,0 12,1 C16,-1 20,3 20,6" stroke="currentColor" fill="none"/><path d="M6,8 C6,5 9,3 12,4 C15,3 18,5 18,8" stroke="currentColor" fill="none"/><path d="M10,8 C10,7 12,6 14,8" stroke="currentColor" fill="none"/><rect x="3" y="8" width="18" height="11" rx="3" stroke="currentColor" fill="none"/><circle cx="9" cy="13" r="2" stroke="currentColor" fill="none"/><circle cx="15" cy="13" r="2" stroke="currentColor" fill="none"/><circle class="pupil" cx="9" cy="13" r="1" fill="currentColor" stroke="none"/><circle class="pupil" cx="15" cy="13" r="1" fill="currentColor" stroke="none"/></svg>
            <svg id="close-icon" class="w-8 h-8 absolute opacity-0 scale-50 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span id="chat-badge" class="absolute top-0 right-0 w-4 h-4 bg-red-500 border-2 border-white rounded-full flex items-center justify-center text-[8px] text-white font-bold animate-pulse">1</span>
        </button>
    </div>

    <script>
        // Navbar scroll logic
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            const logoText = document.getElementById('logo-text');
            const navLinks = document.querySelectorAll('.nav-link');
            const loginBtn = document.getElementById('login-btn');
            if (window.scrollY > 50) {
                nav.classList.remove('bg-darkbg', 'border-gray-800');
                nav.classList.add('bg-white', 'border-gray-200', 'shadow-sm', 'bg-opacity-95', 'backdrop-blur-md');
                logoText.classList.remove('text-white'); logoText.classList.add('text-gray-900');
                navLinks.forEach(link => { link.classList.remove('text-white', 'text-gray-300'); link.classList.add('text-gray-600', 'hover:text-gray-900'); });
                if(loginBtn) { loginBtn.classList.remove('border-gray-600', 'text-gray-300', 'hover:text-white', 'hover:border-gray-400'); loginBtn.classList.add('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50'); }
            } else {
                nav.classList.add('bg-darkbg', 'border-gray-800');
                nav.classList.remove('bg-white', 'border-gray-200', 'shadow-sm', 'bg-opacity-95', 'backdrop-blur-md');
                logoText.classList.add('text-white'); logoText.classList.remove('text-gray-900');
                navLinks.forEach(link => { link.classList.add('text-gray-300'); link.classList.remove('text-gray-600', 'hover:text-gray-900'); });
                if(loginBtn) { loginBtn.classList.add('border-gray-600', 'text-gray-300', 'hover:text-white', 'hover:border-gray-400'); loginBtn.classList.remove('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50'); }
            }
        });

        // Scroll reveal logic
        document.addEventListener("DOMContentLoaded", function() {
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('scroll-visible');
                        entry.target.classList.remove('scroll-hidden');
                        observer.unobserve(entry.target); 
                    }
                });
            }, observerOptions);
            document.querySelectorAll('.obs-element').forEach((el) => { observer.observe(el); });

            const toggleBtn = document.getElementById('ai-toggle-btn');
            const chatWindow = document.getElementById('ai-chat-window');
            const robotIcon = document.getElementById('robot-icon');
            const closeIcon = document.getElementById('close-icon');
            const chatBadge = document.getElementById('chat-badge');
            const sendBtn = document.getElementById('ai-send-btn');
            const aiInput = document.getElementById('ai-input');
            const aiMessageContainer = document.getElementById('ai-message-container');
            let isChatOpen = false;

            toggleBtn.addEventListener('click', () => {
                isChatOpen = !isChatOpen;
                if(isChatOpen) {
                    chatWindow.classList.remove('hidden');
                    setTimeout(() => {
                        chatWindow.classList.remove('scale-0', 'opacity-0');
                        chatWindow.classList.add('scale-100', 'opacity-100');
                    }, 10);
                    robotIcon.classList.add('opacity-0', 'scale-50');
                    closeIcon.classList.remove('opacity-0', 'scale-50');
                    closeIcon.classList.add('opacity-100', 'scale-100');
                    if(chatBadge) chatBadge.classList.add('hidden');
                    toggleBtn.classList.remove('bg-gold');
                    toggleBtn.classList.add('bg-darkbg', 'text-white');
                } else {
                    chatWindow.classList.remove('scale-100', 'opacity-100');
                    chatWindow.classList.add('scale-0', 'opacity-0');
                    setTimeout(() => { chatWindow.classList.add('hidden'); }, 300);
                    robotIcon.classList.remove('opacity-0', 'scale-50');
                    robotIcon.classList.add('opacity-100', 'scale-100');
                    closeIcon.classList.remove('opacity-100', 'scale-100');
                    closeIcon.classList.add('opacity-0', 'scale-50');
                    toggleBtn.classList.remove('bg-darkbg', 'text-white');
                    toggleBtn.classList.add('bg-gold');
                }
            });

            async function sendMessage() {
                const message = aiInput.value.trim();
                if (!message) return;

                const userBubble = document.createElement('div');
                userBubble.className = 'flex justify-end mt-2';
                userBubble.innerHTML = `<div class="bg-gold text-darkbg p-3 rounded-2xl rounded-tr-none shadow-sm text-sm max-w-[80%]">${message}</div>`;
                aiMessageContainer.appendChild(userBubble);
                aiInput.value = '';
                document.getElementById('ai-chat-body').scrollTop = document.getElementById('ai-chat-body').scrollHeight;

                try {
                    const response = await fetch('/api/ai/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: message })
                    });

                    const data = await response.json();
                    
                    const aiBubble = document.createElement('div');
                    aiBubble.className = 'flex gap-2 items-start mt-3';
                    aiBubble.innerHTML = `
                        <div class="w-6 h-6 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1"><svg class="w-3 h-3 text-darkbg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg></div>
                        <div class="bg-white border border-gray-200 p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 whitespace-pre-line max-w-[80%]">${data.reply}</div>
                    `;
                    aiMessageContainer.appendChild(aiBubble);
                    document.getElementById('ai-chat-body').scrollTop = document.getElementById('ai-chat-body').scrollHeight;

                } catch (error) {
                    const aiBubble = document.createElement('div');
                    aiBubble.className = 'flex gap-2 items-start mt-3';
                    aiBubble.innerHTML = `<div class="bg-white border border-red-200 p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-red-600 max-w-[80%]">Maaf, terjadi kesalahan koneksi AI.</div>`;
                    aiMessageContainer.appendChild(aiBubble);
                }
            }

            sendBtn.addEventListener('click', sendMessage);
            aiInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') sendMessage();
            });
        });
    </script>
</body>
</html>