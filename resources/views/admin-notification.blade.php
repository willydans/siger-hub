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
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        .submenu { transition: all 0.3s ease-in-out; overflow: hidden; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR (Sesuai kode Anda) -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 sidebar-scroll">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">A</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">AKSARA</span>
                <span class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Super Admin</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Dashboard
            </a>
            
            <!-- Knowledge Management & Menu Lainnya (Sesuai kode Anda) -->
            <div>
                <button onclick="toggleSubmenu('submenu-knowledge')" class="w-full flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Knowledge Management
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" id="arrow-knowledge" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="submenu-knowledge" class="submenu hidden pl-9 space-y-1 mt-1">
                    <a href="{{ route('admin.all-articles') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• All Articles</a>
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ \App\Models\Article::where('status', 'pending')->count() }}</span></a>
                    <a href="{{ route('admin.draft') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Draft</a>
                    <a href="{{ route('admin.revision') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Revision</a>
                    <a href="{{ route('admin.published') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Published</a>
                    <a href="{{ route('admin.archive') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Archived</a>
                    <a href="{{ route('admin.delete') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Deleted</a>
                </div>
            </div>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>
            <a href="{{ route('admin.category') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>
            <a href="{{ route('admin.analytics') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Analytics
            </a>
            <a href="{{ route('admin.searchlog') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
            </a>
            <a href="{{ route('admin.feedback') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>
            <!-- Notification Active -->
            <a href="{{ route('admin.notification') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            <a href="{{ route('admin.activity') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
            </a>
            <a href="{{ route('admin.storage') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z"></path></svg> Storage
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Settings
            </a>
            <a href="{{ route('admin.backup') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
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
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        @if(session('success'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('success') }}'); });</script>
        @elseif(session('error'))
            <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('error') }}', 'error'); });</script>
        @endif

        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Notification</h2>
        </div>

        <!-- Header & Tombol Mark All -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Notification</h1>
                <p class="text-sm text-gray-500 mt-1">Pantau semua aktivitas penting sistem, mulai dari pengajuan artikel staf, feedback buruk, hingga peringatan sistem (Storage/Backup/Keamanan).</p>
            </div>
            <div class="flex items-center gap-2 mt-2 md:mt-0">
                <form action="{{ route('admin.notification.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-xs font-medium transition-colors shadow-sm">Tandai Semua Dibaca</button>
                </form>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up" style="animation-delay: 0.2s;">
            <span class="text-[10px] font-bold text-gray-400 uppercase px-1">Kategori:</span>
            <a href="{{ route('admin.notification') }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Semua' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
            <a href="{{ route('admin.notification', ['type' => 'Approval']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Approval' ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600 hover:bg-blue-200' }}">Approval</a>
            <a href="{{ route('admin.notification', ['type' => 'Revision']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Revision' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-600 hover:bg-yellow-200' }}">Revision</a>
            <a href="{{ route('admin.notification', ['type' => 'Comment']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Comment' ? 'bg-purple-600 text-white' : 'bg-purple-100 text-purple-600 hover:bg-purple-200' }}">Komentar</a>
            <a href="{{ route('admin.notification', ['type' => 'Like']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Like' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-600 hover:bg-red-200' }}">Like</a>
            <a href="{{ route('admin.notification', ['type' => 'Feedback']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'Feedback' ? 'bg-orange-600 text-white' : 'bg-orange-100 text-orange-600 hover:bg-orange-200' }}">Feedback</a>
            <a href="{{ route('admin.notification', ['type' => 'System']) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200 {{ $type == 'System' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-600 hover:bg-green-200' }}">System</a>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="space-y-4 mb-10 fade-in-up" style="animation-delay: 0.3s;">
            @forelse($notifications as $notification)
                @php
                    // Atur warna border, icon, dan background berdasarkan tipe notifikasi
                    $config = match($notification->type) {
                        'Approval' => ['border' => 'border-blue-500', 'icon' => 'bg-blue-100 text-blue-600', 'badge' => 'bg-blue-100 text-blue-600'],
                        'Revision' => ['border' => 'border-yellow-500', 'icon' => 'bg-yellow-100 text-yellow-600', 'badge' => 'bg-yellow-100 text-yellow-600'],
                        'Comment'  => ['border' => 'border-purple-500', 'icon' => 'bg-purple-100 text-purple-600', 'badge' => 'bg-purple-100 text-purple-600'],
                        'Like'     => ['border' => 'border-red-500', 'icon' => 'bg-red-100 text-red-600', 'badge' => 'bg-red-100 text-red-600'],
                        'Feedback' => ['border' => 'border-orange-500', 'icon' => 'bg-orange-100 text-orange-600', 'badge' => 'bg-orange-100 text-orange-600'],
                        'System'   => ['border' => 'border-green-500', 'icon' => 'bg-green-100 text-green-600', 'badge' => 'bg-green-100 text-green-600'],
                        default    => ['border' => 'border-gray-500', 'icon' => 'bg-gray-100 text-gray-600', 'badge' => 'bg-gray-100 text-gray-600']
                    };
                @endphp

                <div class="bg-white border-l-4 {{ $config['border'] }} border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift relative">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full {{ $config['icon'] }} flex items-center justify-center flex-shrink-0">
                            @if($notification->type == 'Feedback')
                                <span class="text-lg font-bold">👎</span>
                            @elseif($notification->type == 'System')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">{{ $notification->title }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $notification->message }}</p>
                            
                            @if($notification->url)
                                <a href="{{ $notification->url }}" class="inline-block mt-1 text-[10px] font-medium text-blue-600 hover:underline">Lihat Detail</a>
                            @endif
                            
                            <span class="text-[10px] text-gray-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        @if(!$notification->is_read)
                            <span class="w-2.5 h-2.5 bg-{{ explode('-', $config['border'])[1] }}-500 rounded-full animate-pulse"></span>
                        @endif
                        <span class="text-[10px] font-medium {{ $config['badge'] }} px-2 py-0.5 rounded-full">{{ $notification->type }}</span>
                        
                        <!-- Aksi CRUD: Tandai Dibaca & Hapus -->
                        <div class="flex gap-2 mt-2">
                            @if(!$notification->is_read)
                                <form action="{{ route('admin.notification.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] text-blue-600 hover:underline font-medium">Tandai Dibaca</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.notification.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] text-red-500 hover:underline font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-8 text-center text-gray-500">
                    <p class="text-sm">Belum ada notifikasi untuk saat ini.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-4">
                {{ $notifications->appends(['type' => $type])->links() }}
            </div>
        </div>

    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
            } else {
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                setTimeout(() => { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }, 300);
            }
        }

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

        function showToast(message, type = 'success') {
            const color = type === 'success' ? 'border-gold' : 'border-red-500';
            const icon = type === 'success' ? '✦' : '✖';
            const iconColor = type === 'success' ? 'text-gold' : 'text-red-500';
            
            const toastContainer = document.createElement('div');
            toastContainer.className = `fixed top-5 right-5 z-[9999] bg-white border-l-4 ${color} p-4 rounded-lg shadow-xl transform translate-x-[120%] animate-[slideInRight_0.4s_ease-out_forwards]`;
            toastContainer.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="${iconColor} text-lg font-bold">${icon}</span>
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