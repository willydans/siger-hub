<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - SIGER-Hub</title>
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

        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar Mobile Styling */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Notification Unread Dot Pulse */
        .unread-dot {
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
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
            
            <!-- Dashboard tidak aktif -->
            <a href="/staff/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            
            <!-- Artikel Saya tidak aktif -->
            <a href="/staff/articles" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            
            <!-- Draft tidak aktif -->
            <a href="/staff/draft" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft
            </a>
            
            <!-- Revision sekarang tidak aktif -->
            <a href="/staff/revision" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            
            <!-- Notification sekarang aktif (ditandai dengan background, border, dan ikon emas) -->
            <a href="/staff/notification" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
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
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Notifikasi</h2>
        </div>

        <!-- Header Halaman Notification -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halaman Notifikasi</h1>
                <p class="text-sm text-gray-500 mt-1">Seluruh notifikasi untuk Anda.</p>
            </div>
        </div>

        <!-- Filter Options (Belum dibaca, Hari ini, Minggu ini, Semua) -->
        <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up delay-2">
            <button class="px-4 py-2 text-xs font-medium rounded-lg bg-darkbg text-white shadow-sm transition-colors duration-200 hover:scale-105">Belum dibaca</button>
            <button class="px-4 py-2 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Hari ini</button>
            <button class="px-4 py-2 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Minggu ini</button>
            <button class="px-4 py-2 text-xs font-medium rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200">Semua</button>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="space-y-4">
            
            <!-- Notif 1: Approval (Disetujui) - Belum dibaca -->
            <div class="bg-white border-l-4 border-green-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-2 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Artikel Anda Disetujui.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Tim Admin telah menyetujui artikel Anda untuk dipublikasikan.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">10 menit lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full unread-dot"></span>
                    <span class="text-[10px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">Approval</span>
                </div>
            </div>

            <!-- Notif 2: Komentar Baru -->
            <div class="bg-white border-l-4 border-blue-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-3 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Komentar baru.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Budi Santoso memberikan komentar pada artikel "Panduan VPN".</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">1 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full unread-dot"></span>
                    <span class="text-[10px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">Komentar</span>
                </div>
            </div>

            <!-- Notif 3: Rating Baru -->
            <div class="bg-white border-l-4 border-gold border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-4 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Rating baru.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Artikel "SOP Backup Server" mendapatkan rating 5.0 dari pengguna.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">3 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-transparent rounded-full"></span> <!-- Sudah dibaca -->
                    <span class="text-[10px] text-yellow-600 font-medium bg-yellow-50 px-2 py-0.5 rounded-full">Rating</span>
                </div>
            </div>

            <!-- Notif 4: Revision (Admin meminta revisi) -->
            <div class="bg-white border-l-4 border-red-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-1 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Admin meminta revisi.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Artikel "Panduan VPN" perlu diperbaiki di bagian nomor 3.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">5 jam lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full unread-dot"></span>
                    <span class="text-[10px] text-red-600 font-medium bg-red-50 px-2 py-0.5 rounded-full">Revision</span>
                </div>
            </div>

            <!-- Notif 5: Bookmark -->
            <div class="bg-white border-l-4 border-purple-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-2 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Bookmark baru.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Seseorang menambahkan artikel "Panduan Laravel" ke bookmark.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">Kemarin</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-transparent rounded-full"></span>
                    <span class="text-[10px] text-purple-600 font-medium bg-purple-50 px-2 py-0.5 rounded-full">Bookmark</span>
                </div>
            </div>

            <!-- Notif 6: Mention -->
            <div class="bg-white border-l-4 border-indigo-500 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-3 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-lg font-bold">@</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Mention.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Admin menyebut Anda dalam diskusi artikel "SOP Email Dinas".</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">2 hari lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full unread-dot"></span>
                    <span class="text-[10px] text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded-full">Mention</span>
                </div>
            </div>

            <!-- Notif 7: System -->
            <div class="bg-white border-l-4 border-gray-400 border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-4 relative">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Pembaruan Sistem.</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Sistem akan menjalani pemeliharaan pada Minggu, 29 Juni 2026 pukul 02.00 WIB.</p>
                        <span class="text-[10px] text-gray-400 mt-1 block">3 hari lalu</span>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="w-2.5 h-2.5 bg-transparent rounded-full"></span>
                    <span class="text-[10px] text-gray-600 font-medium bg-gray-100 px-2 py-0.5 rounded-full">System</span>
                </div>
            </div>

        </div>
    </main>

    <script>
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
    </script>
</body>
</html>