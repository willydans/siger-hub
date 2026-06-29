<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - AKSARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahan CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        darkbg: '#0F172A', 
                        gold: '#EAB308', 
                        lightbg: '#F8FAFC', 
                        cardborder: '#E2E8F0', 
                        textmain: '#334155' 
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                } 
            } 
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Sidebar Mobile & Hover */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08);
        }
        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Animation untuk Tab */
        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease-out forwards;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR USER -->
    <aside id="sidebar-mobile" class="w-64 bg-white text-gray-700 flex flex-col border-r border-gray-200 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 sidebar-scroll">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-200">
            <div class="w-8 h-8 bg-gold rounded text-white flex items-center justify-center font-bold text-lg">A</div>
            <div class="flex flex-col">
                <span class="font-bold text-gray-900 text-sm leading-tight">AKSARA</span>
                <span class="text-[10px] text-green-600 font-bold uppercase tracking-widest">Portal Pengguna</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="#" onclick="switchTab('dashboard')" class="sidebar-link flex items-center gap-3 bg-gray-100 text-gray-900 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-200">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="/knowledge-base" class="flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Knowledge Base
            </a>
            <a href="#" onclick="switchTab('history')" class="sidebar-link flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                History
            </a>
            <a href="#" onclick="switchTab('bookmark')" class="sidebar-link flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                Bookmark
            </a>
            <a href="#" onclick="switchTab('notification')" class="sidebar-link flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <div class="relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </div>
                Notification
            </a>
            <a href="#" onclick="switchTab('profile')" class="sidebar-link flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <a href="#" onclick="switchTab('settings')" class="sidebar-link flex items-center gap-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Pengaturan
            </a>

            <div class="border-t border-gray-200 mt-6 pt-4 px-2">
                <a href="/login" class="flex items-center gap-3 text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Logout
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT (User Dashboard) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-gold rounded text-white flex items-center justify-center font-bold text-sm">A</div>
                <span class="font-bold text-gray-800 text-lg">AKSARA</span>
            </div>
        </div>

        <!-- ==================== 1. DASHBOARD TAB ==================== -->
        <div id="tab-dashboard" class="tab-content active">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Selamat Datang, Wildan</h1>
                    <p class="text-sm text-gray-500 mt-1">Teruslah belajar dan jelajahi pengetahuan baru di AKSARA.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📚 Total Aktivitas</p>
                    <p class="text-xl font-bold text-gray-900">125</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up">
                    <p class="text-[10px] font-bold text-blue-500 uppercase mb-1">📖 Artikel Dibaca</p>
                    <p class="text-xl font-bold text-gray-900">98</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up">
                    <p class="text-[10px] font-bold text-purple-500 uppercase mb-1">⬇ Download</p>
                    <p class="text-xl font-bold text-gray-900">12</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up">
                    <p class="text-[10px] font-bold text-gold uppercase mb-1">🔖 Bookmark</p>
                    <p class="text-xl font-bold text-gray-900">15</p>
                </div>
            </div>

            <!-- NEW SECTION: CHARTS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 fade-in-up">
                <!-- Doughnut Chart -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                    <h3 class="font-bold text-gray-800 text-sm mb-3">Distribusi Aktivitas</h3>
                    <div class="w-full h-56 relative">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>
                <!-- Bar Chart -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                    <h3 class="font-bold text-gray-800 text-sm mb-3">Aktivitas 7 Hari Terakhir</h3>
                    <div class="w-full h-56 relative">
                        <canvas id="userTrendChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- END NEW SECTION -->
        </div>

        <!-- ==================== 2. HISTORY TAB ==================== -->
        <div id="tab-history" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">History</h1>
                    <p class="text-sm text-gray-500 mt-1">Menyimpan seluruh aktivitas pengguna saat menggunakan KMS.</p>
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <button onclick="alert('History berhasil diunduh!')" class="bg-darkbg text-white hover:bg-gray-800 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download History
                    </button>
                    <button onclick="if(confirm('Hapus semua history?')) alert('History berhasil dihapus.')" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Semua
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6 fade-in-up">
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📚 Total Aktivitas</p>
                    <p class="text-xl font-bold text-gray-900">125</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-blue-500 uppercase mb-1">📖 Artikel Dibaca</p>
                    <p class="text-xl font-bold text-gray-900">98</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-purple-500 uppercase mb-1">⬇ Download</p>
                    <p class="text-xl font-bold text-gray-900">12</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gold uppercase mb-1">🔖 Bookmark</p>
                    <p class="text-xl font-bold text-gray-900">15</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 fade-in-up">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex-1 min-w-[200px] w-full md:w-auto relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" placeholder="Cari History..." class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                    </div>
                    <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                        <option>Filter Waktu</option>
                        <option>Hari Ini</option>
                        <option>Minggu Ini</option>
                        <option>Bulan Ini</option>
                        <option>Semua</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                        <option>Kategori</option>
                        <option>SOP</option>
                        <option>Tutorial</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                        <option>OPD</option>
                        <option>Kominfo</option>
                        <option>Bappeda</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                        <option>Jenis Aktivitas</option>
                        <option>Dibaca</option>
                        <option>Download</option>
                        <option>Rating</option>
                        <option>Komentar</option>
                        <option>Bookmark</option>
                        <option>Like</option>
                        <option>Search</option>
                        <option>Share</option>
                    </select>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 ml-auto">
                        Terapkan Filter
                    </button>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">Hari Ini</h3>
                <div class="relative border-l border-gray-200 ml-3 space-y-6">
                    <!-- Item 1 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-blue-500 ring-4 ring-white"></div>
                        <div class="flex flex-col sm:flex-row justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">📄 Membaca</span>
                                <span class="text-xs text-gray-500">SOP Penggunaan VPN</span>
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded">Kominfo</span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium">09.25</span>
                        </div>
                        <p class="text-xs text-gray-500">5 menit membaca</p>
                        <div class="mt-2 flex gap-2">
                            <button class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</button>
                            <button class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-purple-500 ring-4 ring-white"></div>
                        <div class="flex flex-col sm:flex-row justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">⬇ Download</span>
                                <span class="text-xs text-gray-500">Panduan Email Pemerintah</span>
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded">PDF</span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium">09.05</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</button>
                            <button class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-yellow-500 ring-4 ring-white"></div>
                        <div class="flex flex-col sm:flex-row justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">⭐ Memberikan Rating</span>
                                <span class="text-xs text-gray-500">Panduan VPN</span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium">08.45</span>
                        </div>
                        <div class="flex items-center gap-1 text-yellow-400 text-sm">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</button>
                            <button class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                        </div>
                    </div>
                    <!-- Item 4 -->
                    <div class="relative pl-6">
                        <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-gold ring-4 ring-white"></div>
                        <div class="flex flex-col sm:flex-row justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">🔖 Bookmark</span>
                                <span class="text-xs text-gray-500">Tutorial Backup Server</span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium">08.30</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</button>
                            <button class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                        </div>
                    </div>
                </div>

                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mt-8 mb-4 flex items-center gap-2">Kemarin</h3>
                <div class="relative border-l border-gray-200 ml-3 space-y-6">
                    <div class="relative pl-6">
                        <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <div class="flex flex-col sm:flex-row justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-800 text-sm">💬 Komentar</span>
                                <span class="text-xs text-gray-500">Panduan Mikrotik</span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium">15.20</span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            <button class="text-blue-500 text-[10px] font-medium hover:underline">Buka Artikel</button>
                            <button class="text-red-500 text-[10px] font-medium hover:underline">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== 3. BOOKMARK TAB ==================== -->
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
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Semua</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors duration-200">SOP</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-colors duration-200">Tutorial</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition-colors duration-200">Video</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors duration-200">PDF</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors duration-200">Dokumen</button>
            </div>

            <!-- Grid Bookmarks -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in-up">
                <!-- Item 1 -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover-lift">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">SOP VPN</h3>
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Kominfo</span>
                    </div>
                    <p class="text-xs text-gray-400">Terakhir Dibaca: Kemarin</p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                        <button class="text-blue-500 text-xs font-medium hover:underline">Buka Artikel</button>
                        <div class="flex items-center gap-2">
                            <button class="text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            <button class="text-gray-400 hover:text-green-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                            <button class="text-gray-400 hover:text-blue-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                        </div>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover-lift">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">Panduan Email</h3>
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Kominfo</span>
                    </div>
                    <p class="text-xs text-gray-400">Terakhir Dibaca: 2 hari lalu</p>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                        <button class="text-blue-500 text-xs font-medium hover:underline">Buka Artikel</button>
                        <div class="flex items-center gap-2">
                            <button class="text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            <button class="text-gray-400 hover:text-green-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                            <button class="text-gray-400 hover:text-blue-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                        </div>
                    </div>
                </div>
                <!-- Item 3 -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover-lift">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">Tutorial Backup</h3>
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Diskominfo</span>
                    </div>
                    <p class="text-xs text-gray-400">Terakhir Dibaca: 1 minggu lalu</p>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                        <button class="text-blue-500 text-xs font-medium hover:underline">Buka Artikel</button>
                        <div class="flex items-center gap-2">
                            <button class="text-gray-400 hover:text-red-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                            <button class="text-gray-400 hover:text-green-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg></button>
                            <button class="text-gray-400 hover:text-blue-500 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== 4. NOTIFICATION TAB ==================== -->
        <div id="tab-notification" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Notification</h1>
                    <p class="text-sm text-gray-500 mt-1">Menampilkan seluruh notifikasi yang berkaitan dengan akun pengguna.</p>
                </div>
                <button onclick="if(confirm('Hapus semua notifikasi?')) alert('Notifikasi berhasil dihapus.')" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Semua
                </button>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-2 gap-4 mb-6 fade-in-up">
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">🔔 Belum Dibaca</p>
                    <p class="text-xl font-bold text-red-500">3</p>
                </div>
                <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                    <p class="text-[10px] font-bold text-gray-500 uppercase mb-1">📨 Total</p>
                    <p class="text-xl font-bold text-gray-900">128</p>
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up">
                <span class="text-[10px] font-bold text-gray-400 uppercase px-1">Kategori:</span>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Semua</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors duration-200">System</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-colors duration-200">Knowledge</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition-colors duration-200">Komentar</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors duration-200">Update</button>
                <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-200 transition-colors duration-200">Pengumuman</button>
            </div>

            <!-- Daftar Notifikasi -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <div class="space-y-4">
                    <!-- Notif 1 -->
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">📄</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-800 text-sm">SOP VPN</h4>
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Update</span>
                            </div>
                            <p class="text-xs text-gray-500">telah diperbarui</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">5 menit lalu</span>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <button class="text-[10px] text-blue-600 hover:underline font-medium">Buka</button>
                            <button class="text-[10px] text-gray-400 hover:text-red-500">Hapus</button>
                        </div>
                    </div>
                    <!-- Notif 2 -->
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">📢</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-800 text-sm">Artikel Baru</h4>
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Knowledge</span>
                            </div>
                            <p class="text-xs text-gray-500">Panduan AI</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">20 menit lalu</span>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <button class="text-[10px] text-blue-600 hover:underline font-medium">Buka</button>
                            <button class="text-[10px] text-gray-400 hover:text-red-500">Hapus</button>
                        </div>
                    </div>
                    <!-- Notif 3 -->
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">💬</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-800 text-sm">Balasan komentar</h4>
                                <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Komentar</span>
                            </div>
                            <p class="text-xs text-gray-500">oleh Admin</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">1 jam lalu</span>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <button class="text-[10px] text-blue-600 hover:underline font-medium">Buka</button>
                            <button class="text-[10px] text-gray-400 hover:text-red-500">Hapus</button>
                        </div>
                    </div>
                    <!-- Notif 4 -->
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">⭐</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-800 text-sm">Terima kasih</h4>
                            </div>
                            <p class="text-xs text-gray-500">Anda telah memberi rating</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">2 jam lalu</span>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <button class="text-[10px] text-gray-400 hover:text-gray-600">Tandai Sudah Dibaca</button>
                            <button class="text-[10px] text-gray-400 hover:text-red-500">Hapus</button>
                        </div>
                    </div>
                    <!-- Notif 5 -->
                    <div class="flex items-start gap-4 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">📥</div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-gray-800 text-sm">Dokumen yang Anda bookmark</h4>
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">System</span>
                            </div>
                            <p class="text-xs text-gray-500">baru saja diperbarui.</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">3 jam lalu</span>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <button class="text-[10px] text-blue-600 hover:underline font-medium">Buka</button>
                            <button class="text-[10px] text-gray-400 hover:text-red-500">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaturan Notifikasi -->
            <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Pengaturan Notifikasi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="text-sm text-gray-700">Artikel Baru</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="text-sm text-gray-700">Artikel Diperbarui</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="text-sm text-gray-700">Balasan Komentar</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="text-sm text-gray-700">Pengumuman</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer sm:col-span-2">
                        <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold">
                        <span class="text-sm text-gray-700">Email Notification</span>
                    </label>
                </div>
                <button class="mt-4 bg-gold text-darkbg hover:bg-goldhover font-bold py-2 px-4 rounded-lg text-sm transition-colors shadow-sm">Simpan Pengaturan</button>
            </div>
        </div>

        <!-- ==================== 5. PROFILE TAB ==================== -->
        <div id="tab-profile" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Profile</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan preferensi Anda.</p>
                </div>
            </div>

            <!-- Header & Statistik -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <div class="flex flex-col md:flex-row gap-6 border-b border-gray-100 pb-6 mb-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 flex-1">
                        <img src="https://ui-avatars.com/api/?name=Wildan&background=eab308&color=0f172a&size=128" class="w-20 h-20 rounded-full border-2 border-white shadow-sm">
                        <div class="text-center sm:text-left flex-1">
                            <h2 class="text-xl font-bold text-gray-900">Wildan</h2>
                            <p class="text-sm text-gray-500">wildan@lampungprov.go.id</p>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-1 mt-2 text-[11px] text-gray-600">
                                <span class="bg-gray-100 px-2 py-1 rounded">NIP: 198012012005011002</span>
                                <span class="bg-gray-100 px-2 py-1 rounded">Kominfo</span>
                                <span class="bg-gray-100 px-2 py-1 rounded">Staf IT</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2">Tanggal Bergabung: 12 Jan 2026</p>
                        </div>
                    </div>
                </div>
                <!-- Statistik -->
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-4">
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">125</p><p class="text-[10px] text-gray-500">Dibaca</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">15</p><p class="text-[10px] text-gray-500">Bookmark</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">25</p><p class="text-[10px] text-gray-500">Download</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">12</p><p class="text-[10px] text-gray-500">Komentar</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">35</p><p class="text-[10px] text-gray-500">Rating</p></div>
                    <div class="text-center"><p class="text-xl font-bold text-gray-900">40</p><p class="text-[10px] text-gray-500">Like</p></div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Informasi Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label><input type="text" value="Wildan" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label><input type="email" value="wildan@lampungprov.go.id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor HP</label><input type="text" value="081234567890" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Instansi</label><input type="text" value="Diskominfo Lampung" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bidang</label><input type="text" value="E-Government" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                    <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jabatan</label><input type="text" value="Staf IT" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"></div>
                </div>
            </div>

            <!-- Preferensi -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Preferensi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold"><span class="text-sm text-gray-700">Mode Gelap</span></label>
                        <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Bahasa</label><select class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"><option>Bahasa Indonesia</option><option>English</option></select></div>
                        <div><label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ukuran Font</label><select class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold outline-none"><option>Normal</option><option>Besar</option><option>Kecil</option></select></div>
                    </div>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold"><span class="text-sm text-gray-700">Notifikasi Email (ON)</span></label>
                        <label class="flex items-center gap-3 cursor-pointer"><input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold"><span class="text-sm text-gray-700">Notifikasi Website (ON)</span></label>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terakhir -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Aktivitas Terakhir</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-gray-100 pb-2"><span class="text-gray-600">Login</span><span class="font-medium text-gray-800">Hari Ini, 08.10</span></div>
                    <div class="flex justify-between border-b border-gray-100 pb-2"><span class="text-gray-600">Artikel Terakhir</span><span class="font-medium text-gray-800">Panduan VPN</span></div>
                    <div class="flex justify-between border-b border-gray-100 pb-2"><span class="text-gray-600">Download Terakhir</span><span class="font-medium text-gray-800">SOP Backup</span></div>
                    <div class="flex justify-between border-b border-gray-100 pb-0"><span class="text-gray-600">Komentar Terakhir</span><span class="font-medium text-gray-800">Panduan Email</span></div>
                </div>
            </div>

            <!-- Bookmark Terbaru -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Bookmark Terbaru</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2"><span class="text-sm text-gray-700 flex items-center gap-2"><span class="text-gold">📌</span> Panduan VPN</span><span class="text-[10px] text-gray-400">Kemarin</span></li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2"><span class="text-sm text-gray-700 flex items-center gap-2"><span class="text-gold">📌</span> SOP Backup</span><span class="text-[10px] text-gray-400">2 hari lalu</span></li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-0"><span class="text-sm text-gray-700 flex items-center gap-2"><span class="text-gold">📌</span> Panduan Email</span><span class="text-[10px] text-gray-400">3 hari lalu</span></li>
                </ul>
            </div>

            <!-- Keamanan -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b border-gray-100 pb-2">Keamanan</h3>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-darkbg text-white hover:bg-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm hover:shadow">Ganti Password</button>
                    <button class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Aktivitas Login</button>
                    <button class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Perangkat Aktif</button>
                    <button class="border border-red-500 text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Logout Semua Device</button>
                </div>
            </div>
        </div>

        <!-- ==================== 6. SETTINGS TAB ==================== -->
        <div id="tab-settings" class="tab-content">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pengaturan</h1>
                    <p class="text-sm text-gray-500 mt-1">Sesuaikan pengalaman Anda menggunakan AKSARA.</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up">
                <p class="text-gray-500 text-sm">Halaman ini berisi pengaturan global yang mencakup preferensi, notifikasi, dan keamanan yang sudah diatur pada halaman Profile.</p>
                <button onclick="switchTab('profile')" class="mt-4 text-blue-600 hover:underline text-sm font-medium">Lihat Pengaturan di Profile →</button>
            </div>
        </div>

    </main>

    <script>
        // --- Toggle Sidebar Mobile ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
            } else {
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        // --- Switch Tab Logic ---
        function switchTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            // Remove active state from sidebar links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('bg-gray-100', 'text-gray-900', 'border-gray-200');
                link.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
                const svg = link.querySelector('svg');
                if(svg) svg.classList.remove('text-gold');
                if(svg) svg.classList.add('text-gray-500');
            });

            // Show target tab
            const target = document.getElementById('tab-' + tabId);
            if(target) target.classList.add('active');

            // Highlight active sidebar link
            const activeLink = document.querySelector(`.sidebar-link[onclick*="'${tabId}'"]`);
            if(activeLink) {
                activeLink.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
                activeLink.classList.add('bg-gray-100', 'text-gray-900', 'border-gray-200');
                const svg = activeLink.querySelector('svg');
                if(svg) svg.classList.add('text-gold');
                if(svg) svg.classList.remove('text-gray-500');
            }

            // Inisialisasi Chart jika tab Dashboard yang dibuka
            if(tabId === 'dashboard') {
                setTimeout(initDashboardCharts, 150); // Delay sejenak agar DOM siap
            }

            // Close sidebar on mobile after selection
            if(window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar-mobile');
                const overlay = document.getElementById('sidebar-overlay');
                if(!sidebar.classList.contains('-translate-x-full')) {
                    overlay.classList.add('opacity-0');
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    }, 300);
                }
            }
        }

        // --- Chart Initialization ---
        let chartsInitialized = false;
        let activityChartInstance = null;
        let trendChartInstance = null;

        function initDashboardCharts() {
            // Cegah inisialisasi ganda
            if (chartsInitialized) return;
            
            const activityCtx = document.getElementById('userActivityChart');
            const trendCtx = document.getElementById('userTrendChart');

            // Pastikan elemen canvas ada
            if (!activityCtx || !trendCtx) return;

            // Hancurkan instance lama jika ada (untuk keamanan)
            if (activityChartInstance) activityChartInstance.destroy();
            if (trendChartInstance) trendChartInstance.destroy();

            // Chart 1: Distribusi Aktivitas (Doughnut)
            activityChartInstance = new Chart(activityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Membaca', 'Download', 'Bookmark'],
                    datasets: [{
                        data: [98, 12, 15],
                        backgroundColor: ['#3B82F6', '#8B5CF6', '#EAB308'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, boxWidth: 8, padding: 15, font: { size: 11 } }
                        }
                    },
                    cutout: '65%'
                }
            });

            // Chart 2: Aktivitas 7 Hari Terakhir (Bar)
            trendChartInstance = new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Aktivitas',
                        data: [12, 18, 10, 25, 20, 5, 8],
                        backgroundColor: '#EAB308',
                        borderRadius: 4,
                        barThickness: 25
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { stepSize: 5, font: { size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });

            chartsInitialized = true;
        }

        // Set initial tab to dashboard on load
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('dashboard');
        });
    </script>
</body>
</html>