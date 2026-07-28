<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - AKSARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* --- ANIMASI HALUS --- */
        .fade-in-up {
            opacity: 0;
            transform: translateY(16px);
            animation: fadeInUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .fade-in-up.delay-1 { animation-delay: 0.08s; }
        .fade-in-up.delay-2 { animation-delay: 0.16s; }
        .fade-in-up.delay-3 { animation-delay: 0.24s; }
        .fade-in-up.delay-4 { animation-delay: 0.32s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .scale-in {
            opacity: 0;
            transform: scale(0.96);
            animation: scaleIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        #sidebar-mobile { transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.3s ease; }
        #sidebar-overlay { transition: opacity 0.3s ease; }

        .stat-card {
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px -8px rgba(0,0,0,0.08);
        }

        .hover-lift {
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px -6px rgba(0,0,0,0.06);
        }

        .tab-content { display: none; }
        .tab-content.active {
            display: block;
            animation: fadeInUp 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .modal-box {
            animation: modalPop 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.94) translateY(12px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .sidebar-link.active {
            background: #F1F5F9;
            color: #0F172A;
            border-color: #E2E8F0;
        }
        .sidebar-link.active svg { color: #EAB308; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F8FAFC] flex h-screen overflow-hidden">

    <!-- ==================== SIDEBAR OVERLAY (MOBILE) ==================== -->
    <div id="sidebar-overlay" class="fixed inset-0 z-30 hidden md:hidden opacity-0 modal-backdrop" onclick="toggleSidebar()"></div>

    <!-- ==================== SIDEBAR ==================== -->
    <aside id="sidebar-mobile" class="w-64 bg-white text-gray-700 flex flex-col border-r border-gray-200 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 transition-transform duration-300">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-200">
            <div class="w-8 h-8 bg-gold rounded-lg text-white flex items-center justify-center font-bold text-lg shadow-sm">A</div>
            <div class="flex flex-col">
                <span class="font-bold text-gray-900 text-sm leading-tight">AKSARA</span>
                <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">Portal Pengguna</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-5 px-3 space-y-1 no-scrollbar">
            <a href="#" onclick="switchTab('dashboard')" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 active">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="#" onclick="switchTab('history')" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                History
            </a>
            <a href="#" onclick="switchTab('bookmark')" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                Bookmark
            </a>
            <a href="#" onclick="switchTab('notification')" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <div class="relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @if($user->unreadNotifications()->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">{{ $user->unreadNotifications()->count() }}</span>
                    @endif
                </div>
                Notification
            </a>
            <a href="#" onclick="switchTab('profile')" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>

            <div class="border-t border-gray-200 mt-6 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2 md:hidden">
                <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-gold rounded-lg text-white flex items-center justify-center font-bold text-sm">A</div>
                    <span class="font-bold text-gray-800 text-lg">AKSARA</span>
                </div>
            </div>

            <a href="{{ route('home.public') }}" class="ml-auto flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-white border border-gray-200 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition-all duration-200 hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- ========== TAB DASHBOARD ========== -->
        <div id="tab-dashboard" class="tab-content active">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Selamat Datang, {{ $user->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Teruslah belajar dan jelajahi pengetahuan baru di AKSARA.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card fade-in-up delay-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📚 Total Aktivitas</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_activities'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card fade-in-up delay-2">
                    <p class="text-[10px] font-bold text-blue-500 uppercase mb-1">📖 Artikel Dibaca</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['articles_read'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card fade-in-up delay-3">
                    <p class="text-[10px] font-bold text-purple-500 uppercase mb-1">⬇ Download</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['downloads'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card fade-in-up delay-4">
                    <p class="text-[10px] font-bold text-gold uppercase mb-1">🔖 Bookmark</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['bookmarks'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 fade-in-up">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-shadow duration-300">
                    <h3 class="font-bold text-gray-800 text-sm mb-3">Distribusi Aktivitas</h3>
                    <div class="w-full h-56 relative">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition-shadow duration-300">
                    <h3 class="font-bold text-gray-800 text-sm mb-3">Aktivitas 7 Hari Terakhir</h3>
                    <div class="w-full h-56 relative">
                        <canvas id="userTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== TAB HISTORY ========== -->
        <div id="tab-history" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">History</h1>
                    <p class="text-sm text-gray-500 mt-1">Menyimpan seluruh aktivitas pengguna saat menggunakan KMS.</p>
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <form action="{{ route('user.history.clear') }}" method="POST" onsubmit="return confirm('Hapus semua history?')">
                        @csrf
                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Semua
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 fade-in-up">
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📚 Total</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total_activities'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-blue-500 uppercase mb-1">📖 Dibaca</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['articles_read'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-purple-500 uppercase mb-1">⬇ Download</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['downloads'] }}</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gold uppercase mb-1">🔖 Bookmark</p>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['bookmarks'] }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 fade-in-up">
                <form action="{{ route('user.profil') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <div class="flex-1 min-w-[180px] w-full md:w-auto relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" placeholder="Cari History..." value="{{ request('search') }}" class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm outline-none focus:border-gold focus:ring-2 focus:ring-gold/30 transition-all duration-200">
                    </div>
                    <select name="type" class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-2 focus:ring-gold/30 transition-all duration-200 bg-white text-gray-700 min-w-[120px]">
                        <option value="">Jenis Aktivitas</option>
                        <option value="read" {{ request('type') == 'read' ? 'selected' : '' }}>Dibaca</option>
                        <option value="download" {{ request('type') == 'download' ? 'selected' : '' }}>Download</option>
                        <option value="rating" {{ request('type') == 'rating' ? 'selected' : '' }}>Rating</option>
                        <option value="comment" {{ request('type') == 'comment' ? 'selected' : '' }}>Komentar</option>
                        <option value="bookmark" {{ request('type') == 'bookmark' ? 'selected' : '' }}>Bookmark</option>
                        <option value="like" {{ request('type') == 'like' ? 'selected' : '' }}>Like</option>
                        <option value="search" {{ request('type') == 'search' ? 'selected' : '' }}>Search</option>
                        <option value="share" {{ request('type') == 'share' ? 'selected' : '' }}>Share</option>
                    </select>
                    <input type="date" name="date" value="{{ request('date') }}" class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-2 focus:ring-gold/30 transition-all duration-200 bg-white text-gray-700">
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Terapkan</button>
                    @if(request()->anyFilled(['search', 'type', 'date']))
                        <a href="{{ route('user.profil') }}" class="text-gray-400 hover:text-gray-600 text-sm underline">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                @if($activities->count() > 0)
                    @foreach($activities as $activity)
                    <div class="relative border-l border-gray-200 ml-3 pb-6 last:pb-0">
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full 
                                @if($activity->type == 'read') bg-blue-500
                                @elseif($activity->type == 'download') bg-purple-500
                                @elseif($activity->type == 'rating') bg-yellow-500
                                @elseif($activity->type == 'comment') bg-green-500
                                @elseif($activity->type == 'bookmark') bg-gold
                                @elseif($activity->type == 'like') bg-red-500
                                @else bg-gray-400
                                @endif
                                ring-4 ring-white">
                            </div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800 text-sm">{{ ucfirst($activity->type) }}</span>
                                    <span class="text-xs text-gray-500">{{ $activity->title }}</span>
                                </div>
                                <span class="text-[11px] text-gray-400 font-medium">{{ $activity->created_at->format('H:i') }}</span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $activity->description }}</p>
                            <div class="mt-2 flex gap-2">
                                @if($activity->url)
                                    <a href="{{ $activity->url }}" class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</a>
                                @endif
                                <form action="{{ route('user.history.delete', $activity->id) }}" method="POST" onsubmit="return confirm('Hapus aktivitas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada aktivitas.</p>
                @endif
            </div>
        </div>

        <!-- ========== TAB BOOKMARK (DENGAN DOWNLOAD & SHARE) ========== -->
        <div id="tab-bookmark" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Bookmark Saya</h1>
                    <p class="text-sm text-gray-500 mt-1">Koleksi artikel dan dokumen favorit Anda.</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up">
                <span class="text-[10px] font-bold text-gray-400 uppercase px-1">Filter:</span>
                <a href="javascript:void(0)" onclick="filterBookmarks('')" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 filter-btn active transition-colors">Semua</a>
                @foreach(['SOP', 'Tutorial', 'Video', 'PDF', 'Dokumen'] as $cat)
                    <a href="javascript:void(0)" onclick="filterBookmarks('{{ $cat }}')" class="px-3 py-1.5 text-xs font-medium rounded-lg text-gray-500 hover:bg-gray-50 filter-btn transition-colors">{{ $cat }}</a>
                @endforeach
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in-up" id="bookmark-grid">
                @if($bookmarks->count() > 0)
                    @foreach($bookmarks as $bookmark)
                    @php
                        $article = $bookmark->article;
                        $slug = $article->slug ?? $article->id;
                        $detailUrl = route('document.detail', $slug);
                        // 🔥 PERBAIKAN: gunakan $article->id untuk route download
                        $downloadUrl = route('document.download', $article->id);
                    @endphp
                    <div class="bookmark-item bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover-lift transition-all duration-300" data-category="{{ $article->category ?? 'Umum' }}">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">{{ $article->title }}</h3>
                            <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $article->category ?? 'Umum' }}</span>
                        </div>
                        <p class="text-xs text-gray-400">Terakhir Dibaca: {{ $article->updated_at->diffForHumans() }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                            <a href="{{ $detailUrl }}" class="text-blue-500 text-xs font-medium hover:underline">Buka Artikel</a>
                            <div class="flex items-center gap-2">
                                <!-- Hapus Bookmark -->
                                <form action="{{ route('user.bookmarks.delete', $bookmark->id) }}" method="POST" onsubmit="return confirm('Hapus bookmark ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors duration-200" title="Hapus Bookmark">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>

                                <!-- Download PDF (menggunakan ID) -->
                                <a href="{{ $downloadUrl }}" 
                                   class="text-gray-400 hover:text-green-500 transition-colors duration-200" 
                                   title="Download PDF" 
                                   target="_blank">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>

                                <!-- Share -->
                                <button onclick="shareArticle('{{ $detailUrl }}', '{{ addslashes($article->title) }}')" 
                                        class="text-gray-400 hover:text-blue-500 transition-colors duration-200" 
                                        title="Bagikan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div id="bookmark-empty" class="col-span-full text-center py-10 text-gray-500">
                        <p>Belum ada bookmark.</p>
                    </div>
                @endif
            </div>
            <div class="mt-4">{{ $bookmarks->links() }}</div>
        </div>

        <!-- ========== TAB NOTIFICATION ========== -->
        <div id="tab-notification" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Notification</h1>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan seluruh notifikasi yang berkaitan dengan akun pengguna.</p>
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <form action="{{ route('user.notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                    <form action="{{ route('user.notifications.clear') }}" method="POST" onsubmit="return confirm('Hapus semua notifikasi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Semua
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 fade-in-up">
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">🔔 Belum Dibaca</p>
                    <p class="text-xl font-bold text-red-500">{{ $user->unreadNotifications()->count() }}</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📨 Total</p>
                    <p class="text-xl font-bold text-gray-900">{{ $notifications->total() }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                @if($notifications->count() > 0)
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                        <div class="flex items-start gap-4 border-b border-gray-100 pb-4 {{ !$notification->is_read ? 'bg-blue-50/40 rounded-lg p-2' : '' }} transition-colors">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 
                                {{ $notification->type == 'system' ? 'bg-blue-100 text-blue-600' : 
                                   ($notification->type == 'comment' ? 'bg-green-100 text-green-600' :
                                   ($notification->type == 'update' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-600')) }}">
                                {{ $notification->type == 'system' ? '⚙️' : 
                                   ($notification->type == 'comment' ? '💬' :
                                   ($notification->type == 'update' ? '🔄' : '📩')) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $notification->title }}</h4>
                                    @if(!$notification->is_read)
                                        <span class="bg-blue-100 text-blue-700 text-[9px] font-bold px-2 py-0.5 rounded-full">Baru</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500">{{ $notification->message }}</p>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                @if(!$notification->is_read)
                                    <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] text-blue-600 hover:underline font-medium">Tandai Dibaca</button>
                                    </form>
                                @endif
                                <form action="{{ route('user.notifications.delete', $notification->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[10px] text-gray-400 hover:text-red-500 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $notifications->links() }}</div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Tidak ada notifikasi.</p>
                @endif
            </div>
        </div>

        <!-- ========== TAB PROFILE ========== -->
        <div id="tab-profile" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Profile</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan preferensi Anda.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <div class="flex flex-col md:flex-row gap-6 border-b border-gray-100 pb-6 mb-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 flex-1">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=eab308&color=0f172a&size=128" class="w-20 h-20 rounded-full border-2 border-white shadow-md">
                        <div class="text-center sm:text-left flex-1">
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-1 mt-2 text-[11px] text-gray-600">
                                @if($user->nip) <span class="bg-gray-100 px-2 py-1 rounded">NIP: {{ $user->nip }}</span> @endif
                                @if($user->instansi) <span class="bg-gray-100 px-2 py-1 rounded">{{ $user->instansi }}</span> @endif
                                @if($user->jabatan) <span class="bg-gray-100 px-2 py-1 rounded">{{ $user->jabatan }}</span> @endif
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2">Bergabung: {{ $user->created_at->isoFormat('D MMM YYYY') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-4">
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['articles_read'] }}</p><p class="text-[10px] text-gray-500">Dibaca</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['bookmarks'] }}</p><p class="text-[10px] text-gray-500">Bookmark</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['downloads'] }}</p><p class="text-[10px] text-gray-500">Download</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['ratings'] }}</p><p class="text-[10px] text-gray-500">Rating</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['likes'] }}</p><p class="text-[10px] text-gray-500">Like</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ $stats['total_activities'] }}</p><p class="text-[10px] text-gray-500">Aktivitas</p></div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Informasi Akun</h3>
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Instansi</label>
                            <input type="text" name="instansi" value="{{ old('instansi', $user->instansi ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bidang</label>
                            <input type="text" name="bidang" value="{{ old('bidang', $user->bidang ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan ?? '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200">
                        </div>
                    </div>
                    <button type="submit" class="mt-4 bg-gold text-darkbg hover:bg-goldhover font-bold py-2 px-5 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md">Simpan Perubahan</button>
                </form>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Keamanan</h3>

                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 text-sm mb-2">Ganti Password</h4>
                    <form action="{{ route('user.profile.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Saat Ini</label>
                                <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Baru</label>
                                <input type="password" name="new_password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Konfirmasi</label>
                                <input type="password" name="new_password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold focus:ring-2 focus:ring-gold/30 outline-none transition-all duration-200" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-3 bg-darkbg text-white hover:bg-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">Ubah Password</button>
                    </form>
                </div>

                <div class="flex flex-wrap gap-3 mt-4">
                    <button onclick="openModal('loginHistory')" class="border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Aktivitas Login
                    </button>
                    <button onclick="openModal('activeDevices')" class="border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Perangkat Aktif
                    </button>
                    <form action="{{ route('user.logout.all') }}" method="POST" onsubmit="return confirm('Yakin ingin logout dari semua perangkat?')" class="inline">
                        @csrf
                        <button type="submit" class="border border-red-500 text-red-600 hover:bg-red-50 hover:border-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout Semua Device
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL ==================== -->
        <div id="loginHistoryModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[85vh] overflow-hidden modal-box">
                <div class="flex justify-between items-center p-5 border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Login
                    </h3>
                    <button onclick="closeModal('loginHistoryModal')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">&times;</button>
                </div>
                <div id="loginHistoryContent" class="p-5 overflow-y-auto max-h-[70vh] no-scrollbar">
                    <div class="text-center py-10 text-gray-500">Memuat...</div>
                </div>
            </div>
        </div>

        <div id="activeDevicesModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[85vh] overflow-hidden modal-box">
                <div class="flex justify-between items-center p-5 border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Perangkat Aktif
                    </h3>
                    <button onclick="closeModal('activeDevicesModal')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">&times;</button>
                </div>
                <div id="activeDevicesContent" class="p-5 overflow-y-auto max-h-[70vh] no-scrollbar">
                    <div class="text-center py-10 text-gray-500">Memuat...</div>
                </div>
            </div>
        </div>

    </main>

    <!-- ==================== SCRIPTS ==================== -->
    <script>
        // ======= SIDEBAR =======
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
            } else {
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                setTimeout(() => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }, 300);
            }
        }

        // ======= SWITCH TAB =======
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));

            const target = document.getElementById('tab-' + tabId);
            if (target) target.classList.add('active');

            const activeLink = document.querySelector(`.sidebar-link[onclick*="'${tabId}'"]`);
            if (activeLink) activeLink.classList.add('active');

            if (tabId === 'dashboard') setTimeout(initDashboardCharts, 200);

            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar-mobile');
                const overlay = document.getElementById('sidebar-overlay');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    overlay.classList.add('opacity-0');
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }, 300);
                }
            }
        }

        // ======= SHARE FUNCTION =======
        function shareArticle(url, title) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Baca artikel ini di AKSARA',
                    url: url
                }).catch(() => {});
            } else {
                // Fallback: copy link
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Link artikel telah disalin ke clipboard!');
                    }).catch(() => {
                        prompt('Salin link ini:', url);
                    });
                } else {
                    prompt('Salin link ini:', url);
                }
            }
        }

        // ======= MODAL =======
        function openModal(type) {
            const modalMap = {
                'loginHistory': {
                    modalId: 'loginHistoryModal',
                    contentId: 'loginHistoryContent',
                    url: '{{ route("user.login.history") }}'
                },
                'activeDevices': {
                    modalId: 'activeDevicesModal',
                    contentId: 'activeDevicesContent',
                    url: '{{ route("user.active.devices") }}'
                }
            };

            const config = modalMap[type];
            if (!config) return;

            const modal = document.getElementById(config.modalId);
            const content = document.getElementById(config.contentId);

            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            content.innerHTML = '<div class="text-center py-10 text-gray-500">Memuat...</div>';

            fetch(config.url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                content.innerHTML = data.html;
                content.querySelectorAll('.fade-in-up, .scale-in').forEach(el => {
                    el.style.animation = 'none';
                    setTimeout(() => el.style.animation = '', 10);
                });
            })
            .catch(err => {
                content.innerHTML = `
                    <div class="text-center py-10">
                        <p class="text-red-500 text-sm">Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                `;
                console.error(err);
            });
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                const modalId = e.target.id;
                closeModal(modalId);
            }
        });

        // ======= FILTER BOOKMARK =======
        function filterBookmarks(category) {
            const items = document.querySelectorAll('.bookmark-item');
            const emptyState = document.getElementById('bookmark-empty');
            let visible = 0;

            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-gray-100', 'text-gray-600');
                btn.classList.add('text-gray-500');
            });
            const activeBtn = Array.from(document.querySelectorAll('.filter-btn'))
                .find(btn => btn.getAttribute('onclick').includes(`'${category}'`));
            if (activeBtn) {
                activeBtn.classList.add('bg-gray-100', 'text-gray-600');
                activeBtn.classList.remove('text-gray-500');
            } else if (category === '') {
                const firstBtn = document.querySelector('.filter-btn');
                if (firstBtn) {
                    firstBtn.classList.add('bg-gray-100', 'text-gray-600');
                    firstBtn.classList.remove('text-gray-500');
                }
            }

            items.forEach(item => {
                const cat = item.dataset.category;
                if (category === '' || cat === category) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', visible > 0);
            }
        }

        // ======= CHARTS =======
        let chartsInitialized = false;
        let activityChartInstance = null;
        let trendChartInstance = null;

        function initDashboardCharts() {
            if (chartsInitialized) return;

            const activityCtx = document.getElementById('userActivityChart');
            const trendCtx = document.getElementById('userTrendChart');
            if (!activityCtx || !trendCtx) return;

            if (activityChartInstance) activityChartInstance.destroy();
            if (trendChartInstance) trendChartInstance.destroy();

            const activityData = {!! json_encode([$stats['articles_read'], $stats['downloads'], $stats['bookmarks']]) !!};
            const trendData = {!! json_encode($chartData['data'] ?? []) !!};

            activityChartInstance = new Chart(activityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Membaca', 'Download', 'Bookmark'],
                    datasets: [{
                        data: activityData,
                        backgroundColor: ['#3B82F6', '#8B5CF6', '#EAB308'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, boxWidth: 8, padding: 16, font: { size: 11 } }
                        }
                    },
                    cutout: '68%'
                }
            });

            trendChartInstance = new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartData['labels'] ?? ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']) !!},
                    datasets: [{
                        label: 'Aktivitas',
                        data: trendData,
                        backgroundColor: '#EAB308',
                        borderRadius: 6,
                        barThickness: 28,
                        hoverBackgroundColor: '#CA8A04'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F5F9' }, ticks: { stepSize: 5, font: { size: 10 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                    }
                }
            });

            chartsInitialized = true;
        }

        // ======= INIT =======
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('dashboard');

            const urlParams = new URLSearchParams(window.location.search);
            const categoryParam = urlParams.get('category');
            if (categoryParam) {
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
                setTimeout(() => filterBookmarks(categoryParam), 150);
            }
        });
    </script>
</body>
</html>