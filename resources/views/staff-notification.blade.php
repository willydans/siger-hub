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
        .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }

        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }

        .unread-dot { animation: pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.2); } }

        #toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }
        .toast-item {
            background: #0F172A; color: white; padding: 12px 24px; border-radius: 12px; font-size: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3); transform: translateX(120%);
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            border-left: 4px solid #EAB308; display: flex; align-items: center; gap: 10px;
        }
        .toast-item.out { animation: slideOutRight 0.3s ease-in forwards; }
        @keyframes slideInRight { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(120%); opacity: 0; } }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <div id="toast-container"></div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('success') }}'); });
    </script>
    @endif

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR (Sama persis, tidak diubah) -->
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
            <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            <a href="{{ route('staff.articles') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            <a href="{{ route('staff.draft') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft
            </a>
            <a href="{{ route('staff.revision') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            <a href="{{ route('staff.notification') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            <a href="{{ route('staff.editor') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="{{ route('staff.profile') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya
            </a>
        </div>
        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Notifikasi</h2>
        </div>

        <!-- Header -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halaman Notifikasi</h1>
                <p class="text-sm text-gray-500 mt-1">Seluruh notifikasi untuk Anda.</p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <form action="{{ route('staff.notification.readAll') }}" method="POST" onsubmit="return confirm('Tandai semua notifikasi sebagai sudah dibaca?');">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto text-xs font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-lg transition-colors duration-200">
                        Tandai Semua Dibaca
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter -->
        <div class="flex flex-wrap items-center gap-2 mb-6 bg-white p-2 rounded-xl border border-gray-200 shadow-sm fade-in-up delay-2">
            <a href="?filter=unread" class="px-4 py-2 text-xs font-medium rounded-lg {{ request('filter') == 'unread' ? 'bg-darkbg text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors duration-200 hover:scale-105">Belum dibaca</a>
            <a href="?filter=today" class="px-4 py-2 text-xs font-medium rounded-lg {{ request('filter') == 'today' ? 'bg-darkbg text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors duration-200">Hari ini</a>
            <a href="?filter=week" class="px-4 py-2 text-xs font-medium rounded-lg {{ request('filter') == 'week' ? 'bg-darkbg text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors duration-200">Minggu ini</a>
            <a href="?filter=all" class="px-4 py-2 text-xs font-medium rounded-lg {{ request('filter') == 'all' || !request('filter') ? 'bg-darkbg text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition-colors duration-200">Semua</a>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="space-y-4">
            @forelse($notifications as $notif)
                @php
                    // ✅ Sekarang kita pakai kolom langsung!
                    $title = $notif->title ?? 'Notifikasi Sistem';
                    $message = $notif->message ?? '';
                    $link = $notif->url ?? null;

                    // Mapping Warna & Ikon berdasarkan $notif->type
                    $type = $notif->type;
                    $borderColor = 'border-gray-400';
                    $bgColor = 'bg-gray-200';
                    $textColor = 'text-gray-600';
                    $labelClass = 'bg-gray-100 text-gray-600';
                    $labelText = 'System';
                    $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>';

                    if ($type === 'approval') {
                        $borderColor = 'border-green-500'; $bgColor = 'bg-green-100'; $textColor = 'text-green-600'; $labelClass = 'bg-green-50 text-green-600'; $labelText = 'Approval';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    } elseif ($type === 'comment') {
                        $borderColor = 'border-blue-500'; $bgColor = 'bg-blue-100'; $textColor = 'text-blue-600'; $labelClass = 'bg-blue-50 text-blue-600'; $labelText = 'Komentar';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>';
                    } elseif ($type === 'rating') {
                        $borderColor = 'border-yellow-400'; $bgColor = 'bg-yellow-100'; $textColor = 'text-yellow-600'; $labelClass = 'bg-yellow-50 text-yellow-600'; $labelText = 'Rating';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>';
                    } elseif ($type === 'revision') {
                        $borderColor = 'border-red-500'; $bgColor = 'bg-red-100'; $textColor = 'text-red-600'; $labelClass = 'bg-red-50 text-red-600'; $labelText = 'Revision';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                    } elseif ($type === 'bookmark') {
                        $borderColor = 'border-purple-500'; $bgColor = 'bg-purple-100'; $textColor = 'text-purple-600'; $labelClass = 'bg-purple-50 text-purple-600'; $labelText = 'Bookmark';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>';
                    } elseif ($type === 'mention') {
                        $borderColor = 'border-indigo-500'; $bgColor = 'bg-indigo-100'; $textColor = 'text-indigo-600'; $labelClass = 'bg-indigo-50 text-indigo-600'; $labelText = 'Mention';
                        $iconHtml = '<span class="text-lg font-bold">@</span>';
                    } elseif ($type === 'assignment') {
                        $borderColor = 'border-blue-500'; $bgColor = 'bg-blue-100'; $textColor = 'text-blue-600'; $labelClass = 'bg-blue-50 text-blue-600'; $labelText = 'Tugas';
                        $iconHtml = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
                    }
                @endphp

                <div class="bg-white border-l-4 {{ $borderColor }} border-y border-r border-gray-200 rounded-xl shadow-sm p-4 flex items-center justify-between hover-lift fade-in-up delay-2 relative">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full {{ $bgColor }} {{ $textColor }} flex items-center justify-center flex-shrink-0">
                            {!! $iconHtml !!}
                        </div>
                        <div>
                            @if($link)
                                <a href="{{ $link }}" class="font-bold text-gray-800 text-sm hover:text-blue-600 transition-colors">
                                    {{ $title }}
                                </a>
                            @else
                                <h4 class="font-bold text-gray-800 text-sm">{{ $title }}</h4>
                            @endif
                            
                            <p class="text-xs text-gray-500 mt-0.5">{{ $message }}</p>
                            <span class="text-[10px] text-gray-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        @if(!$notif->is_read)
                            <button onclick="markAsRead({{ $notif->id }}, this)" class="w-2.5 h-2.5 bg-blue-500 rounded-full unread-dot cursor-pointer hover:scale-125 transition-transform" title="Tandai sudah dibaca"></button>
                        @else
                            <span class="w-2.5 h-2.5 bg-transparent rounded-full"></span>
                        @endif
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] {{ $labelClass }} font-medium px-2 py-0.5 rounded-full">{{ $labelText }}</span>
                            <form action="{{ route('staff.notification.destroy', $notif->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus notifikasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p class="text-lg font-medium">Tidak ada notifikasi.</p>
                    <p class="text-sm">Semua pemberitahuan akan muncul di sini.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
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

        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast-item';
            toast.innerHTML = `<span class="text-gold text-lg leading-none">✦</span><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('out');
                setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
            }, 3000);
        }

        function markAsRead(id, buttonElement) {
            buttonElement.classList.remove('bg-blue-500', 'unread-dot');
            buttonElement.classList.add('bg-transparent');
            buttonElement.removeAttribute('onclick');

            fetch(`/staff/notification/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal menandai notifikasi. Silakan coba lagi.');
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi. Silakan refresh halaman.');
                window.location.reload();
            });
        }
    </script>
</body>
</html>