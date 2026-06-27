<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artikel - SIGER-Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', goldhover: '#CA8A04', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }</script>
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

    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8 relative">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Verifikasi & Manajemen Dokumen</h2>
                <p class="text-sm text-gray-500">Tinjau pengajuan dari staf, publikasi, atau hapus konten.</p>
            </div>
            <a href="/admin/editor" class="bg-darkbg text-white font-bold py-2.5 px-5 rounded-lg text-sm hover:bg-gray-800 shadow-md transition">Tulis Dokumen Internal</a>
        </div>

        <div class="flex gap-6 border-b border-gray-200 mb-6 text-sm font-medium">
            <button onclick="switchTab('pending')" id="tab-btn-pending" class="border-b-2 border-gold text-gray-900 pb-3 outline-none transition-colors">Menunggu Verifikasi (2)</button>
            <button onclick="switchTab('published')" id="tab-btn-published" class="text-gray-500 hover:text-gray-900 pb-3 outline-none transition-colors">Sudah Rilis (1)</button>
            <button onclick="switchTab('rejected')" id="tab-btn-rejected" class="text-gray-500 hover:text-gray-900 pb-3 outline-none transition-colors">Ditolak / Revisi (1)</button>
        </div>

        <div id="tab-pending" class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden block">
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
                            <p class="text-xs text-gray-500 mt-1">Kategori: Pedoman TI</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">Budi ASN</td>
                        <td class="px-6 py-4"><span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded text-[10px] font-bold">Publik Terbatas</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openApproveModal('Panduan Audit Jaringan Tahap 2')" class="bg-green-100 text-green-700 hover:bg-green-200 font-bold text-xs px-3 py-1.5 rounded mr-2 transition">Approve</button>
                            <button onclick="openRejectModal('Panduan Audit Jaringan Tahap 2')" class="bg-red-100 text-red-700 hover:bg-red-200 font-bold text-xs px-3 py-1.5 rounded mr-4 transition">Reject</button>
                            <button onclick="openReviewModal('Panduan Audit Jaringan Tahap 2')" class="text-blue-600 hover:underline text-xs border-l border-gray-300 pl-4 font-medium outline-none">Edit/Review</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">Struktur Jaringan Intranet BKD</p>
                            <p class="text-xs text-gray-500 mt-1">Kategori: Infrastruktur</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">Andi IT</td>
                        <td class="px-6 py-4"><span class="bg-red-100 text-red-700 px-2.5 py-1 rounded text-[10px] font-bold">Privat</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openApproveModal('Struktur Jaringan Intranet BKD')" class="bg-green-100 text-green-700 hover:bg-green-200 font-bold text-xs px-3 py-1.5 rounded mr-2 transition">Approve</button>
                            <button onclick="openRejectModal('Struktur Jaringan Intranet BKD')" class="bg-red-100 text-red-700 hover:bg-red-200 font-bold text-xs px-3 py-1.5 rounded mr-4 transition">Reject</button>
                            <button onclick="openReviewModal('Struktur Jaringan Intranet BKD')" class="text-blue-600 hover:underline text-xs border-l border-gray-300 pl-4 font-medium outline-none">Edit/Review</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="tab-published" class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Visibilitas</th>
                        <th class="px-6 py-4">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">SOP Penanganan Insiden Keamanan Siber</p>
                            <p class="text-xs text-gray-500 mt-1">Kategori: Keamanan Siber</p>
                        </td>
                        <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2.5 py-1 rounded text-[10px] font-bold">Publik</span></td>
                        <td class="px-6 py-4 text-gray-600">20 Jun 2026</td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openReviewModal('SOP Penanganan Insiden Keamanan Siber')" class="text-blue-600 hover:underline mr-4 text-xs font-medium">Edit</button>
                            <button class="text-red-500 hover:underline text-xs font-medium">Turunkan (Take Down)</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="tab-rejected" class="bg-white border border-cardborder rounded-xl shadow-sm overflow-hidden hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-[11px] uppercase text-gray-500 font-bold border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4">Judul Dokumen</th>
                        <th class="px-6 py-4">Author (Staf)</th>
                        <th class="px-6 py-4">Alasan Penolakan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-900">Draf Aturan Cuti Pegawai</p>
                            <p class="text-xs text-gray-500 mt-1">Kategori: Kebijakan</p>
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">Siti HRD</td>
                        <td class="px-6 py-4 text-xs text-red-600 italic">"Gunakan format PDF yang sudah ditandatangani basah."</td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openReviewModal('Draf Aturan Cuti Pegawai')" class="text-blue-600 hover:underline text-xs font-medium">Lihat Detail</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modalApprove" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center" id="modalApproveContent">
            <div class="p-6 pt-8">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-2">Setujui Dokumen?</h3>
                <p class="text-sm text-gray-500 mb-2">Anda akan mempublikasikan: <br><span id="approve-title" class="font-bold text-gray-700"></span></p>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-center gap-3">
                <button onclick="closeModal('modalApprove')" class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalApprove')" class="w-1/2 px-4 py-2.5 text-sm font-bold bg-green-600 text-white hover:bg-green-700 rounded-lg transition-colors focus:outline-none shadow-md">Ya, Approve</button>
            </div>
        </div>
    </div>

    <div id="modalReject" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="modalRejectContent">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-gray-900 text-lg">Tolak / Kembalikan Dokumen</h3>
                <button onclick="closeModal('modalReject')" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-4">Dokumen: <span id="reject-title" class="font-bold text-gray-700"></span></p>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Alasan Penolakan / Catatan Revisi</label>
                <textarea rows="4" placeholder="Misal: Harap perbaiki bagian referensi undang-undang..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 resize-none"></textarea>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button onclick="closeModal('modalReject')" class="px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors focus:outline-none">Batal</button>
                <button onclick="closeModal('modalReject')" class="px-6 py-2.5 text-sm font-bold bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors focus:outline-none shadow-md">Kirim Penolakan</button>
            </div>
        </div>
    </div>

    <div id="modalReview" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity opacity-0 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-full flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="modalReviewContent">
            
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50 shrink-0">
                <h3 class="font-bold text-gray-900 text-lg flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Review Dokumen Internal
                </h3>
                <button onclick="closeModal('modalReview')" class="text-gray-400 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1 flex flex-col md:flex-row gap-6 bg-gray-50/30">
                
                <div class="w-full md:w-1/3 space-y-4">
                    <div class="bg-white p-4 border border-gray-200 rounded-xl shadow-sm">
                        <h4 class="font-bold text-xs text-gray-500 uppercase mb-3">Informasi Metadata</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Judul Dokumen</label>
                                <input type="text" id="review-title" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Visibilitas</label>
                                <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none focus:border-blue-500">
                                    <option>Publik (Semua)</option>
                                    <option>Publik Terbatas</option>
                                    <option>Privat (Internal)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                                <select class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none focus:border-blue-500">
                                    <option>Pedoman TI</option>
                                    <option>SOP (Standar Operasional)</option>
                                    <option>Infrastruktur</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-2/3 bg-white border border-gray-200 rounded-xl shadow-sm p-6 overflow-y-auto">
                    <div class="border-b border-gray-100 pb-4 mb-4">
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded">PREVIEW KONTEN</span>
                        <h1 id="review-title-display" class="text-2xl font-bold text-gray-900 mt-2 mb-2">Judul Dokumen</h1>
                        <p class="text-xs text-gray-500">Oleh: <span class="font-bold text-gray-700">Staf Penulis</span> | Dibuat: Hari ini</p>
                    </div>
                    <div class="prose prose-sm text-gray-700">
                        <p>Ini adalah pratinjau konten dokumen yang dikirimkan oleh staf. Admin dapat membaca seluruh isi dokumen di panel ini sebelum melakukan persetujuan (Approve) atau penolakan (Reject).</p>
                        <br>
                        <p><strong>Bab 1. Pendahuluan</strong><br>Sistem pemerintahan berbasis elektronik memerlukan pedoman yang jelas terkait audit jaringan...</p>
                        <br>
                        <div class="bg-gray-100 p-4 rounded text-xs font-mono text-gray-600 border border-gray-200">
                            # Contoh Log / Kode<br>
                            ping 192.168.1.1<br>
                            Status: OK
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-gray-200 bg-white flex justify-between items-center shrink-0">
                <a href="/admin/editor" class="text-sm font-medium text-blue-600 hover:underline">Buka di Editor Penuh</a>
                <div class="flex gap-3">
                    <button onclick="closeModal('modalReview')" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors border border-gray-300">Batal / Tutup</button>
                    <button onclick="closeModal('modalReview')" class="px-5 py-2 text-sm font-bold bg-darkbg text-white hover:bg-gray-800 rounded-lg transition-colors shadow-md">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- LOGIC TABS ---
        function switchTab(tabName) {
            // Semua Tabs Container
            const tabs = ['pending', 'published', 'rejected'];
            // Reset Semua Tab Content & Button Styles
            tabs.forEach(t => {
                // Sembunyikan konten
                document.getElementById('tab-' + t).classList.add('hidden');
                document.getElementById('tab-' + t).classList.remove('block');
                
                // Reset Button style ke abu-abu
                const btn = document.getElementById('tab-btn-' + t);
                btn.classList.remove('border-b-2', 'border-gold', 'text-gray-900');
                btn.classList.add('text-gray-500');
            });

            // Aktifkan Tab yang dipilih
            document.getElementById('tab-' + tabName).classList.remove('hidden');
            document.getElementById('tab-' + tabName).classList.add('block');
            
            const activeBtn = document.getElementById('tab-btn-' + tabName);
            activeBtn.classList.remove('text-gray-500');
            activeBtn.classList.add('border-b-2', 'border-gold', 'text-gray-900');
        }

        // --- LOGIC MODALS ---
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

        // --- SPECIFIC MODAL TRIGGERS ---
        function openApproveModal(title) {
            document.getElementById('approve-title').innerText = title;
            openModal('modalApprove');
        }

        function openRejectModal(title) {
            document.getElementById('reject-title').innerText = title;
            openModal('modalReject');
        }

        function openReviewModal(title) {
            document.getElementById('review-title').value = title;
            document.getElementById('review-title-display').innerText = title;
            openModal('modalReview');
        }
    </script>
</body>
</html>