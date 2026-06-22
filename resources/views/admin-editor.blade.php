<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Artikel Admin - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', goldhover: '#CA8A04', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- SIDEBAR ADMIN -->
    <aside class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-20">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-red-400 font-bold uppercase tracking-widest">Super Admin</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Core System</p>
            <a href="/admin/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Utama
            </a>
            
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Manajemen</p>
            <!-- ACTIVE MENU: Menandakan bahwa Admin sedang berada dalam flow "Verifikasi & Artikel" -->
            <a href="/admin/articles" class="flex items-center justify-between bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Verifikasi & Artikel
                </div>
                <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">3</span>
            </a>
            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Pengguna & Role
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Keamanan & Ekspor</p>
            <a href="/admin/reports" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Laporan & Audit Trail
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

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8">
        
        <!-- Header dengan Tombol Back ke Manajemen Artikel -->
        <div class="flex items-center gap-4 mb-6 border-b border-gray-200 pb-4">
            <a href="/admin/articles" class="text-gray-400 hover:text-gray-800 transition-colors p-2 rounded-full hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="flex-1 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">Tulis Dokumen Internal / Publik</h2>
                <div class="flex gap-3">
                    <button class="border border-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg text-sm bg-white hover:bg-gray-50 transition-colors">Simpan Draf</button>
                    <!-- Sebagai Admin, tidak perlu 'Ajukan Verifikasi', langsung Terbitkan (Publish) -->
                    <button class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg text-sm hover:bg-red-700 shadow-md transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terbitkan (Bypass)
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Ruang Editor Utama -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Artikel</label>
                    <input type="text" placeholder="Masukkan judul yang jelas dan deskriptif..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg font-medium focus:border-red-500 outline-none focus:ring-1 focus:ring-red-500 transition">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Isi Konten (Rich Text)</label>
                    <div class="border border-gray-300 rounded-lg bg-white overflow-hidden flex flex-col h-[500px]">
                        <!-- Placeholder Toolbar WYSIWYG -->
                        <div class="bg-gray-50 border-b border-gray-200 p-2 flex gap-2 text-gray-600">
                            <button class="p-1 hover:bg-gray-200 rounded font-bold transition">B</button>
                            <button class="p-1 hover:bg-gray-200 rounded italic transition">I</button>
                            <button class="p-1 hover:bg-gray-200 rounded underline transition">U</button>
                            <span class="w-px h-6 bg-gray-300 mx-1"></span>
                            <button class="p-1 hover:bg-gray-200 rounded text-sm px-2 transition">Link</button>
                            <button class="p-1 hover:bg-gray-200 rounded text-sm px-2 transition">Image</button>
                            <button class="p-1 hover:bg-gray-200 rounded text-sm px-2 transition">Code Block</button>
                        </div>
                        <textarea class="flex-1 w-full p-4 outline-none resize-none" placeholder="Mulai menulis konten di sini..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Panel Pengaturan Sidebar Kanan -->
            <div class="space-y-6">
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Pengaturan Visibilitas</h3>
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="radio" name="visibility" checked class="mt-1 accent-red-600">
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Publik (Semua Orang)</span>
                                <span class="text-xs text-gray-500">Bisa diakses siapa saja di portal depan tanpa login.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="radio" name="visibility" class="mt-1 accent-red-600">
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Publik Terbatas</span>
                                <span class="text-xs text-gray-500">Hanya bisa diakses oleh user yang memiliki akun/login.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="radio" name="visibility" class="mt-1 accent-red-600">
                            <div>
                                <span class="block text-sm font-bold text-gray-800">Privat (Internal Saja)</span>
                                <span class="text-xs text-gray-500">Hanya untuk kalangan internal instansi / admin.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Kategori & Metadata</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Pilih Kategori Utama</label>
                            <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-red-500">
                                <option>SOP (Standar Operasional)</option>
                                <option>Pedoman TI</option>
                                <option>Keamanan Siber</option>
                                <option>Infrastruktur & Jaringan</option>
                                <option>Kebijakan Pemerintah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Tags / Kata Kunci</label>
                            <input type="text" placeholder="Pisahkan dengan koma (cth: ssl, nginx, bug)" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-red-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>