<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - AKSARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        'pulse-dot': 'pulse-dot 2s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'pulse-dot': {
                            '0%, 100%': { opacity: 1, transform: 'scale(1)' },
                            '50%': { opacity: 0.5, transform: 'scale(1.2)' },
                        }
                    }
                } 
            } 
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Sidebar Mobile & Dropdown */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        .submenu {
            transition: all 0.3s ease-in-out;
            overflow: hidden;
        }
        /* Hover Effects */
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08);
        }
        /* Chart Container Responsiveness */
        .chart-container {
            position: relative;
            height: 100%;
            width: 100%;
        }
        /* Hide scrollbar for cleaner sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar-scroll {
            scrollbar-width: thin;
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

        <!-- SIDEBAR DENGAN DROPDOWN -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 sidebar-scroll">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">A</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">AKSARA</span>
                <span class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Super Admin</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            
            <!-- Dashboard (Status Aktif) -->
            <a href="/admin/dashboard" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Dashboard
            </a>
            
            <!-- Menu Utama 1: Knowledge Management -->
            <div>
                <button onclick="toggleSubmenu('submenu-knowledge')" class="w-full flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Knowledge Management
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" id="arrow-knowledge" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="submenu-knowledge" class="submenu hidden pl-9 space-y-1 mt-1">
                    <!-- Semua tautan submenu telah diperbaiki -->
                    <a href="/admin/all-articles" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• All Articles</a>
                    <a href="/admin/pending-approval" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">23</span></a>
                    <a href="/admin/draft" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Draft</a>
                    <a href="/admin/revision" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Revision</a>
                    <a href="/admin/published" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Published</a>
                    <a href="/admin/archive" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Archived</a>
                    <a href="/admin/delete" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Deleted</a>
                </div>
            </div>

            <!-- Menu Utama 2: User Management (Diubah menjadi menu tunggal) -->
            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>

            <!-- Menu Utama 3: Category (Menggantikan Master Data, menu tunggal) -->
            <a href="/admin/category" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>

            <!-- Menu Utama 4: Single Links (Semua tautan telah diperbaiki) -->
            <a href="/admin/analytics" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Analytics
            </a>
            <a href="/admin/searchlog" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
            </a>
            <a href="/admin/feedback" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>
            <a href="/admin/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            <a href="/admin/activity" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
            </a>
            <a href="/admin/storage" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z"></path></svg> Storage
            </a>
            <a href="/admin/settings" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Settings
            </a>
            <a href="/admin/backup" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Backup & Restore
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name=Admin+Utama&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Admin Diskominfo</span>
                    <span class="text-[10px] text-gray-400">Super Admin</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Admin Dashboard</h2>
        </div>

        <!-- Header & Welcome Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Selamat Datang, Administrator</h1>
                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 mt-1">
                    <span class="bg-red-100 text-red-700 px-2.5 py-0.5 rounded text-[10px] font-bold">Kominfo Provinsi Lampung</span>
                    <span class="text-gray-300">|</span>
                    <span class="font-medium text-gray-700">Sabtu, 27 Juni 2026</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-blue-600 font-medium">08.25 WIB</span>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 border border-gray-200 rounded-lg shadow-sm w-full md:w-auto">
                <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse-dot"></div>
                <span class="text-xs font-bold text-gray-700">Database & API Online</span>
            </div>
        </div>

        <!-- Quick Action -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6 fade-in-up" style="animation-delay: 0.2s;">
            <button class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 hover:shadow-md hover:-translate-y-1 transition-all duration-200 stat-card">
                <span class="text-xl">➕</span>
                <span class="text-[10px] font-bold text-gray-700 text-center">Approve Artikel</span>
            </button>
            <button class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 hover:shadow-md hover:-translate-y-1 transition-all duration-200 stat-card">
                <span class="text-xl">👥</span>
                <span class="text-[10px] font-bold text-gray-700 text-center">Tambah User</span>
            </button>
            <button class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 hover:shadow-md hover:-translate-y-1 transition-all duration-200 stat-card">
                <span class="text-xl">📚</span>
                <span class="text-[10px] font-bold text-gray-700 text-center">Tambah Kategori</span>
            </button>
            <button class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 hover:shadow-md hover:-translate-y-1 transition-all duration-200 stat-card">
                <span class="text-xl">📊</span>
                <span class="text-[10px] font-bold text-gray-700 text-center">Analytics</span>
            </button>
            <button class="bg-white border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 hover:shadow-md hover:-translate-y-1 transition-all duration-200 stat-card">
                <span class="text-xl">💾</span>
                <span class="text-[10px] font-bold text-gray-700 text-center">Backup</span>
            </button>
        </div>

        <!-- Summary Cards (12 Kartu) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-8 fade-in-up" style="animation-delay: 0.3s;">
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">👥 Total User</p>
                <p class="text-xl font-bold text-gray-900">1,245</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">👨‍💼 Total Staff</p>
                <p class="text-xl font-bold text-gray-900">325</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">📄 Total Artikel</p>
                <p class="text-xl font-bold text-gray-900">12,563</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-yellow-600 uppercase mb-1 flex items-center gap-1">🟡 Pending</p>
                <p class="text-xl font-bold text-gray-900">23</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-green-600 uppercase mb-1 flex items-center gap-1">🟢 Published</p>
                <p class="text-xl font-bold text-gray-900">11,987</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-red-600 uppercase mb-1 flex items-center gap-1">🔴 Rejected</p>
                <p class="text-xl font-bold text-gray-900">18</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-gray-600 uppercase mb-1 flex items-center gap-1">📦 Archived</p>
                <p class="text-xl font-bold text-gray-900">145</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-blue-600 uppercase mb-1 flex items-center gap-1">🔒 Private</p>
                <p class="text-xl font-bold text-gray-900">67</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-purple-600 uppercase mb-1 flex items-center gap-1">💾 Storage</p>
                <p class="text-xl font-bold text-gray-900">31 GB</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-cyan-600 uppercase mb-1 flex items-center gap-1">⬇ Download</p>
                <p class="text-xl font-bold text-gray-900">58,321</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-gold uppercase mb-1 flex items-center gap-1">⭐ Rating</p>
                <p class="text-xl font-bold text-gray-900">4.8</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card">
                <p class="text-[10px] font-bold text-orange-600 uppercase mb-1 flex items-center gap-1">💬 Feedback</p>
                <p class="text-xl font-bold text-gray-900">425</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.4s;">
            <!-- 1. Upload Knowledge (Bar Chart) -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-gold"></span> Upload Knowledge
                </h3>
                <p class="text-xs text-gray-400 mb-4">Chart Bulanan</p>
                <div class="chart-container h-64">
                    <canvas id="uploadChart"></canvas>
                </div>
            </div>

            <!-- 2. & 3. Sidebar Kanan: Pie & Donut Charts -->
            <div class="space-y-6">
                <!-- OPD Pie Chart -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">Artikel Berdasarkan OPD</h3>
                    <div class="chart-container h-32">
                        <canvas id="opdChart"></canvas>
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mt-2 text-[10px] font-medium text-gray-500">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> Kominfo</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-400"></span> BKD</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-400"></span> Bappeda</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-400"></span> Dinkes</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-400"></span> Disdik</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-400"></span> Inspektorat</span>
                    </div>
                </div>

                <!-- Status Donut Chart -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">Status Artikel</h3>
                    <div class="chart-container h-32">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mt-2 text-[10px] font-medium text-gray-500">
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-300"></span> Draft</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> Pending</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-400"></span> Published</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-400"></span> Revision</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-600"></span> Archive</span>
                        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-400"></span> Delete</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Widgets: Top Contributor, Populer, Search Keywords -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in-up" style="animation-delay: 0.5s;">
            <!-- Top Contributor -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">🏆 Top Contributor</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">Wildan</span>
                        <span class="text-xs font-bold text-gray-400">125 Artikel</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">Rina</span>
                        <span class="text-xs font-bold text-gray-400">114 Artikel</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-0">
                        <span class="font-medium text-gray-700 text-sm">Andi</span>
                        <span class="text-xs font-bold text-gray-400">90 Artikel</span>
                    </li>
                </ul>
            </div>

            <!-- Artikel Terpopuler -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">🔥 Artikel Terpopuler</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">SOP VPN</span>
                        <span class="text-xs font-bold text-gray-400">5.621 View</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">SOP Backup</span>
                        <span class="text-xs font-bold text-gray-400">4.911 View</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-0">
                        <span class="font-medium text-gray-700 text-sm">Panduan Email</span>
                        <span class="text-xs font-bold text-gray-400">3.700 View</span>
                    </li>
                </ul>
            </div>

            <!-- Search Keywords -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 text-sm flex items-center gap-2">🔍 Search Keyword</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">VPN</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">Backup</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">Server</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">Email</span>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">Jaringan</span>
                </div>
                <p class="text-[10px] text-gray-400 mt-4 text-center">Admin bisa tahu apa yang paling banyak dicari.</p>
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

        // --- Toggle Sidebar Dropdowns ---
        function toggleSubmenu(id) {
            const el = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id.split('-')[1]);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                if(arrow) arrow.classList.add('rotate-180');
            } else {
                el.classList.add('hidden');
                if(arrow) arrow.classList.remove('rotate-180');
            }
        }

        // --- Chart.js Initialization ---
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Upload Knowledge Chart (Bar)
            const ctx1 = document.getElementById('uploadChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Upload Knowledge',
                        data: [3, 6, 7, 4, 8, 10],
                        backgroundColor: '#EAB308',
                        borderRadius: 4,
                        barThickness: 35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F5F9' }, ticks: { stepSize: 1 } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. OPD Chart (Pie)
            const ctx2 = document.getElementById('opdChart').getContext('2d');
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Kominfo', 'BKD', 'Bappeda', 'Dinkes', 'Disdik', 'Inspektorat'],
                    datasets: [{
                        data: [35, 20, 15, 10, 12, 8],
                        backgroundColor: ['#EAB308', '#3B82F6', '#22C55E', '#EF4444', '#A855F7', '#F97316'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            // 3. Status Chart (Donut)
            const ctx3 = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx3, {
                type: 'doughnut',
                data: {
                    labels: ['Draft', 'Pending', 'Published', 'Revision', 'Archive', 'Delete'],
                    datasets: [{
                        data: [150, 23, 11987, 45, 145, 10],
                        backgroundColor: ['#D1D5DB', '#EAB308', '#22C55E', '#F97316', '#4B5563', '#EF4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '65%'
                }
            });
        });
    </script>
</body>
</html>