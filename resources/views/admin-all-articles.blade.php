<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'All Articles' }} - AKSARA</title>
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
        .modal-overlay { background: rgba(0,0,0,0.5); }
        .dropdown-menu {
            transform-origin: top right;
            transition: transform 0.1s ease, opacity 0.1s ease;
            position: fixed !important; 
            z-index: 9999 !important;
            width: 12rem;
            max-height: 60vh;
            overflow-y: auto;
        }
        .dropdown-menu::-webkit-scrollbar { width: 4px; }
        .dropdown-menu::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
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
                    <a href="{{ route('admin.all-articles') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.all-articles') ? 'text-white' : '' }}">• All Articles</a>
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between {{ request()->routeIs('admin.pending-approval') ? 'text-white' : '' }}">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">23</span></a>
                    <a href="{{ route('admin.draft') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.draft') ? 'text-white' : '' }}">• Draft</a>
                    <a href="{{ route('admin.revision') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.revision') ? 'text-white' : '' }}">• Revision</a>
                    <a href="{{ route('admin.published') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.published') ? 'text-white' : '' }}">• Published</a>
                    <a href="{{ route('admin.archive') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.archive') ? 'text-white' : '' }}">• Archived</a>
                    <a href="{{ route('admin.delete') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.delete') ? 'text-white' : '' }}">• Deleted</a>
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
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</span>
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
            <h2 class="text-xl font-bold text-gray-900">{{ $pageTitle ?? 'All Articles' }}</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $pageTitle ?? 'All Articles' }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $statusLabel ?? 'Semua artikel' }} seluruh pegawai. Kelola, review, dan pantau status publikasi.</p>
            </div>
            <a href="{{ route('admin.editor') }}" class="w-full md:w-auto bg-darkbg text-white hover:bg-gray-800 font-bold py-2 px-6 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                + Tambah Artikel Baru
            </a>
        </div>

        <!-- Filter Section -->
        <form action="{{ route('admin.all-articles') }}" method="GET" class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 fade-in-up" style="animation-delay: 0.2s;">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Judul Artikel..." class="w-full border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300">
                </div>
                <select name="category" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="opd" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">OPD</option>
                    @foreach($opds as $opd)
                        <option value="{{ $opd->name }}" {{ request('opd') == $opd->name ? 'selected' : '' }}>{{ $opd->name }}</option>
                    @endforeach
                </select>
                <select name="author" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">Penulis</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('author') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="revision" {{ request('status') == 'revision' ? 'selected' : '' }}>Revision</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <select name="visibility" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">Visibility</option>
                    <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                    <option value="internal" {{ request('visibility') == 'internal' ? 'selected' : '' }}>Internal</option>
                    <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                <select name="version" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700">
                    <option value="">Version</option>
                    <option value="v1.0" {{ request('version') == 'v1.0' ? 'selected' : '' }}>v1.0</option>
                    <option value="v2.0" {{ request('version') == 'v2.0' ? 'selected' : '' }}>v2.0</option>
                    <option value="v2.1" {{ request('version') == 'v2.1' ? 'selected' : '' }}>v2.1</option>
                </select>
                <select name="sort" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-all duration-300 bg-white text-gray-700 col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-1">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort By: Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Sort By: Terlama</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort By: Rating</option>
                    <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Sort By: Views</option>
                </select>
            </div>
            <div class="mt-3 flex justify-end">
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">Terapkan Filter</button>
            </div>
        </form>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[1000px]">
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
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">{{ $article->title }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $article->user->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $article->category ?? '-' }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $statusColors = [
                                        'published' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'revision' => 'bg-red-100 text-red-700',
                                        'archived' => 'bg-gray-300 text-gray-600',
                                    ];
                                    $statusColor = $statusColors[$article->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="{{ $statusColor }} px-2.5 py-1 rounded-full text-[10px] font-bold">{{ ucfirst($article->status) }}</span>
                            </td>
                            <td class="px-4 py-4 text-center text-gray-600">{{ number_format($article->views) }}</td>
                            <td class="px-4 py-4 text-center text-yellow-400 font-medium">{{ number_format($article->rating_avg, 1) }}</td>
                            <td class="px-4 py-4 text-center text-gray-600">{{ $article->version ?? '-' }}</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    
                                    <div class="dropdown-menu hidden w-48 bg-white border border-gray-200 rounded-lg shadow-xl scale-95 opacity-0">
                                        <div class="py-1">

                                            @if($article->status === 'revision')
                                                <button type="button" onclick="openRevisionModal({{ $article->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                                </button>
                                            @else
                                                <a href="{{ route('admin.articles.show', $article->id) }}" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                                </a>
                                            @endif

                                            <!-- === PERBAIKAN: SEMUA STATUS (kecuali revision) langsung ke editor lengkap === -->
                                            @unless($article->status === 'revision')
                                                <a href="{{ route('admin.editor.edit', $article->id) }}" class="dropdown-item flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit
                                                </a>
                                            @endunless
                                            
                                            @if($article->status === 'pending')
                                            <form action="{{ route('admin.articles.approve', $article->id) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Approve</button>
                                            </form>
                                            <form action="{{ route('admin.articles.reject', $article->id) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Reject</button>
                                            </form>
                                            @endif

                                            @if($article->status !== 'archived')
                                            <form action="{{ route('admin.articles.archive', $article->id) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Archive</button>
                                            </form>
                                            @else
                                            <a href="{{ route('admin.articles.restore', $article->id) }}" onclick="return confirm('Apakah Anda yakin ingin memulihkan artikel ini?')" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Restore
                                            </a>
                                            @endif

                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="block" onsubmit="return confirm('Hapus artikel ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete</button>
                                            </form>

                                            <a href="{{ route('admin.articles.history', $article->id) }}" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> History
                                            </a>

                                            @unless($article->status === 'revision')
                                            <form action="{{ route('admin.articles.duplicate', $article->id) }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg> Duplicate</button>
                                            </form>
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada artikel.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $articles->links() }}
            </div>
        </div>
    </main>

    <!-- Edit Modal (tidak terpakai, tetap ada untuk kompatibilitas) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden modal-overlay flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6 relative animate-fade-in-up">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Artikel</h2>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                        <input type="text" name="title" id="editTitle" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="editCategory" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="editStatus" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                            <option value="draft">Draft</option>
                            <option value="pending">Pending</option>
                            <option value="published">Published</option>
                            <option value="revision">Revision</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                        <select name="visibility" id="editVisibility" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                            <option value="public">Public</option>
                            <option value="internal">Internal</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Version</label>
                        <input type="text" name="version" id="editVersion" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-darkbg text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Detail Alasan Revisi --}}
    <div id="revisionDetailModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center opacity-0" style="transition: opacity 0.3s ease;">
        <div id="revisionModalBox" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0" style="transition: transform 0.3s cubic-bezier(0.175,0.885,0.32,1.275), opacity 0.3s ease;">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Detail Alasan Revisi</h3>
                </div>
                <button onclick="closeRevisionModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <span id="revisionModalTitle" class="text-base font-bold text-gray-900">Memuat...</span>
                    <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-bold">Revision</span>
                </div>
                <div id="revisionModalNotes" class="space-y-4"></div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-gray-400 w-full sm:w-auto text-center sm:text-left mb-2 sm:mb-0">Aksi:</p>
                <div class="flex flex-wrap justify-end gap-2 w-full sm:w-auto">
                    <a id="revisionBtnShow" href="#" class="flex-1 sm:flex-none border border-blue-500 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-1 min-w-[130px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Artikel Lengkap
                    </a>
                    <form id="revisionBtnRestore" action="" method="POST" class="flex-1 sm:flex-none min-w-[130px]" onsubmit="return confirm('Batalkan revisi ini? Artikel akan dikembalikan ke status Draft.');">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Batalkan Revisi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        // --- DROPDOWN POSITION FIX ---
        function toggleDropdown(button) {
            const menu = button.parentElement.querySelector('.dropdown-menu');
            const isHidden = menu.classList.contains('hidden');

            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) {
                    m.classList.add('hidden');
                    m.classList.remove('scale-100', 'opacity-100');
                    m.classList.add('scale-95', 'opacity-0');
                }
            });

            if (isHidden) {
                positionDropdown(button, menu);

                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-95', 'opacity-0');
                    menu.classList.add('scale-100', 'opacity-100');
                }, 10);

                const reposition = () => positionDropdown(button, menu);
                menu._repositionHandler = reposition;
                window.addEventListener('scroll', reposition, true);
                window.addEventListener('resize', reposition);
            } else {
                closeDropdownMenu(menu);
            }
        }

        function positionDropdown(button, menu) {
            const rect = button.getBoundingClientRect();
            const margin = 8;
            const menuWidth = menu.offsetWidth || 192;

            const spaceBelow = window.innerHeight - rect.bottom - margin;
            const spaceAbove = rect.top - margin;
            const naturalHeight = menu.scrollHeight;

            let top, maxHeight;

            if (naturalHeight <= spaceBelow || spaceBelow >= spaceAbove) {
                top = rect.bottom + 8;
                maxHeight = Math.max(spaceBelow - 8, 120);
            } else {
                maxHeight = Math.max(spaceAbove - 8, 120);
                top = Math.max(rect.top - Math.min(naturalHeight, maxHeight) - 8, margin);
            }

            let left = rect.right - menuWidth;
            if (left < margin) left = margin;
            if (left + menuWidth > window.innerWidth - margin) {
                left = window.innerWidth - menuWidth - margin;
            }

            menu.style.top = top + 'px';
            menu.style.left = left + 'px';
            menu.style.maxHeight = maxHeight + 'px';
        }

        function closeDropdownMenu(menu) {
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

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => closeDropdownMenu(m));
            }
        });

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Fungsi openEditModal tidak digunakan lagi (seluruh Edit menggunakan link langsung ke editor)
        function openEditModal(id) {
            // fallback: redirect ke editor lengkap
            window.location.href = "/admin/editor/" + id;
        }

        const revisionModal = document.getElementById('revisionDetailModal');
        const revisionModalBox = document.getElementById('revisionModalBox');

        function openRevisionModal(id) {
            fetch(`/admin/articles/json/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('revisionModalTitle').innerText = data.title || 'Artikel';

                    let notes = {};
                    if (data.revision_notes) {
                        notes = typeof data.revision_notes === 'string'
                            ? (JSON.parse(data.revision_notes || '{}') || {})
                            : data.revision_notes;
                    }

                    let html = '';
                    if (notes && Object.keys(notes).length > 0) {
                        html += `
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-3">
                                <h4 class="font-bold text-sm text-blue-800 mb-2 flex items-center gap-2">📋 Detail Permintaan Revisi</h4>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-700">
                                    <div><span class="font-semibold text-gray-500">Judul:</span> ${notes.title_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Isi:</span> ${notes.content_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Lampiran:</span> ${notes.attachments_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Kategori:</span> ${notes.category_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Tag:</span> ${notes.tags_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Thumbnail:</span> ${notes.thumbnail_revision || '-'}</div>
                                    <div class="col-span-2"><span class="font-semibold text-gray-500">Lainnya:</span> ${notes.others_revision || '-'}</div>
                                </div>
                            </div>`;

                        const priorityClass = notes.priority === 'Tinggi' ? 'text-red-600' : (notes.priority === 'Sedang' ? 'text-yellow-600' : 'text-green-600');
                        html += `
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-3 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-xs text-yellow-800">Prioritas</h4>
                                    <p class="text-sm font-bold ${priorityClass}">${notes.priority || 'Sedang'}</p>
                                </div>
                                <div class="text-right">
                                    <h4 class="font-bold text-xs text-yellow-800">Deadline</h4>
                                    <p class="text-sm font-bold text-blue-600">${notes.deadline || '7 Hari'}</p>
                                </div>
                            </div>`;

                        if (notes.note) {
                            html += `
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-bold text-sm flex items-center gap-2">📝 Catatan Admin</h4>
                                    <p class="text-sm mt-1 text-gray-700">${notes.note}</p>
                                </div>`;
                        }
                    } else {
                        html = `<p class="text-sm text-gray-500 text-center py-2">Tidak ada catatan revisi spesifik.</p>`;
                    }
                    document.getElementById('revisionModalNotes').innerHTML = html;
                    document.getElementById('revisionBtnShow').href = `/admin/articles/view/${id}`;
                    document.getElementById('revisionBtnRestore').action = `/admin/articles/restore/${id}`;

                    revisionModal.classList.remove('hidden');
                    setTimeout(() => {
                        revisionModal.classList.remove('opacity-0');
                        revisionModalBox.classList.remove('scale-95', 'opacity-0');
                        revisionModalBox.classList.add('scale-100', 'opacity-100');
                    }, 10);
                })
                .catch(() => showToast('Gagal memuat detail revisi.', 'error'));
        }

        function closeRevisionModal() {
            revisionModalBox.classList.remove('scale-100', 'opacity-100');
            revisionModalBox.classList.add('scale-95', 'opacity-0');
            revisionModal.classList.remove('opacity-100');
            revisionModal.classList.add('opacity-0');
            setTimeout(() => revisionModal.classList.add('hidden'), 300);
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