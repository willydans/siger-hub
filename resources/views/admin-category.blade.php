<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - AKSARA</title>
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
        .modal-overlay { transition: opacity 0.3s ease-out; }
        .modal-content { transition: transform 0.3s ease-out, opacity 0.3s ease-out; }
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
            <a href="/admin/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Dashboard
            </a>
            
            <div>
                <button type="button" onclick="toggleSubmenu('submenu-knowledge')" class="w-full flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Knowledge Management
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" id="arrow-knowledge" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="submenu-knowledge" class="submenu hidden pl-9 space-y-1 mt-1">
                    @php
                        // Menghitung jumlah artikel yang berstatus 'pending' langsung dari database
                        $pendingCount = \App\Models\Article::where('status', 'pending')->count();
                    @endphp

                    <a href="{{ route('admin.all-articles') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors {{ request()->routeIs('admin.all-articles') ? 'text-white' : '' }}">• All Articles</a>
                    
                    <a href="{{ route('admin.pending-approval') }}" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between {{ request()->routeIs('admin.pending-approval') ? 'text-white' : '' }}">
                        • Pending Approval 
                        
                        {{-- Badge merah HANYA akan muncul jika ada artikel pending (> 0) --}}
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

            <a href="/admin/category" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
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
                <img src="https://ui-avatars.com/api/?name=Admin+Utama&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Admin Diskominfo</span>
                    <span class="text-[10px] text-gray-400">Super Admin</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Category Management</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in-up">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <ul class="list-disc ml-5 mt-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 fade-in-up">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in-up">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Category</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola kategori konten utama dan subkategori di dalam sistem.</p>
            </div>
            <button onclick="openModal('createModal')" class="w-full md:w-auto bg-darkbg text-white hover:bg-gray-800 font-bold py-2 px-6 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                + Tambah Kategori Baru
            </button>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 min-w-[180px]">Category</th>
                            <th class="px-4 py-4 min-w-[300px]">Subcategories</th>
                            <th class="px-4 py-4 text-center min-w-[120px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $badgeColors = [
                                'bg-blue-100 text-blue-700', 'bg-purple-100 text-purple-700',
                                'bg-green-100 text-green-700', 'bg-yellow-100 text-yellow-700',
                                'bg-red-100 text-red-700', 'bg-indigo-100 text-indigo-700'
                            ];
                        @endphp

                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                                <td class="px-4 py-4 font-bold text-gray-900">{{ $category->name }}</td>
                                <td class="px-4 py-4 flex flex-wrap items-center gap-2">
                                    @if($category->subcategories->count() > 0)
                                        @foreach($category->subcategories as $index => $sub)
                                            @php $colorClass = $badgeColors[$index % count($badgeColors)]; @endphp
                                            <span class="{{ $colorClass }} px-2.5 py-1 rounded-full text-[10px] font-medium">
                                                {{ $sub->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500 italic text-xs">Belum ada subkategori</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <button onclick="openModal('editModal-{{ $category->id }}')" class="text-blue-600 hover:text-blue-800 hover:underline text-xs font-medium transition-colors">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 hover:underline text-xs font-medium transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500 italic">Belum ada data kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
                <div class="p-4 border-t border-gray-200">{{ $categories->links() }}</div>
            @endif
        </div>
    </main>

    <div id="createModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
        <div class="fixed inset-0 bg-black/50 modal-overlay opacity-0" onclick="closeModal('createModal')"></div>
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 z-50 modal-content scale-95 opacity-0 flex flex-col max-h-[90vh]">
            
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            
            <form action="{{ route('admin.category.store') }}" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                <div class="p-5 overflow-y-auto">
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori Induk</label>
                        <input type="text" name="name" required placeholder="Contoh: IT, Keuangan, SDM" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>

                    <div class="mb-2 flex justify-between items-end">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Subkategori</label>
                            <span class="text-[10px] text-gray-500">Minimal wajib 2 subkategori</span>
                        </div>
                        <button type="button" onclick="addSubcategoryRow('subcats-container-create')" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md font-medium transition-colors">
                            + Tambah Sub
                        </button>
                    </div>

                    <div id="subcats-container-create" class="space-y-2 subcats-wrapper">
                        <div class="flex items-center gap-2 subcat-row">
                            <input type="text" name="subcategories[]" required placeholder="Subkategori 1..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold outline-none">
                            <button type="button" onclick="removeSubcategoryRow(this)" class="text-red-400 hover:text-red-600 p-2 btn-remove-sub" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                        <div class="flex items-center gap-2 subcat-row">
                            <input type="text" name="subcategories[]" required placeholder="Subkategori 2..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold outline-none">
                            <button type="button" onclick="removeSubcategoryRow(this)" class="text-red-400 hover:text-red-600 p-2 btn-remove-sub" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-xl">
                    <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-bold text-darkbg bg-gold rounded-lg hover:bg-yellow-500 transition-colors shadow-sm">Simpan Kategori</button>
                </div>
            </form>

        </div>
    </div>
    @foreach($categories as $category)
        <div id="editModal-{{ $category->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center">
            <div class="fixed inset-0 bg-black/50 modal-overlay opacity-0" onclick="closeModal('editModal-{{ $category->id }}')"></div>
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-4 z-50 modal-content scale-95 opacity-0 flex flex-col max-h-[90vh]">
                
                <div class="flex justify-between items-center p-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900">Edit Kategori</h3>
                    <button type="button" onclick="closeModal('editModal-{{ $category->id }}')" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="flex flex-col overflow-hidden">
                    @csrf @method('PUT')
                    <div class="p-5 overflow-y-auto">
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori Induk</label>
                            <input type="text" name="name" value="{{ $category->name }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                        </div>

                        <div class="mb-2 flex justify-between items-end">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Subkategori</label>
                                <span class="text-[10px] text-gray-500">Minimal wajib 2 subkategori</span>
                            </div>
                            <button type="button" onclick="addSubcategoryRow('subcats-container-edit-{{ $category->id }}')" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md font-medium transition-colors">
                                + Tambah Sub
                            </button>
                        </div>

                        <div id="subcats-container-edit-{{ $category->id }}" class="space-y-2 subcats-wrapper">
                            @php 
                                $subs = $category->subcategories; 
                                $count = max(2, $subs->count());
                            @endphp

                            @for($i = 0; $i < $count; $i++)
                                <div class="flex items-center gap-2 subcat-row">
                                    <input type="text" name="subcategories[]" value="{{ isset($subs[$i]) ? $subs[$i]->name : '' }}" required placeholder="Nama Subkategori..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold outline-none">
                                    <button type="button" onclick="removeSubcategoryRow(this)" class="text-red-400 hover:text-red-600 p-2 btn-remove-sub" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="p-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50 rounded-b-xl">
                        <button type="button" onclick="closeModal('editModal-{{ $category->id }}')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-bold text-darkbg bg-gold rounded-lg hover:bg-yellow-500 transition-colors shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    @endforeach

    <script>
        // --- Sidebar Mobile ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
            } else {
                overlay.classList.add('opacity-0'); overlay.classList.remove('opacity-100');
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

        // --- Logic Subkategori Dinamis (Minimal 2) ---
        function addSubcategoryRow(containerId) {
            const container = document.getElementById(containerId);
            if(!container) return; // Pengaman tambahan

            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 subcat-row mt-2';
            row.innerHTML = `
                <input type="text" name="subcategories[]" required placeholder="Subkategori Baru..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-gold outline-none">
                <button type="button" onclick="removeSubcategoryRow(this)" class="text-red-400 hover:text-red-600 p-2 btn-remove-sub" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
            `;
            
            container.appendChild(row);

            // Fokus ke input yang baru dibuat
            const inputBaru = row.querySelector('input');
            if (inputBaru) inputBaru.focus();
            
            // Auto scroll modal ke bagian bawah
            const modalBody = container.closest('.overflow-y-auto');
            if (modalBody) modalBody.scrollTop = modalBody.scrollHeight;

            checkRemoveButtonsState(containerId);
        }

        function removeSubcategoryRow(btnElement) {
            const container = btnElement.closest('.subcats-wrapper');
            if (container.querySelectorAll('.subcat-row').length > 2) {
                btnElement.closest('.subcat-row').remove();
            }
            checkRemoveButtonsState(container.id);
        }

        function checkRemoveButtonsState(containerId) {
            const container = document.getElementById(containerId);
            if(!container) return;
            
            const rows = container.querySelectorAll('.subcat-row');
            const btns = container.querySelectorAll('.btn-remove-sub');
            
            // Mematikan fungsional tombol hapus secara paksa jika sisa 2
            if (rows.length <= 2) {
                btns.forEach(btn => {
                    btn.classList.add('opacity-30', 'cursor-not-allowed');
                    btn.classList.remove('hover:text-red-600');
                    btn.disabled = true; // Tombol di-disable 100%
                });
            } else {
                btns.forEach(btn => {
                    btn.classList.remove('opacity-30', 'cursor-not-allowed');
                    btn.classList.add('hover:text-red-600');
                    btn.disabled = false; // Tombol di-enable
                });
            }
        }

        // --- Logic Modals Animasi Tailwind ---
        function openModal(id) {
            const modal = document.getElementById(id);
            if(!modal) return;
            
            const overlay = modal.querySelector('.modal-overlay');
            const content = modal.querySelector('.modal-content');
            
            modal.classList.remove('hidden');
            
            // Cek kondisi tombol saat modal terbuka
            const containerId = modal.querySelector('.subcats-wrapper').id;
            checkRemoveButtonsState(containerId);

            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if(!modal) return;
            
            const overlay = modal.querySelector('.modal-overlay');
            const content = modal.querySelector('.modal-content');
            
            overlay.classList.add('opacity-0');
            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
</body>
</html>