<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Log - AKSARA</title>
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
        /* Sidebar Mobile */
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
        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

        <!-- SIDEBAR (Dipertahankan persis, dengan Search Log sebagai menu baru yang aktif) -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 sidebar-scroll">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">A</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">AKSARA</span>
                <span class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Super Admin</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            
            <!-- Dashboard -->
            <a href="/admin/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Dashboard
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
                    <a href="/admin/all-articles" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• All Articles</a>
                    <a href="/admin/pending-approval" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">23</span></a>
                    <a href="/admin/draft" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Draft</a>
                    <a href="/admin/revision" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Revision</a>
                    <a href="/admin/published" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Published</a>
                    <a href="/admin/archive" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Archived</a>
                    <a href="/admin/delete" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Deleted</a>
                </div>
            </div>

            <!-- Menu Utama 2: User Management -->
            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>

            <!-- Menu Utama 3: Category -->
            <a href="/admin/category" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>

            <!-- Menu Utama 4: Analytics -->
            <a href="/admin/analytics" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Analytics
            </a>

            <!-- Menu Utama 5: Feedback -->
            <a href="/admin/feedback" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>

            <!-- Menu Utama 6: Notification -->
            <a href="/admin/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>

            <!-- Menu Utama 7: Activity Log -->
            <a href="/admin/activity" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
            </a>

            <!-- Menu Utama 8: Search Log (Sedang Aktif) -->
            <a href="/admin/searchlog" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
            </a>

            <!-- Menu Utama 9: Storage -->
            <a href="/admin/storage" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z"></path></svg> Storage
            </a>

            <!-- Menu Utama 10: Settings -->
            <a href="/admin/settings" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Settings
            </a>

            <!-- Menu Utama 11: Backup & Restore -->
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

    <!-- MAIN CONTENT (Search Log Page) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Search Log</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Search Log</h1>
                <p class="text-sm text-gray-500 mt-1">Tujuan: Semua keyword yang diketik user disimpan. Misalnya user mencari VPN, Firewall, Email, Server, Mikrotik. Semuanya masuk database.</p>
            </div>
        </div>

        <!-- Ringkasan Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.2s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">🔍 Total Search</p>
                <p class="text-2xl font-bold text-gray-900">15.842</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">📅 Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">324</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.4s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">👤 User Aktif</p>
                <p class="text-2xl font-bold text-gray-900">120</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.5s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">✨ Keyword Baru</p>
                <p class="text-2xl font-bold text-gray-900">18</p>
            </div>
        </div>

        <!-- Trend Chart & Top Keyword Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.3s;">
            
            <!-- Trending Chart (Bar) -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-2">Trend Chart</h3>
                <div class="w-full h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Top Keyword List -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Top Keyword</h3>
                <ul class="space-y-3">
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">VPN</span>
                        <span class="text-xs font-bold text-gray-400">1.200</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">Backup</span>
                        <span class="text-xs font-bold text-gray-400">875</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-medium text-gray-700 text-sm">Server</span>
                        <span class="text-xs font-bold text-gray-400">654</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-100 pb-0">
                        <span class="font-medium text-gray-700 text-sm">Email</span>
                        <span class="text-xs font-bold text-gray-400">600</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Search History Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-8 fade-in-up" style="animation-delay: 0.4s;">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                <h3 class="font-bold text-gray-800 text-sm">Search History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-3 min-w-[120px]">Keyword</th>
                            <th class="px-4 py-3 min-w-[120px]">User</th>
                            <th class="px-4 py-3 min-w-[100px]">Role</th>
                            <th class="px-4 py-3 min-w-[120px]">OPD</th>
                            <th class="px-4 py-3 min-w-[80px]">Waktu</th>
                            <th class="px-4 py-3 min-w-[100px]">Hasil</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900">VPN</td>
                            <td class="px-4 py-3 text-gray-600">Wildan</td>
                            <td class="px-4 py-3 text-gray-600">Staff</td>
                            <td class="px-4 py-3 text-gray-600">Kominfo</td>
                            <td class="px-4 py-3 text-gray-600">08.15</td>
                            <td class="px-4 py-3"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">5 Artikel</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900">Firewall</td>
                            <td class="px-4 py-3 text-gray-600">Rina</td>
                            <td class="px-4 py-3 text-gray-600">Admin</td>
                            <td class="px-4 py-3 text-gray-600">Diskominfo</td>
                            <td class="px-4 py-3 text-gray-600">09.30</td>
                            <td class="px-4 py-3"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-[10px] font-bold">0 Hasil</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900">Email</td>
                            <td class="px-4 py-3 text-gray-600">Andi</td>
                            <td class="px-4 py-3 text-gray-600">Staff</td>
                            <td class="px-4 py-3 text-gray-600">BKD</td>
                            <td class="px-4 py-3 text-gray-600">10.05</td>
                            <td class="px-4 py-3"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">3 Artikel</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900">Server</td>
                            <td class="px-4 py-3 text-gray-600">Budi</td>
                            <td class="px-4 py-3 text-gray-600">Reviewer</td>
                            <td class="px-4 py-3 text-gray-600">Bappeda</td>
                            <td class="px-4 py-3 text-gray-600">11.20</td>
                            <td class="px-4 py-3"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">8 Artikel</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Keyword Tanpa Hasil & Group Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.5s;">
            
            <!-- Keyword Tanpa Hasil -->
            <div class="lg:col-span-1 bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-2">Keyword Tanpa Hasil</h3>
                <p class="text-xs text-gray-500 mb-4">Nah ini keren. Misalnya "Firewall Fortigate", 0 hasil masuk list.</p>
                <ul class="space-y-4">
                    <li class="flex flex-col border-b border-gray-100 pb-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-700 text-sm">Firewall Fortigate</span>
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">0 hasil</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400">45 Kali Dicari</span>
                            <button onclick="showToast('Artikel ditugaskan ke Wildan dengan deadline 7 hari!')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 text-[10px] font-bold px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Assign
                            </button>
                        </div>
                    </li>
                    <li class="flex flex-col border-b border-gray-100 pb-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-700 text-sm">Docker</span>
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">0 hasil</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400">20 Kali Dicari</span>
                            <button onclick="showToast('Artikel ditugaskan ke Rina dengan deadline 7 hari!')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 text-[10px] font-bold px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Assign
                            </button>
                        </div>
                    </li>
                    <li class="flex flex-col border-b border-gray-100 pb-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-700 text-sm">Virtual Machine</span>
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">0 hasil</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400">18 Kali Dicari</span>
                            <button onclick="showToast('Artikel ditugaskan ke Andi dengan deadline 7 hari!')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 text-[10px] font-bold px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Assign
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Search Berdasarkan OPD -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Search Berdasarkan OPD</h3>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-1">Kominfo</h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-medium">VPN</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-medium">Email</span>
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-medium">Server</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-1">BKD</h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-medium">Cuti</span>
                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-medium">Kepegawaian</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-1">BPKAD</h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-[10px] font-medium">Anggaran</span>
                            <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-[10px] font-medium">SPJ</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 italic">Admin tahu tiap OPD butuh knowledge apa.</p>
                </div>
            </div>

            <!-- Search Berdasarkan Role & Device -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-3">Search Berdasarkan Role</h3>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">User</span>
                            <span class="font-bold text-gray-800">4.2k</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">Staff</span>
                            <span class="font-bold text-gray-800">8.5k</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-0">
                            <span class="text-gray-600">Admin</span>
                            <span class="font-bold text-gray-800">3.1k</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic">Karena kebutuhan mereka berbeda.</p>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-3">Search Berdasarkan Device</h3>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">📱 Mobile</span>
                            <span class="font-bold text-gray-800 text-green-600">80%</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">💻 Desktop</span>
                            <span class="font-bold text-gray-800">15%</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-0">
                            <span class="text-gray-600">📟 Tablet</span>
                            <span class="font-bold text-gray-800">5%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic">Kalau ternyata 80% pengguna pakai HP, berarti UI mobile harus diprioritaskan.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Search Success Rate & Search Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 fade-in-up" style="animation-delay: 0.6s;">
            
            <!-- Success Rate Doughnut Chart -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Search Success Rate</h3>
                <p class="text-xs text-gray-500 mb-4">Ini jarang ada. Persentase pencarian yang berhasil vs tidak ditemukan.</p>
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-full md:w-1/2 h-48 relative">
                        <canvas id="successRateChart"></canvas>
                    </div>
                    <div class="flex-1 space-y-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">Total Search</span>
                            <span class="font-bold text-gray-900">15.000</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-green-600 font-medium">Berhasil</span>
                            <span class="font-bold text-gray-900">13.500 (90%)</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-0">
                            <span class="text-red-600 font-medium">Tidak Ditemukan</span>
                            <span class="font-bold text-gray-900">1.500 (10%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Analytics Table -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm">Search Analytics</h3>
                    <p class="text-[10px] text-gray-500">Admin bisa lihat Keyword, Jumlah Search, Klik, CTR, Artikel Dibaca.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 text-[10px] uppercase text-gray-500 font-bold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 min-w-[80px]">Keyword</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">Search</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">Klik</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">CTR</th>
                                <th class="px-4 py-2 min-w-[100px]">Artikel Dibaca</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                <td class="px-4 py-2 font-medium text-gray-900">VPN</td>
                                <td class="px-4 py-2 text-center text-gray-600">1.200</td>
                                <td class="px-4 py-2 text-center text-gray-600">1.180</td>
                                <td class="px-4 py-2 text-center text-green-600 font-bold">98%</td>
                                <td class="px-4 py-2 text-gray-600">Panduan VPN</td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                <td class="px-4 py-2 font-medium text-gray-900">Firewall</td>
                                <td class="px-4 py-2 text-center text-gray-600">250</td>
                                <td class="px-4 py-2 text-center text-gray-600">50</td>
                                <td class="px-4 py-2 text-center text-red-600 font-bold">20%</td>
                                <td class="px-4 py-2 text-gray-600">-</td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                <td class="px-4 py-2 font-medium text-gray-900">Backup</td>
                                <td class="px-4 py-2 text-center text-gray-600">875</td>
                                <td class="px-4 py-2 text-center text-gray-600">800</td>
                                <td class="px-4 py-2 text-center text-green-600 font-bold">91%</td>
                                <td class="px-4 py-2 text-gray-600">SOP Backup</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

        // --- Toggle Knowledge Management Submenu ---
        function toggleSubmenu(id) {
            const el = document.getElementById(id);
            const arrow = document.getElementById('arrow-knowledge');
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                if(arrow) arrow.classList.add('rotate-180');
            } else {
                el.classList.add('hidden');
                if(arrow) arrow.classList.remove('rotate-180');
            }
        }

        // --- Custom Simple Toast Notification Helper ---
        function showToast(message) {
            const toastContainer = document.createElement('div');
            toastContainer.className = `fixed top-5 right-5 z-[9999] bg-white border-l-4 border-gold p-4 rounded-lg shadow-xl transform translate-x-[120%] animate-[slideInRight_0.4s_ease-out_forwards]`;
            toastContainer.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="text-gold text-lg font-bold">✦</span>
                    <p class="text-sm font-medium text-gray-800">${message}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 ml-4">✕</button>
                </div>
            `;
            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.style.transform = 'translateX(120%)';
                toastContainer.style.transition = 'transform 0.3s ease-in';
                setTimeout(() => toastContainer.remove(), 300);
            }, 3500);
        }

        // Add CSS for slideInRight if not defined in tailwind config
        const styleSheet = document.createElement("style");
        styleSheet.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(styleSheet);

        // --- Chart.js Initialization ---
        document.addEventListener("DOMContentLoaded", function() {
            
            // 1. Trend Chart (Bar)
            const ctx1 = document.getElementById('trendChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['VPN', 'Backup', 'Email', 'Firewall'],
                    datasets: [{
                        label: 'Trend Search',
                        data: [1200, 875, 600, 250],
                        backgroundColor: '#EAB308',
                        borderRadius: 4,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. Success Rate (Doughnut)
            const ctx2 = document.getElementById('successRateChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Berhasil', 'Tidak Ditemukan'],
                    datasets: [{
                        data: [13500, 1500],
                        backgroundColor: ['#22C55E', '#EF4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>