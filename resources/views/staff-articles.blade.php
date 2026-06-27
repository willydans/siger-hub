<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artikel - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', goldhover: '#CA8A04', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

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
            <a href="/staff/articles" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Artikel Saya
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
                <img src="https://ui-avatars.com/api/?name=ASN+Staf&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Budi ASN</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <a href="/login" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8 relative">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manajemen Artikel Saya</h2>
                <p class="text-sm text-gray-500">Edit, hapus, dan pantau status publikasi artikel.</p>
            </div>
            <a href="/staff/editor" class="bg-darkbg text-white font-bold py-2.5 px-5 rounded-lg text-sm hover:bg-gray-800 shadow-md transition-colors">Tulis Baru</a>
        </div>

        <div class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Judul Artikel / SOP</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Visibilitas</th>
                        <th class="px-6 py-4">Status Admin</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">SOP Penanganan Insiden Siber</td>
                        <td class="px-6 py-4 text-gray-600">Keamanan</td>
                        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded text-[10px] font-bold">Publik (Semua)</span></td>
                        <td class="px-6 py-4"><span class="text-green-600 font-medium text-xs flex items-center gap-1">✅ Terbit</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openEditModal('SOP Penanganan Insiden Siber', 'Keamanan', 'publik')" class="text-blue-600 hover:underline mr-3 text-xs font-medium focus:outline-none">Edit</button>
                            <button onclick="openDeleteModal('SOP Penanganan Insiden Siber')" class="text-red-500 hover:underline text-xs font-medium focus:outline-none">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Struktur Jaringan Intranet BKD</td>
                        <td class="px-6 py-4 text-gray-600">Infrastruktur</td>
                        <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2.5 py-1 rounded text-[10px] font-bold">Privat (Internal)</span></td>
                        <td class="px-6 py-4"><span class="text-blue-600 font-medium text-xs flex items-center gap-1">⏳ Menunggu Verifikasi</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openEditModal('Struktur Jaringan Intranet BKD', 'Infrastruktur', 'privat')" class="text-blue-600 hover:underline mr-3 text-xs font-medium focus:outline-none">Edit</button>
                            <button onclick="openDeleteModal('Struktur Jaringan Intranet BKD')" class="text-red-500 hover:underline text-xs font-medium focus:outline-none">Hapus</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">Draf Panduan Aplikasi SIAKADU</td>
                        <td class="px-6 py-4 text-gray-600">Tutorial Aplikasi</td>
                        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded text-[10px] font-bold">Publik Terbatas (Login)</span></td>
                        <td class="px-6 py-4"><span class="text-gray-500 font-medium text-xs flex items-center gap-1">📝 Draf (Belum Diajukan)</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openEditModal('Draf Panduan Aplikasi SIAKADU', 'Tutorial Aplikasi', 'terbatas')" class="text-blue-600 hover:underline mr-3 text-xs font-medium focus:outline-none">Edit</button>
                            <button onclick="openDeleteModal('Draf Panduan Aplikasi SIAKADU')" class="text-red-500 hover:underline text-xs font-medium focus:outline-none">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300" id="editModalContent">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Edit Cepat Artikel</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Judul Dokumen</label>
                    <input type="text" id="edit-title" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none focus:ring-1 focus:ring-blue-500 transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Kategori</label>
                        <select id="edit-category" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none transition">
                            <option value="Keamanan">Keamanan</option>
                            <option value="Infrastruktur">Infrastruktur</option>
                            <option value="Tutorial Aplikasi">Tutorial Aplikasi</option>
                            <option value="SOP Umum">SOP Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Visibilitas</label>
                        <select id="edit-visibility" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:border-blue-500 outline-none transition">
                            <option value="publik">Publik (Semua)</option>
                            <option value="terbatas">Publik Terbatas</option>
                            <option value="privat">Privat (Internal)</option>
                        </select>
                    </div>
                </div>
                <div class="pt-2">
                    <a href="/staff/editor" class="text-xs text-blue-600 hover:underline flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka di Editor Lengkap (Teks & Isi)
                    </a>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeEditModal()" class="px-5 py-2 text-sm font-bold bg-gold text-darkbg hover:bg-goldhover rounded-lg transition-colors focus:outline-none shadow-md">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="deleteModalContent">
            <div class="p-6 pt-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2">Hapus Artikel?</h3>
                <p class="text-sm text-gray-500 mb-2">Anda yakin ingin menghapus <span id="delete-title-display" class="font-bold text-gray-700">Dokumen</span>?</p>
                <p class="text-xs text-red-500 bg-red-50 p-2 rounded-lg border border-red-100 inline-block">Tindakan ini permanen dan tidak bisa dibatalkan.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeDeleteModal()" class="w-1/2 px-4 py-2.5 text-sm font-bold bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors focus:outline-none shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        // --- Logic Modal Edit ---
        const editModal = document.getElementById('editModal');
        const editModalContent = document.getElementById('editModalContent');

        function openEditModal(title, category, visibility) {
            // Isi data ke dalam form modal
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-visibility').value = visibility;

            // Tampilkan Modal dengan animasi
            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                editModalContent.classList.remove('scale-95');
            }, 10);
        }

        function closeEditModal() {
            // Sembunyikan Modal dengan animasi
            editModal.classList.add('opacity-0');
            editModalContent.classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300); // Sesuai dengan duration-300 di class
        }

        // --- Logic Modal Delete ---
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');

        function openDeleteModal(title) {
            // Masukkan nama dokumen ke dalam teks konfirmasi
            document.getElementById('delete-title-display').innerText = '"' + title + '"';

            // Tampilkan Modal dengan animasi
            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModal.classList.remove('opacity-0');
                deleteModalContent.classList.remove('scale-95');
            }, 10);
        }

        function closeDeleteModal() {
            // Sembunyikan Modal dengan animasi
            deleteModal.classList.add('opacity-0');
            deleteModalContent.classList.add('scale-95');
            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>
</html>