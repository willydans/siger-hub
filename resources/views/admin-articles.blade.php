<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Artikel - SIGER-Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- SIDEBAR ADMIN KONSISTEN -->
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
            <!-- ACTIVE MENU -->
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

    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Verifikasi & Manajemen Dokumen</h2>
                <p class="text-sm text-gray-500">Tinjau pengajuan dari staf, publikasi, atau hapus konten.</p>
            </div>
            <!-- Perhatikan perubahan href menjadi /admin/editor -->
<a href="/admin/editor" class="bg-darkbg text-white font-bold py-2.5 px-5 rounded-lg text-sm hover:bg-gray-800 shadow-md">Tulis Dokumen Internal</a>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-6 border-b border-gray-200 mb-6 text-sm font-medium">
            <a href="#" class="border-b-2 border-gold text-gray-900 pb-3">Menunggu Verifikasi (3)</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 pb-3">Sudah Rilis</a>
            <a href="#" class="text-gray-500 hover:text-gray-900 pb-3">Ditolak / Revisi</a>
        </div>

        <div class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Author (Staf)</th>
                        <th class="px-6 py-4">Visibilitas Req.</th>
                        <th class="px-6 py-4 text-right">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">Panduan Audit Jaringan Tahap 2</p>
                            <p class="text-xs text-gray-500">Kategori: Pedoman TI</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">Budi ASN</td>
                        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded text-[10px] font-bold">Publik Terbatas</span></td>
                        <td class="px-6 py-4 text-right">
                            <button class="bg-green-100 text-green-700 hover:bg-green-200 font-bold text-xs px-3 py-1.5 rounded mr-2">Approve</button>
                            <button class="bg-red-100 text-red-700 hover:bg-red-200 font-bold text-xs px-3 py-1.5 rounded mr-4">Reject</button>
                            <button class="text-blue-600 hover:underline text-xs border-l border-gray-300 pl-4">Edit/Review</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">Struktur Jaringan Intranet BKD</p>
                            <p class="text-xs text-gray-500">Kategori: Infrastruktur</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">Andi IT</td>
                        <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2.5 py-1 rounded text-[10px] font-bold">Privat</span></td>
                        <td class="px-6 py-4 text-right">
                            <button class="bg-green-100 text-green-700 hover:bg-green-200 font-bold text-xs px-3 py-1.5 rounded mr-2">Approve</button>
                            <button class="bg-red-100 text-red-700 hover:bg-red-200 font-bold text-xs px-3 py-1.5 rounded mr-4">Reject</button>
                            <button class="text-blue-600 hover:underline text-xs border-l border-gray-300 pl-4">Edit/Review</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>