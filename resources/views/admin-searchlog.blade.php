<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Log - AKSARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08); }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- SIDEBAR & MOBILE OVERLAY -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

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

            <a href="{{ route('admin.searchlog') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
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
            <h2 class="text-xl font-bold text-gray-900">Search Log</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Search Log</h1>
                <p class="text-sm text-gray-500 mt-1">Memantau semua kata kunci pencarian yang dilakukan pengguna sebagai bahan analisis kebutuhan konten.</p>
            </div>
        </div>

        <!-- Ringkasan Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.2s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">🔍 Total Search</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSearch) }}</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.3s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">📅 Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($todaySearch) }}</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.4s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">👤 User Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($activeUsers) }}</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-4 shadow-sm stat-card fade-in-up" style="animation-delay: 0.5s;">
                <p class="text-[10px] font-bold text-gray-500 uppercase mb-1 flex items-center gap-1">✨ Keyword Baru</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($newKeywords) }}</p>
            </div>
        </div>

        <!-- Trend Chart & Top Keyword Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.3s;">
            
            <!-- Trending Chart (Bar) -->
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-2">Trend Chart</h3>
                <div class="w-full h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Top Keyword List -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Top Keyword</h3>
                <ul class="space-y-3">
                    @foreach($trendData as $index => $item)
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2 {{ $loop->last ? 'border-b-0 pb-0' : '' }}">
                        <span class="font-medium text-gray-700 text-sm">{{ $item->query }}</span>
                        <span class="text-xs font-bold text-gray-400">{{ number_format($item->total) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Search History Table -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-8 fade-in-up" style="animation-delay: 0.4s;">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                <h3 class="font-bold text-gray-800 text-sm">Search History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-3 min-w-[120px]">Keyword</th>
                            <th class="px-4 py-3 min-w-[120px]">User</th>
                            <th class="px-4 py-3 min-w-[100px]">Role</th>
                            <th class="px-4 py-3 min-w-[120px]">OPD</th>
                            <th class="px-4 py-3 min-w-[80px]">Waktu</th>
                            <th class="px-4 py-3 min-w-[100px]">Hasil</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($history as $log)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $log->query }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $log->user ? $log->user->name : 'Guest' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $log->user ? optional($log->user->role)->name : '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $log->user ? $log->user->opd : '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $log->created_at->format('H:i') }}</td>
                            <td class="px-4 py-3">
                                @if($log->results_count > 0)
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">{{ $log->results_count }} Artikel</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-[10px] font-bold">0 Hasil</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500 text-sm">Belum ada data pencarian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $history->links() }}
                </div>
            </div>
        </div>

        <!-- Keyword Tanpa Hasil & Group Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.5s;">
            
            <!-- Keyword Tanpa Hasil -->
            <div class="lg:col-span-1 bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-2">Keyword Tanpa Hasil</h3>
                <p class="text-xs text-gray-500 mb-4">Daftar kata kunci yang tidak menghasilkan artikel, membantu mengidentifikasi celah pengetahuan.</p>
                <ul class="space-y-4">
                    @forelse($zeroResults as $zero)
                    <li class="flex flex-col border-b border-gray-100 pb-3">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-gray-700 text-sm">{{ $zero->query }}</span>
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">0 hasil</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-400">{{ $zero->created_at->diffForHumans() }} · {{ $zero->user ? $zero->user->name : 'Guest' }}</span>
                            <form action="{{ route('admin.searchlog.assign') }}" method="POST" class="inline-flex">
                                @csrf
                                <input type="hidden" name="keyword" value="{{ $zero->query }}">
                                <select name="staff_id" class="text-[10px] border border-gray-300 rounded py-1 px-2 bg-white mr-2">
                                    @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('name', 'staff'))->get() as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-100 hover:bg-blue-200 text-blue-700 text-[10px] font-bold px-3 py-1 rounded-full transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Assign
                                </button>
                            </form>
                        </div>
                    </li>
                    @empty
                    <li class="text-xs text-gray-500 text-center py-3">Tidak ada keyword tanpa hasil.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Search Berdasarkan OPD -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Search Berdasarkan OPD</h3>
                <p class="text-xs text-gray-500 mb-2">Analisis kata kunci pencarian berdasarkan OPD, membantu mengetahui kebutuhan pengetahuan setiap unit.</p>
                <div class="space-y-4">
                    @forelse($opdData as $opd => $queries)
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-1">{{ $opd }}</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($queries as $q)
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-medium">{{ $q->query }}</span>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-500 text-center">Belum ada data pencarian berdasarkan OPD.</p>
                    @endforelse
                </div>
            </div>

            <!-- Search Berdasarkan Role & Device -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-3">Search Berdasarkan Role</h3>
                    <p class="text-xs text-gray-500 mb-2">Distribusi pencarian berdasarkan peran pengguna.</p>
                    <div class="flex flex-col gap-2 text-sm">
                        @forelse($roleData as $role)
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">{{ ucfirst($role->role) }}</span>
                            <span class="font-bold text-gray-800">{{ number_format($role->total) }}</span>
                        </div>
                        @empty
                        <div class="text-gray-500 text-center text-xs py-2">Belum ada data.</div>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-3">Search Berdasarkan Device</h3>
                    <p class="text-xs text-gray-500 mb-2">Proporsi perangkat yang digunakan untuk melakukan pencarian.</p>
                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">📱 Mobile</span>
                            <span class="font-bold text-green-600">{{ round(($deviceData['Mobile'] / max(1, $totalSearch)) * 100) }}%</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">💻 Desktop</span>
                            <span class="font-bold text-gray-800">{{ round(($deviceData['Desktop'] / max(1, $totalSearch)) * 100) }}%</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-0">
                            <span class="text-gray-600">📟 Tablet</span>
                            <span class="font-bold text-gray-800">{{ round(($deviceData['Tablet'] / max(1, $totalSearch)) * 100) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Search Success Rate & Search Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 fade-in-up" style="animation-delay: 0.6s;">
            
            <!-- Success Rate Doughnut Chart -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Search Success Rate</h3>
                <p class="text-xs text-gray-500 mb-4">Persentase pencarian yang berhasil vs tidak ditemukan.</p>
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-full md:w-1/2 h-48 relative">
                        <canvas id="successRateChart"></canvas>
                    </div>
                    <div class="flex-1 space-y-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-gray-600">Total Search</span>
                            <span class="font-bold text-gray-900">{{ number_format($totalCount) }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1">
                            <span class="text-green-600 font-medium">Berhasil</span>
                            <span class="font-bold text-gray-900">{{ number_format($successCount) }} ({{ $totalCount > 0 ? round(($successCount / $totalCount) * 100) : 0 }}%)</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-0">
                            <span class="text-red-600 font-medium">Tidak Ditemukan</span>
                            <span class="font-bold text-gray-900">{{ number_format($failCount) }} ({{ $totalCount > 0 ? round(($failCount / $totalCount) * 100) : 0 }}%)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Analytics Table -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-sm">Search Analytics</h3>
                    <p class="text-[10px] text-gray-500">Ringkasan performa setiap kata kunci, termasuk jumlah klik dan CTR.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 text-[10px] uppercase text-gray-500 font-bold border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-2 min-w-[80px]">Keyword</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">Search</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">Klik</th>
                                <th class="px-4 py-2 text-center min-w-[60px]">CTR</th>
                                <th class="px-4 py-2 min-w-[100px]">Artikel Dibaca</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($analytics as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                <td class="px-4 py-2 font-medium text-gray-900">{{ $item->query }}</td>
                                <td class="px-4 py-2 text-center text-gray-600">{{ number_format($item->search_count) }}</td>
                                <td class="px-4 py-2 text-center text-gray-600">{{ number_format($item->total_clicks) }}</td>
                                <td class="px-4 py-2 text-center font-bold {{ $item->ctr >= 50 ? 'text-green-600' : 'text-red-600' }}">{{ $item->ctr }}%</td>
                                <td class="px-4 py-2 text-gray-600">{{ $item->article_title }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

        // --- Chart.js Initialization ---
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari controller
            const trendLabels = @json($trendLabels);
            const trendValues = @json($trendValues);
            const successCount = {{ $successCount }};
            const failCount = {{ $failCount }};

            // 1. Trend Chart (Bar)
            const ctx1 = document.getElementById('trendChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: trendLabels.length ? trendLabels : ['Tidak Ada Data'],
                    datasets: [{
                        label: 'Trend Search',
                        data: trendValues.length ? trendValues : [0],
                        backgroundColor: '#EAB308',
                        borderRadius: 4,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F1F5F9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // 2. Success Rate (Doughnut)
            const ctx2 = document.getElementById('successRateChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Berhasil', 'Tidak Ditemukan'],
                    datasets: [{
                        data: [successCount || 1, failCount || 1],
                        backgroundColor: ['#22C55E', '#EF4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>