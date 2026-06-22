<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGER-Hub | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#111827', // Warna gelap untuk Hero dan Footer
                        gold: '#EAB308',   // Warna aksen emas
                        goldhover: '#CA8A04',
                        lightbg: '#F9FAFB', // Warna terang untuk section konten
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-800 bg-lightbg">

    <nav id="navbar" class="bg-darkbg text-gray-300 py-4 px-8 flex justify-between items-center border-b border-gray-800 sticky top-0 z-50 transition-all duration-300">
        <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold">S</div>
            <div class="flex flex-col">
                <span id="logo-text" class="font-bold text-white leading-tight transition-colors duration-300">SIGER-Hub</span>
                <span class="text-[10px] text-gray-400">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-sm">
            <a href="/" class="nav-link text-white hover:text-white transition-colors duration-300">Beranda</a>
            <a href="/knowledge-base" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Knowledge Base</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Statistik</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Tentang</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Kontak</a>
        </div>
        <div>
            <a href="/login" id="login-btn" class="border border-gray-600 text-gray-300 hover:text-white hover:border-gray-400 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Portal
            </a>
        </div>
    </nav>

    <section class="relative bg-darkbg text-center py-24 px-8 overflow-hidden" 
             style="background-image: radial-gradient(circle at 10% 20%, rgba(234, 179, 8, 0.08) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(234, 179, 8, 0.05) 0%, transparent 40%);">
             
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-50">
            <svg class="absolute -top-10 -left-10 w-[500px] h-[500px] text-gold" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.6"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.4"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.2"/>
            </svg>
            <svg class="absolute -bottom-20 -right-10 w-[600px] h-[600px] text-gold transform rotate-180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.5"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.3"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.1"/>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto relative z-10">
            <div class="inline-flex items-center gap-2 border border-gold/30 bg-gold/10 text-gold px-4 py-1.5 rounded-full text-xs font-semibold mb-8">
                <span>✦ Platform Manajemen Pengetahuan Resmi Pemprov Lampung</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                Sistem Informasi & Gerbang <br> Pengetahuan <br>
                <span class="text-gold">Pemprov Lampung</span>
            </h1>
            
            <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-10">
                Akses ribuan dokumen publik, SOP, pedoman teknis, dan basis pengetahuan terintegrasi untuk mendukung tata kelola pemerintahan yang transparan dan cerdas di Provinsi Lampung.
            </p>
            
            <div class="max-w-2xl mx-auto flex bg-gray-800/50 border border-gray-700 rounded-lg p-1 mb-8">
                <div class="flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Cari dokumen publik, SOP, pedoman, atau regulasi..." class="w-full bg-transparent px-4 py-3 outline-none text-white text-sm">
                <button class="bg-gold text-darkbg px-6 py-2 rounded-md font-semibold text-sm hover:bg-goldhover transition">Cari Dokumen</button>
            </div>

            <button class="bg-gold text-darkbg px-6 py-2.5 rounded-md font-bold text-sm hover:bg-goldhover transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Masuk ke Portal
            </button>
        </div>
    </section>

    <section class="py-16 px-8 max-w-7xl mx-auto bg-lightbg">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Real-Time Government<br>Knowledge Metrics</h2>
                <p class="text-gray-500 mb-8 text-sm">Data statistik terkini yang mencerminkan aktivitas dan pertumbuhan ekosistem manajemen pengetahuan di lingkungan Pemerintah Provinsi Lampung.</p>
                
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <div class="text-3xl font-bold text-gold">12.487 <span class="text-xl">+</span></div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Total Public Documents</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Live Data</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gold">342</div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Active Regional IT Assets</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Live Data</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gold">8.956 <span class="text-xl">+</span></div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Resolved Support Tickets</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Live Data</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gold">156</div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Government Agencies Connected</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Live Data</div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 bg-gray-100 rounded-3xl p-12 flex justify-center items-center relative h-80">
                <div class="absolute w-40 h-40 bg-white rounded-full shadow-lg flex flex-col items-center justify-center z-20">
                    <div class="w-10 h-10 bg-gold rounded text-darkbg flex items-center justify-center font-bold mb-2">=</div>
                    <div class="text-xs font-bold text-gray-800">System Online</div>
                    <div class="text-[10px] text-gray-500">99.9% Uptime</div>
                </div>
                <div class="absolute top-10 right-10 w-24 h-24 bg-gray-200 rounded-2xl"></div>
                <div class="absolute bottom-10 left-10 w-32 h-32 bg-gray-200 rounded-full"></div>
            </div>
        </div>
    </section>

    <section class="py-16 px-8 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Public SOPs & Guidelines</h2>
                <p class="text-gray-500 mt-2 text-sm">Akses dokumen Standar Operasional Prosedur, pedoman TI, kebijakan, dan regulasi yang tersedia untuk publik.</p>
            </div>
            <a href="/knowledge-base" class="text-gray-600 font-medium text-sm flex items-center gap-1 hover:text-darkbg transition">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-gray-200 relative">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Published</span>
                </div>
                <div class="p-5">
                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">SOP</span>
                    <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug">Standar Operasional Prosedur Pengelolaan Arsip Digital</h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">Pedoman teknis pengelolaan arsip digital untuk seluruh OPD di lingkungan Pemerintah Provin...</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex items-center gap-1"><div class="w-4 h-4 bg-gray-200 rounded-full"></div><span>Biro Organisasi</span></div>
                        <span>👁 3.421</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-gray-300 relative">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Published</span>
                </div>
                <div class="p-5">
                    <span class="bg-orange-100 text-orange-800 text-[10px] font-bold px-2 py-0.5 rounded">PEDOMAN TI</span>
                    <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug">Panduan Implementasi SPBE di Pemerintah Daerah Lampung</h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">Dokumen panduan lengkap implementasi Sistem Pemerintahan Berbasis Elektronik untuk...</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex items-center gap-1"><div class="w-4 h-4 bg-gray-200 rounded-full"></div><span>Dinas Kominfotik</span></div>
                        <span>👁 5.120</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-gray-800 relative">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Published</span>
                </div>
                <div class="p-5">
                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">KEBIJAKAN</span>
                    <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug">Kebijakan Keamanan Informasi dan Perlindungan Data Pribadi</h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">Kerangka kebijakan keamanan informasi dan perlindungan data pribadi sesuai UU No. 27...</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex items-center gap-1"><div class="w-4 h-4 bg-gray-200 rounded-full"></div><span>Dinas Kominfotik</span></div>
                        <span>👁 2.830</span>
                    </div>
                </div>
            </div>

            <a href="/document/sop-siber" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-gray-900 relative">
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full">Published</span>
                </div>
                <div class="p-5">
                    <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded">SOP</span>
                    <h3 class="font-bold text-sm text-gray-900 mt-3 leading-snug">SOP Penanganan Insiden Keamanan Siber Pemerintah...</h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">Prosedur standar penanganan insiden keamanan siber untuk seluruh sistem informa...</p>
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <div class="flex items-center gap-1"><div class="w-4 h-4 bg-gray-200 rounded-full"></div><span>CSIRT Lampung</span></div>
                        <span>👁 1.876</span>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <section class="py-16 px-8 max-w-7xl mx-auto">
        <div class="mb-10">
            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full mb-4">Community Voices</span>
            <h2 class="text-4xl font-bold text-gray-900 leading-tight">What Our Officials Say <br> About SIGER-Hub</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Dr. Hj. Ratna Dewi, M.Si.</h4>
                        <p class="text-[11px] text-gray-500">Kepala Dinas<br>Dinas Kominfotik Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"SIGER-Hub telah mentransformasi cara kami mengelola pengetahuan organisasi. Semua SOP dan dokumen teknis kini terpusat dan mudah diakses oleh seluruh pegawai."</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Ahmad Fauzi, S.E., M.M.</h4>
                        <p class="text-[11px] text-gray-500">Sekretaris Daerah<br>Sekretariat Daerah Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Sebagai bagian dari transformasi digital Pemprov Lampung, SIGER-Hub menjadi tulang punggung manajemen pengetahuan yang transparan dan akuntabel."</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Ir. Hendra Gunawan</h4>
                        <p class="text-[11px] text-gray-500">Kepala Bappeda<br>Bappeda Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Integrasi data sektoral melalui SIGER-Hub memungkinkan perencanaan pembangunan yang lebih evidence-based dan kolaboratif antar OPD."</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Budi Santoso, S.Kom., M.T.</h4>
                        <p class="text-[11px] text-gray-500">Kabid Infrastruktur TI<br>Dinas Kominfotik Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Fitur AI summary dan version history sangat membantu tim kami dalam proses review dokumen. Waktu validasi berkurang hingga 60% sejak menggunakan platform ini."</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Dewi Anggraini, S.H.</h4>
                        <p class="text-[11px] text-gray-500">Kepala Biro Hukum<br>Biro Hukum Setda Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Kemudahan pencarian dokumen hukum dan regulasi menggunakan smart search sangat menghemat waktu kerja kami. Interface-nya intuitif dan profesional."</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Rina Marlina, S.Sos., M.A.P.</h4>
                        <p class="text-[11px] text-gray-500">Kabid Dokumentasi & Informasi<br>Dinas Perpustakaan & Kearsipan Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Platform ini menjadi game-changer untuk pengarsipan digital. Sistem kategorisasi dan metadata-nya sangat lengkap, memudahkan preservasi pengetahuan daerah."</p>
            </div>
        </div>
    </section>

    <section class="py-16 px-8 max-w-7xl mx-auto border-t border-gray-200">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Featured <span class="text-gold">Knowledge</span></h2>
                <p class="text-gray-500 mt-2 text-sm max-w-xl">Dokumen dan pedoman unggulan yang paling banyak diakses oleh instansi pemerintah daerah.</p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-full">Trending Now</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-stone-200 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">PEDOMAN TI</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">SPBE Architecture Framework...</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Kerangka arsitektur SPBE terbaru</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 4.520</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-teal-800 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">SOP</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Data Center Operations Manual</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Manual operasional pusat data</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 3.210</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-blue-100 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">STANDAR</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Network Topology Standards</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Standar topologi jaringan daerah</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 2.890</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-indigo-900 relative flex items-center justify-center">
                    <span class="text-white text-xs font-bold">INCIDENT RESPONSE</span>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">SOP</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Incident Response Playbook</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Panduan respons insiden siber</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 5.150</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-md transition">
                <div class="h-32 bg-gray-900 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">PERENCANAAN</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Digital Transformation Roadmap</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Peta jalan transformasi digital</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 6.780</div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 mb-16 flex flex-col md:flex-row mt-8">
        <div class="w-full md:w-1/2 bg-gray-800 text-white p-12 relative overflow-hidden flex flex-col justify-end min-h-[300px]">
            <div class="absolute inset-0 bg-darkbg opacity-90"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold tracking-wider text-gray-300 mb-2 block">PORTAL AKSES</span>
                <h2 class="text-3xl font-bold">Siap Berkontribusi<br>untuk Lampung?</h2>
            </div>
        </div>
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center items-center text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Masuk ke Portal<br>Internal SIGER-Hub</h3>
            <p class="text-gray-500 text-sm mb-8 max-w-sm">Akses dashboard internal untuk mengelola dokumen, melakukan review, berkolaborasi dalam forum pengetahuan, dan berkontribusi pada ekosistem manajemen pengetahuan Pemprov Lampung.</p>
            <div class="flex gap-4">
                <button class="bg-darkbg text-white px-6 py-2 rounded-md font-medium text-sm hover:bg-gray-800 transition shadow-md">Portal Pegawai →</button>
                <button class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md font-medium text-sm hover:bg-gray-50 transition">Portal Admin ⚙</button>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white py-16">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-black font-bold">S</div>
                    <span class="font-bold text-lg">SIGER-Hub</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung. Platform manajemen pengetahuan terintegrasi untuk tata kelola pemerintahan yang cerdas dan transparan.</p>
            </div>
            
            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Dapatkan update terbaru seputar dokumen dan kebijakan.</p>
                <div class="flex">
                    <input type="text" placeholder="Alamat Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white">
                    <button class="bg-gold px-3 py-2 rounded-r text-black">→</button>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-2">
                    <li><a href="/knowledge-base" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-gold transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-gold transition">Bantuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2"><span>📍</span> Jl. Wolter Monginsidi No.5, Bandar Lampung, Lampung 35213</li>
                    <li class="flex gap-2"><span>📞</span> (0721) 486711</li>
                    <li class="flex gap-2"><span>✉</span> sigerhub@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex justify-between items-center">
            <p>&copy; 2026 SIGER-Hub — Pemerintah Provinsi Lampung. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition">F</a>
                <a href="#" class="hover:text-white transition">X</a>
                <a href="#" class="hover:text-white transition">IG</a>
                <a href="#" class="hover:text-white transition">YT</a>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            const logoText = document.getElementById('logo-text');
            const navLinks = document.querySelectorAll('.nav-link');
            const loginBtn = document.getElementById('login-btn');

            if (window.scrollY > 50) {
                // Tampilan Navbar saat di-scroll ke bawah (Light Mode)
                nav.classList.remove('bg-darkbg', 'border-gray-800');
                nav.classList.add('bg-white', 'border-gray-200', 'shadow-sm');
                
                logoText.classList.remove('text-white');
                logoText.classList.add('text-gray-900');

                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'text-gray-300');
                    link.classList.add('text-gray-600', 'hover:text-gray-900');
                });

                loginBtn.classList.remove('border-gray-600', 'text-gray-300', 'hover:text-white', 'hover:border-gray-400');
                loginBtn.classList.add('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50');
            } else {
                // Tampilan Navbar saat di Hero Section (Dark Mode)
                nav.classList.add('bg-darkbg', 'border-gray-800');
                nav.classList.remove('bg-white', 'border-gray-200', 'shadow-sm');
                
                logoText.classList.add('text-white');
                logoText.classList.remove('text-gray-900');

                navLinks.forEach(link => {
                    link.classList.add('text-gray-300');
                    link.classList.remove('text-gray-600', 'hover:text-gray-900');
                });

                loginBtn.classList.add('border-gray-600', 'text-gray-300', 'hover:text-white', 'hover:border-gray-400');
                loginBtn.classList.remove('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50');
            }
        });
    </script>
</body>
</html>