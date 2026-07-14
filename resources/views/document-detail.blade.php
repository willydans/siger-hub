<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - SIGER-Hub</title>
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
                        cardborder: '#E5E7EB',
                        textmain: '#374151',
                        navy: '#0F172A'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['Fira Code', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', "Liberation Mono", "Courier New", 'monospace'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .like-active { transform: scale(1.2); transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .bookmark-active { transform: rotate(10deg); transition: transform 0.2s ease-in-out; }
        .fade-in-new-comment { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-white">

    <!-- NAVBAR (Dinamis: Guest vs Auth) -->
    <nav class="bg-white text-gray-800 py-4 px-8 flex justify-between items-center border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-gray-900 leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gray-500">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-sm">
            <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Beranda</a>
            <a href="/knowledge-base" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Knowledge Base</a>
            <a href="#" class="text-gray-900 font-bold transition-colors duration-300">Dokumen Publik</a>
            <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Statistik</a>
            <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Tentang</a>
        </div>
        
        <div>
            @auth
                <!-- Tampilan Login: User Profil Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-700 hover:text-navy transition-colors duration-300 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=f3f4f6&color=333' }}" 
                             alt="Avatar" 
                             class="w-8 h-8 rounded-full border border-gray-200 group-hover:border-gold transition-all duration-300">
                        <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Dropdown Menu -->
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
                <!-- Tampilan Guest (Belum Login) -->
                <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Login Portal
                </a>
            @endauth
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="max-w-[1400px] mx-auto px-8 py-8 flex flex-col lg:flex-row gap-12">
        
        <!-- LEFT COLUMN (Main Document Content) -->
        <main class="w-full lg:w-2/3 xl:w-[70%]">
            
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home.public') }}" class="hover:text-gray-900 transition hover:underline underline-offset-4">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <a href="{{ route('knowledge-base') }}" class="hover:text-gray-900 transition hover:underline underline-offset-4">Public Directory</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="hover:text-gray-900 transition cursor-pointer">{{ $article->category->name ?? 'Umum' }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-gray-900 font-medium truncate max-w-[150px]">{{ $article->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Document Header -->
            <div class="mb-6 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-yellow-100 text-yellow-800 text-[11px] font-bold px-2.5 py-1 rounded">{{ $article->category->name ?? 'Dokumen' }}</span>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded">{{ ucfirst($article->status) }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name ?? 'Admin') . '&background=cbd5e1&color=374151' }}" alt="Author Avatar" class="w-10 h-10 rounded-full border border-gray-200">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-[13px]">{{ $article->user->name ?? 'Admin' }}</span>
                                    <a href="#" class="inline-flex items-center gap-1 text-[11px] text-navy bg-blue-50 hover:bg-blue-100 transition-colors duration-200 px-2 py-0.5 rounded-full border border-blue-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Profil
                                    </a>
                                </div>
                                <span class="text-[11px]">{{ $article->user->position ?? 'Kontributor' }}</span>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>{{ number_format($article->views) }} Views</span>
                        </div>
                    </div>
                </div>

                <!-- ACTION BAR: Bookmark, Like, Rating, Share -->
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-3 sm:gap-4">
                    
                    @auth
                        <!-- 1. BOOKMARK (Hanya untuk Login) -->
                        <button id="btn-bookmark" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-gold">
                            <svg id="icon-bookmark" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            <span class="text-xs font-medium hidden sm:inline">Bookmark</span>
                        </button>

                        <!-- 2. LIKE (Hanya untuk Login) -->
                        <button id="btn-like" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-red-300">
                            <svg id="icon-like" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            <span id="like-count" class="text-xs font-medium">{{ $article->likes_count ?? 0 }}</span>
                        </button>

                        <!-- 3. RATING BINTANG (Hanya untuk Login) -->
                        <div class="flex items-center gap-1 px-3 py-1.5 rounded-full border border-gray-200 bg-white">
                            <span class="text-[10px] font-medium text-gray-400 mr-1">Beri Rating:</span>
                            <div class="flex">
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="1">☆</button>
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="2">☆</button>
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="3">☆</button>
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="4">☆</button>
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="5">☆</button>
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ number_format($article->rating_avg, 1) }})</span>
                        </div>
                    @else
                        <!-- INFO UNTUK GUEST -->
                        <div class="flex items-center gap-2 text-sm text-gray-400 py-1 px-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <a href="{{ route('login') }}" class="text-navy font-bold hover:underline">Login</a> untuk menyukai, memberi rating, atau menyimpan dokumen ini.
                        </div>
                    @endauth

                    <!-- 4. SHARE (Tetap bisa diakses semua orang) -->
                    <div class="relative group/share inline-block">
                        <button id="btn-share" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            <span class="text-xs font-medium hidden sm:inline">Bagikan</span>
                        </button>
                        <!-- Tooltip Share Popup -->
                        <div class="absolute right-0 top-full mt-2 w-max bg-white border border-gray-200 rounded-lg shadow-xl p-3 hidden group-hover/share:block z-20 transition-opacity duration-200">
                            <p class="text-xs font-medium text-gray-500 mb-2">Salin tautan:</p>
                            <div class="flex items-center gap-2 bg-gray-50 rounded border border-gray-200 px-2 py-1">
                                <input id="share-url-input" type="text" value="{{ url()->current() }}" readonly class="bg-transparent border-none text-xs text-gray-700 w-48 outline-none p-0">
                                <button onclick="copyShareLink()" class="bg-navy hover:bg-gray-800 text-white text-[10px] px-2 py-1 rounded transition-colors">Salin</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- AI Summary Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-10 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center gap-2 mb-3">
                    <div class="bg-gold text-white p-1 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">AI Document Summary</h3>
                </div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ Str::limit(strip_tags($article->content), 300) }}
                </p>
            </div>

            <!-- Document Content Body -->
            <article class="prose prose-gray max-w-none text-[15px] leading-loose">
                {!! $article->content !!}
            </article>

            <!-- BAGIAN KOMENTAR -->
            <section class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Komentar <span class="text-sm font-normal text-gray-400 ml-2">({{ $comments->count() }})</span></h3>
                </div>

                <!-- Form Komentar (Hanya bisa dikirim jika login) -->
                @auth
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=f3f4f6' }}" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                    <div class="flex-1 flex flex-col gap-3">
                        <textarea id="comment-input" placeholder="Tulis komentar Anda tentang SOP ini..." class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent transition-all duration-300 h-20 bg-white shadow-sm"></textarea>
                        <div class="flex justify-end">
                            <button id="btn-submit-comment" class="bg-navy hover:bg-gray-800 text-white text-sm font-medium px-5 py-2 rounded-full transition-all duration-300 shadow-sm hover:shadow-md hover:scale-105 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Komentar
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 text-center mb-8">
                    <p class="text-sm text-gray-600">Silakan <a href="{{ route('login') }}" class="text-navy font-semibold hover:underline">Login</a> untuk memberikan komentar.</p>
                </div>
                @endauth

                <!-- List Komentar Dinamis -->
                <div id="comment-list" class="space-y-6">
                    @forelse($comments as $comment)
                    <div class="flex gap-4">
                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name ?? 'Anon') . '&background=d1fae5&color=065f46' }}" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-gray-900 text-sm">{{ $comment->user->name ?? 'Pengguna' }}</span>
                                <span class="text-[11px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $comment->content }}</p>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                
                                @auth
                                    <!-- LIKE PADA KOMENTAR (Hanya jika Login) -->
                                    <button class="hover:text-navy transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                        {{ $comment->likes }}
                                    </button>
                                @else
                                    <!-- LIKE STATIS (Jika Guest) -->
                                    <span class="text-gray-400">
                                        <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                        {{ $comment->likes }}
                                    </span>
                                @endauth

                                <button class="hover:text-navy transition-colors">Balas</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic text-center py-6">Belum ada komentar untuk artikel ini. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>

        </main>

        <!-- RIGHT COLUMN (Sticky Sidebar / Metadata) -->
        <aside class="w-full lg:w-1/3 xl:w-[30%]">
            <div class="sticky top-24 space-y-6">
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button class="w-full bg-navy hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </button>
                    <button class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                        Print Document
                    </button>
                </div>

                <!-- Document Details Card -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Document Details</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">DOCUMENT ID</span>
                            <span class="font-semibold text-gray-900 text-sm">{{ $article->sop_code ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">CURRENT VERSION</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $article->version ?? 'v1.0' }}</span>
                        </div>
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">LAST UPDATED</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $article->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Version History Card (Timeline) -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-5">Version History</h3>
                    <div class="relative border-l border-gray-200 ml-2 space-y-6">
                        @forelse($revisions as $revision)
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-gray-300 ring-4 ring-white"></span>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-900 text-sm">v{{ $revision->version ?? '1.0' }}</span>
                            </div>
                            <p class="text-xs text-gray-700 mb-1">{{ $revision->revision_notes ?? 'Dokumen diperbarui' }}</p>
                            <span class="text-[11px] text-gray-400">{{ $revision->created_at->format('d M Y') }}</span>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 pl-5">Belum ada riwayat revisi.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Related Documents Card -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Related Documents</h3>
                    <ul class="space-y-3">
                        @forelse($relatedArticles as $related)
                        <li>
                            <a href="{{ route('document.detail', $related->slug) }}" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight group-hover:underline underline-offset-2">{{ $related->title }}</span>
                            </a>
                        </li>
                        @empty
                        <li class="text-xs text-gray-500">Tidak ada dokumen terkait.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </aside>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#0B1120] text-white py-16 mt-12 border-t border-gray-800">
        <div class="max-w-[1400px] mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-[#0B1120] font-bold">S</div>
                    <span class="font-bold text-lg">SIGER-Hub</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung.</p>
            </div>
            
            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Dapatkan update terbaru seputar dokumen dan kebijakan.</p>
                <div class="flex">
                    <input type="text" placeholder="Alamat Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold transition-colors">
                    <button class="bg-gold hover:bg-goldhover px-3 py-2 rounded-r text-[#0B1120] transition-colors">→</button>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li><a href="#" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2"><span>📍</span> Jl. Wolter Monginsidi No.5, Bandar Lampung</li>
                    <li class="flex gap-2"><span>✉</span> sigerhub@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-[1400px] mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex justify-between items-center">
            <p>&copy; 2026 SIGER-Hub — Pemerintah Provinsi Lampung.</p>
        </div>
    </footer>

    <!-- SCRIPT INTERAKTIF -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. BOOKMARK
            const bookmarkBtn = document.getElementById('btn-bookmark');
            const bookmarkIcon = document.getElementById('icon-bookmark');
            if(bookmarkBtn) {
                let isBookmarked = false;
                bookmarkBtn.addEventListener('click', function() {
                    isBookmarked = !isBookmarked;
                    if(isBookmarked) {
                        bookmarkIcon.setAttribute('fill', '#EAB308');
                        bookmarkIcon.setAttribute('stroke', '#EAB308');
                        bookmarkIcon.classList.add('bookmark-active');
                        setTimeout(() => { bookmarkIcon.classList.remove('bookmark-active'); }, 300);
                        bookmarkBtn.querySelector('span').textContent = 'Disimpan';
                        bookmarkBtn.classList.add('border-gold', 'bg-yellow-50');
                    } else {
                        bookmarkIcon.setAttribute('fill', 'none');
                        bookmarkIcon.setAttribute('stroke', 'currentColor');
                        bookmarkBtn.querySelector('span').textContent = 'Bookmark';
                        bookmarkBtn.classList.remove('border-gold', 'bg-yellow-50');
                    }
                });
            }

            // 2. LIKE
            const likeBtn = document.getElementById('btn-like');
            const likeIcon = document.getElementById('icon-like');
            const likeCount = document.getElementById('like-count');
            if(likeBtn) {
                let isLiked = false;
                likeBtn.addEventListener('click', function() {
                    isLiked = !isLiked;
                    let count = parseInt(likeCount.textContent);
                    if(isLiked) {
                        likeIcon.setAttribute('fill', '#EF4444');
                        likeIcon.setAttribute('stroke', '#EF4444');
                        likeIcon.classList.add('like-active');
                        likeBtn.classList.add('border-red-300', 'bg-red-50');
                        count++;
                        setTimeout(() => { likeIcon.classList.remove('like-active'); }, 300);
                    } else {
                        likeIcon.setAttribute('fill', 'none');
                        likeIcon.setAttribute('stroke', 'currentColor');
                        likeBtn.classList.remove('border-red-300', 'bg-red-50');
                        count--;
                    }
                    likeCount.textContent = count;
                });
            }

            // 3. RATING BINTANG
            const stars = document.querySelectorAll('.star-rating');
            if(stars.length > 0) {
                let currentRating = 0;
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.getAttribute('data-value'));
                        currentRating = (currentRating === val) ? 0 : val;
                        updateStars();
                    });
                    star.addEventListener('mouseenter', function() {
                        const val = parseInt(this.getAttribute('data-value'));
                        highlightStars(val);
                    });
                    star.addEventListener('mouseleave', function() {
                        highlightStars(currentRating);
                    });
                });
                function updateStars() {
                    stars.forEach(s => {
                        const val = parseInt(s.getAttribute('data-value'));
                        if(val <= currentRating) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                            s.textContent = '★';
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                            s.textContent = '☆';
                        }
                    });
                }
                function highlightStars(val) {
                    stars.forEach(s => {
                        const starVal = parseInt(s.getAttribute('data-value'));
                        if(starVal <= val) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                            s.textContent = '★';
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                            s.textContent = '☆';
                        }
                    });
                    if(val === 0) {
                        stars.forEach(s => s.classList.remove('text-yellow-400'));
                    }
                }
            }

            // 4. FITUR SHARE COPY LINK
            window.copyShareLink = function() {
                const input = document.getElementById('share-url-input');
                input.select();
                input.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(input.value).then(() => {
                    const btn = input.nextElementSibling;
                    const originalText = btn.textContent;
                    btn.textContent = 'Tersalin!';
                    btn.classList.add('bg-green-500');
                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.classList.remove('bg-green-500');
                    }, 2000);
                }).catch(err => {
                    console.error('Gagal menyalin', err);
                });
            }

            // 5. FITUR KOMENTAR
            const submitBtn = document.getElementById('btn-submit-comment');
            const commentInput = document.getElementById('comment-input');
            const commentList = document.getElementById('comment-list');

            if(submitBtn) {
                submitBtn.addEventListener('click', function() {
                    const text = commentInput.value.trim();
                    if(text) {
                        const now = new Date();
                        const timeString = "Baru saja";
                        
                        const newCommentHTML = `
                            <div class="flex gap-4 fade-in-new-comment">
                                <img src="https://ui-avatars.com/api/?name=Anda&background=ffffff&color=333" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900 text-sm">Anda</span>
                                        <span class="text-[11px] text-gray-400">${timeString}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">${text}</p>
                                    <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                        <button class="hover:text-navy transition-colors flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                            0
                                        </button>
                                        <button class="hover:text-navy transition-colors">Balas</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        commentList.insertAdjacentHTML('afterbegin', newCommentHTML);
                        commentInput.value = '';
                        commentInput.style.height = '5rem';
                        
                        // Update comment count
                        const countSpan = document.querySelector('h3 span');
                        let currentCount = parseInt(countSpan.textContent.replace(/[^0-9]/g, ''));
                        countSpan.textContent = `(${currentCount + 1})`;
                    } else {
                        commentInput.classList.add('border-red-300');
                        setTimeout(() => commentInput.classList.remove('border-red-300'), 2000);
                    }
                });
            }
        });
    </script>
</body>
</html>