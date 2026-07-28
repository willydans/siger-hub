<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Artikel - SIGER-Hub</title>
    
    <!-- 🚀 PERBAIKAN: Paksa Browser Jangan Cache Halaman Ini -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- ✅ TAMBAHAN: Meta CSRF agar aman jika menggunakan Fetch API -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ✅ PERBAIKAN KRUSIAL: Tambahkan jQuery SEBELUM Toastr agar tidak error -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    
    <!-- 🚀 PERBAIKAN: Tambahkan Cache Buster ?v={{ time() }} -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    
    <!-- 🚀 PERBAIKAN: Cache Buster untuk CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js?v={{ time() }}"></script>
    
    <style>
        .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
        .preview-btn { transition: all 0.2s ease; }
        .preview-btn.active { background-color: #EAB308; color: #0F172A; border-color: #EAB308; }
        .block-card { transition: all 0.2s ease; }
        .block-card:hover { transform: scale(1.02); border-color: #EAB308; }
        .ck-editor__editable_inline { min-height: 400px; }
        .ck-content { font-family: 'Inter', sans-serif; color: #334155; }
        .dropzone { border: 2px dashed #d1d5db; border-radius: 0.5rem; background: #f9fafb; transition: all 0.3s; }
        .dropzone:hover { border-color: #EAB308; }
        .dropzone .dz-message { font-size: 0.875rem; color: #6b7280; }
        .dropzone .dz-message i { font-size: 2rem; display: block; margin-bottom: 0.5rem; }
        .relation-chip-wrapper { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem; }
        .relation-chip { display: inline-flex; align-items: center; background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.85rem; color: #1f2937; }
        .relation-chip .remove-btn { margin-left: 0.5rem; cursor: pointer; color: #9ca3af; transition: color 0.2s; }
        .relation-chip .remove-btn:hover { color: #ef4444; }

        /* ✅ BARU: highlight sementara untuk field yang baru saja diisi otomatis oleh AI */
        .ai-filled,
        .ai-filled .ts-control {
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.35) !important;
            border-color: #9333ea !important;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .ai-glow-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 700; color: #9333ea;
            background: #f5f3ff; border: 1px solid #ddd6fe;
            padding: 2px 8px; border-radius: 9999px;
        }
        .ai-action-btn { cursor: pointer; }
        .ai-action-btn:hover i, .ai-action-btn:hover span { color: inherit; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">
    @php $user = auth()->user(); @endphp
    
    @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded', function() { toastr.success('{{ session('success') }}', 'Sukses', { positionClass: 'toast-top-right' }); });</script>
    @endif
    @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded', function() { toastr.error('Ada kesalahan pada form. Periksa kembali.', 'Error', { positionClass: 'toast-top-right' }); });</script>
    @endif

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
                    @php
                        $pendingCount = \App\Models\Article::where('status', 'pending')->count();
                    @endphp

                    <a href="{{ route('admin.all-articles') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.all-articles') ? 'text-white' : '' }}">• All Articles</a>
                    
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between {{ request()->routeIs('admin.pending-approval') ? 'text-white' : '' }}">
                        • Pending Approval 
                        @if($pendingCount > 0)
                            <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.draft') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.draft') ? 'text-white' : '' }}">• Draft</a>
                    <a href="{{ route('admin.revision') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.revision') ? 'text-white' : '' }}">• Revision</a>
                    <a href="{{ route('admin.published') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.published') ? 'text-white' : '' }}">• Published</a>
                    <a href="{{ route('admin.archive') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.archive') ? 'text-white' : '' }}">• Archived</a>
                    <a href="{{ route('admin.delete') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.delete') ? 'text-white' : '' }}">• Deleted</a>
                </div>
            </div>

            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>
            <a href="/admin/category" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>
            <a href="/admin/analytics" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Analytics
            </a>
            <a href="/admin/searchlog" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Search Log
            </a>
            <a href="/admin/feedback" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> Feedback
            </a>
            <a href="/admin/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            <a href="/admin/activity" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Activity Log
            </a>
            <a href="/admin/storage" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7h-4.586a2 2 0 01-1.414-.586l-1.172-1.172a2 2 0 00-1.414-.586H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7z"></path></svg> Storage
            </a>
            <a href="/admin/settings" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Settings
            </a>
            <a href="/admin/backup" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
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

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        <div class="flex justify-between items-center mb-4 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars w-6 h-6"></i>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Tulis Artikel</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="p-2 bg-gold/10 text-gold rounded-lg hidden md:block">
                    <i class="fas fa-pen-fancy text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 hidden md:block">Tulis Artikel / Dokumen Baru</h1>
                    <span class="text-xs text-gray-400 block md:hidden text-center w-full">Pastikan konten Anda relevan dan akurat.</span>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto justify-end flex-wrap">
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full hidden md:inline-block">
                    Status: <span class="font-bold {{ isset($article) && $article->status == 'draft' ? 'text-yellow-500' : 'text-green-500' }}">{{ isset($article) ? ucfirst($article->status) : 'Draft Baru' }}</span>
                </span>
                <button type="button" onclick="openAIAssistant()" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-wand-magic-sparkles"></i> AI Assistant
                </button>
            </div>
        </div>

        <form id="editorForm" method="POST" action="{{ isset($article) ? route('admin.all-articles.update', $article->id) : route('admin.article.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @if(isset($article)) @method('PUT') @endif

            <!-- ========================================== -->
            <!-- KOLOM KIRI (UTAMA)                         -->
            <!-- ========================================== -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- 1. Judul Artikel -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-2 hover-lift">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input id="title-input" name="title" type="text" value="{{ old('title', $article->title ?? '') }}" placeholder="Masukkan judul yang jelas dan deskriptif..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg font-medium focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors duration-200" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    
                    <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-2 text-xs text-gray-400">
                        <span class="font-medium text-gray-500">Slug Otomatis:</span>
                        <div class="flex items-center gap-1 w-full sm:w-auto bg-gray-50 border border-gray-200 rounded px-3 py-1.5">
                            <span class="text-gray-500 font-mono">sigerhub.lampungprov.go.id/</span>
                            <span id="slug-output" class="text-gray-800 font-mono font-medium">{{ $article->slug ?? 'judul-artikel-anda' }}</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Konten Artikel -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden fade-in-up delay-3 hover-lift">
                    <div class="p-4">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Konten Artikel <span class="text-red-500">*</span></label>
                        <textarea id="editor" name="content">{{ old('content', $article->content ?? '') }}</textarea>
                        @error('content') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- 3. Upload Lampiran -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3">
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-paperclip text-gold"></i>
                        Upload Lampiran
                    </h3>

                    @php
                        $existingAttachments = [];
                        if (isset($article) && $article->attachments) {
                            $existingAttachments = is_array($article->attachments)
                                ? $article->attachments
                                : (json_decode($article->attachments, true) ?? []);
                        }
                    @endphp
                    <div id="existing-attachments-list" class="space-y-2 mb-3">
                        @foreach($existingAttachments as $attachmentPath)
                            <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm attachment-item">
                                <a href="{{ asset('storage/' . $attachmentPath) }}" target="_blank" class="text-blue-600 hover:underline truncate flex items-center gap-2 flex-1 min-w-0">
                                    <i class="fas fa-file-alt flex-shrink-0"></i>
                                    <span class="truncate">{{ basename($attachmentPath) }}</span>
                                </a>
                                <input type="hidden" name="uploaded_attachments[]" value="{{ $attachmentPath }}">
                                <button type="button" onclick="removeExistingAttachment(this)" class="text-gray-400 hover:text-red-500 ml-2 flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="dropzone" id="myDropzone">
                        <div class="dz-message needsclick">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Tarik file ke sini atau klik untuk upload.</span>
                            <span class="block text-xs text-gray-400 mt-1">Maks 20MB per file. Format: PDF, Word, Excel, PPT, ZIP, Video, Audio, Gambar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- KOLOM KANAN (SIDEBAR)                      -->
            <!-- ========================================== -->
            <!-- Ditambahkan max-h dan overflow-y-auto agar sidebar bisa di-scroll terpisah jika terlalu panjang -->
            <div class="lg:col-span-1 space-y-6 sticky top-6 h-fit max-h-[calc(100vh-2rem)] overflow-y-auto sidebar-scroll pb-6">
                
                <!-- 1. Informasi Dasar -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-2 hover-lift">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-2 mb-1">
                        <h3 class="font-bold text-gray-800">Informasi Dasar</h3>
                        <button type="button" id="ai-autofill-btn" onclick="autoFillFromAI()" class="flex items-center gap-1.5 text-[11px] font-bold text-purple-600 bg-purple-50 hover:bg-purple-100 border border-purple-200 px-2.5 py-1.5 rounded-lg transition-colors flex-shrink-0">
                            <i class="fas fa-wand-magic-sparkles"></i> Auto-Isi AI
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 mb-4 leading-relaxed">
                        Kategori, subkategori, OPD, tag, dan metadata SEO akan disarankan otomatis oleh AI berdasarkan isi artikel Anda. Anda tetap bisa memilih atau mengubahnya secara manual kapan saja.
                    </p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Kategori Utama <span class="text-red-500">*</span></label>
                            <select id="category-select" name="category" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (isset($article) && $article->category_id == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Subkategori</label>
                            <select id="subcategory-select" name="subcategory" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option value="">Pilih Subkategori...</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ (isset($article) && $article->subcategory_id == $sub->id) ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">OPD / Unit</label>
                                <select id="opd-select" name="opd_unit">
                                    <option value="">Pilih OPD...</option>
                                    @foreach($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ (isset($article) && $article->opd_id == $opd->id) ? 'selected' : '' }}>
                                            {{ $opd->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tags</label>
                                <input type="text" name="tags" id="tags-input" value="{{ old('tags', isset($article) && is_array($article->tags) ? implode(', ', $article->tags) : '') }}" placeholder="cth: ssl, nginx" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Visibilitas</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="public" {{ (old('visibility', $article->visibility ?? 'public') == 'public') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Public</span><span class="text-[10px] text-gray-500">Semua orang bisa akses</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="internal" {{ (old('visibility', $article->visibility ?? '') == 'internal') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Internal</span><span class="text-[10px] text-gray-500">Hanya ASN Prov. Lampung</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="restricted" {{ (old('visibility', $article->visibility ?? '') == 'restricted') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Restricted</span><span class="text-[10px] text-gray-500">Login dengan akses khusus</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="private" {{ (old('visibility', $article->visibility ?? '') == 'private') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Private</span><span class="text-[10px] text-gray-500">Hanya author & admin</span></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Thumbnail / Cover Image <span class="text-red-500">*</span></h4>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gold transition-colors bg-gray-50/50 cursor-pointer relative group">
                            <input type="file" name="thumbnail" id="thumbnailInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewThumbnail(event)" {{ isset($article) ? '' : 'required' }}>
                            <div id="thumbnailPreviewContainer" class="flex flex-col items-center pointer-events-none">
                                @if(isset($article) && $article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-auto max-h-32 object-contain rounded mb-2 shadow-sm">
                                @endif
                                <div id="thumbnailPlaceholder" class="{{ isset($article) && $article->thumbnail ? 'hidden' : '' }} flex flex-col items-center">
                                    <i class="fas fa-image text-4xl text-gray-400 group-hover:text-gold transition-colors mb-2"></i>
                                    <span class="text-xs font-medium text-gray-600">Drag & Drop</span>
                                    <span class="text-[10px] text-gray-400">atau klik untuk upload</span>
                                </div>
                            </div>
                        </div>
                        @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- 2. Metadata & SEO -->
                <details class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift group open:border-gold/50 transition-all duration-200">
                    <summary class="flex justify-between items-center cursor-pointer list-none font-bold text-gray-800">
                        <span><i class="fas fa-tags mr-2"></i> Metadata & SEO</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform duration-200"><i class="fas fa-chevron-down"></i></span>
                    </summary>
                    <div class="mt-4 space-y-3 border-t border-gray-100 pt-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Keyword SEO</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $article->meta_keywords ?? '') }}" placeholder="Masukkan keyword" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Deskripsi (Meta)</label>
                            <textarea name="meta_description" rows="2" placeholder="Deskripsi singkat" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold resize-none">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Estimasi Waktu Baca</label>
                                <input type="number" name="estimated_read_time" value="{{ old('estimated_read_time', $article->estimated_read_time ?? '') }}" placeholder="Menit" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Bahasa</label>
                                <select name="language" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                    <option value="id" {{ (old('language', $article->language ?? 'id') == 'id') ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ (old('language', $article->language ?? '') == 'en') ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Versi</label>
                            <input type="text" name="version" value="{{ old('version', $article->version ?? '') }}" placeholder="v1.0" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                    </div>
                </details>

                <!-- 3. Knowledge Relation (Telah dipindahkan ke kanan) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm"><i class="fas fa-link mr-2 text-gold"></i> Knowledge Relation</h3>
                    <p class="text-xs text-gray-500 mb-2">Artikel berhubungan dengan (Enter untuk tambah):</p>
                    <div class="flex items-center gap-2">
                        <input type="text" id="relation-input" placeholder="Ketik nama relasi..." class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        <button type="button" onclick="addRelation()" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-sm font-medium border border-blue-200 transition-colors">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>
                    <div id="relation-list" class="relation-chip-wrapper mt-2">
                        @if(isset($article) && $article->relations)
                            @foreach(json_decode($article->relations, true) as $rel)
                                <div class="relation-chip">
                                    <span>{{ $rel }}</span>
                                    <input type="hidden" name="relations[]" value="{{ $rel }}">
                                    <span class="remove-btn" onclick="removeRelation(this)"><i class="fas fa-times"></i></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- 4. Flowchart / SOP (Telah dipindahkan ke kanan) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm"><i class="fas fa-project-diagram mr-2 text-gold"></i> Flowchart (SOP)</h3>
                    <p class="text-xs text-gray-500 mb-2">Tulis kode Mermaid untuk diagram alur.</p>
                    <textarea id="mermaid-input" rows="4" placeholder="flowchart TD&#10;A[Start] --> B[Process]&#10;B --> C[End]" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold resize-none">{{ old('flowchart', $article->flowchart ?? '') }}</textarea>
                    <button type="button" onclick="renderFlowchart()" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-medium flex items-center gap-1">
                        <i class="fas fa-sync-alt"></i> Render
                    </button>
                    <div id="mermaid-preview" class="mt-3 border border-gray-200 rounded bg-white p-2 min-h-[60px]"></div>
                </div>

                <!-- 5. Tombol Aksi (Telah dipindahkan ke kanan agar selalu terlihat) -->
                <div class="flex flex-col gap-2 mt-6">
                    <button type="submit" class="w-full border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg text-sm bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Draf
                    </button>
                    
                    @if(isset($article))
                        <a href="{{ route('admin.articles.show', $article->id) }}" target="_blank" class="w-full bg-darkbg text-white font-bold py-3 px-4 rounded-lg text-sm hover:bg-gray-800 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-eye"></i> Preview
                        </a>
                    @else
                        <button type="button" onclick="Swal.fire('Info', 'Simpan draft terlebih dahulu untuk melihat preview.', 'info')" class="w-full bg-gray-300 text-gray-600 font-bold py-3 px-4 rounded-lg text-sm cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                    @endif

                    @if(isset($article))
                        @if($article->status === 'draft')
                            <form action="{{ route('admin.editor.submit', $article->id) }}" method="POST" id="submitForm" class="w-full">
                                @csrf
                                <button type="button" onclick="confirmSubmit()" class="w-full bg-gold text-darkbg font-bold py-3 px-4 rounded-lg text-sm hover:bg-goldhover transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle"></i> Submit Approval
                                </button>
                            </form>
                        @else
                            <div class="w-full bg-blue-50 border border-blue-200 text-blue-800 text-center py-3 px-4 rounded-lg text-sm font-bold flex flex-col items-center justify-center gap-1">
                                <i class="fas fa-clock"></i> <span>Menunggu Persetujuan</span>
                            </div>
                        @endif
                    @else
                        <button type="button" onclick="Swal.fire('Info', 'Silakan simpan draft terlebih dahulu sebelum melakukan Submit Approval!', 'info')" class="w-full bg-gold/50 text-darkbg/50 cursor-not-allowed font-bold py-3 px-4 rounded-lg text-sm shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Submit Approval
                        </button>
                    @endif
                </div>

            </div>
        </form>
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

        const titleInput = document.getElementById('title-input');
        const slugOutput = document.getElementById('slug-output');
        if(titleInput) {
            titleInput.addEventListener('input', function(e) {
                const text = e.target.value;
                const slug = text.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') 
                    .replace(/\s+/g, '-') 
                    .replace(/-+/g, '-') 
                    .replace(/^-|-$/g, '');
                slugOutput.textContent = slug || 'judul-artikel-anda';
            });
        }

        function previewThumbnail(event) {
            const input = event.target;
            const container = document.getElementById('thumbnailPreviewContainer');
            const placeholder = document.getElementById('thumbnailPlaceholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-auto max-h-32 object-contain rounded mb-2 shadow-sm';
                    container.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
                if(placeholder) placeholder.classList.add('hidden');
            }
        }

        function MyUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }
        
        class MyUploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    
                    const uploadUrl = "#";

                    fetch(uploadUrl, { 
                        method: 'POST',
                        headers: { 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: data
                    })
                    .then(async response => {
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error("Server returned HTML/Error:", errorText);
                            throw new Error(`Gagal terhubung ke server (${response.status}). Cek console untuk detail.`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (result.url) {
                            resolve({ default: result.url });
                        } else {
                            reject('Gagal mengupload gambar: Response tidak memiliki URL');
                        }
                    })
                    .catch(error => {
                        console.error('CKEditor Upload Error:', error);
                        toastr.error(error.message || 'Terjadi kesalahan upload gambar', 'Gagal');
                        reject(error);
                    });
                }));
            }
            abort() {}
        }

        // ✅ FIX KRUSIAL: sebelumnya `editorElement.ckeditorInstance` TIDAK PERNAH di-assign,
        // sehingga getCKEditorContent() selalu jatuh ke fallback (data basi/kosong) dan
        // AI Assistant, Preview, dan Auto-Isi AI tidak pernah membaca konten yang sebenarnya.
        const editorElement = document.querySelector('#editor');
        let ckEditorReady = false;
        if (editorElement) {
            ClassicEditor
                .create( editorElement, {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'link', 'blockQuote', 'insertTable', 'imageUpload', 'mediaEmbed', '|',
                            'alignment', 'outdent', 'indent', '|',
                            'undo', 'redo'
                        ]
                    },
                    alignment: { options: [ 'left', 'center', 'right', 'justify' ] },
                    image: { toolbar: [ 'imageTextAlternative', 'imageStyle:full', 'imageStyle:side' ] },
                    table: { contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ] },
                    extraPlugins: [ MyUploadAdapterPlugin ]
                })
                .then(editor => {
                    editorElement.ckeditorInstance = editor;
                    ckEditorReady = true;
                    // ✅ BARU: pantau perubahan konten (debounced) untuk auto-trigger Auto-Isi AI
                    editor.model.document.on('change:data', debounce(() => {
                        maybeAutoFillFromAI();
                    }, 2500));
                })
                .catch( error => console.error(error) );
        }

        function debounce(fn, delay) {
            let timer;
            return function(...args) {
                clearTimeout(timer);
                timer = setTimeout(() => fn.apply(this, args), delay);
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category-select');
            if (categorySelect) {
                categoryTS = new TomSelect(categorySelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const subcategorySelect = document.getElementById('subcategory-select');
            if (subcategorySelect) {
                subcategoryTS = new TomSelect(subcategorySelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const opdSelect = document.getElementById('opd-select');
            if (opdSelect) {
                opdTS = new TomSelect(opdSelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const tagsInput = document.getElementById('tags-input');
            if (tagsInput) {
                tagsTS = new TomSelect(tagsInput, {
                    delimiter: ',',
                    persist: false,
                    create: function(input) { return { value: input, text: input }; },
                });
            }
        });

        // ✅ PERBAIKAN: DROPZONE menggunakan Route Helper
        Dropzone.options.myDropzone = {
    url: "{{ route('admin.article.uploadAttachment') }}", 
            paramName: "file",
            maxFilesize: 20,
            acceptedFiles: '.pdf,.docx,.mp4,.zip,.jpg,.jpeg,.png,.webp',
            addRemoveLinks: true,
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest' 
            },
            init: function() {
                this.on("success", function(file, response) {
                    console.log("Upload Success:", response);
                    if (response.success) {
                        let hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'uploaded_attachments[]');
                        hiddenInput.setAttribute('value', response.path);
                        hiddenInput.setAttribute('data-file-id', file.upload.uuid);
                        document.getElementById('editorForm').appendChild(hiddenInput);
                        toastr.success('File berhasil diupload!', 'Sukses');
                    } else {
                        toastr.error('Gagal upload', 'Error');
                    }
                });
                this.on("removedfile", function(file) {
                    let hiddenInputs = document.querySelectorAll('input[name="uploaded_attachments[]"]');
                    hiddenInputs.forEach(function(input) {
                        if (input.getAttribute('data-file-id') === file.upload.uuid) {
                            input.remove();
                        }
                    });
                });
                this.on("error", function(file, errorMessage, xhr) {
                    console.error("Dropzone Error:", errorMessage);
                    if (xhr && xhr.responseText) {
                        console.error("Full Server Response (HTML):", xhr.responseText);
                        if (xhr.responseText.includes('<!DOCTYPE html>')) {
                            toastr.error('Server mengembalikan halaman error 404/500. Pastikan sudah run php artisan route:clear!', 'Error');
                            return;
                        }
                    }
                    toastr.error('Upload gagal! Buka Console (F12) untuk detail error.', 'Error');
                });
            }
        };

        mermaid.initialize({ startOnLoad: false });
        function renderFlowchart() {
            const code = document.getElementById('mermaid-input').value;
            const preview = document.getElementById('mermaid-preview');
            if (code.trim() === '') {
                preview.innerHTML = '<p class="text-gray-400 text-sm">Belum ada flowchart.</p>';
                return;
            }
            preview.innerHTML = `<div class="mermaid">${code}</div>`;
            try {
                mermaid.run({ nodes: [preview] });
            } catch(e) {
                preview.innerHTML = '<p class="text-red-500 text-xs">Kode Mermaid tidak valid.</p>';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('mermaid-input').value.trim() !== '') {
                renderFlowchart();
            }
        });

        function addRelation() {
            const input = document.getElementById('relation-input');
            const val = input.value.trim();
            if (!val) {
                toastr.warning('Masukkan nama relasi terlebih dahulu!', 'Peringatan');
                return;
            }
            const list = document.getElementById('relation-list');
            const existing = list.querySelectorAll('input[name="relations[]"]');
            for (let e of existing) {
                if (e.value === val) {
                    toastr.warning('Relasi "' + val + '" sudah ada!', 'Duplikat');
                    return;
                }
            }
            const chip = document.createElement('div');
            chip.className = 'relation-chip';
            chip.innerHTML = `
                <span>${val}</span>
                <input type="hidden" name="relations[]" value="${val}">
                <span class="remove-btn" onclick="removeRelation(this)"><i class="fas fa-times"></i></span>
            `;
            list.appendChild(chip);
            input.value = '';
            input.focus();
        }

        function removeRelation(element) {
            const chip = element.parentElement;
            chip.remove();
        }

        function removeExistingAttachment(button) {
            const item = button.closest('.attachment-item');
            if (item) item.remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('relation-input');
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addRelation();
                }
            });
        });

        function confirmSubmit() {
            Swal.fire({
                title: 'Kirim ke Admin?',
                text: "Artikel akan direview oleh Admin. Anda tidak bisa mengubahnya sampai disetujui.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EAB308',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-check-circle"></i> Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('submitForm').submit();
                }
            });
        }

        function getCKEditorContent() {
            const editor = document.querySelector('#editor');
            if (editor && editor.ckeditorInstance) {
                return editor.ckeditorInstance.getData();
            }
            return editor ? editor.value : '';
        }

        function setPreview(device) {
            const buttons = document.querySelectorAll('.preview-btn');
            buttons.forEach(btn => btn.classList.remove('active', 'bg-gold', 'text-darkbg', 'border-gold'));
            const activeBtn = Array.from(buttons).find(btn => btn.textContent.toLowerCase().includes(device));
            if(activeBtn) {
                activeBtn.classList.add('active', 'bg-gold', 'text-darkbg', 'border-gold');
            }
        }

        function openPreview() {
            const title = document.querySelector('input[name="title"]').value;
            const content = getCKEditorContent();
            const win = window.open('', '_blank');
            win.document.write(`
                <html><head><title>Preview: ${title}</title>
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
                <script src="https://cdn.tailwindcss.com"><\/script>
                <style>body { font-family: 'Inter', sans-serif; padding: 40px; max-width: 800px; margin: 0 auto; }</style>
                </head><body>
                    <h1 class="text-3xl font-bold mb-6">${title}</h1>
                    <div class="ck-content">${content}</div>
                </body></html>
            `);
            win.document.close();
        }

        /* =========================================================================
           ✅ BARU: AUTO-ISI INFORMASI DASAR & METADATA SEO DARI AI
           (mengisi field yang MASIH KOSONG saja, tidak menimpa input manual user)
           ========================================================================= */
        let categoryTS, subcategoryTS, opdTS, tagsTS;
        let aiAutoFillDone = false;

        function collectPlainContent() {
            const raw = getCKEditorContent();
            return raw.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
        }

        function markAiFilled(el) {
            if (!el) return;
            el.classList.add('ai-filled');
            setTimeout(() => el.classList.remove('ai-filled'), 3500);
        }

        function maybeAutoFillFromAI() {
            if (aiAutoFillDone) return; // sudah pernah auto-isi otomatis, tidak diulang lagi supaya tidak mengganggu saat user masih mengetik
            const plain = collectPlainContent();
            if (plain.length >= 150) {
                autoFillFromAI(true);
            }
        }

        function autoFillFromAI(isAutoTrigger = false) {
            const plainText = collectPlainContent();
            const title = document.getElementById('title-input') ? document.getElementById('title-input').value : '';

            if (plainText.length < 80) {
                if (!isAutoTrigger) {
                    Swal.fire('Info', 'Tulis konten artikel dulu (minimal kurang lebih 80 karakter) supaya AI bisa menganalisa dan mengisi otomatis.', 'info');
                }
                return;
            }

            const btn = document.getElementById('ai-autofill-btn');
            const originalBtnHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menganalisa...';
            }

            fetch("{{ route('admin.article.autofill') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ content: plainText, title: title })
            })
            .then(async res => {
                if (!res.ok) {
                    const t = await res.json().catch(() => ({}));
                    throw new Error(t.error || `Gagal menghubungi AI (status ${res.status})`);
                }
                return res.json();
            })
            .then(json => {
                if (!json.success) throw new Error(json.error || 'AI gagal memproses.');
                applyAutoFillResult(json.data);
                aiAutoFillDone = true;
                toastr.success('Informasi Dasar & Metadata SEO otomatis disarankan oleh AI. Silakan sesuaikan jika perlu.', '✨ AI Autofill');
            })
            .catch(err => {
                if (!isAutoTrigger) {
                    toastr.error(err.message, 'Gagal Auto-Isi');
                }
                console.error('AI Autofill Error:', err);
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnHtml;
                }
            });
        }

        function applyAutoFillResult(data) {
            if (data.category && categoryTS && !categoryTS.getValue()) {
                categoryTS.addOption({ value: data.category, text: data.category });
                categoryTS.setValue(data.category, true);
                markAiFilled(document.getElementById('category-select').nextElementSibling);
            }
            if (data.subcategory && subcategoryTS && !subcategoryTS.getValue()) {
                subcategoryTS.addOption({ value: data.subcategory, text: data.subcategory });
                subcategoryTS.setValue(data.subcategory, true);
                markAiFilled(document.getElementById('subcategory-select').nextElementSibling);
            }
            if (data.opd_unit && opdTS && !opdTS.getValue()) {
                opdTS.addOption({ value: data.opd_unit, text: data.opd_unit });
                opdTS.setValue(data.opd_unit, true);
                markAiFilled(document.getElementById('opd-select').nextElementSibling);
            }
            if (Array.isArray(data.tags) && data.tags.length && tagsTS && tagsTS.getValue().length === 0) {
                data.tags.forEach(tag => {
                    tagsTS.addOption({ value: tag, text: tag });
                    tagsTS.addItem(tag, true);
                });
                markAiFilled(document.getElementById('tags-input').nextElementSibling);
            }

            const metaKeywords = document.querySelector('input[name="meta_keywords"]');
            if (metaKeywords && !metaKeywords.value && data.meta_keywords) {
                metaKeywords.value = data.meta_keywords;
                markAiFilled(metaKeywords);
            }
            const metaDescription = document.querySelector('textarea[name="meta_description"]');
            if (metaDescription && !metaDescription.value && data.meta_description) {
                metaDescription.value = data.meta_description;
                markAiFilled(metaDescription);
            }
            const readTime = document.querySelector('input[name="estimated_read_time"]');
            if (readTime && !readTime.value && data.estimated_read_time) {
                readTime.value = data.estimated_read_time;
                markAiFilled(readTime);
            }
        }

        /* =========================================================================
           ✅ AI ASSISTANT — dibuat lebih menarik & fungsional dengan tombol "Terapkan"
           per-aksi supaya hasil AI langsung mengisi field terkait, bukan cuma teks.
           ========================================================================= */
        const AI_ACTIONS = [
            { action: 'Ringkas Artikel',      label: 'Ringkas',  icon: 'fa-compress',        desc: 'Ringkasan singkat',    theme: 'blue'   },
            { action: 'Generate Keyword',     label: 'Keyword',  icon: 'fa-key',              desc: 'Kata kunci SEO',       theme: 'green'  },
            { action: 'Buat FAQ',             label: 'FAQ',      icon: 'fa-question-circle',  desc: 'Tanya-jawab pembaca',  theme: 'yellow' },
            { action: 'Perbaiki Tata Bahasa', label: 'EYD',      icon: 'fa-spell-check',      desc: 'Perbaiki ejaan',       theme: 'purple' },
            { action: 'Generate Tag',         label: 'Tag',      icon: 'fa-tags',             desc: 'Tag artikel',          theme: 'pink'   },
            { action: 'Buat Deskripsi SEO',   label: 'SEO',      icon: 'fa-search',           desc: 'Meta deskripsi',       theme: 'indigo' },
        ];

        const AI_THEME_CLASSES = {
            blue:   'border-blue-100 bg-blue-50 text-blue-700 hover:bg-blue-500 hover:border-blue-500',
            green:  'border-green-100 bg-green-50 text-green-700 hover:bg-green-500 hover:border-green-500',
            yellow: 'border-yellow-100 bg-yellow-50 text-yellow-700 hover:bg-yellow-500 hover:border-yellow-500',
            purple: 'border-purple-100 bg-purple-50 text-purple-700 hover:bg-purple-500 hover:border-purple-500',
            pink:   'border-pink-100 bg-pink-50 text-pink-700 hover:bg-pink-500 hover:border-pink-500',
            indigo: 'border-indigo-100 bg-indigo-50 text-indigo-700 hover:bg-indigo-500 hover:border-indigo-500',
        };

        const AI_APPLY_LABEL = {
            'Generate Keyword':     'Terapkan ke Keyword SEO',
            'Buat Deskripsi SEO':   'Terapkan ke Meta Deskripsi',
            'Generate Tag':         'Terapkan ke Tags',
            'Perbaiki Tata Bahasa': 'Ganti Isi Artikel',
            'Ringkas Artikel':      'Sisipkan ke Akhir Artikel',
            'Buat FAQ':             'Sisipkan ke Akhir Artikel',
        };

        function openAIAssistant() {
            const rawContent = getCKEditorContent();
            const plainText = rawContent.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();

            if (!plainText || plainText.length < 50) {
                Swal.fire('Peringatan', 'Konten artikel terlalu pendek untuk AI. Minimal 50 karakter teks (tanpa tag HTML).', 'warning');
                return;
            }

            const buttonsHtml = AI_ACTIONS.map(a => `
                <button class="ai-action-btn flex flex-col items-center justify-center gap-1.5 p-3 rounded-xl border-2 transition-all duration-200 hover:text-white hover:shadow-md hover:-translate-y-0.5 ${AI_THEME_CLASSES[a.theme]}" data-action="${a.action}">
                    <i class="fas ${a.icon} text-lg"></i>
                    <span class="text-xs font-bold">${a.label}</span>
                    <span class="text-[10px] opacity-70">${a.desc}</span>
                </button>
            `).join('');

            Swal.fire({
                title: '<i class="fas fa-wand-magic-sparkles text-purple-500"></i> AI Assistant',
                width: 640,
                html: `
                    <div style="text-align: left;">
                        <p class="mb-3 text-sm text-gray-600">Pilih aksi AI untuk konten artikel Anda. Hasilnya bisa langsung diterapkan ke form dengan satu klik.</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            ${buttonsHtml}
                        </div>
                        <div id="ai-result" class="mt-4 p-3 border rounded-lg bg-gray-50 hidden text-sm max-h-56 overflow-y-auto"></div>
                        <div id="ai-apply-wrapper" class="mt-3 hidden"></div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Tutup',
                showConfirmButton: true,
                didOpen: () => {
                    document.querySelectorAll('.ai-action-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            document.querySelectorAll('.ai-action-btn').forEach(b => b.classList.remove('ring-2', 'ring-offset-1'));
                            this.classList.add('ring-2', 'ring-offset-1');
                            const action = this.getAttribute('data-action');
                            runAIAction(action, plainText);
                        });
                    });
                }
            });
        }

        function runAIAction(action, plainText) {
            const resultDiv = document.getElementById('ai-result');
            const applyWrapper = document.getElementById('ai-apply-wrapper');
            resultDiv.classList.remove('hidden');
            applyWrapper.classList.add('hidden');
            applyWrapper.innerHTML = '';
            resultDiv.innerHTML = '<div class="text-center text-gray-500 py-2"><i class="fas fa-spinner fa-spin text-purple-500"></i> AI sedang memproses...</div>';

            fetch("{{ route('admin.article.ai') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ action: action, content: plainText }),
                credentials: 'same-origin'
            })
            .then(async (response) => {
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Server Error ${response.status}: ${errorText.substring(0, 150)}`);
                }
                return response.json();
            })
            .then(data => {
                resultDiv.innerHTML = `<b class="text-gray-700">Hasil ${action}:</b><div class="mt-1 whitespace-pre-line text-gray-600">${data.result}</div>`;
                const applyLabel = AI_APPLY_LABEL[action];
                if (applyLabel) {
                    applyWrapper.classList.remove('hidden');
                    applyWrapper.innerHTML = `<button type="button" id="ai-apply-btn" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2"><i class="fas fa-check"></i> ${applyLabel}</button>`;
                    document.getElementById('ai-apply-btn').addEventListener('click', () => applyAIResult(action, data.result));
                }
            })
            .catch(err => {
                toastr.error(err.message || 'Terjadi kesalahan pada AI Assistant', 'Gagal');
                resultDiv.innerHTML = '<p class="text-red-500">Terjadi kesalahan: ' + err.message + '</p>';
            });
        }

        function applyAIResult(action, resultText) {
            const plain = resultText.replace(/<[^>]*>?/gm, '').trim();
            switch (action) {
                case 'Generate Keyword': {
                    const el = document.querySelector('input[name="meta_keywords"]');
                    if (el) { el.value = plain; markAiFilled(el); }
                    break;
                }
                case 'Buat Deskripsi SEO': {
                    const el = document.querySelector('textarea[name="meta_description"]');
                    if (el) { el.value = plain; markAiFilled(el); }
                    break;
                }
                case 'Generate Tag': {
                    if (tagsTS) {
                        plain.split(',').map(t => t.trim()).filter(Boolean).forEach(tag => {
                            tagsTS.addOption({ value: tag, text: tag });
                            tagsTS.addItem(tag, true);
                        });
                        markAiFilled(document.getElementById('tags-input').nextElementSibling);
                    }
                    break;
                }
                case 'Perbaiki Tata Bahasa': {
                    const editorEl = document.querySelector('#editor');
                    if (editorEl && editorEl.ckeditorInstance) editorEl.ckeditorInstance.setData(resultText);
                    break;
                }
                case 'Ringkas Artikel':
                case 'Buat FAQ': {
                    const editorEl = document.querySelector('#editor');
                    if (editorEl && editorEl.ckeditorInstance) {
                        const current = editorEl.ckeditorInstance.getData();
                        const heading = action === 'Ringkas Artikel' ? '<h3>Ringkasan</h3>' : '<h3>FAQ</h3>';
                        const htmlChunk = plain.split('\n').filter(Boolean).map(line => `<p>${line}</p>`).join('');
                        editorEl.ckeditorInstance.setData(current + heading + htmlChunk);
                    }
                    break;
                }
            }
            toastr.success('Hasil AI berhasil diterapkan ke form!', 'Diterapkan');
            Swal.close();
        }
    </script>
</body>
</html>