<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - SIGER-Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">

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
            <a href="/admin/users" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Pengguna & Role
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
                <h2 class="text-2xl font-bold text-gray-900">Manajemen Pengguna & Role</h2>
                <p class="text-sm text-gray-500">Atur hak akses, status, dan data pengguna sistem.</p>
            </div>
            <button onclick="openModal('modalAddUser')" class="bg-gold hover:bg-yellow-500 text-darkbg font-bold py-2.5 px-5 rounded-lg text-sm shadow-md transition-colors flex items-center gap-2 outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Staf Baru
            </button>
        </div>

        <div class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Role Hak Akses</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">Admin Utama</p>
                            <p class="text-xs text-gray-500">admin@lampungprov.go.id</p>
                        </td>
                        <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2.5 py-1 rounded text-[10px] font-bold">Admin</span></td>
                        <td class="px-6 py-4"><span class="text-green-600 font-bold text-xs">Aktif</span></td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-gray-400 text-xs italic">Akses Sistem Inti</span>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900" id="name-budi">Budi ASN</p>
                            <p class="text-xs text-gray-500" id="email-budi">budi@lampungprov.go.id</p>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="confirmRoleChange(this, 'Budi ASN')" class="border border-gray-300 rounded px-2 py-1 text-xs font-bold bg-blue-50 text-blue-700 outline-none cursor-pointer focus:ring-1 focus:ring-blue-400 transition-shadow">
                                <option value="Staff" selected>Staff</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </td>
                        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded text-[10px] font-bold">Aktif</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openStatusModal('Budi ASN', 'suspend')" class="text-orange-500 hover:text-orange-700 font-medium text-xs mr-3 outline-none transition-colors">Suspend</button>
                            <button onclick="openEditModal('budi')" class="text-blue-600 hover:underline font-medium text-xs mr-3 outline-none transition-colors">Edit Detail</button>
                            <button onclick="openDeleteModal('Budi ASN')" class="text-red-500 hover:text-red-700 font-medium text-xs outline-none transition-colors">Hapus</button>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900" id="name-agus">Agus Masyarakat</p>
                            <p class="text-xs text-gray-500" id="email-agus">agus@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="confirmRoleChange(this, 'Agus Masyarakat')" class="border border-gray-300 rounded px-2 py-1 text-xs font-bold bg-gray-100 text-gray-700 outline-none cursor-pointer focus:ring-1 focus:ring-gray-400 transition-shadow">
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                                <option value="User" selected>User</option>
                            </select>
                        </td>
                        <td class="px-6 py-4"><span class="bg-gray-100 text-gray-600 border border-gray-200 px-2.5 py-1 rounded text-[10px] font-bold">Tidak Aktif</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openStatusModal('Agus Masyarakat', 'aktifkan')" class="text-green-600 hover:text-green-700 font-medium text-xs mr-3 outline-none transition-colors">Aktifkan</button>
                            <button onclick="openEditModal('agus')" class="text-blue-600 hover:underline font-medium text-xs mr-3 outline-none transition-colors">Edit Detail</button>
                            <button onclick="openDeleteModal('Agus Masyarakat')" class="text-red-500 hover:text-red-700 font-medium text-xs outline-none transition-colors">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modalAddUser" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="modalAddUserContent">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Tambah Pengguna Baru</h3>
                <button onclick="closeModal('modalAddUser')" class="text-gray-400 hover:text-gray-700 focus:outline-none"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Alamat Email</label>
                    <input type="email" placeholder="email@domain.com" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Role Pengguna</label>
                    <select class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                        <option>Staff</option>
                        <option>User</option>
                        <option>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Password Sementara</label>
                    <input type="password" placeholder="Minimal 8 karakter..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeModal('modalAddUser')" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalAddUser')" class="px-5 py-2 text-sm font-bold bg-gold text-darkbg hover:bg-goldhover rounded-lg transition-colors focus:outline-none shadow-md">Simpan Akun</button>
            </div>
        </div>
    </div>

    <div id="modalEditUser" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="modalEditUserContent">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Edit Data Pengguna</h3>
                <button onclick="closeModal('modalEditUser')" class="text-gray-400 hover:text-gray-700 focus:outline-none"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama Lengkap</label>
                    <input type="text" id="edit-name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Alamat Email</label>
                    <input type="email" id="edit-email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Reset Password (Opsional)</label>
                    <input type="password" placeholder="Kosongkan jika tidak diubah" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-blue-500 outline-none transition">
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeModal('modalEditUser')" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalEditUser')" class="px-5 py-2 text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 rounded-lg transition-colors focus:outline-none shadow-md">Update Data</button>
            </div>
        </div>
    </div>

    <div id="modalStatus" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="modalStatusContent">
            <div class="p-6 pt-8">
                <div id="status-icon-bg" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-orange-100">
                    <svg id="status-icon" class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2" id="status-title">Ubah Status Akun?</h3>
                <p class="text-sm text-gray-500 mb-2">Anda yakin ingin <span id="status-action-text" class="font-bold">melakukan aksi ini</span> pada akun <span id="status-user-name" class="font-bold text-gray-700"></span>?</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="closeModal('modalStatus')" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalStatus')" id="status-confirm-btn" class="w-1/2 px-4 py-2.5 text-sm font-bold text-white rounded-lg transition-colors focus:outline-none shadow-md">Ya, Ubah</button>
            </div>
        </div>
    </div>

    <div id="modalDelete" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="modalDeleteContent">
            <div class="p-6 pt-8">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2">Hapus Pengguna?</h3>
                <p class="text-sm text-gray-500 mb-2">Anda yakin ingin menghapus permanen akun <span id="delete-user-name" class="font-bold text-gray-700"></span>?</p>
                <p class="text-[11px] text-red-500 bg-red-50 p-2 rounded-lg border border-red-100 inline-block mt-2">Semua data terkait pengguna ini akan hilang.</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="closeModal('modalDelete')" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalDelete')" class="w-1/2 px-4 py-2.5 text-sm font-bold bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors focus:outline-none shadow-md">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div id="modalRole" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="modalRoleContent">
            <div class="p-6 pt-8">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2">Konfirmasi Hak Akses</h3>
                <p class="text-sm text-gray-500 mb-2">Ubah role <span id="role-user-name" class="font-bold text-gray-700"></span> menjadi <span id="role-new-name" class="font-bold text-blue-600"></span>?</p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="cancelRoleChange()" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalRole')" class="w-1/2 px-4 py-2.5 text-sm font-bold bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors focus:outline-none shadow-md">Konfirmasi</button>
            </div>
        </div>
    </div>


    <script>
        // FUNGSI UMUM BUKA/TUTUP MODAL
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(modalId + 'Content');
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // --- FUNGSI EDIT DETAIL ---
        function openEditModal(userId) {
            // Ambil data dari tabel berdasarkan ID yang di-passing (contoh frontend)
            const name = document.getElementById('name-' + userId).innerText;
            const email = document.getElementById('email-' + userId).innerText;

            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            
            openModal('modalEditUser');
        }

        // --- FUNGSI SUSPEND / AKTIFKAN ---
        function openStatusModal(userName, action) {
            document.getElementById('status-user-name').innerText = userName;
            
            const titleEl = document.getElementById('status-title');
            const actionTextEl = document.getElementById('status-action-text');
            const iconBg = document.getElementById('status-icon-bg');
            const icon = document.getElementById('status-icon');
            const confirmBtn = document.getElementById('status-confirm-btn');

            if (action === 'suspend') {
                titleEl.innerText = "Suspend Akun?";
                actionTextEl.innerText = "menangguhkan (suspend)";
                actionTextEl.className = "font-bold text-orange-600";
                
                // Styling warna Orange
                iconBg.className = "w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-orange-100";
                icon.className = "w-8 h-8 text-orange-600";
                confirmBtn.className = "w-1/2 px-4 py-2.5 text-sm font-bold text-white rounded-lg transition-colors focus:outline-none shadow-md bg-orange-500 hover:bg-orange-600";
            } else {
                titleEl.innerText = "Aktifkan Akun?";
                actionTextEl.innerText = "mengaktifkan kembali";
                actionTextEl.className = "font-bold text-green-600";
                
                // Styling warna Hijau
                iconBg.className = "w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100";
                icon.className = "w-8 h-8 text-green-600";
                confirmBtn.className = "w-1/2 px-4 py-2.5 text-sm font-bold text-white rounded-lg transition-colors focus:outline-none shadow-md bg-green-600 hover:bg-green-700";
            }

            openModal('modalStatus');
        }

        // --- FUNGSI HAPUS AKUN ---
        function openDeleteModal(userName) {
            document.getElementById('delete-user-name').innerText = userName;
            openModal('modalDelete');
        }

        // --- FUNGSI UBAH ROLE DROPDOWN ---
        let currentSelectElement = null;
        let previousRoleValue = null;

        // Menyimpan nilai original dropdown saat di-klik sebelum diganti
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('focus', function() {
                this.dataset.prev = this.value;
            });
        });

        function confirmRoleChange(selectElement, userName) {
            currentSelectElement = selectElement;
            previousRoleValue = selectElement.dataset.prev || 'Staff'; // fallback
            
            const newRole = selectElement.value;
            
            document.getElementById('role-user-name').innerText = userName;
            document.getElementById('role-new-name').innerText = newRole;
            
            openModal('modalRole');
        }

        function cancelRoleChange() {
            // Revert dropdown ke value sebelumnya jika dibatalkan
            if (currentSelectElement) {
                currentSelectElement.value = previousRoleValue;
            }
            closeModal('modalRole');
        }
    </script>
</body>
</html>