<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel - SIGER-Hub</title>
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
        /* Sidebar Mobile Overlay */
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        
        /* Artikel Content Styling (WYSIWYG) */
        .article-content h1 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; color: #111827; }
        .article-content h2 { font-size: 1.25rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.75rem; color: #1f2937; }
        .article-content h3 { font-size: 1.125rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; color: #374151; }
        .article-content p { margin-bottom: 1rem; line-height: 1.8; color: #374151; }
        .article-content ul, .article-content ol { margin-left: 1.5rem; margin-bottom: 1rem; }
        .article-content li { margin-bottom: 0.5rem; }
        .article-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1.5rem 0; }
        .article-content blockquote { border-left: 4px solid #EAB308; padding-left: 1rem; font-style: italic; color: #4b5563; margin: 1.5rem 0; }
    </style>
</head>
<body class="font-sans antialiased bg-lightbg flex h-screen overflow-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="{{ route('home.public') }}" class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm hover:scale-[1.02] duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Portal Publik
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard</a>
            <a href="{{ route('staff.articles') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700"><svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya</a>
            <a href="{{ route('staff.draft') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft</a>
            <a href="{{ route('staff.revision') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision</a>
            <a href="{{ route('staff.notification') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification</a>
            <a href="{{ route('staff.editor') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru</a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="{{ route('staff.profile') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya</a>
        </div>
        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col"><span class="text-sm font-bold text-white">{{ auth()->user()->name }}</span><span class="text-[10px] text-gray-400">Kontributor</span></div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-50 p-6 md:p-8 w-full">
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Detail Artikel</h2>
        </div>

        <!-- Breadcrumb & Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <a href="{{ route('staff.articles') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Artikel
                </a>
                <h2 class="text-2xl font-bold text-gray-900 mt-2">Detail Artikel</h2>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('staff.editor.edit', $article->id) }}" class="bg-gold text-darkbg font-bold py-2 px-4 rounded-lg text-sm hover:bg-goldhover shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105">Edit di Editor</a>
            </div>
        </div>

        <!-- Article Detail Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-8 fade-in">
            
            <div class="border-b border-gray-200 pb-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $article->title }}</h1>
                <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        {{ $article->category ?? '-' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMMM YYYY') }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($article->views) }}x dilihat
                    </span>
                    <span class="flex items-center gap-1 text-yellow-500">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        {{ number_format($article->rating, 1) }}
                    </span>
                    @php
                        $statusColor = [
                            'published' => 'bg-green-100 text-green-700',
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'draft' => 'bg-gray-100 text-gray-600',
                            'archived' => 'bg-gray-200 text-gray-500'
                        ];
                    @endphp
                    <span class="{{ $statusColor[$article->status] ?? 'bg-gray-100 text-gray-600' }} px-3 py-1 rounded-full text-[11px] font-bold ml-auto">{{ ucfirst($article->status) }}</span>
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="article-content text-gray-800">
                {!! $article->content !!}
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <a href="{{ route('staff.editor.edit', $article->id) }}" class="inline-flex items-center gap-2 text-sm font-medium text-gold hover:text-goldhover transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Artikel Ini
                </a>
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
    </script>
</body>
</html>