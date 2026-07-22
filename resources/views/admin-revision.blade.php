<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revision Management - AKSARA</title>
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
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        .submenu { transition: all 0.3s ease-in-out; overflow: hidden; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
        .dropdown-menu { transform-origin: top right; transition: transform 0.1s ease, opacity 0.1s ease; }

        /* ✅ BARU: styling modal detail revisi (disamakan dengan staff-revision.blade.php) */
        #revision-modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        #modal-box { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease; }
        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
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

    <!-- Toast Container -->
    <div id="toast-container"></div>

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
                    <a href="{{ route('admin.revision') }}" class="block text-white font-medium bg-gray-800/30 rounded px-2 py-1.5 text-[13px] transition-colors">• Revision</a>
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
                <img src="https://ui-avatars.com/api/?name=Admin+Utama&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
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

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('success') }}'); });</script>
        @endif

        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Daftar Revisi</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Revisi Artikel</h1>
                <p class="text-sm text-gray-500 mt-1">Semua artikel revisi yang diajukan oleh Admin ke Staff.</p>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></th>
                            <th class="px-4 py-4 min-w-[220px]">Judul Artikel</th>
                            <th class="px-4 py-4 min-w-[120px]">Penulis</th>
                            <th class="px-4 py-4 min-w-[120px]">Admin Pemberi Revisi</th>
                            <th class="px-4 py-4 min-w-[160px]">Catatan Revisi</th>
                            <th class="px-4 py-4 min-w-[120px]">Status</th>
                            <th class="px-4 py-4 min-w-[110px]">Tanggal Revisi</th>
                            <th class="px-4 py-4 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($articles as $article)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">{{ $article->title }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $article->user->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ optional($article->reviewedBy)->name ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600 max-w-[200px] truncate">
                                @php
                                    $revNotes = json_decode($article->revision_notes, true);
                                    $notePreview = is_array($revNotes) && isset($revNotes['note']) ? $revNotes['note'] : $article->revision_notes;
                                @endphp
                                {{ Str::limit(strip_tags($notePreview), 80) }}
                            </td>
                            <td class="px-4 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full text-[10px] font-bold">Revision</span></td>
                            <td class="px-4 py-4 text-gray-600">{{ \Carbon\Carbon::parse($article->updated_at)->isoFormat('D MMM YYYY') }}</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button type="button" onclick="toggleDropdown(this)" data-menu-target="dropdown-menu-rev-{{ $article->id }}" class="dropdown-toggle-btn text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div id="dropdown-menu-rev-{{ $article->id }}" class="dropdown-menu hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-xl z-20 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            {{-- ✅ FIX: "Lihat Detail" sekarang membuka modal (disamakan dengan
                                                 staff-revision.blade.php) alih-alih pindah ke halaman lain.
                                                 Tidak ada opsi Edit/Duplicate di sini — kalau itu muncul di
                                                 halaman "admin.articles.show" (link lama), kirimkan file blade-nya
                                                 supaya saya bisa hapus dari sana juga. --}}
                                            <button type="button" onclick="openModal({{ $article->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Lihat Detail
                                            </button>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <form action="{{ route('admin.articles.restore', $article->id) }}" method="POST" onsubmit="return confirm('Batalkan revisi ini? Artikel akan dikembalikan ke status Pending/Draft.');">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Batalkan Revisi
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada data revisi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </main>

    {{-- ✅ BARU: Modal Detail Revisi — struktur & style disamakan dengan staff-revision.blade.php --}}
    <div id="revision-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center opacity-0">
        <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Detail Alasan Revisi</h3>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <span id="modal-title" class="text-base font-bold text-gray-900">Memuat...</span>
                    <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-bold">Revision</span>
                </div>

                <div id="modal-notes-container" class="space-y-4">
                    <!-- Diisi oleh JavaScript -->
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-gray-400 w-full sm:w-auto text-center sm:text-left mb-2 sm:mb-0">Aksi:</p>
                <div class="flex flex-wrap justify-end gap-2 w-full sm:w-auto">
                    <a id="btn-show" href="#" class="flex-1 sm:flex-none border border-blue-500 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-1 min-w-[130px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Artikel Lengkap
                    </a>
                    <form id="btn-restore" action="" method="POST" class="flex-1 sm:flex-none min-w-[130px]" onsubmit="return confirm('Batalkan revisi ini? Artikel akan dikembalikan ke status Pending/Draft.');">
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

        /* ===== Dropdown action (portal fix sama seperti halaman Feedback/User) ===== */
        function toggleDropdown(button) {
            const menu = document.getElementById(button.dataset.menuTarget);
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
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
            setTimeout(() => { menu.classList.add('hidden'); }, 100);
        }

        function positionDropdown(button, menu) {
            const rect = button.getBoundingClientRect();
            const menuWidth = menu.offsetWidth || 176;
            const menuHeight = menu.offsetHeight || 120;
            const margin = 8;
            let left = rect.right - menuWidth;
            let top = rect.bottom + 6;
            if (left < margin) left = margin;
            if (left + menuWidth > window.innerWidth - margin) left = window.innerWidth - menuWidth - margin;
            if (top + menuHeight > window.innerHeight - margin) top = rect.top - menuHeight - 6;
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

        document.addEventListener('DOMContentLoaded', function() {
            const submenu = document.getElementById('submenu-knowledge');
            const arrow = document.getElementById('arrow-knowledge');
            if(submenu) {
                submenu.classList.remove('hidden');
                if(arrow) arrow.classList.add('rotate-180');
            }
        });

        /* ===== Toast (sama seperti staff-revision.blade.php, tidak butuh library eksternal) ===== */
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

        /* =========================================================================
           ✅ BARU: Modal Detail Revisi — logic disamakan dengan staff-revision.blade.php.
           Memakai endpoint 'admin.articles.json' yang sudah ada di routes/web.php
           (Route::get('/articles/json/{id}', ...)->name('articles.json')).

           CATATAN: kalau field JSON yang dikembalikan controller getArticleJson()
           namanya beda dari yang diasumsikan di sini (title, revision_notes,
           reviewed_by.name), tinggal kabari saya supaya disesuaikan persis.
           ========================================================================= */
        const modal = document.getElementById('revision-modal');
        const modalBox = document.getElementById('modal-box');

        function openModal(id) {
            fetch(`/admin/articles/json/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-title').innerText = data.title || 'Artikel';

                    // revision_notes bisa berupa string JSON mentah (kolom database) atau
                    // sudah berupa object kalau controller sudah men-decode-nya duluan.
                    let notes = {};
                    if (data.revision_notes) {
                        notes = typeof data.revision_notes === 'string'
                            ? (JSON.parse(data.revision_notes || '{}') || {})
                            : data.revision_notes;
                    } else if (data.notes) {
                        notes = data.notes;
                    }

                    let notesHtml = '';
                    if (notes && typeof notes === 'object' && Object.keys(notes).length > 0) {
                        notesHtml += `
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
                            </div>
                        `;

                        const priorityClass = notes.priority === 'Tinggi' ? 'text-red-600' : (notes.priority === 'Sedang' ? 'text-yellow-600' : 'text-green-600');
                        notesHtml += `
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-3 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-xs text-yellow-800">Prioritas</h4>
                                    <p class="text-sm font-bold ${priorityClass}">${notes.priority || 'Sedang'}</p>
                                </div>
                                <div class="text-right">
                                    <h4 class="font-bold text-xs text-yellow-800">Deadline</h4>
                                    <p class="text-sm font-bold text-blue-600">${notes.deadline || '7 Hari'}</p>
                                </div>
                            </div>
                        `;

                        if (notes.note) {
                            notesHtml += `
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-bold text-sm flex items-center gap-2">📝 Catatan Admin</h4>
                                    <p class="text-sm mt-1 text-gray-700">${notes.note}</p>
                                </div>
                            `;
                        }
                    } else {
                        notesHtml = `<p class="text-sm text-gray-500 text-center py-2">Tidak ada catatan revisi spesifik.</p>`;
                    }
                    document.getElementById('modal-notes-container').innerHTML = notesHtml;

                    document.getElementById('btn-show').href = `/admin/articles/view/${id}`;
                    document.getElementById('btn-restore').action = `/admin/articles/restore/${id}`;

                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0');
                        modal.classList.add('opacity-100');
                        modalBox.classList.remove('scale-95', 'opacity-0');
                        modalBox.classList.add('scale-100', 'opacity-100');
                    }, 10);
                })
                .catch(error => {
                    console.error('Error fetching revision details:', error);
                    showToast('Gagal memuat detail revisi.');
                });
        }

        function closeModal() {
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
</body>
</html>