<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', goldhover: '#CA8A04', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-20">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="/" class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Portal Publik
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            <a href="/staff/dashboard" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Dashboard
            </a>
            <a href="/staff/articles" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
            </a>
            <a href="/staff/editor" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Tulis Artikel Baru
            </a>

            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="/staff/profile" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Profil Saya
            </a>
        </div>

        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name=ASN+Staf&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Budi ASN</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8 shadow-sm">
            <h1 class="font-bold text-gray-800 text-lg">Pengaturan Akun</h1>
        </header>

        <div class="flex-1 overflow-y-auto p-8 flex justify-center">
            <div class="bg-white border border-cardborder rounded-xl shadow-sm w-full max-w-2xl p-8 h-fit">
                <div class="flex items-center gap-6 mb-8 border-b border-gray-100 pb-8">
                    <img src="https://ui-avatars.com/api/?name=ASN+Staf&background=eab308&color=0f172a" class="w-20 h-20 rounded-full border-2 border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Budi ASN</h2>
                        <p class="text-sm text-gray-500 mb-2">Kontributor Diskominfo</p>
                        <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-3 py-1.5 rounded transition">Ubah Foto Profil</button>
                    </div>
                </div>

                <form class="space-y-5">
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                            <input type="text" value="Budi ASN" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NIP</label>
                            <input type="text" value="198012012005011002" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Email</label>
                        <input type="email" value="budi.s@lampungprov.go.id" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kata Sandi Baru (Opsional)</label>
                        <input type="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-gold outline-none focus:ring-1 focus:ring-gold transition">
                    </div>
                    <div class="pt-4 text-right">
                        <button type="button" class="bg-darkbg hover:bg-gray-800 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>