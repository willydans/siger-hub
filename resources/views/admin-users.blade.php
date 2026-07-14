<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - AKSARA</title>
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
        .modal-overlay { background: rgba(0,0,0,0.5); }
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

            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
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
            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Settings
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
            <h2 class="text-xl font-bold text-gray-900">User Management</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">User Management</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola pengguna, reset password, dan pantau aktivitas login.</p>
            </div>
            <button onclick="openUserModal()" class="w-full md:w-auto bg-darkbg text-white hover:bg-gray-800 font-bold py-2 px-6 rounded-lg text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                + Tambah Pengguna Baru
            </button>
        </div>

        <!-- Table User Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm fade-in-up" style="animation-delay: 0.3s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[1200px]">
                    <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-4 py-4 w-10"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></th>
                            <th class="px-4 py-4 min-w-[160px]">Nama</th>
                            <th class="px-4 py-4 min-w-[140px]">NIP</th>
                            <th class="px-4 py-4 min-w-[180px]">Email</th>
                            <th class="px-4 py-4 min-w-[120px]">Jabatan</th>
                            <th class="px-4 py-4 min-w-[120px]">Bidang</th>
                            <th class="px-4 py-4 min-w-[120px]">Role</th>
                            <th class="px-4 py-4 min-w-[100px]">Status</th>
                            <th class="px-4 py-4 min-w-[140px]">Login Terakhir</th>
                            <th class="px-4 py-4 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-4 py-4"><input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-gold focus:ring-gold cursor-pointer"></td>
                            <td class="px-4 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->nip ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->jabatan ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->bidang ?? '-' }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $roleColors = [
                                        'super_admin' => 'bg-red-100 text-red-700',
                                        'admin' => 'bg-purple-100 text-purple-700',
                                        'reviewer' => 'bg-yellow-100 text-yellow-700',
                                        'staff' => 'bg-blue-100 text-blue-700',
                                        'user' => 'bg-gray-100 text-gray-700',
                                    ];
                                    $roleColor = $roleColors[$user->role->name ?? 'user'] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="{{ $roleColor }} px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    {{ $user->role ? $user->role->label ?? ucfirst($user->role->name) : 'User' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="{{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}</td>
                            <td class="px-4 py-4 text-center relative">
                                <div class="relative inline-block">
                                    <button onclick="toggleDropdown(this)" class="text-gray-400 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                    </button>
                                    <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-20 origin-top-right scale-95 opacity-0">
                                        <div class="py-1">
                                            <button onclick="resetPassword({{ $user->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-yellow-600 hover:bg-yellow-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Reset Password
                                            </button>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <button onclick="toggleUserStatus({{ $user->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs {{ $user->status === 'active' ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }} transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $user->status === 'active' ? '10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                                                {{ $user->status === 'active' ? 'Disable' : 'Enable' }}
                                            </button>
                                            <button onclick="openUserEditModal({{ $user->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-blue-600 hover:bg-blue-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit
                                            </button>
                                            @if($user->id !== auth()->id())
                                            <button onclick="deleteUser({{ $user->id }})" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ROLE & PERMISSION MANAGEMENT SECTION -->
        <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm p-6 fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 border-b border-gray-100 pb-4 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Manajemen Role & Permission</h2>
                    <p class="text-xs text-gray-500 mt-1">Kelola akses dan hak istimewa untuk setiap level pengguna.</p>
                </div>
                <button onclick="openRoleModal()" class="bg-darkbg text-white hover:bg-gray-800 py-2 px-4 rounded-lg text-xs font-bold transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105">
                    + Tambah Role Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs min-w-[1000px]">
                    <thead class="bg-gray-50 text-[10px] uppercase text-gray-500 font-bold border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 min-w-[120px]">Role</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Create</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Read</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Update</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Delete</th>
                            <th class="px-4 py-3 text-center min-w-[70px]">Approve</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Export</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Backup</th>
                            <th class="px-4 py-3 text-center min-w-[70px]">Restore</th>
                            <th class="px-4 py-3 text-center min-w-[70px]">Analytics</th>
                            <th class="px-4 py-3 text-center min-w-[60px]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($roles as $role)
                        @php
                            $perms = $role->permissions->pluck('name')->toArray();
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                            <td class="px-4 py-3 font-bold text-gray-900">{{ $role->label ?? $role->name }}</td>
                            
                            <!-- Create -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'create')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('create', $perms))
                                        <svg id="icon-create-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-create-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Read -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'read')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('read', $perms))
                                        <svg id="icon-read-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-read-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Update -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'update')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('update', $perms))
                                        <svg id="icon-update-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-update-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Delete -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'delete')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('delete', $perms))
                                        <svg id="icon-delete-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-delete-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Approve -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'approve')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('approve', $perms))
                                        <svg id="icon-approve-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-approve-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Export -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'export')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('export', $perms))
                                        <svg id="icon-export-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-export-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Backup -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'backup')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('backup', $perms))
                                        <svg id="icon-backup-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-backup-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Restore -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'restore')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('restore', $perms))
                                        <svg id="icon-restore-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-restore-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Analytics -->
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="togglePermission({{ $role->id }}, 'analytics')" class="focus:outline-none hover:opacity-70 transition-opacity">
                                    @if(in_array('analytics', $perms))
                                        <svg id="icon-analytics-{{ $role->id }}" class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg id="icon-analytics-{{ $role->id }}" class="w-5 h-5 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    @endif
                                </button>
                            </td>

                            <!-- Action -->
                            <td class="px-4 py-3 text-center">
                                <button onclick="openRoleEditModal({{ $role->id }})" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1 rounded text-[10px] font-medium transition-colors">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODALS -->
    <!-- User Modal -->
    <div id="userModal" class="fixed inset-0 z-50 hidden modal-overlay flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6 relative animate-fade-in-up">
            <h2 id="userModalTitle" class="text-xl font-bold text-gray-900 mb-4">Tambah Pengguna Baru</h2>
            <form id="userForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="userMethod" value="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="userNameInput" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="userEmailInput" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" id="userNipInput" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="userPasswordInput" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none" {{ isset($user) ? '' : 'required' }}>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" id="userJabatanInput" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bidang</label>
                        <input type="text" name="bidang" id="userBidangInput" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role_id" id="userRoleInput" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->label ?? $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal('userModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-darkbg text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Role Modal -->
    <div id="roleModal" class="fixed inset-0 z-50 hidden modal-overlay flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-6 relative animate-fade-in-up">
            <h2 id="roleModalTitle" class="text-xl font-bold text-gray-900 mb-4">Tambah Role Baru</h2>
            <form id="roleForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="roleMethod" value="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Role</label>
                    <input type="text" name="name" id="roleNameInput" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Label (Opsional)</label>
                    <input type="text" name="label" id="roleLabelInput" class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none">
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeModal('roleModal')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-darkbg text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">Simpan</button>
                </div>
            </form>
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
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-95', 'opacity-0');
                    menu.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 100);
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('.dropdown-menu').forEach(m => {
                    m.classList.remove('scale-100', 'opacity-100');
                    m.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        m.classList.add('hidden');
                    }, 100);
                });
            }
        });

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // --- User Modal ---
        function openUserModal() {
            document.getElementById('userModalTitle').innerText = 'Tambah Pengguna Baru';
            document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
            document.getElementById('userMethod').value = 'POST';
            document.getElementById('userNameInput').value = '';
            document.getElementById('userEmailInput').value = '';
            document.getElementById('userNipInput').value = '';
            document.getElementById('userPasswordInput').value = '';
            document.getElementById('userPasswordInput').required = true;
            document.getElementById('userJabatanInput').value = '';
            document.getElementById('userBidangInput').value = '';
            document.getElementById('userRoleInput').value = '';
            document.getElementById('userModal').classList.remove('hidden');
        }

        function openUserEditModal(id) {
            fetch(`/admin/users/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('userModalTitle').innerText = 'Edit Pengguna';
                    document.getElementById('userForm').action = `/admin/users/${id}`;
                    document.getElementById('userMethod').value = 'PUT';
                    document.getElementById('userNameInput').value = data.name;
                    document.getElementById('userEmailInput').value = data.email;
                    document.getElementById('userNipInput').value = data.nip || '';
                    document.getElementById('userPasswordInput').value = '';
                    document.getElementById('userPasswordInput').required = false;
                    document.getElementById('userJabatanInput').value = data.jabatan || '';
                    document.getElementById('userBidangInput').value = data.bidang || '';
                    document.getElementById('userRoleInput').value = data.role_id || '';
                    document.getElementById('userModal').classList.remove('hidden');
                });
        }

        // --- Role Modal ---
        function openRoleModal() {
            document.getElementById('roleModalTitle').innerText = 'Tambah Role Baru';
            document.getElementById('roleForm').action = "{{ route('admin.roles.store') }}";
            document.getElementById('roleMethod').value = 'POST';
            document.getElementById('roleNameInput').value = '';
            document.getElementById('roleLabelInput').value = '';
            document.getElementById('roleModal').classList.remove('hidden');
        }

        function openRoleEditModal(id) {
            fetch(`/admin/roles/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('roleModalTitle').innerText = 'Edit Role';
                    document.getElementById('roleForm').action = `/admin/roles/${id}`;
                    document.getElementById('roleMethod').value = 'PUT';
                    document.getElementById('roleNameInput').value = data.name;
                    document.getElementById('roleLabelInput').value = data.label || '';
                    document.getElementById('roleModal').classList.remove('hidden');
                });
        }

        // --- User Actions (AJAX) ---
        function toggleUserStatus(id) {
            if(!confirm('Ubah status pengguna ini?')) return;
            fetch(`/admin/users/${id}/toggle-status`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showToast('Status pengguna berhasil diubah menjadi ' + data.status);
                    location.reload();
                }
            });
        }

        function resetPassword(id) {
            if(!confirm('Reset password pengguna ini? Password baru akan dihasilkan secara acak.')) return;
            fetch(`/admin/users/${id}/reset-password`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showToast('Password berhasil direset. Password baru: ' + data.new_password);
                }
            });
        }

        function deleteUser(id) {
            if(!confirm('Hapus pengguna ini?')) return;
            fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => {
                if(response.ok) {
                    showToast('Pengguna berhasil dihapus.');
                    location.reload();
                }
            });
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

        // --- Fitur Toggle Permission ---
        function togglePermission(roleId, permName) {
            const iconElement = document.getElementById(`icon-${permName}-${roleId}`);
            const originalHtml = iconElement.innerHTML;
            
            // Loading state
            iconElement.innerHTML = `<div class="w-5 h-5 border-2 border-t-transparent border-gray-400 rounded-full animate-spin mx-auto"></div>`;

            fetch('/admin/permissions/toggle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    role_id: roleId,
                    permission_name: permName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const isActive = data.active;
                    const colorClass = isActive ? 'text-green-600' : 'text-gray-300';
                    let pathSVG = isActive 
                        ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>`
                        : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>`;
                    
                    iconElement.innerHTML = `
                        <svg class="w-5 h-5 ${colorClass} mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">${pathSVG}</svg>
                    `;
                    showToast('Hak akses berhasil diperbarui!', 'success');
                } else {
                    iconElement.innerHTML = originalHtml;
                    showToast('Gagal memperbarui hak akses.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                iconElement.innerHTML = originalHtml;
                showToast('Terjadi kesalahan server.', 'error');
            });
        }
    </script>
</body>
</html>