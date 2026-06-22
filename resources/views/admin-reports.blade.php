<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Audit - SIGER-Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }</script>
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
            <a href="/admin/articles" class="flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Verifikasi & Artikel
                </div>
                <span class="bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">3</span>
            </a>
            <a href="/admin/users" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Pengguna & Role
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Keamanan & Ekspor</p>
            <!-- ACTIVE MENU: Laporan & Audit Trail -->
            <a href="/admin/reports" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Laporan & Audit Trail
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Audit Trail & Laporan</h2>
                <p class="text-sm text-gray-500">Log keamanan sistem dan ekspor laporan kinerja KMS.</p>
            </div>
            <button class="bg-darkbg hover:bg-gray-800 text-white font-bold py-2.5 px-5 rounded-lg text-sm shadow-md flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Ekspor Log (PDF)
            </button>
        </div>

        <div class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-sm">Security Log (7 Hari Terakhir)</h3>
                <input type="date" class="text-xs border border-gray-300 rounded px-2 py-1.5 outline-none cursor-pointer">
            </div>
            <table class="w-full text-left text-sm">
                <thead class="text-[10px] uppercase text-gray-400 font-bold border-b border-gray-200 bg-white">
                    <tr>
                        <th class="px-6 py-4">Waktu Kejadian</th>
                        <th class="px-6 py-4">Aktor (Pengguna)</th>
                        <th class="px-6 py-4">Modul</th>
                        <th class="px-6 py-4">Aktivitas Sistem</th>
                        <th class="px-6 py-4">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-mono text-xs">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">22 Jun 2026 14:02:11</td>
                        <td class="px-6 py-4 font-bold text-red-600">Admin Utama</td>
                        <td class="px-6 py-4">Dokumen</td>
                        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded">APPROVED</span> SOP_Keamanan.pdf</td>
                        <td class="px-6 py-4 text-gray-400">192.168.1.12</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">22 Jun 2026 13:45:00</td>
                        <td class="px-6 py-4 font-bold text-blue-600">Budi ASN</td>
                        <td class="px-6 py-4">Editor</td>
                        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">UPDATED</span> Draf_Tutorial.html</td>
                        <td class="px-6 py-4 text-gray-400">10.0.5.55</td>
                    </tr>
                    <tr class="hover:bg-gray-50 bg-red-50/30">
                        <td class="px-6 py-4 text-gray-500">22 Jun 2026 02:11:43</td>
                        <td class="px-6 py-4 font-bold text-gray-600">Unknown / Guest</td>
                        <td class="px-6 py-4">Auth</td>
                        <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded">FAILED_LOGIN</span> Attempt (5x) admin@...</td>
                        <td class="px-6 py-4 text-red-500 font-bold">114.122.x.x</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">21 Jun 2026 09:00:12</td>
                        <td class="px-6 py-4 font-bold text-red-600">Admin Utama</td>
                        <td class="px-6 py-4">Manajemen Akun</td>
                        <td class="px-6 py-4"><span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded">ROLE_CHANGE</span> Budi ASN -> Staff</td>
                        <td class="px-6 py-4 text-gray-400">192.168.1.12</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>