<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Articles - SIGER-Hub</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Sidebar Mobile */
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        .submenu { transition: all 0.3s ease-in-out; overflow: hidden; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- Flash Message Toast -->
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastr = document.createElement('div');
            toastr.className = "fixed top-5 right-5 z-[9999] bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-lg transform translate-x-[120%] animate-[slideInRight_0.4s_ease-out_forwards]";
            toastr.innerHTML = `
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-gray-800">${'{{ session('success') }}'}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 ml-4">✕</button>
                </div>
            `;
            document.body.appendChild(toastr);
            setTimeout(() => {
                toastr.style.transform = 'translateX(120%)';
                toastr.style.transition = 'transform 0.3s ease-in';
                setTimeout(() => toastr.remove(), 300);
            }, 3500);
        });
    </script>
    @endif

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <!-- SIDEBAR (Sidebar Staf / Penulis) -->
    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0 sidebar-scroll">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="{{ route('home.public') }}" target="_blank" class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm hover:scale-[1.02] duration-200">
                <i class="fas fa-external-link-alt w-4 h-4"></i> Lihat Portal Publik
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-th-large w-5 h-5"></i> Analitik Dashboard
            </a>
            <a href="{{ route('staff.articles') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-file-alt w-5 h-5"></i> Artikel Saya
            </a>
            <a href="{{ route('staff.draft') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <i class="fas fa-pen-square w-5 h-5"></i> Draft
            </a>
            <a href="{{ route('staff.revision') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-history w-5 h-5"></i> Revision
            </a>
            <a href="{{ route('staff.notification') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-bell w-5 h-5"></i> Notification
            </a>
            <a href="{{ route('staff.editor') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-pen-fancy w-5 h-5 text-gold"></i> Tulis Artikel Baru
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="{{ route('staff.profile') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-user w-5 h-5"></i> Profil Saya
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Staff') }}&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Staff' }}</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT (Draft Page) -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars w-6 h-6"></i>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Draft</h2>
        </div>

        <!-- Header Section -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 fade-in-up" style="animation-delay: 0.1s;">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Draft</h1>
                <p class="text-sm text-gray-500 mt-1">Berisi artikel yang belum dikirim.</p>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <a href="{{ route('staff.draft') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center justify-center gap-1">
                    <i class="fas fa-sync-alt w-3 h-3"></i>
                    Refresh
                </a>
            </div>
        </div>

        <!-- Draft Cards Grid -->
        @if($drafts->isEmpty())
            <div class="text-center py-20 bg-white border border-gray-200 rounded-xl shadow-sm">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800">Belum ada Draft</h3>
                <p class="text-sm text-gray-500 mt-1">Mulai buat artikel baru dari menu Tulis Artikel Baru.</p>
                <a href="{{ route('staff.editor') }}" class="inline-block mt-4 bg-darkbg text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition">Buat Artikel Baru</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($drafts as $draft)
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col hover-lift fade-in-up" style="animation-delay: 0.2s;">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">{{ $draft->title }}</h3>
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap mt-1">Draft</span>
                        </div>
                        
                        <div class="space-y-3 flex-1 mt-2">
                            <p class="text-xs text-gray-400">Terakhir diedit: {{ $draft->updated_at->diffForHumans() }}</p>
                            
                            <!-- Progress Bar -->
                            @php $progress = $draft->progress ?? 0; @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                <div class="bg-gold h-2 rounded-full" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-500">
                                <span>Progress {{ $progress }}%</span>
                                <span class="flex items-center gap-1"><i class="fas fa-check-circle text-green-500"></i> Auto Save</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                            <!-- Edit (Redirect ke Editor) -->
                            <a href="{{ route('staff.editor.edit', $draft->id) }}" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                                <i class="fas fa-edit w-3 h-3"></i>
                                Edit
                            </a>
                            
                            <!-- Preview -->
                            <a href="{{ route('staff.draft.preview', $draft->id) }}" target="_blank" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                                <i class="fas fa-eye w-3 h-3"></i>
                                Preview
                            </a>
                            
                            <!-- Delete -->
                            <form action="{{ route('staff.draft.destroy', $draft->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft ini?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                                    <i class="fas fa-trash w-3 h-3"></i>
                                    Delete
                                </button>
                            </form>
                            
                            <!-- Submit -->
                            <form action="{{ route('staff.draft.submit', $draft->id) }}" method="POST" onsubmit="return confirm('Kirim draft ini ke Admin untuk review?')" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-gold hover:bg-goldhover text-darkbg text-xs font-bold py-2 px-3 rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1">
                                    <i class="fas fa-check-circle w-3 h-3"></i>
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

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

        // CSS untuk animasi slideInRight
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