<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - AKSARA</title>
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
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ─── LAYOUT FIX ──────────────────────────────────────── */
        body {
            font-family: 'Inter', sans-serif;
            background: #F8FAFC;
            color: #334155;
            margin: 0;
        }

        #sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 256px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 40;
            background: #0F172A;
            border-right: 1px solid #1e293b;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        #main-content {
            margin-left: 256px;
            min-height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        @media (max-width: 767px) {
            #sidebar        { transform: translateX(-100%); }
            #sidebar.open   { transform: translateX(0); }
            #main-content   { margin-left: 0; }
        }

        #sidebar::-webkit-scrollbar       { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        .submenu { overflow: hidden; transition: max-height 0.3s ease; max-height: 0; }
        .submenu.open { max-height: 500px; }

        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 30;
        }
        #sidebar-overlay.show { display: block; }

        @keyframes slideInRight {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }
    </style>
</head>
<body>

{{-- ══════════ OVERLAY MOBILE ══════════ --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ══════════ SIDEBAR ══════════ --}}
<aside id="sidebar">
    {{-- Logo --}}
    <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800 flex-shrink-0">
        <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">A</div>
        <div class="flex flex-col">
            <span class="font-bold text-white text-sm leading-tight">AKSARA</span>
            <span class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Super Admin</span>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 py-6 px-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Dashboard
        </a>

        {{-- Knowledge Management --}}
        <div>
            <button onclick="toggleSubmenu('submenu-knowledge','arrow-knowledge')"
                    class="w-full flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Knowledge Management
                </div>
                <svg id="arrow-knowledge" class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="submenu-knowledge" class="submenu pl-9 space-y-1 mt-1">
                <a href="{{ route('admin.all-articles') }}"    class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• All Articles</a>
                <a href="{{ route('admin.pending-approval') }}" class="flex items-center justify-between text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">
                    • Pending Approval
                    <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">
                        {{ \App\Models\Article::where('status','pending')->count() }}
                    </span>
                </a>
                <a href="{{ route('admin.draft') }}"     class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Draft</a>
                <a href="{{ route('admin.revision') }}"  class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Revision</a>
                <a href="{{ route('admin.published') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Published</a>
                <a href="{{ route('admin.archive') }}"   class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Archived</a>
                <a href="{{ route('admin.delete') }}"    class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Deleted</a>
            </div>
        </div>

        @php
            // ✨ REVISI UTAMA: Array navbar diurutkan ulang dan Activity Log dipindahkan
            // ke posisi yang benar (setelah Notification), sesuai Gambar 2.
            $navItems = [
                ['route' => 'admin.users',        'label' => 'User Management', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'admin.category',     'label' => 'Category',        'icon' => 'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                ['route' => 'admin.analytics',    'label' => 'Analytics',       'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route' => 'admin.searchlog',    'label' => 'Search Log',      'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                ['route' => 'admin.feedback',     'label' => 'Feedback',        'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                ['route' => 'admin.notification', 'label' => 'Notification',    'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                
                // ➡️ Activity Log dipindahkan ke sini
                ['route' => 'admin.activity',     'label' => 'Activity Log',    'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],

                ['route' => 'admin.storage',      'label' => 'Storage',         'icon' => 'M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z'],
                
                ['route' => 'admin.backup',       'label' => 'Backup & Restore','icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
            ];
        @endphp

        {{-- Loop menu items --}}
        @foreach($navItems as $item)
            @php $isActive = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 {{ $isActive ? 'bg-gray-800/70 text-white border border-gray-700' : 'text-gray-400 border border-transparent hover:text-white hover:bg-gray-800/50' }} px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5 flex-shrink-0 {{ $isActive ? 'text-gold' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- User footer --}}
    <div class="border-t border-gray-800 p-4 flex-shrink-0">
        <div class="flex items-center gap-3 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=ef4444&color=ffffff"
                 class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="Avatar">
            <div class="flex flex-col min-w-0">
                <span class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Admin Diskominfo' }}</span>
                <span class="text-[10px] text-gray-400">Super Admin</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- ══════════ MAIN CONTENT ══════════ --}}
<div id="main-content" class="p-4 md:p-8">

    {{-- Flash toast trigger --}}
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded',()=>showToast('{{ session('success') }}'));</script>
    @elseif(session('error'))
        <script>document.addEventListener('DOMContentLoaded',()=>showToast('{{ session('error') }}','error'));</script>
    @endif

    {{-- Mobile topbar --}}
    <div class="flex justify-between items-center mb-6 md:hidden">
        <button onclick="openSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <h2 class="text-xl font-bold text-gray-900">Activity Log</h2>
    </div>

    {{-- ── Header ── --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Activity Log</h1>
            <p class="text-sm text-gray-500 mt-1">Semua aktivitas pengguna. Export ke PDF atau Excel untuk keperluan audit.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <a href="{{ route('admin.activity.exportPdf', request()->all()) }}"
               class="flex-1 md:flex-none bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg text-xs transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('admin.activity.exportExcel', request()->all()) }}"
               class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-xs transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <form action="{{ route('admin.activity') }}" method="GET"
          class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">User</label>
                <input type="text" name="user" value="{{ request('user') }}"
                       placeholder="Cari user..."
                       class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}"
                       class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Jenis Aktivitas</label>
                <select name="activity_type"
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition bg-white text-gray-700">
                    <option value="">Semua</option>
                    @foreach($activityTypes as $type)
                        <option value="{{ $type }}" {{ request('activity_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">IP Address</label>
                <input type="text" name="ip_address" value="{{ request('ip_address') }}"
                       placeholder="192.168.1.1"
                       class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition">
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Device</label>
                    <input type="text" name="device" value="{{ request('device') }}"
                           placeholder="Chrome / Windows"
                           class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm outline-none focus:border-gold focus:ring-1 focus:ring-gold transition">
                </div>
            </div>

            {{-- Tombol filter --}}
            <div class="sm:col-span-2 lg:col-span-5 flex justify-end gap-2 pt-1">
                @if(request()->anyFilled(['user','date','activity_type','ip_address','device']))
                <a href="{{ route('admin.activity') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                    Reset
                </a>
                @endif
                <button type="submit"
                        class="bg-darkbg hover:bg-gray-800 text-white px-6 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </form>

    {{-- ── Stats ringkas ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Aktivitas', 'value' => $activities->total(), 'color' => 'text-blue-600',   'bg' => 'bg-blue-50'],
                ['label' => 'Halaman Ini',     'value' => $activities->count(), 'color' => 'text-purple-600', 'bg' => 'bg-purple-50'],
                ['label' => 'Halaman',         'value' => $activities->currentPage() . ' / ' . $activities->lastPage(), 'color' => 'text-gray-700', 'bg' => 'bg-gray-50'],
                ['label' => 'Per Halaman',     'value' => $activities->perPage(), 'color' => 'text-green-600', 'bg' => 'bg-green-50'],
            ];
        @endphp
        @foreach($statCards as $sc)
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">{{ $sc['label'] }}</p>
            <p class="text-xl font-bold {{ $sc['color'] }}">{{ $sc['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ── Tabel ── --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        {{-- Horizontal scroll wrapper --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" style="min-width:900px">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-[11px] uppercase text-gray-500 font-bold whitespace-nowrap">
                        <th class="px-4 py-3 w-10">
                            <input type="checkbox" id="check-all"
                                   class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer">
                        </th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Aktivitas</th>
                        <th class="px-4 py-3">IP Address</th>
                        <th class="px-4 py-3">Device / Browser</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-4 py-3.5">
                            <input type="checkbox" class="row-check w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer">
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="font-semibold text-gray-800">{{ $activity->created_at->format('H:i') }}</span>
                            <span class="block text-[10px] text-gray-400">{{ $activity->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user->name ?? 'G') }}&background=EAB308&color=0f172a&size=32"
                                     class="w-7 h-7 rounded-full flex-shrink-0 object-cover" alt="">
                                <span class="font-medium text-gray-800 whitespace-nowrap">
                                    {{ $activity->user->name ?? 'Guest' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            @php
                                $badge = [
                                    'Upload Artikel'  => 'bg-blue-100 text-blue-700',
                                    'Approve Artikel' => 'bg-green-100 text-green-700',
                                    'Login'           => 'bg-purple-100 text-purple-700',
                                    'Logout'          => 'bg-gray-100 text-gray-600',
                                    'Delete Draft'    => 'bg-red-100 text-red-700',
                                    'Edit Artikel'    => 'bg-yellow-100 text-yellow-700',
                                    'Revisi'          => 'bg-orange-100 text-orange-700',
                                ][$activity->type] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="{{ $badge }} px-2.5 py-1 rounded-full text-[10px] font-bold whitespace-nowrap">
                                {{ $activity->type }}
                            </span>
                            @if($activity->description)
                            <p class="text-xs text-gray-500 mt-1 max-w-xs truncate" title="{{ $activity->description }}">
                                {{ $activity->description }}
                            </p>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="font-mono text-xs text-gray-600">{{ $activity->ip_address ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3.5 max-w-[220px]">
                            <span class="text-xs text-gray-500 truncate block" title="{{ $activity->user_agent ?? '-' }}">
                                {{ $activity->user_agent ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-400 text-sm font-medium">Belum ada aktivitas yang tercatat.</p>
                            @if(request()->anyFilled(['user','date','activity_type','ip_address','device']))
                            <a href="{{ route('admin.activity') }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Reset filter</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-700">{{ $activities->firstItem() ?? 0 }}</span>–<span class="font-semibold text-gray-700">{{ $activities->lastItem() ?? 0 }}</span>
                dari <span class="font-semibold text-gray-700">{{ $activities->total() }}</span> data
            </p>
            {{ $activities->links() }}
        </div>
    </div>

    {{-- Spacer bawah agar konten terakhir tidak mepet --}}
    <div class="h-8"></div>
</div>{{-- /main-content --}}

<script>
    // ── Sidebar mobile ──
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('show');
    }

    // ── Submenu toggle ──
    function toggleSubmenu(id, arrowId) {
        const el    = document.getElementById(id);
        const arrow = document.getElementById(arrowId);
        el.classList.toggle('open');
        if (arrow) arrow.classList.toggle('rotate-180');
    }

    // ── Check-all checkbox ──
    document.getElementById('check-all')?.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
    });

    // ── Toast ──
    function showToast(message, type = 'success') {
        const border   = type === 'success' ? '#EAB308' : '#ef4444';
        const icon     = type === 'success' ? '✦' : '✖';
        const iconColor= type === 'success' ? '#EAB308' : '#ef4444';

        const el = document.createElement('div');
        el.style.cssText = `
            position:fixed; top:20px; right:20px; z-index:9999;
            background:#fff; border-left:4px solid ${border};
            padding:14px 16px; border-radius:10px;
            box-shadow:0 4px 20px rgba(0,0,0,.12);
            animation:slideInRight .4s ease-out forwards;
            max-width:340px;
        `;
        el.innerHTML = `
            <div style="display:flex;align-items:center;gap:10px;">
                <span style="color:${iconColor};font-weight:bold;font-size:16px">${icon}</span>
                <p style="margin:0;font-size:13px;font-weight:500;color:#1e293b;flex:1">${message}</p>
                <button onclick="this.parentElement.parentElement.remove()"
                        style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:14px;padding:0 0 0 8px">✕</button>
            </div>`;
        document.body.appendChild(el);
        setTimeout(() => {
            el.style.transition = 'transform .3s ease, opacity .3s ease';
            el.style.transform  = 'translateX(120%)';
            el.style.opacity    = '0';
            setTimeout(() => el.remove(), 300);
        }, 3500);
    }
</script>
</body>
</html>