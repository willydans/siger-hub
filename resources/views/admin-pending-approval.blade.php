<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - AKSARA</title>
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
        #review-modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        #modal-box { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease; }
        #revision-form-container { 
            transition: all 0.4s ease-in-out; 
            max-height: 0; 
            opacity: 0; 
            overflow: hidden; 
        }
        #revision-form-container.open { 
            max-height: 800px; 
            opacity: 1; 
            overflow: visible; 
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

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
                    <a href="{{ route('admin.all-articles') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.all-articles') ? 'text-white' : '' }}">• All Articles</a>
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between {{ request()->routeIs('admin.pending-approval') ? 'text-white' : '' }}">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ $articles->total() }}</span></a>
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
            <h2 class="text-xl font-bold text-gray-900">{{ $pageTitle }}</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $pageTitle }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $statusLabel }} yang membutuhkan persetujuan Anda.</p>
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-8 flex items-center justify-between flex-wrap gap-4 fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xl font-bold">{{ $articles->total() }}</div>
                <div>
                    <p class="text-sm font-bold text-red-800">Menunggu Verifikasi Admin</p>
                    <p class="text-xs text-red-600">Artikel yang membutuhkan persetujuan Anda saat ini.</p>
                </div>
            </div>
            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">Pending</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 fade-in-up" style="animation-delay: 0.3s;">
            @forelse($articles as $article)
            <div onclick="openReviewModal({{ $article->id }})" class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 flex flex-col hover-lift cursor-pointer transition-all duration-200">
                <div class="flex items-start gap-4 mb-3">
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden">
                        @if($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-sm leading-snug">{{ $article->title }}</h3>
                        <div class="flex flex-wrap gap-x-3 gap-y-1 text-[10px] text-gray-500 mt-1">
                            <span class="flex items-center gap-1">✍️ {{ $article->user->name ?? 'Tanpa Penulis' }}</span>
                            <span class="flex items-center gap-1">📂 {{ $article->category ?? 'Umum' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between text-[10px] text-gray-500 border-t border-gray-100 pt-3 mt-auto">
                    <span>📅 {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMM YYYY') }}</span>
                    <span>⏱️ {{ $article->reading_time ?? '-' }} min read</span>
                    @if($article->attachments_count > 0)
                        <span class="flex items-center gap-1">📎 <span class="font-bold text-gray-700">{{ $article->attachments_count }}</span> Lampiran</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                <p>Tidak ada artikel yang menunggu persetujuan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </main>

    <!-- MODAL: REVIEW ARTIKEL -->
    <div id="review-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 visibility-hidden">
        <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl transform scale-95 opacity-0 flex flex-col h-[90vh] mx-4 md:mx-auto">
            
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Review Artikel</h3>
                </div>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
                <div class="w-full md:w-2/3 p-6 overflow-y-auto border-r border-gray-100 flex flex-col gap-4" id="article-preview">
                    <div class="animate-pulse">
                        <div class="h-6 bg-gray-200 rounded w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-3 bg-gray-200 rounded w-full"></div>
                            <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3 p-6 overflow-y-auto bg-gray-50/50 flex flex-col gap-6">
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm" id="article-info">
                        <h4 class="text-[10px] font-bold text-gray-500 uppercase mb-3">Informasi Dasar</h4>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div><span class="font-bold text-gray-500">Penulis</span><br><span class="font-medium text-gray-800" id="info-author">-</span></div>
                            <div><span class="font-bold text-gray-500">Kategori</span><br><span class="font-medium text-gray-800" id="info-category">-</span></div>
                            <div><span class="font-bold text-gray-500">Tag</span><br><span class="font-medium text-gray-800" id="info-tags">-</span></div>
                            <div><span class="font-bold text-gray-500">Visibilitas</span><br><span class="font-medium text-gray-800" id="info-visibility">-</span></div>
                            <div><span class="font-bold text-gray-500">Versi</span><br><span class="font-medium text-gray-800" id="info-version">-</span></div>
                            <div><span class="font-bold text-gray-500">Lampiran</span><br><span class="font-medium text-gray-800" id="info-attachments">-</span></div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="font-bold text-gray-500 text-xs block mb-1">History</span>
                            <div class="flex items-center gap-2 text-[10px] text-gray-600">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> <span id="info-submitted">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 block">Komentar Admin</label>
                        <textarea id="admin-comment" rows="2" placeholder="Tambahkan catatan untuk penulis..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none outline-none focus:border-gold focus:ring-1 focus:ring-gold transition"></textarea>
                    </div>

                    <div class="flex flex-col gap-2 mt-auto">
                        <form id="form-approve" method="POST" action="">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-sm hover:shadow flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Approve
                            </button>
                        </form>
                        
                        <button onclick="toggleRevisionForm()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-sm hover:shadow flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Revision
                        </button>
                        
                        <form id="form-reject" method="POST" action="">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-sm hover:shadow flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Reject
                            </button>
                        </form>
                    </div>

                    <!-- ============================================== -->
                    <!-- BAGIAN REVISI (Muncul saat tombol Revision)  -->
                    <!-- ============================================== -->
                    <div id="revision-form-container" class="mt-2 bg-white border border-yellow-300 rounded-xl p-4 shadow-sm">
                        <h4 class="font-bold text-gray-800 text-sm mb-4 border-b border-gray-100 pb-2 flex items-center gap-2">
                            <span class="text-yellow-600">📝</span> Form Revisi
                        </h4>
                        
                        <div class="space-y-4">
                            <!-- Dropdowns -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Judul</label>
                                    <select id="rev-title" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Perbaikan Judul">Perbaikan Judul</option>
                                        <option value="Biarkan Sama">Biarkan Sama</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Isi</label>
                                    <select id="rev-content" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Revisi Paragraf">Revisi Paragraf</option>
                                        <option value="Tambah Referensi">Tambah Referensi</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Lampiran</label>
                                    <select id="rev-attachments" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Upload PDF Baru">Upload PDF Baru</option>
                                        <option value="Hapus Lampiran Lama">Hapus Lampiran Lama</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kategori</label>
                                    <select id="rev-category" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Ganti Kategori">Ganti Kategori</option>
                                        <option value="Biarkan Sama">Biarkan Sama</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tag</label>
                                    <select id="rev-tags" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Tambah Tag">Tambah Tag</option>
                                        <option value="Biarkan Sama">Biarkan Sama</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Thumbnail</label>
                                    <select id="rev-thumbnail" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Ganti Gambar">Ganti Gambar</option>
                                        <option value="Biarkan Sama">Biarkan Sama</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Lainnya</label>
                                    <select id="rev-others" class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs outline-none focus:border-gold">
                                        <option value="Perbaikan UI/UX">Perbaikan UI/UX</option>
                                        <option value="Tidak Ada Perubahan Lain">Tidak Ada Perubahan Lain</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Prioritas -->
                            <div class="border-t border-gray-100 pt-3">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Prioritas</label>
                                <div class="flex gap-4 text-xs font-medium">
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="priority" value="Tinggi" class="text-red-500 focus:ring-red-500"> Tinggi</label>
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="priority" value="Sedang" checked class="text-yellow-500 focus:ring-yellow-500"> Sedang</label>
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="priority" value="Rendah" class="text-green-500 focus:ring-green-500"> Rendah</label>
                                </div>
                            </div>

                            <!-- Deadline -->
                            <div class="border-t border-gray-100 pt-3">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Deadline Revisi</label>
                                <div class="flex gap-4 text-xs font-medium">
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="deadline" value="3 Hari" class="text-blue-500 focus:ring-blue-500"> 3 Hari</label>
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="deadline" value="7 Hari" checked class="text-blue-500 focus:ring-blue-500"> 7 Hari</label>
                                    <label class="flex items-center gap-1 cursor-pointer"><input type="radio" name="deadline" value="14 Hari" class="text-blue-500 focus:ring-blue-500"> 14 Hari</label>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Catatan</label>
                                <textarea id="revision-note" rows="3" placeholder="Mohon tambahkan dasar hukum. Format gambar kurang jelas. Silakan upload PDF." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-xs resize-none outline-none focus:border-gold focus:ring-1 focus:ring-gold transition placeholder-gray-400"></textarea>
                            </div>

                            <!-- Tombol Kirim Revisi -->
                            <button onclick="submitRevision()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg text-xs transition-colors shadow-sm hover:shadow flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Permintaan Revisi
                            </button>
                        </div>
                    </div>
                    <!-- END BAGIAN REVISI -->

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
            const arrow = document.getElementById('arrow-' + id.split('-')[1]);
            if (el.classList.contains('hidden')) {
                el.classList.remove('hidden');
                if(arrow) arrow.classList.add('rotate-180');
            } else {
                el.classList.add('hidden');
                if(arrow) arrow.classList.remove('rotate-180');
            }
        }

        const modal = document.getElementById('review-modal');
        const modalBox = document.getElementById('modal-box');
        let currentArticleId = null;

        function openReviewModal(id) {
            currentArticleId = id;
            const revContainer = document.getElementById('revision-form-container');
            revContainer.classList.remove('open');
            document.getElementById('admin-comment').value = '';
            
            fetch(`/admin/articles/json/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('article-preview').innerHTML = `
                        <h2 class="text-2xl font-bold text-gray-900">${data.title}</h2>
                        <div class="flex items-center gap-3 text-xs text-gray-500 border-b border-gray-100 pb-4">
                            <span>✍️ ${data.user ? data.user.name : 'Tanpa Penulis'}</span> • 
                            <span>📂 ${data.category || 'Umum'}</span> • 
                            <span>📅 ${new Date(data.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</span>
                            ${data.reading_time ? `• <span>⏱️ ${data.reading_time} min read</span>` : ''}
                        </div>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            ${data.content || '<p><em>Konten tidak tersedia.</em></p>'}
                        </div>
                    `;

                    document.getElementById('info-author').textContent = data.user ? data.user.name : '-';
                    document.getElementById('info-category').textContent = data.category || '-';
                    document.getElementById('info-tags').textContent = data.tags || '-';
                    document.getElementById('info-visibility').textContent = data.visibility || '-';
                    document.getElementById('info-version').textContent = data.version || '-';
                    document.getElementById('info-attachments').textContent = data.attachments_count ? `${data.attachments_count} File` : '-';
                    document.getElementById('info-submitted').textContent = `Diajukan ${new Date(data.created_at).toLocaleString('id-ID')}`;

                    document.getElementById('form-approve').action = `/admin/articles/approve/${id}`;
                    document.getElementById('form-reject').action = `/admin/articles/reject/${id}`;

                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0', 'visibility-hidden');
                        modal.classList.add('opacity-100', 'visibility-visible');
                        modalBox.classList.remove('scale-95', 'opacity-0');
                        modalBox.classList.add('scale-100', 'opacity-100');
                    }, 10);
                })
                .catch(error => {
                    showToast('Gagal memuat data artikel.', 'red');
                });
        }

        function closeReviewModal() {
            modalBox.classList.remove('scale-100', 'opacity-100');
            modalBox.classList.add('scale-95', 'opacity-0');
            modal.classList.remove('opacity-100', 'visibility-visible');
            modal.classList.add('opacity-0', 'visibility-hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        let isRevisionOpen = false;
        function toggleRevisionForm() {
            const container = document.getElementById('revision-form-container');
            isRevisionOpen = !isRevisionOpen;
            if(isRevisionOpen) {
                container.classList.add('open');
            } else {
                container.classList.remove('open');
            }
        }

        function submitRevision() {
            const data = {
                title_revision: document.getElementById('rev-title').value,
                content_revision: document.getElementById('rev-content').value,
                attachments_revision: document.getElementById('rev-attachments').value,
                category_revision: document.getElementById('rev-category').value,
                tags_revision: document.getElementById('rev-tags').value,
                thumbnail_revision: document.getElementById('rev-thumbnail').value,
                others_revision: document.getElementById('rev-others').value,
                priority: document.querySelector('input[name="priority"]:checked')?.value || 'Sedang',
                deadline: document.querySelector('input[name="deadline"]:checked')?.value || '7 Hari',
                note: document.getElementById('revision-note').value
            };

            if(confirm("Kirim permintaan revisi ke penulis?")) {
                fetch(`/admin/articles/revision/${currentArticleId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text();
                        throw new Error(`Server merespons ${response.status}. Pastikan route & controller sudah terpasang.`);
                    }
                    return response.json();
                })
                .then(data => {
                    showToast(data.message || 'Permintaan revisi berhasil dikirim!', 'blue');
                    closeReviewModal();
                    location.reload();
                })
                .catch(error => {
                    console.error('Submit revision error:', error);
                    showToast(error.message || 'Gagal mengirim permintaan revisi.', 'red');
                });
            }
        }

        function showToast(message, color = 'green') {
            const borderColor = color === 'green' ? 'border-green-500' : (color === 'red' ? 'border-red-500' : 'border-blue-500');
            const textColor = color === 'green' ? 'text-green-500' : (color === 'red' ? 'text-red-500' : 'text-blue-500');
            const toastContainer = document.createElement('div');
            toastContainer.className = `fixed top-5 right-5 z-[9999] bg-white border-l-4 ${borderColor} p-4 rounded-lg shadow-xl transform translate-x-[120%] animate-[slideInRight_0.4s_ease-out_forwards]`;
            toastContainer.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="${textColor} text-lg font-bold">✦</span>
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