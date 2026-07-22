<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisi Artikel - SIGER-Hub</title>
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
        .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.08); }

        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }

        #revision-modal { transition: opacity 0.3s ease, visibility 0.3s ease; }
        #modal-box { transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease; }

        #toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }
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
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
           <!-- Tombol Portal Publik -->
<a href="{{ route('portal') }}" target="_blank" 
   class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm hover:scale-[1.02] duration-200"
   title="Buka portal publik di tab baru">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    Portal Publik
</a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            
            <a href="/staff/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            
            <a href="/staff/articles" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            
            <a href="/staff/draft" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Draft
            </a>
            
            <a href="{{ route('staff.revision') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Revision
            </a>
            
            <a href="/staff/notification" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg> Notification
            </a>
            
            <a href="/staff/editor" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="/staff/profile" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() { showToast('{{ session('success') }}'); });
        </script>
        @endif

        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Revisi Artikel</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Revisi Artikel</h1>
                <p class="text-sm text-gray-500 mt-1">Berisi revisi yang diberikan dari admin terhadap artikel yang disubmit.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($revisions as $revision)
            @php
                // ✅ TAMBAHAN: decode sekali di sini supaya bisa dipakai untuk
                // badge Prioritas & Deadline langsung di kartu, tanpa perlu
                // buka modal dulu.
                $notesData = json_decode($revision->revision_notes, true) ?: [];
                $firstNote = $notesData['note'] ?? 'Tidak ada catatan spesifik.';
                $priority  = $notesData['priority'] ?? 'Sedang';
                $deadline  = $notesData['deadline'] ?? '7 Hari';
                $priorityColor = match($priority) {
                    'Tinggi' => 'bg-red-100 text-red-700',
                    'Rendah' => 'bg-green-100 text-green-700',
                    default  => 'bg-yellow-100 text-yellow-700',
                };
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 flex flex-col hover-lift fade-in-up delay-2">
                <div class="flex justify-between items-start mb-2 gap-2">
                    <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $revision->title }}</h3>
                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap">Revision</span>
                </div>

                <!-- ✅ TAMBAHAN: badge Prioritas & Deadline langsung terlihat di kartu -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="{{ $priorityColor }} text-[10px] font-bold px-2 py-0.5 rounded-full">Prioritas: {{ $priority }}</span>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Deadline: {{ $deadline }}</span>
                </div>
                
                <div class="space-y-2 flex-1 mb-4">
                    <div class="flex justify-between text-xs text-gray-500 border-b border-gray-100 pb-1">
                        <span>Tanggal</span>
                        <span class="font-medium text-gray-700">{{ $revision->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 border-b border-gray-100 pb-1">
                        <span>Admin</span>
                        <span class="font-medium text-gray-700">{{ optional($revision->reviewedBy)->name ?? 'Admin' }}</span>
                    </div>
                    <div class="pt-2">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            <span class="font-semibold text-gray-700 block mb-1 text-xs">Catatan:</span>
                            {{ Str::limit($firstNote, 80) }}
                        </p>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                    <button onclick="openModal({{ $revision->id }})" class="flex-1 p-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition-colors flex items-center justify-center gap-1 text-xs font-medium border border-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Lihat Detail
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="text-lg font-medium">Tidak ada revisi saat ini.</p>
                <p class="text-sm">Semua artikel Anda sudah diterima atau masih dalam proses.</p>
            </div>
            @endforelse
        </div>
    </main>

    <div id="revision-modal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center opacity-0 visibility-hidden">
        <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 opacity-0">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">Catatan Revisi</h3>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <span id="modal-title" class="text-base font-bold text-gray-900">Loading...</span>
                    <span class="text-[10px] bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold">Revision</span>
                </div>

                <div id="modal-notes-container" class="space-y-4">
                    <!-- Akan diisi oleh Javascript -->
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-gray-400 w-full sm:w-auto text-center sm:text-left mb-2 sm:mb-0">Aksi:</p>
                <div class="flex flex-wrap justify-end gap-2 w-full sm:w-auto">
                    <a id="btn-editor" href="#" class="flex-1 sm:flex-none border border-blue-500 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-1 min-w-[110px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Open Editor
                    </a>
                    <a id="btn-perbaiki" href="#" class="flex-1 sm:flex-none bg-gold text-darkbg hover:bg-goldhover px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-1 min-w-[110px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Perbaiki
                    </a>
                    <form id="btn-submit" action="" method="POST" class="flex-1 sm:flex-none min-w-[110px]">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-darkbg text-white hover:bg-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Submit Again
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

        const modal = document.getElementById('revision-modal');
        const modalBox = document.getElementById('modal-box');

        function openModal(id) {
            fetch(`/staff/revision/${id}/details`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-title').innerText = data.title;
                    
                    let notesHtml = '';
                    if (data.notes && typeof data.notes === 'object' && Object.keys(data.notes).length > 0) {
                        // 1. Detail Revisi (Dropdowns)
                        notesHtml += `
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-3">
                                <h4 class="font-bold text-sm text-blue-800 mb-2 flex items-center gap-2">📋 Detail Permintaan Revisi</h4>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-700">
                                    <div><span class="font-semibold text-gray-500">Judul:</span> ${data.notes.title_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Isi:</span> ${data.notes.content_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Lampiran:</span> ${data.notes.attachments_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Kategori:</span> ${data.notes.category_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Tag:</span> ${data.notes.tags_revision || '-'}</div>
                                    <div><span class="font-semibold text-gray-500">Thumbnail:</span> ${data.notes.thumbnail_revision || '-'}</div>
                                    <div class="col-span-2"><span class="font-semibold text-gray-500">Lainnya:</span> ${data.notes.others_revision || '-'}</div>
                                </div>
                            </div>
                        `;

                        // 2. Prioritas & Deadline
                        const priorityClass = data.notes.priority === 'Tinggi' ? 'text-red-600' : (data.notes.priority === 'Sedang' ? 'text-yellow-600' : 'text-green-600');
                        notesHtml += `
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-3 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-xs text-yellow-800">Prioritas</h4>
                                    <p class="text-sm font-bold ${priorityClass}">${data.notes.priority || 'Sedang'}</p>
                                </div>
                                <div class="text-right">
                                    <h4 class="font-bold text-xs text-yellow-800">Deadline</h4>
                                    <p class="text-sm font-bold text-blue-600">${data.notes.deadline || '7 Hari'}</p>
                                </div>
                            </div>
                        `;

                        // 3. Catatan Admin
                        if (data.notes.note) {
                            notesHtml += `
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-bold text-sm flex items-center gap-2">📝 Catatan dari Admin</h4>
                                    <p class="text-sm mt-1 text-gray-700">${data.notes.note}</p>
                                </div>
                            `;
                        }
                    } else {
                        notesHtml = `<p class="text-sm text-gray-500 text-center py-2">Tidak ada catatan revisi spesifik.</p>`;
                    }
                    document.getElementById('modal-notes-container').innerHTML = notesHtml;

                    const editorUrl = `/staff/editor/${data.id}`;
                    document.getElementById('btn-editor').href = editorUrl;
                    document.getElementById('btn-perbaiki').href = editorUrl;
                    document.getElementById('btn-submit').action = `/staff/revision/${data.id}/submit`;

                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0', 'visibility-hidden');
                        modal.classList.add('opacity-100', 'visibility-visible');
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
            modal.classList.remove('opacity-100', 'visibility-visible');
            modal.classList.add('opacity-0', 'visibility-hidden');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }
    </script>
</body>
</html>