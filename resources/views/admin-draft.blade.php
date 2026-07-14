<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Articles - AKSARA</title>
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

        <!-- SIDEBAR (Dipertahankan persis, dengan Draft di Knowledge Management sebagai menu aktif) -->
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
                    <!-- Draft menjadi submenu yang aktif -->
                    <a href="/admin/draft" class="block text-white font-medium bg-gray-800/30 rounded px-2 py-1.5 text-[13px] transition-colors">• Draft</a>
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

            <!-- Menu Utama 5: Search Log (Ditambahkan) -->
            <a href="/admin/searchlog" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
            </a>

            <!-- Menu Utama 6: Feedback -->
            <a href="/admin/feedback" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>

            <!-- Menu Utama 7: Notification -->
            <a href="/admin/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>

            <!-- Menu Utama 8: Activity Log -->
            <a href="/admin/activity" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
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

    <!-- MAIN CONTENT (Draft Page) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Draft</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Draft</h1>
                <p class="text-sm text-gray-500 mt-1">Berisi artikel yang belum dikirim.</p>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button onclick="showToast('Memuat daftar draft...')" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Draft Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Card Draft 1 -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col hover-lift fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">Panduan Instalasi SSL pada NGINX</h3>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap mt-1">Draft</span>
                </div>
                
                <div class="space-y-3 flex-1 mt-2">
                    <p class="text-xs text-gray-400">Terakhir diedit: 3 jam lalu</p>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-gold h-2 rounded-full" style="width: 80%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-500">
                        <span>Progress 80%</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Auto Save 2 menit lalu</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                    <button onclick="showToast('Membuka editor untuk draft...')" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </button>
                    <button onclick="showToast('Membuka preview draft...')" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Preview
                    </button>
                    <button onclick="if(confirm('Hapus draft ini?')) { showToast('Draft berhasil dihapus.'); }" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete
                    </button>
                    <button onclick="showToast('Draft berhasil dikirim untuk approval!')" class="flex-1 bg-gold hover:bg-goldhover text-darkbg text-xs font-bold py-2 px-3 rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit
                    </button>
                </div>
            </div>

            <!-- Card Draft 2 -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col hover-lift fade-in-up" style="animation-delay: 0.3s;">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">Draf Panduan Aplikasi SIAKADU</h3>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap mt-1">Draft</span>
                </div>
                
                <div class="space-y-3 flex-1 mt-2">
                    <p class="text-xs text-gray-400">Terakhir diedit: 2 hari lalu</p>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-gold h-2 rounded-full" style="width: 45%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-500">
                        <span>Progress 45%</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Auto Save 5 menit lalu</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                    <button onclick="showToast('Membuka editor untuk draft...')" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </button>
                    <button onclick="showToast('Membuka preview draft...')" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Preview
                    </button>
                    <button onclick="if(confirm('Hapus draft ini?')) { showToast('Draft berhasil dihapus.'); }" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete
                    </button>
                    <button onclick="showToast('Draft berhasil dikirim untuk approval!')" class="flex-1 bg-gold hover:bg-goldhover text-darkbg text-xs font-bold py-2 px-3 rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit
                    </button>
                </div>
            </div>

            <!-- Card Draft 3 -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col hover-lift fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">SOP Penanganan Insiden Keamanan Siber (Update)</h3>
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap mt-1">Draft</span>
                </div>
                
                <div class="space-y-3 flex-1 mt-2">
                    <p class="text-xs text-gray-400">Terakhir diedit: 1 jam lalu</p>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-gold h-2 rounded-full" style="width: 95%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-500">
                        <span>Progress 95%</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Auto Save 10 menit lalu</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                    <button onclick="showToast('Membuka editor untuk draft...')" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </button>
                    <button onclick="showToast('Membuka preview draft...')" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Preview
                    </button>
                    <button onclick="if(confirm('Hapus draft ini?')) { showToast('Draft berhasil dihapus.'); }" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete
                    </button>
                    <button onclick="showToast('Draft berhasil dikirim untuk approval!')" class="flex-1 bg-gold hover:bg-goldhover text-darkbg text-xs font-bold py-2 px-3 rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit
                    </button>
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
    </script>
</body>
</html>