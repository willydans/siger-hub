<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIGER-Hub</title>
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
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08);
        }

        /* Sidebar Mobile Styling */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Modal Animation */
        #edit-modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        #modal-box {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR (Dipertahankan Sepenuhnya) -->
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
            
            <!-- Revision tidak aktif -->
            <a href="/staff/revision" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            
            <!-- Notification tidak aktif -->
            <a href="/staff/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            
            <!-- Tulis Artikel Baru sekarang tidak aktif -->
            <a href="/staff/editor" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            
            <!-- Profil Saya sekarang aktif (ditandai dengan background, border, dan ikon emas) -->
            <a href="/staff/profile" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya
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
            <h2 class="text-xl font-bold text-gray-900">Profil Saya</h2>
        </div>

        <!-- Page Header -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 hidden md:block">Pengaturan Akun & Profil</h1>
                <p class="text-sm text-gray-500 mt-1 hidden md:block">Kelola informasi pribadi dan pantau pencapaian Anda.</p>
                <h1 class="text-xl font-bold text-gray-900 md:hidden">Pengaturan Akun</h1>
            </div>
            <button onclick="openEditModal()" class="w-full sm:w-auto bg-darkbg hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2 hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Profil
            </button>
        </div>

        <!-- Layout Grid Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- KOLOM KIRI: Profil, Statistik, Timeline -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- 1. INFORMASI PROFIL -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up delay-2 hover-lift">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="relative flex-shrink-0 group">
                            <img src="https://ui-avatars.com/api/?name=Budi+ASN&background=eab308&color=0f172a&size=128" class="w-24 h-24 rounded-full border-4 border-white shadow-sm group-hover:shadow-md transition-shadow duration-300">
                            <span class="absolute bottom-1 right-1 bg-green-500 border-2 border-white w-4 h-4 rounded-full"></span>
                        </div>
                        <div class="flex-1 space-y-2">
                            <h2 class="text-2xl font-bold text-gray-900">Budi ASN</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 text-sm text-gray-600">
                                <div><span class="font-semibold text-gray-500">NIP:</span> 198012012005011002</div>
                                <div><span class="font-semibold text-gray-500">Email:</span> budi.s@lampungprov.go.id</div>
                                <div><span class="font-semibold text-gray-500">Bidang:</span> E-Government</div>
                                <div><span class="font-semibold text-gray-500">Jabatan:</span> Staff Teknologi Informasi</div>
                                <div><span class="font-semibold text-gray-500">No HP:</span> 081234567890</div>
                            </div>
                            <div class="mt-2">
                                <span class="font-semibold text-gray-500 text-sm">Bio:</span>
                                <p class="text-sm text-gray-600 mt-1">Penulis konten teknis dan pengelola knowledge base di Diskominfo. Berfokus pada keamanan siber dan pengembangan aplikasi pemerintah.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. STATISTIK -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up delay-3">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Statistik Pencapaian
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-xl p-3 text-center border border-gray-100 hover:bg-gray-100 transition-colors">
                            <p class="text-xl font-bold text-gray-900">25</p>
                            <p class="text-[10px] text-gray-500 uppercase">Total Artikel</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-3 text-center border border-green-100 hover:bg-green-100 transition-colors">
                            <p class="text-xl font-bold text-green-700">17</p>
                            <p class="text-[10px] text-green-700 uppercase">Published</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-3 text-center border border-blue-100 hover:bg-blue-100 transition-colors">
                            <p class="text-xl font-bold text-blue-700">12.3k</p>
                            <p class="text-[10px] text-blue-700 uppercase">Views</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-3 text-center border border-purple-100 hover:bg-purple-100 transition-colors">
                            <p class="text-xl font-bold text-purple-700">342</p>
                            <p class="text-[10px] text-purple-700 uppercase">Downloads</p>
                        </div>
                        <div class="bg-red-50 rounded-xl p-3 text-center border border-red-100 hover:bg-red-100 transition-colors">
                            <p class="text-xl font-bold text-red-700">156</p>
                            <p class="text-[10px] text-red-700 uppercase">Likes</p>
                        </div>
                        <div class="bg-yellow-50 rounded-xl p-3 text-center border border-yellow-100 hover:bg-yellow-100 transition-colors">
                            <p class="text-xl font-bold text-yellow-700">4.8</p>
                            <p class="text-[10px] text-yellow-700 uppercase">Rating Rata-rata</p>
                        </div>
                        <div class="bg-indigo-50 rounded-xl p-3 text-center border border-indigo-100 hover:bg-indigo-100 transition-colors">
                            <p class="text-xl font-bold text-indigo-700">87</p>
                            <p class="text-[10px] text-indigo-700 uppercase">Komentar</p>
                        </div>
                    </div>
                </div>

                <!-- 3. ACTIVITY TIMELINE -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up delay-4 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Activity Timeline
                    </h3>
                    <div class="relative border-l border-gray-200 ml-3 space-y-6">
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-green-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <span class="font-semibold text-gray-800 text-sm">Login</span>
                                <span class="text-[11px] text-gray-400 font-medium">12.30</span>
                            </div>
                            <p class="text-xs text-gray-500">Anda login ke Portal Penulis</p>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-blue-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <span class="font-semibold text-gray-800 text-sm">Upload Artikel</span>
                                <span class="text-[11px] text-gray-400 font-medium">10.15</span>
                            </div>
                            <p class="text-xs text-gray-500">Anda mengunggah lampiran PDF baru</p>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-yellow-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <span class="font-semibold text-gray-800 text-sm">Edit Artikel</span>
                                <span class="text-[11px] text-gray-400 font-medium">09.45</span>
                            </div>
                            <p class="text-xs text-gray-500">Anda mengedit artikel "Panduan VPN"</p>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-gold ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <span class="font-semibold text-gray-800 text-sm">Publish Artikel</span>
                                <span class="text-[11px] text-gray-400 font-medium">Kemarin</span>
                            </div>
                            <p class="text-xs text-gray-500">Artikel "SOP Backup Server" dipublikasikan</p>
                        </div>
                        <div class="relative pl-6">
                            <div class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-red-500 ring-4 ring-white"></div>
                            <div class="flex flex-col sm:flex-row justify-between mb-1">
                                <span class="font-semibold text-gray-800 text-sm">Revision</span>
                                <span class="text-[11px] text-gray-400 font-medium">3 hari lalu</span>
                            </div>
                            <p class="text-xs text-gray-500">Admin meminta revisi pada "Panduan Laravel"</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN: Badges & Achievements -->
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up delay-2 hover-lift sticky top-6">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Badge & Pencapaian
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-4 text-center flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                            <span class="text-3xl">🏆</span>
                            <h4 class="font-bold text-gray-800 text-xs">Top Contributor</h4>
                            <p class="text-[10px] text-yellow-600">Kontribusi terbanyak</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 text-center flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                            <span class="text-3xl">📚</span>
                            <h4 class="font-bold text-gray-800 text-xs">Knowledge Master</h4>
                            <p class="text-[10px] text-blue-600">Master Pengetahuan</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-4 text-center flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                            <span class="text-3xl">👁</span>
                            <h4 class="font-bold text-gray-800 text-xs">Most Viewed</h4>
                            <p class="text-[10px] text-purple-600">Tayangan Tertinggi</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-4 text-center flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                            <span class="text-3xl">📄</span>
                            <h4 class="font-bold text-gray-800 text-xs">100 Articles</h4>
                            <p class="text-[10px] text-green-600">Mencapai 100 Artikel</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <!-- MODAL: EDIT PROFIL -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 visibility-hidden">
        <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 opacity-0">
            <!-- Header Modal -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-darkbg text-gold rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Edit Profil Saya</h3>
                </div>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body Modal -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                            <input type="text" value="Budi ASN" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NIP</label>
                            <input type="text" value="198012012005011002" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Email</label>
                        <input type="email" value="budi.s@lampungprov.go.id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Bidang</label>
                            <input type="text" value="E-Government" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jabatan</label>
                            <input type="text" value="Staff Teknologi Informasi" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">No HP</label>
                        <input type="text" value="081234567890" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Bio</label>
                        <textarea rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition resize-none">Penulis konten teknis dan pengelola knowledge base di Diskominfo.</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kata Sandi Baru (Opsional)</label>
                        <input type="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                    </div>
                </form>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeEditModal()" class="px-5 py-2 text-sm font-bold bg-gold text-darkbg hover:bg-goldhover rounded-lg transition-colors focus:outline-none shadow-md hover:scale-105 transition-all duration-200">Simpan Perubahan</button>
            </div>
        </div>
    </div>

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

        // --- Logic Modal Edit Profil ---
        const modal = document.getElementById('edit-modal');
        const modalBox = document.getElementById('modal-box');

        function openEditModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0', 'visibility-hidden');
                modal.classList.add('opacity-100', 'visibility-visible');
                modalBox.classList.remove('scale-95', 'opacity-0');
                modalBox.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeEditModal() {
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100', 'visibility-visible');
            modal.classList.add('opacity-0', 'visibility-hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>