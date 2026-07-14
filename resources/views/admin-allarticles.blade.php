<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles - AKSARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        /* Dropdown Menu Animation */
        .dropdown-menu {
            transform-origin: top right;
            transition: transform 0.1s ease, opacity 0.1s ease;
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

        <!-- SIDEBAR (Dipertahankan persis dari kode Admin Dashboard sebelumnya) -->
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

            <!-- Menu Utama 2: User Management (Diubah menjadi menu tunggal) -->
            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>

            <!-- Menu Utama 3: Category (Menggantikan Master Data, menu tunggal) -->
            <a href="/admin/category" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>

            <!-- Menu Utama 4: Single Links (Semua tautan sudah diperbaiki) -->
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

    <!-- MAIN CONTENT (All Articles Page) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">All Articles</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">All Articles</h1>
                <p class="text-sm text-gray-500 mt-1">Semua artikel seluruh pegawai. Kelola, review, dan pantau status publikasi.</p>
            </div>
            <button class="w-full md:w-auto bg-darkbg text-white hover:bg-gray-800 font-bold py-2 px-6 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                + Tambah Artikel Baru
            </button>
        </div>

        <!-- Filter Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 fade-in-up" style="animation-delay: 0.2s;">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Cari Judul Artikel..." class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                </div>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>Kategori</option>
                    <option>SOP</option>
                    <option>Tutorial</option>
                    <option>Infrastruktur</option>
                </select>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>OPD</option>
                    <option>Kominfo</option>
                    <option>BKD</option>
                    <option>Bappeda</option>
                </select>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>Penulis</option>
                    <option>Wildan</option>
                    <option>Rina</option>
                    <option>Andi</option>
                </select>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>Status</option>
                    <option>Published</option>
                    <option>Pending</option>
                    <option>Draft</option>
                    <option>Revision</option>
                    <option>Archived</option>
                </select>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>Visibility</option>
                    <option>Public</option>
                    <option>Internal</option>
                    <option>Private</option>
                </select>
                <input type="date" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option>Version</option>
                    <option>v1.0</option>
                    <option>v2.0</option>
                    <option>v2.1</option>
                </select>
                <select class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-1">
                    <option>Sort By: Terbaru</option>
                    <option>Sort By: Terlama</option>
                    <option>Sort By: Rating</option>
                    <option>Sort By: Views</option>
                </select>
            </div>
            <div class="mt-3 flex justify-end">
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Terapkan Filter</button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></th>
                            <th class="px-4 py-4 min-w-[220px]">Judul</th>
                            <th class="px-4 py-4 min-w-[120px]">Penulis</th>
                            <th class="px-4 py-4 min-w-[120px]">Kategori</th>
                            <th class="px-4 py-4 min-w-[120px]">Status</th>
                            <th class="px-4 py-4 min-w-[80px] text-center">View</th>
                            <th class="px-4 py-4 min-w-[80px] text-center">Rating</th>
                            <th class="px-4 py-4 min-w-[80px] text-center">Version</th>
                            <th class="px-4 py-4 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">Panduan VPN</td>
                            <td class="px-4 py-4 text-gray-600">Wildan</td>
                            <td class="px-4 py-4 text-gray-600">Tutorial</td>
                            <td class="px-4 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Published</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">2.1k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">4.9</td>
                            <td class="px-4 py-4 text-center text-gray-600">v2.1</td>
                            <td class="px-4 py-4 text-center relative">
                                <!-- Action Dropdown -->
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Approve</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Reject</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Restore</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Rollback</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> History</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">SOP Backup Server</td>
                            <td class="px-4 py-4 text-gray-600">Rina</td>
                            <td class="px-4 py-4 text-gray-600">SOP</td>
                            <td class="px-4 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Pending</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">1.8k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">5.0</td>
                            <td class="px-4 py-4 text-center text-gray-600">v2.0</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Approve</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Reject</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Restore</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Rollback</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> History</button>
                                            <button class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

        // --- Logic Dropdown Action Menu ---
        function toggleDropdown(button) {
            const menu = button.parentElement.querySelector('.dropdown-menu');
            const isHidden = menu.classList.contains('hidden');
            // Close all dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) {
                    m.classList.add('hidden');
                    m.classList.remove('scale-100', 'opacity-100');
                    m.classList.add('scale-95', 'opacity-0');
                }
            });
            if (isHidden) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-95', 'opacity-0');
                    menu.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 100);
            }
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    m.classList.remove('scale-100', 'opacity-100');
                    m.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        m.classList.add('hidden');
                    }, 100);
                });
            }
        });
    </script>
</body>
</html>