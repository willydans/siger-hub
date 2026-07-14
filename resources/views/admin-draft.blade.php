<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Articles - AKSARA (Dinamis)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        darkbg: '#0F172A', 
                        gold: '#EAB308', 
                        goldhover: '#D9A406',
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
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        .sidebar-scroll { scrollbar-width: thin; }
        
        /* Modal Transitions */
        #draft-modal { transition: opacity 0.3s ease, visibility 0.3s ease; visibility: hidden; opacity: 0; }
        #draft-modal.active { visibility: visible; opacity: 1; }
        .modal-box { transform: scale(0.95); transition: transform 0.3s ease; }
        #draft-modal.active .modal-box { transform: scale(1); }
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
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
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
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• All Articles</a>
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors flex items-center justify-between">• Pending Approval <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">23</span></a>
                    <a href="#" class="block text-white font-medium bg-gray-800/30 rounded px-2 py-1.5 text-[13px] transition-colors">• Draft</a>
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Revision</a>
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Published</a>
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Archived</a>
                    <a href="#" class="block text-gray-400 hover:text-white text-[13px] py-1.5 transition-colors">• Deleted</a>
                </div>
            </div>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> User Management
            </a>
            <a href="#" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Category
            </a>
            <!-- Menu lainnya disembunyikan agar fokus ke Draft Page -->
        </div>
        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name=Admin+Utama&background=ef4444&color=ffffff" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">Admin Diskominfo</span>
                    <span class="text-[10px] text-gray-400">Super Admin</span>
                </div>
            </div>
            <a href="#" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition">Keluar</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        
        <!-- Mobile Toggle Sidebar -->
        <div class="flex justify-between items-center mb-6 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
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
                <!-- Tombol CREATE -->
                <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center justify-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Draft
                </button>
                <!-- Tombol REFRESH -->
                <button onclick="loadDrafts()" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-xs font-medium transition-colors flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Draft Cards Grid (Dinamis) -->
        <div id="draft-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kartu akan digenerate oleh JavaScript -->
        </div>
    </main>

    <!-- MODAL CRUD (CREATE / UPDATE) -->
    <div id="draft-modal" class="fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center p-4">
        <div class="modal-box bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden transition-all">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 id="modal-title" class="text-xl font-bold text-gray-900">Buat Draft Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" id="input-title" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none" placeholder="Masukkan judul draft...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Progress Pengerjaan</label>
                    <div class="flex items-center gap-4">
                        <input type="range" id="input-progress" min="0" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                        <span id="progress-percent" class="text-xs font-bold text-gray-600 w-8">0%</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Draft (Preview)</label>
                    <textarea id="input-content" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none" placeholder="Isi artikel..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-2 p-6 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                <button onclick="closeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">Batal</button>
                <button onclick="saveDraftData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">Simpan Draft</button>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // 1. STATE & DATA PERSISTENCE
        let editingId = null;
        const STORAGE_KEY = 'aksara_drafts_data';

        function getDefaultData() {
            return [
                { id: 1, title: 'Panduan Instalasi SSL pada NGINX', content: 'Berisi panduan lengkap instalasi sertifikat SSL pada server NGINX.', progress: 80, lastEdited: '3 jam lalu', autoSave: '2 menit lalu' },
                { id: 2, title: 'Draf Panduan Aplikasi SIAKADU', content: 'Panduan penggunaan sistem SIAKADU untuk mahasiswa.', progress: 45, lastEdited: '2 hari lalu', autoSave: '5 menit lalu' },
                { id: 3, title: 'SOP Penanganan Insiden Keamanan Siber (Update)', content: 'Update terbaru mengenai prosedur penanganan serangan siber di lingkungan instansi.', progress: 95, lastEdited: '1 jam lalu', autoSave: '10 menit lalu' }
            ];
        }

        function loadDrafts() {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored) {
                try { drafts = JSON.parse(stored); } catch(e) { drafts = getDefaultData(); }
            } else {
                drafts = getDefaultData();
            }
            renderDrafts();
            showToast('Data berhasil dimuat & disegarkan');
        }

        function saveDrafts() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(drafts));
            renderDrafts();
        }

        // 2. RENDER FUNCTION
        let drafts = [];

        function renderDrafts() {
            const grid = document.getElementById('draft-grid');
            if (drafts.length === 0) {
                grid.innerHTML = `<div class="col-span-full text-center py-12 bg-white rounded-xl border border-gray-200">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-gray-500 font-medium">Belum ada draft saat ini.</p>
                    <p class="text-xs text-gray-400 mt-1">Klik tombol "Tambah Draft" untuk memulai.</p>
                </div>`;
                return;
            }

            grid.innerHTML = drafts.map((draft, index) => `
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col hover-lift fade-in-up" style="animation-delay: ${(index + 1) * 0.1}s;">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-2">${draft.title}</h3>
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap mt-1">Draft</span>
                    </div>
                    
                    <div class="space-y-3 flex-1 mt-2">
                        <p class="text-xs text-gray-400">Terakhir diedit: ${draft.lastEdited}</p>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                            <div class="bg-gold h-2 rounded-full" style="width: ${draft.progress}%"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-gray-500">
                            <span>Progress ${draft.progress}%</span>
                            <span class="flex items-center gap-1"><svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> ${draft.autoSave}</span>
                        </div>
                    </div>

                    <!-- Action Buttons (CRUD) -->
                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                        <button onclick="openEditModal(${draft.id})" class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </button>
                        <button onclick="previewDraft(${draft.id})" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Preview
                        </button>
                        <button onclick="deleteDraft(${draft.id})" class="flex-1 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium py-2 px-3 rounded-lg transition-colors flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>
                        <button onclick="submitDraft(${draft.id})" class="flex-1 bg-gold hover:bg-goldhover text-darkbg text-xs font-bold py-2 px-3 rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Submit
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // 3. CRUD FUNCTIONS (CREATE, READ, UPDATE, DELETE)

        // CREATE (Open Modal Kosong)
        function openCreateModal() {
            editingId = null;
            document.getElementById('modal-title').innerText = 'Buat Draft Baru';
            document.getElementById('input-title').value = '';
            document.getElementById('input-content').value = '';
            document.getElementById('input-progress').value = 0;
            document.getElementById('progress-percent').innerText = '0%';
            document.getElementById('draft-modal').classList.add('active');
        }

        // READ (Preview)
        function previewDraft(id) {
            const draft = drafts.find(d => d.id === id);
            if(draft) {
                showToast(`📄 Preview: ${draft.title}\n\n${draft.content || '(Belum ada isi konten)'}`);
            }
        }

        // UPDATE (Open Modal Berisi Data)
        function openEditModal(id) {
            const draft = drafts.find(d => d.id === id);
            if(!draft) return;
            editingId = id;
            document.getElementById('modal-title').innerText = 'Edit Draft';
            document.getElementById('input-title').value = draft.title;
            document.getElementById('input-content').value = draft.content || '';
            document.getElementById('input-progress').value = draft.progress;
            document.getElementById('progress-percent').innerText = draft.progress + '%';
            document.getElementById('draft-modal').classList.add('active');
        }

        // SAVE (CREATE OR UPDATE)
        function saveDraftData() {
            const title = document.getElementById('input-title').value.trim();
            const content = document.getElementById('input-content').value.trim();
            const progress = parseInt(document.getElementById('input-progress').value);
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            if(!title) {
                showToast('⚠️ Judul artikel wajib diisi!');
                return;
            }

            if(editingId === null) {
                // CREATE
                const newDraft = {
                    id: Date.now(),
                    title: title,
                    content: content,
                    progress: progress,
                    lastEdited: 'Baru saja',
                    autoSave: 'Tersimpan otomatis'
                };
                drafts.unshift(newDraft); // Tambahkan ke paling atas
                showToast('✅ Draft baru berhasil dibuat!');
            } else {
                // UPDATE
                const index = drafts.findIndex(d => d.id === editingId);
                if(index !== -1) {
                    drafts[index].title = title;
                    drafts[index].content = content;
                    drafts[index].progress = progress;
                    drafts[index].lastEdited = 'Baru saja';
                    drafts[index].autoSave = 'Tersimpan otomatis';
                    showToast('✅ Draft berhasil diperbarui!');
                }
            }
            saveDrafts();
            closeModal();
        }

        // DELETE
        function deleteDraft(id) {
            const confirmDelete = confirm('Apakah Anda yakin ingin menghapus draft ini? Data akan hilang permanen.');
            if(confirmDelete) {
                drafts = drafts.filter(d => d.id !== id);
                saveDrafts();
                showToast('🗑️ Draft berhasil dihapus.');
            }
        }

        // SUBMIT (Flow khusus aplikasi Draf -> Pending Approval)
        function submitDraft(id) {
            const draft = drafts.find(d => d.id === id);
            if(!draft) return;
            
            if(draft.progress < 100) {
                if(!confirm(`Progress draft ini masih ${draft.progress}%. Apakah Anda yakin ingin mengirimnya untuk approval?`)) {
                    return;
                }
            }

            // Hapus dari list draft, simulasikan dikirim ke modul Pending Approval
            drafts = drafts.filter(d => d.id !== id);
            saveDrafts();
            showToast('🚀 Draft berhasil dikirim untuk Approval!');
        }

        // 4. UTILITY FUNCTIONS

        // Modal Utils
        function closeModal() {
            document.getElementById('draft-modal').classList.remove('active');
            editingId = null;
        }
        // Close modal if clicking outside overlay
        document.getElementById('draft-modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Slider Percent Updater
        document.getElementById('input-progress').addEventListener('input', function() {
            document.getElementById('progress-percent').innerText = this.value + '%';
        });

        // Sidebar Utils
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

        // Toast Notification Helper
        function showToast(message) {
            const toastContainer = document.createElement('div');
            toastContainer.className = `fixed top-5 right-5 z-[99999] bg-white border-l-4 border-gold p-4 rounded-lg shadow-xl transform translate-x-[120%] animate-[slideInRight_0.4s_ease-out_forwards] min-w-[250px] max-w-[350px]`;
            toastContainer.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="text-gold text-lg font-bold">✦</span>
                    <p class="text-sm font-medium text-gray-800 whitespace-pre-line">${message}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 ml-4">✕</button>
                </div>
            `;
            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.style.transform = 'translateX(120%)';
                toastContainer.style.transition = 'transform 0.3s ease-in';
                setTimeout(() => toastContainer.remove(), 300);
            }, 5000);
        }

        // Add CSS for slideInRight
        const styleSheet = document.createElement("style");
        styleSheet.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(120%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(styleSheet);

        // INISIALISASI SAAT HALAMAN DIMUAT
        document.addEventListener('DOMContentLoaded', loadDrafts);
    </script>
</body>
</html>