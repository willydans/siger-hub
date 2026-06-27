<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penulis - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        darkbg: '#0F172A', 
                        gold: '#EAB308', 
                        goldhover: '#CA8A04', 
                        lightbg: '#F8FAFC', 
                        cardborder: '#E2E8F0', 
                        textmain: '#334155' 
                    } 
                } 
            } 
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom Animation Ringan & Lebay tapi Elegan */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }

        /* Sidebar Mobile Styling */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Sidebar Overlay untuk Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

        <!-- SIDEBAR (Dipertahankan & Ditambah Menu Notification) -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="/" class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm hover:scale-[1.02] duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Portal Publik
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            
            <!-- Dashboard sekarang aktif (ditandai dengan background dan border) -->
            <a href="/staff/dashboard" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            
            <a href="/staff/articles" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            <a href="/staff/draft" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft
            </a>
            <a href="/staff/revision" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            
            <!-- Notification sekarang tidak aktif (dikembalikan seperti menu lainnya) -->
            <a href="/staff/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            
            <a href="/staff/editor" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="/staff/profile" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name=Ghaisan+Wildan&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Ghaisan Wildan</span>
                    <span class="text-[10px] text-gray-400">Staff E-Government</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50">
        
        <!-- HEADER SECTION -->
        <header class="bg-white border-b border-gray-200 p-6 md:p-8 sticky top-0 z-10 shadow-sm">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <!-- Tombol Toggle Sidebar untuk Mobile -->
                    <button onclick="toggleSidebar()" class="block md:hidden text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 fade-in-up">Selamat Datang, Ghaisan Wildan</h1>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 fade-in-up delay-1">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-medium">Staff - Bidang E-Government</span>
                            <span class="text-gray-300">|</span>
                            <span>Kominfo Provinsi Lampung</span>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:block text-right fade-in-up delay-2">
                    <p class="text-sm text-gray-400 font-medium">Hari ini :</p>
                    <p class="text-sm font-bold text-gray-800">Sabtu, 27 Juni 2026</p>
                </div>
            </div>
        </header>

        <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">

            <!-- RINGKASAN STATISTIK (8 KARTU) -->
            <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                <!-- Kartu 1 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Artikel</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">25</p>
                </div>
                <!-- Kartu 2 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-2">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Draft</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">5</p>
                </div>
                <!-- Kartu 3 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Approval</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">3</p>
                </div>
                <!-- Kartu 4 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Published</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">17</p>
                </div>
                <!-- Kartu 5 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-1">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-red-50 text-red-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rejected</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">2</p>
                </div>
                <!-- Kartu 6 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-2">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Views</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">12.340</p>
                </div>
                <!-- Kartu 7 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-gold/20 text-gold rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rating Rata-rata</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">4.8</p>
                </div>
                <!-- Kartu 8 -->
                <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm fade-in-up delay-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Komentar</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">87</p>
                </div>
            </section>

            <!-- SECTION GRAFIK & TOP 5 -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- KIRI: GRAFIK ARTIKEL PER BULAN (2/3 Lebar) -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-2 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">Grafik Artikel per Bulan</h3>
                        <div class="flex items-center gap-1 text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <span class="w-2 h-2 bg-gold rounded-full inline-block"></span>
                            <span>Total Artikel</span>
                        </div>
                    </div>
                    <div class="w-full h-64">
                        <canvas id="articleChart"></canvas>
                    </div>
                </div>

                <!-- KANAN: PIE CHART & TOP 5 (1/3 Lebar) -->
                <div class="space-y-6">
                    <!-- PIE CHART STATUS -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3 hover:shadow-md transition-shadow">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Status Artikel</h3>
                        <div class="w-full h-40 relative flex justify-center">
                            <canvas id="statusChart"></canvas>
                        </div>
                        <div class="flex flex-wrap justify-center gap-3 mt-4 text-[10px] font-medium">
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Published</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Pending</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Rejected</span>
                            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span> Draft</span>
                        </div>
                    </div>

                    <!-- TOP 5 ARTIKEL TERPOPULER -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-4 hover:shadow-md transition-shadow">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Top 5 Artikel Terpopuler</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center justify-between text-sm border-b border-gray-100 pb-2 last:border-0 last:pb-0 hover:bg-gray-50 -mx-2 px-2 py-1 rounded transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-gold/20 text-gold text-[10px] font-bold flex items-center justify-center">1</span>
                                    <span class="font-medium text-gray-700">Panduan VPN</span>
                                </div>
                                <span class="text-xs text-gray-400">2.1k views</span>
                            </li>
                            <li class="flex items-center justify-between text-sm border-b border-gray-100 pb-2 last:border-0 last:pb-0 hover:bg-gray-50 -mx-2 px-2 py-1 rounded transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold flex items-center justify-center">2</span>
                                    <span class="font-medium text-gray-700">SOP Backup</span>
                                </div>
                                <span class="text-xs text-gray-400">1.8k views</span>
                            </li>
                            <li class="flex items-center justify-between text-sm border-b border-gray-100 pb-2 last:border-0 last:pb-0 hover:bg-gray-50 -mx-2 px-2 py-1 rounded transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold flex items-center justify-center">3</span>
                                    <span class="font-medium text-gray-700">SOP Email</span>
                                </div>
                                <span class="text-xs text-gray-400">1.5k views</span>
                            </li>
                            <li class="flex items-center justify-between text-sm border-b border-gray-100 pb-2 last:border-0 last:pb-0 hover:bg-gray-50 -mx-2 px-2 py-1 rounded transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-orange-50 text-orange-600 text-[10px] font-bold flex items-center justify-center">4</span>
                                    <span class="font-medium text-gray-700">Panduan Laravel</span>
                                </div>
                                <span class="text-xs text-gray-400">1.2k views</span>
                            </li>
                            <li class="flex items-center justify-between text-sm border-b border-gray-100 pb-2 last:border-0 last:pb-0 hover:bg-gray-50 -mx-2 px-2 py-1 rounded transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-bold flex items-center justify-center">5</span>
                                    <span class="font-medium text-gray-700">Instalasi Server</span>
                                </div>
                                <span class="text-xs text-gray-400">950 views</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- SECTION AKTIVITAS TERBARU & WIDGET -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- KIRI: AKTIVITAS TERBARU -->
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3 hover:shadow-md transition-shadow">
                    <h3 class="font-bold text-gray-800 text-lg mb-6">Aktivitas Terbaru</h3>
                    <div class="relative border-l border-gray-200 ml-3 space-y-8">
                        
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-green-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800 text-sm">Artikel "Panduan VPN"</span>
                                    <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Disetujui Admin</span>
                                </div>
                                <span class="text-[11px] text-gray-400 font-medium">10.30</span>
                            </div>
                        </div>

                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-yellow-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800 text-sm">Artikel "Backup Server"</span>
                                    <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">Direvisi</span>
                                </div>
                                <span class="text-[11px] text-gray-400 font-medium">09.10</span>
                            </div>
                        </div>

                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-blue-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800 text-sm">Artikel "SOP Email"</span>
                                    <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Dipublish</span>
                                </div>
                                <span class="text-[11px] text-gray-400 font-medium">Kemarin</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- KANAN: NOTIFIKASI & QUICK ACTION -->
                <div class="space-y-6">
                    <!-- WIDGET NOTIFIKASI -->
                    <div class="bg-white rounded-xl border-l-4 border-gold border-y border-r border-gray-200 shadow-sm p-6 fade-in-up delay-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-red-50 text-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Notification Widget</h4>
                                    <p class="text-xs text-gray-500">Ada pembaruan penting</p>
                                </div>
                            </div>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse">1</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100 mb-4 flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Admin meminta revisi artikel</p>
                                <p class="text-xs text-gray-500">"Panduan VPN"</p>
                            </div>
                            <a href="#" class="text-[11px] bg-navy/10 text-navy px-3 py-1 rounded-full font-medium hover:bg-navy hover:text-white transition-colors">Klik disini</a>
                        </div>
                    </div>

                    <!-- QUICK ACTION -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-1 hover:shadow-md transition-shadow">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Quick Action</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="/staff/editor" class="flex flex-col items-center justify-center gap-2 bg-gold/10 hover:bg-gold/20 border border-gold/20 rounded-xl p-4 transition-colors hover:scale-[1.02] duration-200">
                                <div class="w-10 h-10 bg-gold text-darkbg rounded-full flex items-center justify-center text-lg font-bold">➕</div>
                                <span class="text-xs font-bold text-gray-700 text-center">Buat Artikel</span>
                            </a>
                            <a href="/staff/articles?status=draft" class="flex flex-col items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl p-4 transition-colors hover:scale-[1.02] duration-200">
                                <div class="w-10 h-10 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-lg">📂</div>
                                <span class="text-xs font-bold text-gray-700 text-center">Draft</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center gap-2 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-xl p-4 transition-colors hover:scale-[1.02] duration-200">
                                <div class="w-10 h-10 bg-blue-200 text-blue-700 rounded-full flex items-center justify-center text-lg">🔍</div>
                                <span class="text-xs font-bold text-gray-700 text-center">Cari Artikel</span>
                            </a>
                            <a href="/staff/dashboard" class="flex flex-col items-center justify-center gap-2 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl p-4 transition-colors hover:scale-[1.02] duration-200">
                                <div class="w-10 h-10 bg-purple-200 text-purple-700 rounded-full flex items-center justify-center text-lg">📊</div>
                                <span class="text-xs font-bold text-gray-700 text-center">Lihat Statistik</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <script>
        // --- SCRIPT TOGGLE SIDEBAR MOBILE ---
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

        // --- SCRIPT CHART.JS ---
        document.addEventListener("DOMContentLoaded", function() {
            // GRAFIK ARTIKEL PER BULAN (BAR CHART)
            const ctx1 = document.getElementById('articleChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
                    datasets: [{
                        label: 'Total Artikel',
                        data: [3, 7, 4, 9, 7], // Data sesuai visual prompt (█)
                        backgroundColor: '#EAB308', // Gold
                        borderRadius: 6,
                        barThickness: 35
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
                            grid: { color: '#F1F5F9', drawBorder: false },
                            ticks: { font: { family: "'Inter', sans-serif" } }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { family: "'Inter', sans-serif" } }
                        }
                    }
                }
            });

            // STATUS ARTIKEL (PIE CHART)
            const ctx2 = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Pending', 'Rejected', 'Draft'],
                    datasets: [{
                        data: [17, 3, 2, 5], // 17+3+2+5 = 27 (Total 25? Check prompt: Published 17, Pending 3, Rejected 2, Draft 5. Total is 17+3+2+5 = 27. Wait, prompt says Total Artikel 25. Let's adjust to match 25. Let's use 15 Published to make it 25. Recalculate: 15 + 3 + 2 + 5 = 25. Let's adjust prompt data to match visually. Or trust the text count. Wait, I'll use exactly what user typed: Total 25 (5+3+17+2=27 is a mismatch in user prompt! I must stick to user's numbers for "Ringkasan Statistik" but for pie chart sum must be 25. I will tweak Published to 15 so sum = 5+3+15+2=25, or I'll leave user's numbers and let it sum to 27. Let's keep user's numbers: 5(Draft), 3(Pending), 17(Published), 2(Rejected). Sum = 27. It's fine, user provided those specific numbers. I'll use them exactly.)
                        // Updated to match user's explicit numbers: Published 17, Pending 3, Rejected 2, Draft 5.
                        data: [17, 3, 2, 5], 
                        backgroundColor: ['#22C55E', '#EAB308', '#EF4444', '#D1D5DB'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    cutout: '70%',
                }
            });
        });
    </script>
</body>
</html>