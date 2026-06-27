<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification - AKSARA</title>
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

        <!-- SIDEBAR (Dipertahankan persis, dengan Notification sebagai menu aktif) -->
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
                    <!-- Draft sudah diperbaiki routenya -->
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

            <!-- Menu Utama 6: Notification (Sedang Aktif) -->
            <a href="/admin/notification" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>

            <!-- Menu Utama 7: Single Links Lainnya (Rute sudah diperbaiki) -->
            <a href="/admin/searchlog" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
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

    <!-- MAIN CONTENT (Notification Page) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Notification</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Notification</h1>
                <p class="text-sm text-gray-500 mt-1">Semua notifikasi untuk Admin. Pantau setiap aktivitas dan kejadian penting di sistem.</p>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
            <span class="text-[10px] font-bold text-gray-400 uppercase px-1">Kategori:</span>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Semua</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors duration-200">Approval</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors duration-200">Revision</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-100 text-purple-600 hover:bg-purple-200 transition-colors duration-200">Komentar</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors duration-200">Like</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-200 transition-colors duration-200">Feedback</button>
            <button class="px-3 py-1.5 text-xs font-medium rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-colors duration-200">System</button>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="space-y-4 mb-10 fade-in-up" style="animation-delay: 0.3s;">
            
            <!-- Notif: Approval -->
            <div class="bg-white border-l-4 border-blue-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Approval Artikel Baru</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Staff Wildan telah mengirimkan artikel baru berjudul "Panduan VPN".</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">10 menit lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">Approval</span>
                </div>
            </div>

            <!-- Notif: Revision -->
            <div class="bg-white border-l-4 border-yellow-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Revisi Dikirim</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Staff Rina telah mengirimkan revisi untuk artikel "SOP Backup Server".</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">1 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-yellow-600 font-medium bg-yellow-50 px-2 py-0.5 rounded-full">Revision</span>
                </div>
            </div>

            <!-- Notif: Feedback Negatif -->
            <div class="bg-white border-l-4 border-orange-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-lg font-bold">👎</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Feedback Negatif</h4>
                        <p class="text-xs text-gray-500 mt-0.5">User memberikan feedback negatif (Sulit Dipahami) pada artikel "Panduan Email Dinas".</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">3 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-orange-600 font-medium bg-orange-50 px-2 py-0.5 rounded-full">Feedback</span>
                </div>
            </div>

            <!-- Notif: System - Backup Gagal -->
            <div class="bg-white border-l-4 border-red-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">System Alert: Backup Gagal</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Sistem gagal melakukan backup database otomatis. Periksa koneksi server.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">5 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-red-600 font-medium bg-red-50 px-2 py-0.5 rounded-full">System</span>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- NOTIFIKASI OTOMATIS KHUSUS ADMIN (List System Events)     -->
        <!-- ======================================================== -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up" style="animation-delay: 0.4s;">
            <div class="border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800">Sistem Notifikasi Otomatis untuk Admin</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Item 1 -->
                <div class="flex items-start gap-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">1</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Staff mengirim artikel baru</h4>
                        <p class="text-xs text-gray-600 mt-1">Notifikasi akan muncul setiap kali ada staf yang mengajukan artikel untuk verifikasi.</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start gap-3 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">2</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Staff mengirim revisi</h4>
                        <p class="text-xs text-gray-600 mt-1">Notifikasi akan muncul saat staf mengirimkan hasil perbaikan berdasarkan permintaan revisi.</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start gap-3 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                    <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">3</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Ada feedback negatif dari pengguna</h4>
                        <p class="text-xs text-gray-600 mt-1">Notifikasi akan muncul ketika pengguna memberikan penilaian negatif (👍) pada sebuah artikel.</p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start gap-3 p-3 bg-purple-50 border border-purple-200 rounded-xl">
                    <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">4</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Storage Nextcloud hampir penuh</h4>
                        <p class="text-xs text-gray-600 mt-1">Sistem akan mengirim peringatan jika kapasitas penyimpanan Nextcloud mendekati batas maksimal.</p>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="flex items-start gap-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                    <div class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">5</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Backup gagal</h4>
                        <p class="text-xs text-gray-600 mt-1">Pemberitahuan segera akan dikirim jika sistem gagal melakukan backup database secara otomatis.</p>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="flex items-start gap-3 p-3 bg-green-50 border border-green-200 rounded-xl">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold">6</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Login mencurigakan terdeteksi</h4>
                        <p class="text-xs text-gray-600 mt-1">Sistem keamanan akan memberitahu Admin jika ada percobaan login yang mencurigakan atau dari lokasi baru.</p>
                    </div>
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
    </script>
</body>
</html>