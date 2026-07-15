<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title ?? 'Dokumen' }} - SIGER-Hub</title>
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

        /* Print */
        @media print {
            #navbar, #right-sidebar, #action-bar, #comment-section, #ai-toggle-btn, #footer, #feedback-modal { display: none !important; }
            main { width: 100% !important; }
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-white">

    <!-- NAVBAR -->
    <nav id="navbar" class="bg-white text-gray-800 py-4 px-8 flex justify-between items-center border-b border-gray-200 sticky top-0 z-50 shadow-sm">
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
                <div class="relative group">
                    <button class="flex items-center gap-2 text-gray-700 hover:text-navy transition-colors duration-300 focus:outline-none">
                        {{-- ✅ PERBAIKAN 1: Gunakan optional() untuk Auth user di Navbar --}}
                        <img src="{{ optional(Auth::user())->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(optional(Auth::user())->name ?? 'Guest') . '&background=f3f4f6&color=333' }}" 
                             alt="Avatar" 
                             class="w-8 h-8 rounded-full border border-gray-200 group-hover:border-gold transition-all duration-300">
                        <span class="hidden sm:block text-sm font-medium">{{ optional(Auth::user())->name ?? 'Guest' }}</span>
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
                <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Login Portal
                </a>
            @endauth
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="max-w-[1400px] mx-auto px-8 py-8 flex flex-col lg:flex-row gap-12">
        
        <!-- LEFT COLUMN -->
        <main class="w-full lg:w-2/3 xl:w-[70%]">
            <!-- Breadcrumb -->
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

            <!-- Header Artikel -->
            <div class="mb-6 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-yellow-100 text-yellow-800 text-[11px] font-bold px-2.5 py-1 rounded">{{ $article->category->name ?? 'Dokumen' }}</span>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded">{{ ucfirst($article->status) }}</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $article->title }}</h1>
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name ?? 'Admin') . '&background=cbd5e1&color=374151' }}" alt="Author Avatar" class="w-10 h-10 rounded-full border border-gray-200">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-[13px]">{{ $article->user->name ?? 'Admin' }}</span>
                                    <a href="{{ route('user.profil') }}" class="inline-flex items-center gap-1 text-[11px] text-navy bg-blue-50 hover:bg-blue-100 transition-colors duration-200 px-2 py-0.5 rounded-full border border-blue-200">
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

                <!-- ACTION BAR (Backend Integrated) -->
                <div id="action-bar" class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-3 sm:gap-4">
                    @auth
                        @php $isBookmarked = \App\Models\Bookmark::where('user_id', auth()->id())->where('article_id', $article->id)->exists(); @endphp
                        <button id="btn-bookmark" onclick="toggleBookmark({{ $article->id }})" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-gold">
                            <svg id="icon-bookmark" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="{{ $isBookmarked ? '#EAB308' : 'none' }}" stroke="{{ $isBookmarked ? '#EAB308' : 'currentColor' }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            <span id="text-bookmark" class="text-xs font-medium hidden sm:inline">{{ $isBookmarked ? 'Disimpan' : 'Bookmark' }}</span>
                        </button>

                        @php $isLiked = \App\Models\Like::where('user_id', auth()->id())->where('article_id', $article->id)->exists(); @endphp
                        <button id="btn-like" onclick="toggleLike({{ $article->id }})" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-red-300">
                            <svg id="icon-like" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="{{ $isLiked ? '#EF4444' : 'none' }}" stroke="{{ $isLiked ? '#EF4444' : 'currentColor' }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            <span id="like-count" class="text-xs font-medium">{{ $article->likes_count ?? 0 }}</span>
                        </button>

                        <div class="flex items-center gap-1 px-3 py-1.5 rounded-full border border-gray-200 bg-white">
                            <span class="text-[10px] font-medium text-gray-400 mr-1">Beri Rating:</span>
                            <div class="flex" id="rating-container">
                                @for($i=1; $i<=5; $i++)
                                <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="{{ $i }}" onclick="submitRating({{ $article->id }}, {{ $i }})">☆</button>
                                @endfor
                            </div>
                            <span id="rating-text" class="text-xs text-gray-500 ml-1">({{ number_format($article->rating_avg, 1) }})</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-sm text-gray-400 py-1 px-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <a href="{{ route('login') }}" class="text-navy font-bold hover:underline">Login</a> untuk menyukai, memberi rating, atau menyimpan dokumen ini.
                        </div>
                    @endauth

                    <!-- Share Popup Tooltip -->
                    <div class="relative group/share inline-block">
                        <button id="btn-share" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            <span class="text-xs font-medium hidden sm:inline">Bagikan</span>
                        </button>
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

            <!-- AI Summary -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-10 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center gap-2 mb-3">
                    <div class="bg-gold text-white p-1 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                    <h3 class="font-bold text-gray-900">AI Document Summary</h3>
                </div>
                <p class="text-sm text-gray-700 leading-relaxed">{{ Str::limit(strip_tags($article->content), 300) }}</p>
            </div>

            <!-- Konten Artikel -->
            <article class="prose prose-gray max-w-none text-[15px] leading-loose">
                {!! $article->content !!}
            </article>

            <!-- ============================================== -->
            <!-- BAGIAN KOMENTAR (GABUNGAN: Tampilan Deep Reply + Backend AJAX) -->
            <!-- ============================================== -->
            <section id="comment-section" class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Komentar <span class="text-sm font-normal text-gray-400 ml-2" id="comment-count">({{ $comments->count() }})</span></h3>
                </div>

                @auth
                <!-- Form Komentar Utama -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    {{-- ✅ PERBAIKAN 2: Gunakan optional() untuk Auth user di Form Komentar Utama --}}
                    <img src="{{ optional(Auth::user())->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(optional(Auth::user())->name ?? 'Guest') . '&background=f3f4f6' }}" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                    <div class="flex-1 flex flex-col gap-3">
                        <textarea id="comment-input" placeholder="Tulis komentar Anda..." class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent transition-all duration-300 h-20 bg-white shadow-sm"></textarea>
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

                <!-- Daftar Komentar (Nested hingga Deep Level 2) -->
                <div id="comment-list" class="space-y-6">
                    @forelse($comments->where('parent_id', null) as $comment)
                    <div class="flex gap-4" id="comment-{{ $comment->id }}">
                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name ?? 'Anon') . '&background=d1fae5&color=065f46' }}" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-gray-900 text-sm">{{ $comment->user->name ?? 'Pengguna' }}</span>
                                <span class="text-[11px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div id="comment-content-{{ $comment->id }}" class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $comment->content }}</div>
                            
                            <!-- Form Edit Komentar Utama -->
                            <div id="edit-form-container-{{ $comment->id }}" class="hidden mt-2">
                                <textarea id="edit-input-{{ $comment->id }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent h-20 bg-white shadow-sm">{{ $comment->content }}</textarea>
                                <div class="flex gap-2 mt-2 justify-end">
                                    <button onclick="cancelEdit({{ $comment->id }})" class="text-gray-500 hover:text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-200">Batal</button>
                                    <button onclick="submitEdit({{ $comment->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors">Simpan Perubahan</button>
                                </div>
                            </div>

                            <!-- Action Bar Komentar -->
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                @auth @php $isLiked = $comment->isLikedBy(auth()->user()); @endphp
                                <button onclick="handleLike({{ $comment->id }})" class="hover:text-navy transition-colors flex items-center gap-1 cursor-pointer group">
                                    <svg id="like-icon-{{ $comment->id }}" class="w-3 h-3 group-hover:scale-110 transition-transform {{ $isLiked ? 'fill-navy text-navy' : 'fill-none text-current' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    <span id="like-count-{{ $comment->id }}">{{ $comment->likes }}</span>
                                </button>
                                @else<span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg> {{ $comment->likes }}</span>@endauth
                                @auth<button onclick="toggleReplyForm({{ $comment->id }}, '{{ $comment->user->name }}')" class="hover:text-navy transition-colors">Balas</button>@else<span class="text-gray-400 cursor-not-allowed">Balas</span>@endauth
                                @auth @if(auth()->id() === $comment->user_id)<button onclick="toggleEdit({{ $comment->id }})" class="hover:text-navy transition-colors text-gray-400 hover:text-gray-700">Edit</button><button onclick="deleteComment({{ $comment->id }})" class="text-red-500 hover:text-red-700 transition-colors">Hapus</button>@endif @endauth
                            </div>

                            <!-- Form Balasan untuk Komentar Utama -->
                            <div id="reply-form-container-{{ $comment->id }}" class="hidden mt-3 pl-4">
                                <div class="flex gap-3">
                                    {{-- ✅ PERBAIKAN 3: Gunakan optional() untuk Auth user di Form Balasan (Baris 289 dulu) --}}
                                    <img src="{{ optional(Auth::user())->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(optional(Auth::user())->name ?? 'Guest') . '&background=f3f4f6' }}" class="w-8 h-8 rounded-full flex-shrink-0 border border-gray-200">
                                    <div class="flex-1 flex gap-2">
                                        <input type="text" id="reply-input-{{ $comment->id }}" placeholder="Tulis balasan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                                        <button onclick="submitReply({{ $comment->id }}, {{ $article->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all duration-300">Kirim</button>
                                        <button onclick="toggleReplyForm({{ $comment->id }})" class="text-gray-400 hover:text-gray-600 text-xs font-medium px-3 py-2 rounded-lg border border-gray-200">Batal</button>
                                    </div>
                                </div>
                            </div>

                            <!-- ================================================== -->
                            <!-- BALASAN LEVEL 1 (Replies) -->
                            <!-- ================================================== -->
                            @if($comment->replies->count() > 0)
                            <div class="mt-3 pl-4 border-l-2 border-gray-200 space-y-4">
                                @foreach($comment->replies as $reply)
                                <div class="flex gap-3" id="reply-container-{{ $reply->id }}">
                                    <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name ?? 'Anon') . '&background=d1fae5&color=065f46' }}" class="w-8 h-8 rounded-full flex-shrink-0 border border-gray-200">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-gray-900 text-xs">{{ $reply->user->name ?? 'Pengguna' }}</span>
                                            <span class="text-[10px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div id="comment-content-{{ $reply->id }}" class="text-xs text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $reply->content }}</div>
                                        
                                        <div id="edit-form-container-{{ $reply->id }}" class="hidden mt-2">
                                            <textarea id="edit-input-{{ $reply->id }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent h-20 bg-white shadow-sm">{{ $reply->content }}</textarea>
                                            <div class="flex gap-2 mt-2 justify-end">
                                                <button onclick="cancelEdit({{ $reply->id }})" class="text-gray-500 hover:text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-200">Batal</button>
                                                <button onclick="submitEdit({{ $reply->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors">Simpan Perubahan</button>
                                            </div>
                                        </div>

                                        <div class="mt-1 flex items-center gap-3 text-xs text-gray-400">
                                            @auth
                                            <button onclick="handleLike({{ $reply->id }})" class="hover:text-navy transition-colors flex items-center gap-1 cursor-pointer group">
                                                <svg id="like-icon-{{ $reply->id }}" class="w-3 h-3 group-hover:scale-110 transition-transform {{ $reply->isLikedBy(auth()->user()) ? 'fill-navy text-navy' : 'fill-none text-current' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                                <span id="like-count-{{ $reply->id }}">{{ $reply->likes }}</span>
                                            </button>
                                            @else
                                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg> {{ $reply->likes }}</span>
                                            @endauth

                                            @auth
                                            <button onclick="toggleReplyForm({{ $reply->id }}, '{{ $reply->user->name }}')" class="hover:text-navy transition-colors">Balas</button>
                                            @if(auth()->id() === $reply->user_id)
                                            <button onclick="toggleEdit({{ $reply->id }})" class="hover:text-navy transition-colors text-gray-400 hover:text-gray-700">Edit</button>
                                            <button onclick="deleteComment({{ $reply->id }})" class="text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                                            @endif
                                            @endauth
                                        </div>

                                        <!-- Form Balasan untuk Reply Level 1 -->
                                        <div id="reply-form-container-{{ $reply->id }}" class="hidden mt-2">
                                            <div class="flex gap-3">
                                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Guest') . '&background=f3f4f6' }}" class="w-6 h-6 rounded-full flex-shrink-0 border border-gray-200">
                                                <div class="flex-1 flex gap-2">
                                                    <input type="text" id="reply-input-{{ $reply->id }}" placeholder="Tulis balasan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                                                    <button onclick="submitReply({{ $reply->id }}, {{ $article->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all duration-300">Kirim</button>
                                                    <button onclick="toggleReplyForm({{ $reply->id }})" class="text-gray-400 hover:text-gray-600 text-xs font-medium px-3 py-2 rounded-lg border border-gray-200">Batal</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ================================================== -->
                                        <!-- ✅ DEEP REPLY LEVEL 2 (Balasan dari Balasan) -->
                                        <!-- ================================================== -->
                                        @if($reply->replies->count() > 0)
                                        <div class="mt-2 pl-4 border-l-2 border-gray-200 space-y-2">
                                            @foreach($reply->replies as $deepReply)
                                            <div class="flex gap-3" id="reply-container-{{ $deepReply->id }}">
                                                <img src="{{ $deepReply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($deepReply->user->name ?? 'Anon') . '&background=d1fae5&color=065f46' }}" class="w-6 h-6 rounded-full flex-shrink-0 border border-gray-200">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="font-semibold text-gray-900 text-xs">{{ $deepReply->user->name ?? 'Pengguna' }}</span>
                                                        <span class="text-[10px] text-gray-400">{{ $deepReply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    
                                                    <div id="comment-content-{{ $deepReply->id }}" class="text-xs text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $deepReply->content }}</div>
                                                    
                                                    <div id="edit-form-container-{{ $deepReply->id }}" class="hidden mt-2">
                                                        <textarea id="edit-input-{{ $deepReply->id }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent h-20 bg-white shadow-sm">{{ $deepReply->content }}</textarea>
                                                        <div class="flex gap-2 mt-2 justify-end">
                                                            <button onclick="cancelEdit({{ $deepReply->id }})" class="text-gray-500 hover:text-gray-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-gray-200">Batal</button>
                                                            <button onclick="submitEdit({{ $deepReply->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition-colors">Simpan Perubahan</button>
                                                        </div>
                                                    </div>

                                                    <div class="mt-1 flex items-center gap-3 text-xs text-gray-400">
                                                        @auth
                                                        <button onclick="handleLike({{ $deepReply->id }})" class="hover:text-navy transition-colors flex items-center gap-1 cursor-pointer group">
                                                            <svg id="like-icon-{{ $deepReply->id }}" class="w-3 h-3 group-hover:scale-110 transition-transform {{ $deepReply->isLikedBy(auth()->user()) ? 'fill-navy text-navy' : 'fill-none text-current' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                                            <span id="like-count-{{ $deepReply->id }}">{{ $deepReply->likes }}</span>
                                                        </button>
                                                        @else
                                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg> {{ $deepReply->likes }}</span>
                                                        @endauth

                                                        @auth
                                                        <button onclick="toggleReplyForm({{ $deepReply->id }}, '{{ $deepReply->user->name }}')" class="hover:text-navy transition-colors">Balas</button>
                                                        @if(auth()->id() === $deepReply->user_id)
                                                        <button onclick="toggleEdit({{ $deepReply->id }})" class="hover:text-navy transition-colors text-gray-400 hover:text-gray-700">Edit</button>
                                                        <button onclick="deleteComment({{ $deepReply->id }})" class="text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                                                        @endif
                                                        @endauth
                                                    </div>

                                                    <!-- Form Balasan Deep Reply -->
                                                    <div id="reply-form-container-{{ $deepReply->id }}" class="hidden mt-2">
                                                        <div class="flex gap-3">
                                                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Guest') . '&background=f3f4f6' }}" class="w-6 h-6 rounded-full flex-shrink-0 border border-gray-200">
                                                            <div class="flex-1 flex gap-2">
                                                                <input type="text" id="reply-input-{{ $deepReply->id }}" placeholder="Tulis balasan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                                                                <button onclick="submitReply({{ $deepReply->id }}, {{ $article->id }})" class="bg-navy hover:bg-gray-800 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all duration-300">Kirim</button>
                                                                <button onclick="toggleReplyForm({{ $deepReply->id }})" class="text-gray-400 hover:text-gray-600 text-xs font-medium px-3 py-2 rounded-lg border border-gray-200">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <!-- END DEEP REPLY LEVEL 2 -->

                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <!-- END BALASAN LEVEL 1 -->

                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic text-center py-6" id="empty-comment-msg">Belum ada komentar untuk artikel ini. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>

        </main>

        <!-- RIGHT COLUMN -->
        <aside id="right-sidebar" class="w-full lg:w-1/3 xl:w-[30%]">
            <div class="sticky top-24 space-y-6">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('document.download-pdf', $article->id) }}" target="_blank" class="w-full bg-navy hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </a>
                    
                    <button onclick="window.print()" class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                        Print Document
                    </button>
                </div>

                <!-- Document Details -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Document Details</h3>
                    <div class="space-y-4">
                        <div><span class="block text-[11px] text-gray-500 mb-1">DOCUMENT ID</span><span class="font-semibold text-gray-900 text-sm">{{ $article->doc_code ?? 'N/A' }}</span></div>
                        <div><span class="block text-[11px] text-gray-500 mb-1">CURRENT VERSION</span><span class="font-medium text-gray-900 text-sm">{{ $article->version ?? 'v1.0' }}</span></div>
                        <div><span class="block text-[11px] text-gray-500 mb-1">LAST UPDATED</span><span class="font-medium text-gray-900 text-sm">{{ $article->updated_at->diffForHumans() }}</span></div>
                    </div>
                </div>

                <!-- Version History -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-5">Version History</h3>
                    <div class="relative border-l border-gray-200 ml-2 space-y-6">
                        @forelse($revisions as $revision)
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-gray-300 ring-4 ring-white"></span>
                            <div class="flex items-center gap-2 mb-1"><span class="font-bold text-gray-900 text-sm">v{{ $revision->version ?? '1.0' }}</span></div>
                            <p class="text-xs text-gray-700 mb-1">{{ $revision->change_log ?? 'Dokumen diperbarui' }}</p>
                            <span class="text-[11px] text-gray-400">{{ $revision->created_at->format('d M Y') }}</span>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 pl-5">Belum ada riwayat revisi.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Related Documents -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Related Documents</h3>
                    <ul class="space-y-3">
                        @forelse($relatedArticles as $related)
                        <li><a href="{{ route('document.detail', $related->slug) }}" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition"><svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg><span class="leading-tight group-hover:underline underline-offset-2">{{ $related->title }}</span></a></li>
                        @empty
                        <li class="text-xs text-gray-500">Tidak ada dokumen terkait.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </aside>
    </div>

    <!-- ============================================ -->
    <!-- ✨ MODAL FEEDBACK (SAAT KELUAR HALAMAN)        -->
    <!-- ============================================ -->
    <div id="feedback-modal" class="fixed inset-0 z-[9999] hidden bg-gray-900/70 backdrop-blur-sm flex items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform scale-95 transition-transform duration-300" id="feedback-modal-box">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5 text-white relative">
                <button onclick="closeFeedbackModal(false)" class="absolute top-4 right-4 hover:bg-white/20 rounded-full p-1 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <h3 class="font-bold text-lg flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Berikan Feedback
                </h3>
                <p class="text-sm text-indigo-100 mt-1">Pendapat Anda sangat berarti untuk pengembangan artikel ini.</p>
            </div>

            <!-- Body Modal -->
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Seberapa puas Anda dengan artikel ini?</label>
                    <div id="star-rating" class="flex justify-center gap-2 text-3xl cursor-pointer text-gray-300">
                        <span data-value="1" class="hover:text-gold transition-colors duration-200">☆</span>
                        <span data-value="2" class="hover:text-gold transition-colors duration-200">☆</span>
                        <span data-value="3" class="hover:text-gold transition-colors duration-200">☆</span>
                        <span data-value="4" class="hover:text-gold transition-colors duration-200">☆</span>
                        <span data-value="5" class="hover:text-gold transition-colors duration-200">☆</span>
                    </div>
                    <input type="hidden" id="feedback-rating" value="0">
                    <p id="rating-text" class="text-center text-xs font-medium text-gray-500 mt-1">Klik bintang untuk memberi nilai</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kritik & Saran (Opsional)</label>
                    <textarea id="feedback-comment" rows="3" placeholder="Tulis saran atau kritik Anda di sini..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors resize-none"></textarea>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-xs text-blue-700 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Feedback anonim akan membantu admin meningkatkan kualitas konten.
                    </p>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <button onclick="closeFeedbackModal(false)" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Nanti Saja
                </button>
                <button onclick="submitFeedback()" id="feedback-submit-btn" class="bg-gold hover:bg-goldhover text-darkbg font-bold px-6 py-2 rounded-lg text-sm transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Kirim Feedback
                </button>
            </div>
        </div>
    </div>

    <!-- FOOTER (Tetap sama) -->
    <footer id="footer" class="bg-[#0B1120] text-white py-16 mt-12 border-t border-gray-800">
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
            // ========== SHARE COPY LINK ==========
            window.copyShareLink = function() {
                const input = document.getElementById('share-url-input');
                if(input) {
                    input.select();
                    input.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(input.value).then(() => {
                        const btn = input.nextElementSibling;
                        const originalText = btn.textContent;
                        btn.textContent = 'Tersalin!';
                        btn.classList.add('bg-green-500');
                        setTimeout(() => { btn.textContent = originalText; btn.classList.remove('bg-green-500'); }, 2000);
                    }).catch(err => console.error('Gagal menyalin', err));
                }
            }

            // ========== RATING AJAX ==========
            window.submitRating = function(articleId, rating) {
                fetch(`/document/${articleId}/rate`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ rating: rating })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const stars = document.querySelectorAll('.star-rating');
                        stars.forEach(s => {
                            const val = parseInt(s.getAttribute('data-value'));
                            if(val <= rating) { s.classList.add('text-yellow-400'); s.classList.remove('text-gray-300'); s.textContent = '★'; } 
                            else { s.classList.remove('text-yellow-400'); s.classList.add('text-gray-300'); s.textContent = '☆'; }
                        });
                        document.getElementById('rating-text').textContent = `(${data.avg})`;
                    }
                });
            }

            // ========== LIKE ARTIKEL AJAX ==========
            window.toggleLike = function(articleId) {
                fetch(`/document/${articleId}/like`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const icon = document.getElementById('icon-like');
                        const count = document.getElementById('like-count');
                        count.textContent = data.count;
                        if(data.liked) {
                            icon.setAttribute('fill', '#EF4444');
                            icon.setAttribute('stroke', '#EF4444');
                        } else {
                            icon.setAttribute('fill', 'none');
                            icon.setAttribute('stroke', 'currentColor');
                        }
                    }
                });
            }

            // ========== BOOKMARK AJAX ==========
            window.toggleBookmark = function(articleId) {
                fetch(`/document/${articleId}/bookmark`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const icon = document.getElementById('icon-bookmark');
                        const text = document.getElementById('text-bookmark');
                        if(data.bookmarked) {
                            icon.setAttribute('fill', '#EAB308');
                            icon.setAttribute('stroke', '#EAB308');
                            text.textContent = 'Disimpan';
                        } else {
                            icon.setAttribute('fill', 'none');
                            icon.setAttribute('stroke', 'currentColor');
                            text.textContent = 'Bookmark';
                        }
                    }
                });
            }

            // ========== KOMENTAR: LIKE/UNLIKE COMMENT ==========
            window.handleLike = function(commentId) {
                fetch(`/comments/${commentId}/like`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        const countSpan = document.getElementById(`like-count-${commentId}`);
                        const iconSvg = document.getElementById(`like-icon-${commentId}`);
                        countSpan.textContent = data.likes;
                        if(data.liked) {
                            iconSvg.classList.add('fill-navy', 'text-navy');
                            iconSvg.classList.remove('fill-none');
                        } else {
                            iconSvg.classList.remove('fill-navy', 'text-navy');
                            iconSvg.classList.add('fill-none');
                        }
                    }
                });
            }

            // ========== TOGGLE REPLY FORM ==========
            window.toggleReplyForm = function(commentId, targetUsername) {
                const container = document.getElementById(`reply-form-container-${commentId}`);
                container.classList.toggle('hidden');
                if(!container.classList.contains('hidden')) {
                    const input = document.getElementById(`reply-input-${commentId}`);
                    if(input) {
                        input.value = targetUsername ? `@${targetUsername} ` : '';
                        input.focus();
                    }
                }
            }

            // ========== SUBMIT REPLY ==========
            window.submitReply = function(parentId, articleId) {
                const input = document.getElementById(`reply-input-${parentId}`);
                if(!input) return;
                const content = input.value.trim();
                if(!content) {
                    input.classList.add('border-red-300');
                    setTimeout(() => input.classList.remove('border-red-300'), 2000);
                    return;
                }
                fetch('/comments', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ article_id: articleId, parent_id: parentId, content: content })
                })
                .then(res => res.json())
                .then(data => { if(data.success) location.reload(); })
                .catch(error => console.error('Error:', error));
            }

            // ========== SUBMIT MAIN COMMENT ==========
            const mainSubmitBtn = document.getElementById('btn-submit-comment');
            const mainInput = document.getElementById('comment-input');
            if(mainSubmitBtn) {
                mainSubmitBtn.addEventListener('click', function() {
                    const text = mainInput.value.trim();
                    if(text) {
                        fetch('/comments', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ article_id: {{ $article->id }}, parent_id: null, content: text })
                        })
                        .then(res => res.json())
                        .then(data => { if(data.success) location.reload(); });
                    } else {
                        mainInput.classList.add('border-red-300');
                        setTimeout(() => mainInput.classList.remove('border-red-300'), 2000);
                    }
                });
            }

            // ========== TOGGLE EDIT ==========
            window.toggleEdit = function(commentId) {
                const contentDiv = document.getElementById(`comment-content-${commentId}`);
                const editForm = document.getElementById(`edit-form-container-${commentId}`);
                if(editForm.classList.contains('hidden')) {
                    contentDiv.classList.add('hidden');
                    editForm.classList.remove('hidden');
                    document.getElementById(`edit-input-${commentId}`).focus();
                } else {
                    cancelEdit(commentId);
                }
            }

            // ========== BATAL EDIT ==========
            window.cancelEdit = function(commentId) {
                const contentDiv = document.getElementById(`comment-content-${commentId}`);
                const editForm = document.getElementById(`edit-form-container-${commentId}`);
                contentDiv.classList.remove('hidden');
                editForm.classList.add('hidden');
            }

            // ========== SUBMIT EDIT ==========
            window.submitEdit = function(commentId) {
                const input = document.getElementById(`edit-input-${commentId}`);
                const content = input.value.trim();
                if(!content) {
                    input.classList.add('border-red-300');
                    setTimeout(() => input.classList.remove('border-red-300'), 2000);
                    return;
                }
                fetch(`/comments/${commentId}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ _method: 'PUT', content: content })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        document.getElementById(`comment-content-${commentId}`).textContent = data.content;
                        cancelEdit(commentId);
                    } else {
                        alert(data.message || 'Gagal mengedit komentar.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // ========== DELETE COMMENT ==========
            window.deleteComment = function(commentId) {
                if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                    fetch(`/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) location.reload();
                        else alert(data.message || 'Gagal menghapus komentar.');
                    })
                    .catch(error => console.error('Error:', error));
                }
            }

            // ============================================================
            // ✨ FITUR BARU: LOGIKA MODAL FEEDBACK (HANYA UNTUK USER LOGIN)
            // ============================================================
            @auth
            const articleId = {{ $article->id }};
            const feedbackKeyShown = 'feedback_shown_' + articleId;
            const feedbackKeySubmitted = 'feedback_submitted_' + articleId;

            // Cek jika sudah pernah submit, jangan munculkan lagi
            if (!localStorage.getItem(feedbackKeySubmitted)) {
                // Tangkap semua klik link di halaman
                const allLinks = document.querySelectorAll('a');
                let pendingUrl = null;

                allLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Jika modal sudah pernah ditampilkan, abaikan
                        if (localStorage.getItem(feedbackKeyShown)) {
                            return;
                        }

                        // Cegah navigasi, tampilkan modal
                        e.preventDefault();
                        pendingUrl = this.href;
                        openFeedbackModal();
                    });
                });

                window.openFeedbackModal = function() {
                    const modal = document.getElementById('feedback-modal');
                    const box = document.getElementById('feedback-modal-box');
                    
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.add('opacity-100');
                        box.classList.remove('scale-95');
                        box.classList.add('scale-100');
                    }, 10);
                    
                    localStorage.setItem(feedbackKeyShown, 'true');
                }

                window.closeFeedbackModal = function(submitted = false) {
                    const modal = document.getElementById('feedback-modal');
                    const box = document.getElementById('feedback-modal-box');

                    box.classList.remove('scale-100');
                    box.classList.add('scale-95');
                    modal.classList.remove('opacity-100');
                    
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        if (!submitted && pendingUrl) {
                            window.location.href = pendingUrl;
                            pendingUrl = null;
                        }
                    }, 300);
                }

                // Logic Rating Bintang
                const stars = document.querySelectorAll('#star-rating span');
                const ratingInput = document.getElementById('feedback-rating');
                const ratingText = document.getElementById('rating-text');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const val = parseInt(this.getAttribute('data-value'));
                        ratingInput.value = val;
                        updateStars(val);
                        
                        const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
                        ratingText.textContent = labels[val];
                    });
                    star.addEventListener('mouseenter', function() {
                        const val = parseInt(this.getAttribute('data-value'));
                        updateStars(val, true);
                    });
                    star.addEventListener('mouseleave', function() {
                        const current = parseInt(ratingInput.value);
                        updateStars(current);
                    });
                });

                function updateStars(val, isHover = false) {
                    stars.forEach(s => {
                        const sv = parseInt(s.getAttribute('data-value'));
                        if (sv <= val) {
                            s.textContent = '★';
                            s.classList.add('text-gold');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.textContent = '☆';
                            s.classList.remove('text-gold');
                            s.classList.add('text-gray-300');
                        }
                    });
                }

                // Submit Feedback via AJAX
                window.submitFeedback = function() {
                    const rating = parseInt(ratingInput.value);
                    if (rating === 0) {
                        alert('Silakan pilih rating bintang terlebih dahulu!');
                        return;
                    }

                    const comment = document.getElementById('feedback-comment').value.trim();
                    const btn = document.getElementById('feedback-submit-btn');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

                    fetch(`/document/${articleId}/feedback`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ rating: rating, comment: comment })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            localStorage.setItem(feedbackKeySubmitted, 'true');
                            // Toast sukses sederhana
                            const toast = document.createElement('div');
                            toast.className = 'fixed bottom-5 right-5 z-[9999] bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-300';
                            toast.innerHTML = '<span class="font-bold">Terima kasih!</span> Feedback Anda telah dikirim.';
                            document.body.appendChild(toast);
                            setTimeout(() => {
                                toast.classList.remove('translate-y-20', 'opacity-0');
                                toast.classList.add('translate-y-0', 'opacity-100');
                            }, 100);
                            setTimeout(() => toast.remove(), 4000);

                            closeFeedbackModal(true);
                            if (pendingUrl) {
                                window.location.href = pendingUrl;
                                pendingUrl = null;
                            }
                        } else if (data.status === 'already_submitted') {
                            alert('Anda sudah memberikan feedback untuk artikel ini sebelumnya.');
                            localStorage.setItem(feedbackKeySubmitted, 'true');
                            closeFeedbackModal(true);
                            if (pendingUrl) {
                                window.location.href = pendingUrl;
                                pendingUrl = null;
                            }
                        } else {
                            alert('Gagal mengirim feedback: ' + data.message);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Kirim Feedback';
                    });
                }
            }
            @endauth
        });
    </script>
</body>
</html>