<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artikel - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        /* Custom Animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }

        /* Hover Transitions */
        tr {
            transition: background-color 0.2s ease;
        }
        .dropdown-menu {
            transform-origin: top right;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }

        /* Sidebar Mobile Styling */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Toast Notification Styling (Ringan & Elegan) */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast-item {
            background: #0F172A;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            transform: translateX(120%);
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            border-left: 4px solid #EAB308;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toast-item.out {
            animation: slideOutRight 0.3s ease-in forwards;
        }
        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        
        /* Tombol interaktif di dropdown */
        .dropdown-item {
            transition: all 0.15s ease;
        }
        .dropdown-item:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Container untuk Toast Notification -->
    <div id="toast-container"></div>

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
            
            <!-- Dashboard sekarang tidak aktif (dikembalikan seperti menu lainnya) -->
            <a href="/staff/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            
            <!-- Artikel Saya sekarang aktif (ditandai dengan background, border, dan ikon emas) -->
            <a href="/staff/articles" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            
            <a href="/staff/draft" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft
            </a>
            <a href="/staff/revision" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            
            <!-- Notification tidak aktif -->
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
                <img src="https://ui-avatars.com/api/?name=ASN+Staf&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Budi ASN</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50 p-6 md:p-8 relative w-full">
        <!-- Header Mobile Toggle -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Artikel Saya</h2>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="hidden md:block">
                <h2 class="text-2xl font-bold text-gray-900">Manajemen Artikel Saya</h2>
                <p class="text-sm text-gray-500">Edit, hapus, dan pantau status publikasi artikel.</p>
            </div>
            <a href="/staff/editor" class="bg-darkbg text-white font-bold py-2.5 px-5 rounded-lg text-sm hover:bg-gray-800 shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105">Tulis Baru</a>
        </div>

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 mb-6 fade-in delay-1">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[200px] w-full md:w-auto relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Cari Judul Artikel..." class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                </div>

                <!-- Filter Dropdowns -->
                <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                    <option>Kategori</option>
                    <option>SOP</option>
                    <option>Tutorial</option>
                    <option>Infrastruktur</option>
                </select>
                <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                    <option>Tag</option>
                    <option>Keamanan</option>
                    <option>Backup</option>
                    <option>Jaringan</option>
                </select>
                <input type="date" class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[140px]">
                <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                    <option>Status</option>
                    <option>Published</option>
                    <option>Pending</option>
                    <option>Draft</option>
                    <option>Rejected</option>
                </select>
                <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[120px]">
                    <option>Visibilitas</option>
                    <option>Publik</option>
                    <option>Terbatas</option>
                    <option>Privat</option>
                </select>
                <select class="border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 min-w-[130px]">
                    <option>Urutkan</option>
                    <option>Terbaru</option>
                    <option>Terlama</option>
                    <option>Rating Tertinggi</option>
                    <option>View Terbanyak</option>
                </select>
                <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 ml-auto">
                    Terapkan Filter
                </button>
            </div>
        </div>

        <!-- Bulk Action & Table Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden fade-in delay-2 relative">
            
            <!-- Bulk Action Bar -->
            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer">
                    <span class="text-xs text-gray-500 font-medium">Pilih Semua</span>
                </div>
                <div class="flex items-center gap-2">
                    <select class="border border-gray-300 rounded-lg py-1.5 px-3 text-xs outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                        <option>Bulk Action</option>
                        <option>Hapus Terpilih</option>
                        <option>Arsipkan</option>
                        <option>Ekspor Data</option>
                        <option>Download ZIP</option>
                    </select>
                    <button class="bg-darkbg text-white hover:bg-gray-800 px-4 py-1.5 rounded-lg text-xs font-medium transition-colors shadow-sm hover:shadow">Terapkan</button>
                </div>
            </div>

            <!-- Table Scrollable -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></th>
                            <th class="px-4 py-4 min-w-[200px]">Judul</th>
                            <th class="px-4 py-4 min-w-[120px]">Kategori</th>
                            <th class="px-4 py-4 min-w-[120px]">Status</th>
                            <th class="px-4 py-4 min-w-[80px] text-center">View</th>
                            <th class="px-4 py-4 min-w-[80px] text-center">Rating</th>
                            <th class="px-4 py-4 min-w-[110px]">Tanggal</th>
                            <th class="px-4 py-4 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Row 1: Panduan VPN (Lengkap dengan semua aksi aktif) -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">Panduan VPN</td>
                            <td class="px-4 py-4 text-gray-600">Tutorial</td>
                            <td class="px-4 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Published</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">2.1k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">4.9</td>
                            <td class="px-4 py-4 text-gray-600">20 Jun 2026</td>
                            <td class="px-4 py-4 text-center relative">
                                <!-- Dropdown Menu Action -->
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <!-- Dropdown Content -->
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            <button onclick="showToast('Membuka halaman View untuk Panduan VPN')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button onclick="openEditModal('Panduan VPN', 'Tutorial', 'publik')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button onclick="showToast('Duplikasi artikel Panduan VPN berhasil!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            <button onclick="showToast('Membuka halaman Preview untuk Panduan VPN')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Preview</button>
                                            <button onclick="showToast('Sedang mengunduh PDF: Panduan VPN.pdf')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download PDF</button>
                                            <button onclick="openDeleteModal('Panduan VPN')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button onclick="showToast('Artikel Panduan VPN berhasil diarsipkan!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button onclick="showToast('Menampilkan History Versi untuk Panduan VPN')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History Version</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">SOP Backup Server</td>
                            <td class="px-4 py-4 text-gray-600">SOP</td>
                            <td class="px-4 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Published</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">1.8k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">5.0</td>
                            <td class="px-4 py-4 text-gray-600">18 Jun 2026</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20">
                                        <div class="py-1">
                                            <button onclick="showToast('Membuka halaman View untuk SOP Backup Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button onclick="openEditModal('SOP Backup Server', 'SOP', 'publik')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button onclick="showToast('Duplikasi artikel SOP Backup Server berhasil!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            <button onclick="showToast('Membuka halaman Preview untuk SOP Backup Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Preview</button>
                                            <button onclick="showToast('Sedang mengunduh PDF: SOP Backup Server.pdf')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download PDF</button>
                                            <button onclick="openDeleteModal('SOP Backup Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button onclick="showToast('Artikel SOP Backup Server berhasil diarsipkan!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button onclick="showToast('Menampilkan History Versi untuk SOP Backup Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History Version</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 3 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">SOP Email Dinas</td>
                            <td class="px-4 py-4 text-gray-600">SOP</td>
                            <td class="px-4 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Pending</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">1.5k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">4.8</td>
                            <td class="px-4 py-4 text-gray-600">15 Jun 2026</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20">
                                        <div class="py-1">
                                            <button onclick="showToast('Membuka halaman View untuk SOP Email Dinas')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button onclick="openEditModal('SOP Email Dinas', 'SOP', 'publik')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button onclick="showToast('Duplikasi artikel SOP Email Dinas berhasil!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            <button onclick="showToast('Membuka halaman Preview untuk SOP Email Dinas')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Preview</button>
                                            <button onclick="showToast('Sedang mengunduh PDF: SOP Email Dinas.pdf')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download PDF</button>
                                            <button onclick="openDeleteModal('SOP Email Dinas')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button onclick="showToast('Artikel SOP Email Dinas berhasil diarsipkan!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button onclick="showToast('Menampilkan History Versi untuk SOP Email Dinas')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History Version</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 4 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">Panduan Laravel</td>
                            <td class="px-4 py-4 text-gray-600">Web Dev</td>
                            <td class="px-4 py-4"><span class="bg-red-100 text-red-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Rejected</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">1.2k</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">4.6</td>
                            <td class="px-4 py-4 text-gray-600">10 Jun 2026</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20">
                                        <div class="py-1">
                                            <button onclick="showToast('Membuka halaman View untuk Panduan Laravel')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button onclick="openEditModal('Panduan Laravel', 'Web Dev', 'publik')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button onclick="showToast('Duplikasi artikel Panduan Laravel berhasil!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            <button onclick="showToast('Membuka halaman Preview untuk Panduan Laravel')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Preview</button>
                                            <button onclick="showToast('Sedang mengunduh PDF: Panduan Laravel.pdf')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download PDF</button>
                                            <button onclick="openDeleteModal('Panduan Laravel')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button onclick="showToast('Artikel Panduan Laravel berhasil diarsipkan!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button onclick="showToast('Menampilkan History Versi untuk Panduan Laravel')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History Version</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 5 -->
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">Instalasi Server</td>
                            <td class="px-4 py-4 text-gray-600">Infrastruktur</td>
                            <td class="px-4 py-4"><span class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full text-[10px] font-bold">Draft</span></td>
                            <td class="px-4 py-4 text-center text-gray-600">950</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">4.5</td>
                            <td class="px-4 py-4 text-gray-600">05 Jun 2026</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20">
                                        <div class="py-1">
                                            <button onclick="showToast('Membuka halaman View untuk Instalasi Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View</button>
                                            <button onclick="openEditModal('Instalasi Server', 'Infrastruktur', 'publik')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button onclick="showToast('Duplikasi artikel Instalasi Server berhasil!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            <button onclick="showToast('Membuka halaman Preview untuk Instalasi Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Preview</button>
                                            <button onclick="showToast('Sedang mengunduh PDF: Instalasi Server.pdf')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download PDF</button>
                                            <button onclick="openDeleteModal('Instalasi Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            <button onclick="showToast('Artikel Instalasi Server berhasil diarsipkan!')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            <button onclick="showToast('Menampilkan History Versi untuk Instalasi Server')" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors border-t border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History Version</button>
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

    <!-- Modal Edit Cepat (Dipertahankan) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300" id="editModalContent">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Edit Cepat Artikel</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Judul Dokumen</label>
                    <input type="text" id="edit-title" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none focus:ring-1 focus:ring-blue-500 transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Kategori</label>
                        <select id="edit-category" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none transition">
                            <option value="Keamanan">Keamanan</option>
                            <option value="Infrastruktur">Infrastruktur</option>
                            <option value="Tutorial Aplikasi">Tutorial Aplikasi</option>
                            <option value="SOP Umum">SOP Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Visibilitas</label>
                        <select id="edit-visibility" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none transition">
                            <option value="publik">Publik (Semua)</option>
                            <option value="terbatas">Publik Terbatas</option>
                            <option value="privat">Privat (Internal)</option>
                        </select>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="/staff/editor" class="text-xs text-blue-600 hover:underline flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka di Editor Lengkap (Teks & Isi)
                    </a>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeEditModal()" class="px-5 py-2 text-sm font-bold bg-gold text-darkbg hover:bg-goldhover rounded-lg transition-colors focus:outline-none shadow-md">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- Modal Hapus (Dipertahankan) -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="deleteModalContent">
            <div class="p-6 pt-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2">Hapus Artikel?</h3>
                <p class="text-sm text-gray-500 mb-2">Anda yakin ingin menghapus <span id="delete-title-display" class="font-bold text-gray-700">Dokumen</span>?</p>
                <p class="text-xs text-red-500 bg-red-50 p-2 rounded-lg border border-red-100 inline-block">Tindakan ini permanen dan tidak bisa dibatalkan.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeDeleteModal()" class="w-1/2 px-4 py-2.5 text-sm font-bold bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors focus:outline-none shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        // --- Logic Toast Notification ---
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast-item';
            toast.innerHTML = `
                <span class="text-gold text-lg leading-none">✦</span>
                <span>${message}</span>
            `;
            container.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('out');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // --- Logic Toggle Sidebar Mobile ---
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

        // --- Logic Modal Edit ---
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');
        function openEditModal(title, category, visibility) {
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-visibility').value = visibility;
            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                editModalContent.classList.remove('scale-95');
            }, 10);
        }
        function closeEditModal() {
            editModal.classList.add('opacity-0');
            editModalContent.classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300);
        }

        // --- Logic Modal Delete ---
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');
        function openDeleteModal(title) {
            document.getElementById('delete-title-display').innerText = '"' + title + '"';
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModal.classList.remove('opacity-0');
                deleteModalContent.classList.remove('scale-95');
            }, 10);
        }
        function closeDeleteModal() {
            deleteModal.classList.add('opacity-0');
            deleteModalContent.classList.add('scale-95');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>