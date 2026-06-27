<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Artikel - SIGER-Hub</title>
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
        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Scrollbar Minimalis */
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

        /* Sidebar Mobile Styling */
        #sidebar-mobile {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        #sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Custom Preview Tabs */
        .preview-btn {
            transition: all 0.2s ease;
        }
        .preview-btn.active {
            background-color: #EAB308;
            color: #0F172A;
            border-color: #EAB308;
        }

        /* Block styles for "Content Blocks" section */
        .block-card {
            transition: all 0.2s ease;
        }
        .block-card:hover {
            transform: scale(1.02);
            border-color: #EAB308;
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
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
            
            <!-- Tulis Artikel Baru sekarang aktif (ditandai dengan background, border, dan ikon emas) -->
            <a href="/staff/editor" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
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
        <div class="flex justify-between items-center mb-4 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Tulis Artikel</h2>
        </div>

        <!-- Editor Header (Menu & Actions) -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="p-2 bg-gold/10 text-gold rounded-lg hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 hidden md:block">Tulis Artikel / Dokumen Baru</h1>
                    <span class="text-xs text-gray-400 block md:hidden text-center w-full">Pastikan konten Anda relevan dan akurat.</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto justify-end flex-wrap">
                <div class="relative inline-block text-left">
                    <button type="button" class="border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 py-2 px-4 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Draf
                    </button>
                </div>
                <button class="border border-gold text-gold hover:bg-gold/10 py-2 px-4 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Preview
                </button>
                <button class="bg-gold text-darkbg hover:bg-goldhover py-2 px-6 rounded-lg text-sm font-bold transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                    Submit Approval
                </button>
            </div>
        </div>

        <!-- Grid Layout Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI : KONTEN UTAMA (2/3 Lebar) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- 1. JUDUL & SLUG -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-2 hover-lift">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Artikel</label>
                    <input id="title-input" type="text" placeholder="Masukkan judul yang jelas dan deskriptif..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg font-medium focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors duration-200">
                    
                    <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-2 text-xs text-gray-400">
                        <span class="font-medium text-gray-500">Slug Otomatis:</span>
                        <div class="flex items-center gap-1 w-full sm:w-auto bg-gray-50 border border-gray-200 rounded px-3 py-1.5">
                            <span class="text-gray-500 font-mono">sigerhub.lampungprov.go.id/</span>
                            <span id="slug-output" class="text-gray-800 font-mono font-medium">judul-artikel-anda</span>
                        </div>
                    </div>
                </div>

                <!-- 2. RICH EDITOR (CKEDITOR 5 MOCK) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden fade-in-up delay-3 hover-lift">
                    <div class="bg-gray-50 border-b border-gray-200 p-2 flex flex-wrap gap-1 items-center">
                        <!-- Toolbar Group 1 -->
                        <div class="flex items-center gap-1 px-1 border-r border-gray-200">
                            <button class="p-1.5 hover:bg-gray-200 rounded text-sm font-bold text-gray-700 transition">B</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-sm italic text-gray-700 transition">I</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-sm underline text-gray-700 transition">U</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs bg-gray-100 border border-gray-200 px-2 py-0.5 text-gray-700 transition">H</button>
                        </div>
                        <!-- Toolbar Group 2 -->
                        <div class="flex items-center gap-1 px-1 border-r border-gray-200">
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg></button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13"></path></svg></button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Checklist</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition">Tabel</button>
                        </div>
                        <!-- Toolbar Group 3 -->
                        <div class="flex items-center gap-1 px-1 border-r border-gray-200">
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg> Link</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Quote</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition">Divider</button>
                        </div>
                        <!-- Toolbar Group 4 -->
                        <div class="flex items-center gap-1 px-1 border-r border-gray-200">
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Img</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Video</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2z"></path></svg> PDF</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-4.586 4.586a2 2 0 00.586 2.828l3.414 3.414a2 2 0 002.828-.586l4.586-4.586"></path></svg> Code</button>
                        </div>
                        <div class="flex items-center gap-1 px-1">
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition">😊</button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg></button>
                            <button class="p-1.5 hover:bg-gray-200 rounded text-xs text-gray-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16"></path></svg></button>
                        </div>
                    </div>
                    
                    <div class="p-6 min-h-[300px]">
                        <div contenteditable="true" class="w-full h-full outline-none text-gray-700 leading-relaxed text-[16px]">
                            <p>Mulai menulis isi artikel Anda di sini...</p>
                        </div>
                    </div>
                </div>

                <!-- 3. ISI ARTIKEL (BLOCKS - PREVIEW) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3">
                    <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        Isi Artikel (Tambahkan Elemen)
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1">
                            <span class="font-bold text-sm bg-gray-200 px-2 rounded text-gray-700">H1</span>
                            <span>Heading</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Paragraf</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Checklist</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 18h14"></path></svg>
                            <span>Table</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1 bg-yellow-50 border-yellow-200">
                            <span class="text-yellow-600 font-bold">⚠</span>
                            <span>Warning Box</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1 bg-blue-50 border-blue-200">
                            <span class="text-blue-600 font-bold">🛈</span>
                            <span>Info Box</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1 bg-green-50 border-green-200">
                            <span class="text-green-600 font-bold">✓</span>
                            <span>Success Box</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1 bg-orange-50 border-orange-200">
                            <span class="text-orange-600 font-bold">✆</span>
                            <span>Callout</span>
                        </button>
                        <button class="block-card flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-gold/50 text-gray-600 text-xs gap-1 col-span-2">
                            <span class="text-gray-700 text-xs">📅 Timeline, 🗂 Accordion, 📑 Tabs, 🖼 Gallery</span>
                        </button>
                    </div>
                </div>

                <!-- 4. UPLOAD LAMPIRAN -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3">
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Upload Lampiran
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> PDF
                            <input type="file" class="hidden" accept=".pdf">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Word
                            <input type="file" class="hidden" accept=".docx">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10V6l4 4m-4-4l-4 4m0 10h8"></path></svg> Excel
                            <input type="file" class="hidden" accept=".xlsx">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> PPT
                            <input type="file" class="hidden" accept=".pptx">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> ZIP
                            <input type="file" class="hidden" accept=".zip">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> Video
                            <input type="file" class="hidden" accept="video/*">
                        </label>
                        <label class="cursor-pointer bg-gray-50 border border-gray-200 hover:bg-gray-100 hover:border-gold/50 px-3 py-1.5 rounded-lg text-xs text-gray-600 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3m3 3a3 3 0 013-3m-3 3v4"></path></svg> Audio
                            <input type="file" class="hidden" accept="audio/*">
                        </label>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN : SIDEBAR KONTROL (1/3 Lebar) -->
            <div class="lg:col-span-1 space-y-6 sticky top-6 h-fit">
                
                <!-- 1. VISIBILITAS & THUMBNAIL -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-2 hover-lift sidebar-scroll max-h-[500px] overflow-y-auto">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Dasar</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Kategori Utama</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option>SOP (Standar Operasional)</option>
                                <option>Pedoman TI</option>
                                <option>Keamanan Siber</option>
                                <option>Infrastruktur & Jaringan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Subkategori</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option>Keamanan Jaringan</option>
                                <option>Cloud Services</option>
                                <option>Pengembangan Aplikasi</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">OPD / Unit</label>
                                <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                    <option>Dinas Kominfo</option>
                                    <option>Diskominfo</option>
                                    <option>Bappeda</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tags</label>
                                <input type="text" placeholder="cth: ssl, nginx" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Visibilitas</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" checked class="mt-0.5 text-gold focus:ring-gold">
                                <div>
                                    <span class="block text-sm font-bold text-gray-800">Public</span>
                                    <span class="text-[10px] text-gray-500">Semua orang bisa akses</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" class="mt-0.5 text-gold focus:ring-gold">
                                <div>
                                    <span class="block text-sm font-bold text-gray-800">Internal</span>
                                    <span class="text-[10px] text-gray-500">Hanya ASN Prov. Lampung</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" class="mt-0.5 text-gold focus:ring-gold">
                                <div>
                                    <span class="block text-sm font-bold text-gray-800">Restricted</span>
                                    <span class="text-[10px] text-gray-500">Login dengan akses khusus</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" class="mt-0.5 text-gold focus:ring-gold">
                                <div>
                                    <span class="block text-sm font-bold text-gray-800">Private</span>
                                    <span class="text-[10px] text-gray-500">Hanya author & admin</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Thumbnail / Cover Image</h4>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gold transition-colors bg-gray-50/50 cursor-pointer group">
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-gold transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xs font-medium text-gray-600">Drag & Drop</span>
                                <span class="text-[10px] text-gray-400">atau klik untuk upload</span>
                                <span class="text-[10px] text-blue-500 mt-2 hover:underline">Crop & Preview</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. METADATA (ACCORDION) -->
                <details class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift group open:border-gold/50 transition-all duration-200">
                    <summary class="flex justify-between items-center cursor-pointer list-none font-bold text-gray-800">
                        <span>Metadata & SEO</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform duration-200">▼</span>
                    </summary>
                    <div class="mt-4 space-y-3 border-t border-gray-100 pt-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Keyword SEO</label>
                            <input type="text" placeholder="Masukkan keyword" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Deskripsi (Meta)</label>
                            <textarea rows="2" placeholder="Deskripsi singkat" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Estimasi Waktu Baca</label>
                                <input type="number" placeholder="Menit" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Bahasa</label>
                                <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                    <option>Bahasa Indonesia</option>
                                    <option>English</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Versi</label>
                            <input type="text" placeholder="v1.0" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Nomor SOP / Kode Dokumen</label>
                            <input type="text" placeholder="cth: SOP-CSIRT-004" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tanggal Berlaku</label>
                                <input type="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tanggal Kadaluarsa</label>
                                <input type="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                        </div>
                    </div>
                </details>

                <!-- 3. KNOWLEDGE RELATION -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm">Knowledge Relation</h3>
                    <p class="text-xs text-gray-500 mb-3">Artikel ini berhubungan dengan:</p>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded border border-gray-100 hover:bg-white transition-colors">
                            <span>SOP Email</span>
                            <span class="text-gray-400 cursor-pointer hover:text-red-400">✕</span>
                        </div>
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded border border-gray-100 hover:bg-white transition-colors">
                            <span>Tutorial Email</span>
                            <span class="text-gray-400 cursor-pointer hover:text-red-400">✕</span>
                        </div>
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded border border-gray-100 hover:bg-white transition-colors">
                            <span>Regulasi Email</span>
                            <span class="text-gray-400 cursor-pointer hover:text-red-400">✕</span>
                        </div>
                        <button class="mt-2 text-xs text-blue-600 hover:underline flex items-center gap-1 font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Relasi
                        </button>
                    </div>
                </div>

                <!-- 4. PREVIEW MODE (LIVE PREVIEW) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm">Live Preview</h3>
                    <div class="flex gap-2 mb-3">
                        <button onclick="setPreview('desktop')" class="preview-btn active flex-1 py-1.5 px-3 text-xs font-medium rounded-lg border border-gray-200 text-center">💻 Desktop</button>
                        <button onclick="setPreview('tablet')" class="preview-btn flex-1 py-1.5 px-3 text-xs font-medium rounded-lg border border-gray-200 text-center">📱 Tablet</button>
                        <button onclick="setPreview('mobile')" class="preview-btn flex-1 py-1.5 px-3 text-xs font-medium rounded-lg border border-gray-200 text-center">📱 Mobile</button>
                    </div>
                    <div id="preview-area" class="bg-gray-50 rounded border border-gray-200 p-4 min-h-[120px] flex items-center justify-center text-xs text-gray-400">
                        Preview akan muncul di sini secara otomatis saat Anda mengetik di editor.
                    </div>
                </div>

                <!-- ACTION BUTTONS (BOTTOM SIDEBAR) -->
                <div class="flex flex-col gap-2 mt-6">
                    <button class="w-full border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg text-sm bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Draf
                    </button>
                    <button class="w-full bg-darkbg text-white font-bold py-3 px-4 rounded-lg text-sm hover:bg-gray-800 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Preview
                    </button>
                    <button class="w-full bg-gold text-darkbg font-bold py-3 px-4 rounded-lg text-sm hover:bg-goldhover transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit Approval
                    </button>
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

        // --- Logic Slug Otomatis ---
        const titleInput = document.getElementById('title-input');
        const slugOutput = document.getElementById('slug-output');

        titleInput.addEventListener('input', function(e) {
            const text = e.target.value;
            const slug = text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter spesial
                .replace(/\s+/g, '-') // Ganti spasi dengan strip
                .replace(/-+/g, '-') // Ganti multiple strip dengan satu strip
                .replace(/^-|-$/g, ''); // Hapus strip di awal dan akhir
            slugOutput.textContent = slug || 'judul-artikel-anda';
        });

        // --- Logic Live Preview Tabs ---
        function setPreview(device) {
            const buttons = document.querySelectorAll('.preview-btn');
            buttons.forEach(btn => btn.classList.remove('active', 'bg-gold', 'text-darkbg', 'border-gold'));
            
            const activeBtn = Array.from(buttons).find(btn => btn.textContent.toLowerCase().includes(device));
            if(activeBtn) {
                activeBtn.classList.add('active', 'bg-gold', 'text-darkbg', 'border-gold');
            }

            const previewArea = document.getElementById('preview-area');
            let previewText = "Preview (Mode ";
            if (device === 'desktop') previewText += "Desktop - Layar Lebar 1024px+)";
            else if (device === 'tablet') previewText += "Tablet - 768px)";
            else if (device === 'mobile') previewText += "Mobile - 375px)";
            
            previewArea.innerHTML = `<div class="text-center text-gray-500">${previewText}</div>`;
        }
    </script>
</body>
</html>