<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base - AKSARA | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0F172A', darkerbg: '#0B1120',
                        gold: '#EAB308',   goldhover: '#CA8A04',
                        lightbg: '#F8FAFC', cardborder: '#E2E8F0'
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: { 'fade-in-up': 'fadeInUp 0.8s ease-out forwards' },
                    keyframes: {
                        fadeInUp: {
                            '0%':   { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .scroll-hidden  { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4,0,0.2,1); }
        .scroll-visible { opacity: 1; transform: translateY(0); }
        .article-thumb { width: 100%; height: 100%; object-fit: cover; object-position: center; }
        .star-filled { color: #EAB308; }
        .star-empty { color: #D1D5DB; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-lightbg overflow-x-hidden">

    {{-- ══════════════ NAVBAR ══════════════ --}}
    <nav id="navbar" class="bg-darkbg text-gray-300 py-4 px-8 flex justify-between items-center border-b border-gray-800 sticky top-0 z-50 transition-all duration-300">
        <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold transition-transform duration-300 group-hover:scale-110">A</div>
            <div class="flex flex-col">
                <span id="logo-text" class="font-bold text-white leading-tight transition-colors duration-300">AKSARA</span>
                <span class="text-[10px] text-gray-400">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-sm">
            <a href="/#beranda"        class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Beranda</a>
            <a href="/knowledge-base"  id="active-link" class="text-white font-semibold underline decoration-gold underline-offset-4">Knowledge Base</a>
            <a href="/#dokumen-publik" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Dokumen Publik</a>
            <a href="/#statistik"      class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Statistik</a>
            <a href="/#tentang"        class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Tentang</a>
            <a href="/#kontak"         class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Kontak</a>
        </div>

        {{-- AUTH --}}
        <div>
            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white hover:text-gold transition-colors duration-300 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ? (str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : Storage::url(Auth::user()->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=EAB308&color=0f172a' }}"
                             alt="Avatar"
                             class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-gold transition-all duration-300 object-cover">
                        <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200
                                transform origin-top-right group-hover:scale-100 scale-95 z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('user.profil') }}"
                               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block border-t border-gray-100">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-3 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" id="login-btn"
                   class="bg-white/10 border border-gray-600 text-white hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login Portal
                </a>
            @endauth
        </div>
    </nav>

    {{-- ══════════════ HERO SEARCH ══════════════ --}}
    <section class="bg-darkbg text-center py-20 px-8 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-gold rounded-full mix-blend-multiply filter blur-[100px]"></div>
            <div class="absolute top-1/2 right-0 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-[100px]"></div>
        </div>
        <div class="max-w-3xl mx-auto relative z-10">
            <div class="inline-flex items-center gap-2 border border-gold/30 bg-gold/10 text-gold px-4 py-1.5 rounded-full text-xs font-semibold mb-6 opacity-0 animate-fade-in-up" style="animation-delay:.1s">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>KNOWLEDGE BASE AKSARA</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6 opacity-0 animate-fade-in-up" style="animation-delay:.3s">
                Find documentation, tutorials, and system guides
            </h1>
            <p class="text-gray-400 text-base mb-10 max-w-2xl mx-auto opacity-0 animate-fade-in-up" style="animation-delay:.5s">
                Akses dokumentasi teknis, tutorial langkah-demi-langkah, dan panduan terbaik untuk developer dan profesional IT.
            </p>

            {{-- Search Form --}}
            <form action="{{ route('knowledge-base') }}" method="GET"
                  class="relative max-w-2xl mx-auto mb-6 opacity-0 animate-fade-in-up group" style="animation-delay:.7s">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gold transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari artikel, kata kunci, atau topik..."
                       class="w-full bg-white text-gray-900 rounded-lg py-4 pl-12 pr-4 outline-none focus:ring-2 focus:ring-gold shadow-[0_4px_20px_rgba(0,0,0,0.3)] transition-all duration-300">
            </form>

            <div class="flex flex-wrap justify-center items-center gap-3 text-sm opacity-0 animate-fade-in-up" style="animation-delay:.9s">
                <span class="text-gray-500">Populer:</span>
                @foreach(['Docker','Kubernetes','OWASP','VLAN','NGINX'] as $tag)
                    <a href="{{ route('knowledge-base', ['search' => $tag]) }}"
                       class="bg-white/5 border border-gray-700 text-gray-300 hover:text-darkbg hover:bg-gold hover:border-gold px-3 py-1 rounded-full transition-all duration-300">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════ MAIN CONTENT ══════════════ --}}
    <div class="max-w-7xl mx-auto px-8 py-12 flex flex-col md:flex-row gap-10">

        {{-- ── SIDEBAR ── --}}
        <aside class="w-full md:w-1/4 scroll-hidden obs-element" style="transition-delay:100ms">

            {{-- Kategori --}}
            <div class="bg-white rounded-xl border border-cardborder p-4 mb-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                <h3 class="text-xs font-bold text-gray-500 tracking-wider mb-4 px-2">CATEGORIES</h3>
                <ul class="space-y-1">
                    {{-- All Topics --}}
                    <li>
                        <a href="{{ route('knowledge-base') }}"
                           class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium
                                  {{ !request()->anyFilled(['search','category']) ? 'bg-darkbg text-white' : 'hover:bg-gray-50 text-gray-700' }}
                                  group transition-all duration-200">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ !request()->anyFilled(['search','category']) ? 'text-gold' : 'text-gray-400 group-hover:text-gold' }} transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span>All Topics</span>
                            </div>
                            <span class="{{ !request()->anyFilled(['search','category']) ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }} text-[10px] font-bold px-2 py-0.5 rounded-full">
                                {{ $totalArticles }}
                            </span>
                        </a>
                    </li>

                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('knowledge-base', ['category' => $category->name]) }}"
                           class="flex justify-between items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                                  {{ request('category') === $category->name ? 'bg-gold/10 text-gold font-semibold' : 'hover:bg-gray-50 text-gray-700 hover:translate-x-1' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ request('category') === $category->name ? 'text-gold' : 'text-gray-400 group-hover:text-gold' }} transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                                <span>{{ $category->name }}</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full group-hover:bg-gold/20 group-hover:text-gold transition-colors">
                                {{ $category->articles_count ?? 0 }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contribute Box --}}
            <div class="bg-[#FFFBEB] rounded-xl border border-yellow-200 p-6 flex flex-col items-start hover:shadow-lg transition-shadow duration-300">
                <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center text-white mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Contribute</h3>
                <p class="text-xs text-gray-600 mb-6 leading-relaxed">Share your knowledge with the community. Submit tutorials and guides.</p>
                @auth
                    <a href="{{ route('staff.editor') }}"
                       class="w-full bg-gold hover:bg-goldhover text-darkbg hover:text-white font-bold py-2.5 rounded-lg text-sm transition-colors duration-300 shadow-sm hover:shadow-md text-center block">
                        Submit Article
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="w-full bg-gold hover:bg-goldhover text-darkbg hover:text-white font-bold py-2.5 rounded-lg text-sm transition-colors duration-300 shadow-sm hover:shadow-md text-center block">
                        Login to Submit
                    </a>
                @endauth
            </div>
        </aside>

        {{-- ── MAIN ── --}}
        <main class="w-full md:w-3/4">

            {{-- Filter info bar --}}
            <div class="flex justify-between items-center mb-6 scroll-hidden obs-element" style="transition-delay:200ms">
                <p class="text-sm text-gray-600">
                    Menampilkan
                    <span class="font-bold text-gray-900">{{ $articles->count() }}</span>
                    dari
                    <span class="font-bold text-gray-900">{{ $articles->total() }}</span>
                    artikel
                    @if(request('category'))
                        <span class="text-xs text-gray-400 ml-2">
                            (Filter: <span class="font-semibold text-gray-700">{{ request('category') }}</span>)
                        </span>
                    @endif
                    @if(request('search'))
                        <span class="text-xs text-gray-400 ml-2">
                            (Pencarian: "<span class="font-semibold text-gray-700">{{ request('search') }}</span>")
                        </span>
                    @endif
                </p>
                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('knowledge-base') }}" class="text-xs text-blue-600 hover:underline">Reset Filter</a>
                @endif
            </div>

            {{-- ══ GRID KARTU ARTIKEL ══ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($articles as $article)
                @php
                    // Build Thumbnail URL aman tanpa accessor
                    $thumbUrl = asset('images/placeholder-article.png');
                    if (!empty($article->thumbnail)) {
                        $thumbUrl = str_starts_with($article->thumbnail, 'http') 
                            ? $article->thumbnail 
                            : Storage::url($article->thumbnail);
                    }

                    // Author Avatar URL aman
                    $authorAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name ?? 'A') . '&background=bfdbfe&color=1e3a8a&size=32';
                    if ($article->user && !empty($article->user->avatar)) {
                        $authorAvatar = str_starts_with($article->user->avatar, 'http') 
                            ? $article->user->avatar 
                            : Storage::url($article->user->avatar);
                    }

                    // Kategori
                    $catName = $article->category->name ?? $article->getRawOriginal('category') ?? 'Umum';
                    
                    // Rating rata-rata (Langsung ambil dari kolom database)
                    $avgRating = $article->rating_avg ?? 0;

                    // Tambahan: Mapping warna badge untuk Visibilitas
                    $visClass = 'bg-gray-500 text-white';
                    $visLabel = $article->visibility ?? 'public';
                    if ($article->visibility === 'public') {
                        $visClass = 'bg-green-600 text-white';
                    } elseif ($article->visibility === 'internal') {
                        $visClass = 'bg-blue-600 text-white';
                    } elseif ($article->visibility === 'private') {
                        $visClass = 'bg-red-600 text-white';
                    }
                @endphp

                <a href="{{ route('document.detail', $article->slug) }}"
                   class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col cursor-pointer scroll-hidden obs-element"
                   style="transition-delay: {{ ($loop->index % 3 + 1) * 100 }}ms">

                    {{-- Thumbnail --}}
                    <div class="relative h-44 bg-gray-100 overflow-hidden group flex-shrink-0">
                        <img
                            src="{{ $thumbUrl }}"
                            alt="{{ $article->title }}"
                            class="article-thumb group-hover:scale-110 transition-transform duration-700"
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder-article.png') }}';"
                            loading="lazy"
                        >
                        {{-- Badge kategori --}}
                        <span class="absolute top-3 left-3 bg-yellow-100/90 backdrop-blur-sm text-yellow-800 text-[10px] font-bold px-2 py-1 rounded">
                            {{ $catName }}
                        </span>

                        {{-- ✨ BADGE BARU: Badge Visibilitas (Public/Internal/Private) --}}
                        <span class="absolute top-3 right-3 {{ $visClass }} text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm uppercase">
                            {{ ucfirst($visLabel) }}
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2 hover:text-gold transition-colors duration-300 line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mb-4 line-clamp-2">
                            {{ $article->excerpt ?? 'Deskripsi tidak tersedia.' }}
                        </p>

                        <div class="mt-auto flex flex-col gap-3">
                            {{-- Author & Read time --}}
                            <div class="flex items-center justify-between text-[11px] text-gray-400 font-medium">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $authorAvatar }}"
                                         alt="{{ $article->user->name ?? 'Author' }}"
                                         class="w-5 h-5 rounded-full object-cover"
                                         onerror="this.src='https://ui-avatars.com/api/?name=A&background=bfdbfe&color=1e3a8a&size=32'">
                                    <span>{{ $article->user->name ?? 'Admin' }}</span>
                                </div>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $article->estimated_read_time ?? 5 }} min
                                </span>
                            </div>

                            {{-- Action Bar (Menggunakan kolom integer langsung dari tabel) --}}
                            <div class="flex flex-wrap items-center justify-between pt-3 border-t border-gray-100 text-[11px] text-gray-400 gap-2">
                                <div class="flex items-center gap-3 flex-wrap">
                                    {{-- Like (Diambil dari kolom `likes`) --}}
                                    <span class="flex items-center gap-1 cursor-default">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        <span>{{ $article->likes ?? 0 }}</span>
                                    </span>

                                    {{-- Rating (Diambil dari kolom `rating_avg`) --}}
                                    <div class="flex items-center gap-0.5 text-[10px]">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= round($avgRating) ? 'star-filled' : 'star-empty' }}">★</span>
                                        @endfor
                                        <span class="text-gray-400 ml-1">({{ number_format($avgRating, 1) }})</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- Views --}}
                                    <span class="flex items-center gap-1 cursor-default">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $article->views ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                @empty
                <div class="col-span-full text-center py-20 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium">Tidak ada artikel yang ditemukan.</p>
                    @if(request()->anyFilled(['search','category']))
                        <a href="{{ route('knowledge-base') }}" class="text-sm text-blue-500 hover:underline mt-2 inline-block">Lihat semua artikel</a>
                    @else
                        <div class="text-xs text-gray-400 mt-1 max-w-md mx-auto bg-gray-50 p-4 rounded-lg border border-gray-200 text-left">
                            <p class="text-red-500 font-semibold mb-1">💡 Kenapa ini kosong?</p>
                            <p class="mb-2">
                                Artikel Anda di Dashboard Staff mungkin sudah berstatus <b>"Published"</b>, namun kolom <b><i>Tanggal Publikasi</i></b> (published_at) kemungkinan masih kosong (NULL). 
                                <br><br>
                                <b>Solusi:</b> Edit artikel Anda di Dashboard Staff, isi kolom <i>"Tanggal Publikasi"</i> dengan tanggal hari ini, lalu klik simpan. Artikel akan langsung muncul di sini!
                            </p>
                            <div class="mt-2 text-center">
                                <a href="{{ route('staff.articles') }}" class="inline-block bg-gold text-darkbg font-bold py-1.5 px-4 rounded-lg text-xs shadow hover:bg-goldhover transition-colors">
                                    Buka Dashboard Staff →
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12 text-center scroll-hidden obs-element" style="transition-delay:400ms">
                {{ $articles->links() }}
            </div>
        </main>
    </div>

    {{-- ══════════════ FOOTER ══════════════ --}}
    <footer class="bg-[#0B1120] text-white py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 scroll-hidden obs-element" style="transition-delay:100ms">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-[#0B1120] font-bold">A</div>
                    <span class="font-bold text-lg">AKSARA</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">
                    Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung.
                    Platform manajemen pengetahuan terintegrasi untuk tata kelola pemerintahan yang cerdas dan transparan.
                </p>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay:200ms">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Dapatkan update terbaru seputar dokumen dan kebijakan.</p>
                <div class="flex">
                    <input type="email" placeholder="Alamat Email"
                           class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold transition-colors">
                    <button class="bg-gold hover:bg-goldhover transition-colors px-3 py-2 rounded-r text-[#0B1120]">→</button>
                </div>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay:300ms">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li><a href="/#dokumen-publik" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="/#statistik"      class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#"                class="hover:text-gold transition">Kebijakan Privasi</a></li>
                    <li><a href="#"                class="hover:text-gold transition">Syarat & Ketentuan</a></li>
                    <li><a href="#"                class="hover:text-gold transition">Bantuan</a></li>
                </ul>
            </div>
            <div class="scroll-hidden obs-element" style="transition-delay:400ms">
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2"><span>📍</span> Jl. Wolter Monginsidi No.5, Bandar Lampung 35213</li>
                    <li class="flex gap-2"><span>📞</span> (0721) 486711</li>
                    <li class="flex gap-2 text-gold"><span>✉</span> aksara@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex justify-between items-center">
            <p>&copy; 2026 AKSARA — Pemerintah Provinsi Lampung. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">F</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">X</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">IG</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">YT</a>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll color change
        window.addEventListener('scroll', function () {
            const nav      = document.getElementById('navbar');
            const logoText = document.getElementById('logo-text');
            const navLinks = document.querySelectorAll('.nav-link');
            const active   = document.getElementById('active-link');
            const loginBtn = document.getElementById('login-btn');

            if (window.scrollY > 50) {
                nav.classList.replace('bg-darkbg','bg-white');
                nav.classList.add('shadow-sm');
                logoText.classList.replace('text-white','text-gray-900');
                active.classList.replace('text-white','text-gray-900');
                navLinks.forEach(l => { l.classList.replace('text-gray-300','text-gray-600'); });
                if (loginBtn) {
                    loginBtn.classList.remove('bg-white/10','border-gray-600','text-white');
                    loginBtn.classList.add('border-gray-300','text-gray-700');
                }
            } else {
                nav.classList.replace('bg-white','bg-darkbg');
                nav.classList.remove('shadow-sm');
                logoText.classList.replace('text-gray-900','text-white');
                active.classList.replace('text-gray-900','text-white');
                navLinks.forEach(l => { l.classList.replace('text-gray-600','text-gray-300'); });
                if (loginBtn) {
                    loginBtn.classList.add('bg-white/10','border-gray-600','text-white');
                    loginBtn.classList.remove('border-gray-300','text-gray-700');
                }
            }
        });

        // Scroll reveal animation
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver(
                (entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('scroll-visible');
                            entry.target.classList.remove('scroll-hidden');
                            obs.unobserve(entry.target);
                        }
                    });
                },
                { root: null, rootMargin: '0px', threshold: 0.1 }
            );
            document.querySelectorAll('.obs-element').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>