<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - AKSARA</title>
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
        .dropdown-menu { transform-origin: top right; transition: transform 0.1s ease, opacity 0.1s ease; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
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
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">23</span></a>
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

            <a href="{{ route('admin.feedback') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>

            <a href="{{ route('admin.notification') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            <a href="{{ route('admin.activity') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
            </a>
            <a href="{{ route('admin.storage') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z"></path></svg> Storage
            </a>
            
            <a href="{{ route('admin.backup') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Backup & Restore
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Admin Diskominfo' }}</span>
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
            <h2 class="text-xl font-bold text-gray-900">Feedback</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Feedback</h1>
                <p class="text-sm text-gray-500 mt-1">Setelah user memberikan rating dan komentar, data akan masuk di sini. Feedback dengan rating rendah akan diberi highlight.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto"> <!-- Scroll horizontal tetap aman di sini -->
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></th>
                            <th class="px-4 py-4 min-w-[180px]">Artikel</th>
                            <th class="px-4 py-4 min-w-[120px]">Dari User</th>
                            <th class="px-4 py-4 min-w-[200px]">Rating & Komentar</th>
                            <th class="px-4 py-4 min-w-[120px]">Tanggal</th>
                            <th class="px-4 py-4 min-w-[120px]">Status</th>
                            <th class="px-4 py-4 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($feedbacks as $feedback)
                        {{-- Beri highlight merah untuk rating rendah (<= 3) --}}
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200 {{ $feedback->rating && $feedback->rating <= 3 ? 'bg-red-50/50 border-l-4 border-red-400' : '' }}">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            
                            <!-- Data Artikel -->
                            <td class="px-4 py-4 font-bold text-gray-900">
                                {{ $feedback->article ? $feedback->article->title : 'Artikel Telah Dihapus' }}
                            </td>
                            
                            <!-- Data User yang memberi feedback -->
                            <td class="px-4 py-4 text-gray-600">
                                {{ $feedback->user ? $feedback->user->name : 'Pengguna Umum (Guest)' }}
                            </td>
                            
                            <!-- Rating & Komentar -->
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1 text-sm mb-1">
                                    @if($feedback->rating)
                                        @for($i=1; $i<=5; $i++)
                                            <span class="{{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                        @endfor
                                        <span class="text-[10px] text-gray-500 ml-2">({{ $feedback->rating }} / 5)</span>
                                    @else
                                        <span class="text-gray-400 text-[10px]">Tidak ada rating</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 max-w-[200px] leading-relaxed break-words">
                                    {{ $feedback->comment ? '"' . Str::limit($feedback->comment, 80) . '"' : '-' }}
                                </p>
                            </td>
                            
                            <!-- Tanggal -->
                            <td class="px-4 py-4 text-gray-600">{{ $feedback->created_at->format('d M Y H:i') }}</td>
                            
                            <!-- Status dengan badge warna -->
                            <td class="px-4 py-4">
                                @php
                                    $statusColors = [
                                        'Open' => 'bg-red-100 text-red-700',
                                        'In Progress' => 'bg-yellow-100 text-yellow-700',
                                        'Resolved' => 'bg-green-100 text-green-700',
                                        'Assigned' => 'bg-blue-100 text-blue-700',
                                        'Closed' => 'bg-gray-100 text-gray-700',
                                    ];
                                    $statusColor = $statusColors[$feedback->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="{{ $statusColor }} px-2.5 py-1 rounded-full text-[10px] font-bold">{{ $feedback->status }}</span>
                            </td>
                            
                            <!-- Action -->
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    {{-- ✅ FIX: data-menu-target menyimpan id unik dropdown-nya, dipakai JS
                                         untuk menemukan menu meskipun nanti dipindah (portal) ke <body> --}}
                                    <button type="button" onclick="toggleDropdown(this)" data-menu-target="dropdown-menu-{{ $feedback->id }}" class="dropdown-toggle-btn text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    
                                    <div id="dropdown-menu-{{ $feedback->id }}" class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-50 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            <!-- Assign Action -->
                                            <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="assign">
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Assign ke Penulis
                                                </button>
                                            </form>
                                            
                                            <!-- Close Action -->
                                            <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="close">
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-green-600 hover:bg-green-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Close
                                                </button>
                                            </form>

                                            <!-- Resolve Action -->
                                            <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="resolve">
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-purple-600 hover:bg-purple-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Resolve
                                                </button>
                                            </form>

                                            <!-- Request Revision Action -->
                                            <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="action" value="revision">
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-yellow-600 hover:bg-yellow-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Request Revision
                                                </button>
                                            </form>

                                            <!-- Hapus Action (Delete) -->
                                            <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada feedback yang masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $feedbacks->links() }}
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

        /* =========================================================================
           ✅ FIX: DROPDOWN ACTION DI TABEL FEEDBACK
           Sebelumnya dropdown "tenggelam"/terpotong karena parent tabel pakai
           class overflow-x-auto — begitu overflow-x di-set, browser otomatis
           ikut meng-clip overflow-y juga (ini perilaku standar CSS, bukan bug
           Tailwind). Dropdown yang position:absolute di baris² bawah/kanan jadi
           tidak bisa diklik penuh.

           Solusinya: begitu dropdown dibuka, pindahkan (portal) elemennya ke
           <body> dengan position:fixed, dengan posisi dihitung langsung dari
           lokasi tombol titik-tiga di layar. Dengan begitu dropdown tidak lagi
           berada di dalam container yang overflow-nya ke-clip, dan otomatis
           reposisi kalau halaman di-scroll/resize selagi terbuka.
           ========================================================================= */
        function toggleDropdown(button) {
            const menu = document.getElementById(button.dataset.menuTarget);
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');

            // Tutup dropdown lain yang mungkin masih terbuka
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) closeDropdownMenu(m);
            });

            if (isHidden) {
                openDropdownMenu(button, menu);
            } else {
                closeDropdownMenu(menu);
            }
        }

        function openDropdownMenu(button, menu) {
            // Portal ke <body> sekali saja (dropdown akan tetap di body untuk toggle berikutnya)
            if (!menu.dataset.portaled) {
                menu.dataset.portaled = 'true';
                document.body.appendChild(menu);
                menu.style.position = 'fixed';
                menu.style.zIndex = '9999';
            }

            positionDropdown(button, menu);
            menu.classList.remove('hidden');
            requestAnimationFrame(() => {
                menu.classList.remove('scale-95', 'opacity-0');
                menu.classList.add('scale-100', 'opacity-100');
            });

            // Reposisi otomatis selama dropdown terbuka (scroll tabel / resize window)
            const reposition = () => positionDropdown(button, menu);
            menu._repositionHandler = reposition;
            window.addEventListener('scroll', reposition, true);
            window.addEventListener('resize', reposition);
        }

        function closeDropdownMenu(menu) {
            if (menu.classList.contains('hidden')) return;
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            if (menu._repositionHandler) {
                window.removeEventListener('scroll', menu._repositionHandler, true);
                window.removeEventListener('resize', menu._repositionHandler);
                menu._repositionHandler = null;
            }
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 100);
        }

        function positionDropdown(button, menu) {
            const rect = button.getBoundingClientRect();
            const menuWidth = menu.offsetWidth || 192; // w-48 = 192px
            const menuHeight = menu.offsetHeight || 220;
            const margin = 8;

            let left = rect.right - menuWidth;
            let top = rect.bottom + 6;

            // Jaga supaya tidak keluar dari tepi kiri/kanan layar
            if (left < margin) left = margin;
            if (left + menuWidth > window.innerWidth - margin) {
                left = window.innerWidth - menuWidth - margin;
            }

            // Kalau ruang di bawah tombol tidak cukup, tampilkan di atas tombol
            if (top + menuHeight > window.innerHeight - margin) {
                top = rect.top - menuHeight - 6;
            }
            if (top < margin) top = margin;

            menu.style.top = top + 'px';
            menu.style.left = left + 'px';
        }

        document.addEventListener('click', function(e) {
            const isToggleButton = e.target.closest('.dropdown-toggle-btn');
            const isInsideMenu = e.target.closest('.dropdown-menu');
            if (!isToggleButton && !isInsideMenu) {
                document.querySelectorAll('.dropdown-menu').forEach(m => closeDropdownMenu(m));
            }
        });

        // Tutup dropdown otomatis kalau user menekan Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.dropdown-menu').forEach(m => closeDropdownMenu(m));
            }
        });

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