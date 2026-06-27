<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKSARA | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#111827',
                        gold: '#EAB308',
                        goldhover: '#CA8A04',
                        lightbg: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 3s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Class pembantu untuk animasi scroll */
        .scroll-hidden {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .scroll-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-lightbg overflow-x-hidden">

    <!-- NAVBAR -->
    <nav id="navbar" class="bg-darkbg text-gray-300 py-4 px-8 flex justify-between items-center border-b border-gray-800 sticky top-0 z-50 transition-all duration-300">
        <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold transition-transform duration-300 group-hover:scale-110">A</div>
            <div class="flex flex-col">
                <span id="logo-text" class="font-bold text-white leading-tight transition-colors duration-300">AKSARA</span>
                <span class="text-[10px] text-gray-400">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-sm">
            <a href="#beranda" class="nav-link text-white hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Beranda</a>
            <a href="#dokumen-publik" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Dokumen Publik</a>
            <a href="/knowledge-base" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Knowledge Base</a>
            <a href="#statistik" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Statistik</a>
            <a href="#tentang" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Tentang</a>
            <a href="#kontak" class="nav-link text-gray-300 hover:text-white transition-colors duration-300 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-gold after:transition-all after:duration-300 hover:after:w-full">Kontak</a>
        </div>
        <div>
            <a href="/login" id="login-btn" class="border border-gray-600 text-gray-300 hover:text-white hover:border-gray-400 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-[0_0_15px_rgba(234,179,8,0.2)]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Portal
            </a>
        </div>
    </nav>

    <!-- FOTO 1: BERANDA -->
    <section id="beranda" class="relative bg-darkbg text-center py-24 px-8 overflow-hidden scroll-mt-20" 
             style="background-image: radial-gradient(circle at 10% 20%, rgba(234, 179, 8, 0.08) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(234, 179, 8, 0.05) 0%, transparent 40%);">
             
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-50">
            <svg class="absolute -top-10 -left-10 w-[500px] h-[500px] text-gold animate-float" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.6"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.4"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.2"/>
            </svg>
            <svg class="absolute -bottom-20 -right-10 w-[600px] h-[600px] text-gold transform rotate-180 animate-float-delayed" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" fill="none" opacity="0.5"/>
                <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" fill="none" opacity="0.3"/>
                <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" fill="none" opacity="0.1"/>
            </svg>
        </div>

        <div class="max-w-4xl mx-auto relative z-10 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="inline-flex items-center gap-2 border border-gold/30 bg-gold/10 text-gold px-4 py-1.5 rounded-full text-xs font-semibold mb-8 hover:bg-gold/20 transition duration-300">
                <span>✦ Platform Manajemen Pengetahuan Resmi Pemprov Lampung</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4 opacity-0 animate-fade-in-up" style="animation-delay: 0.3s;">
                Aplikasi Kolaborasi & Sistem <br> Arsip Referensi Akuntabel <br>
                <span class="text-gold">Pemprov Lampung</span>
            </h1>
            
            <p class="text-gray-400 text-lg max-w-2xl mx-auto mb-10 opacity-0 animate-fade-in-up" style="animation-delay: 0.5s;">
                Akses ribuan dokumen publik, SOP, pedoman teknis, dan basis pengetahuan terintegrasi untuk mendukung tata kelola pemerintahan yang transparan dan cerdas di Provinsi Lampung.
            </p>
            
            <div class="max-w-2xl mx-auto flex bg-gray-800/50 border border-gray-700 rounded-lg p-1 mb-8 opacity-0 animate-fade-in-up hover:border-gray-500 transition-colors duration-300" style="animation-delay: 0.7s;">
                <div class="flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Cari dokumen publik, SOP, pedoman, atau regulasi..." class="w-full bg-transparent px-4 py-3 outline-none text-white text-sm focus:ring-0">
                <button class="bg-gold text-darkbg px-6 py-2 rounded-md font-semibold text-sm hover:bg-goldhover hover:scale-105 transition-all duration-300 shadow-lg">Cari Dokumen</button>
            </div>

            <a href="/login" class="bg-gold text-darkbg px-6 py-2.5 rounded-md font-bold text-sm hover:bg-goldhover hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-2 shadow-lg shadow-gold/20 opacity-0 animate-fade-in-up" style="animation-delay: 0.9s;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Masuk ke Portal AKSARA
            </a>
        </div>
    </section>

    <!-- FOTO 2: STATISTIK -->
    <section id="statistik" class="py-16 px-8 max-w-7xl mx-auto bg-lightbg scroll-mt-20">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2 scroll-hidden obs-element">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Real-Time Government<br>Knowledge Metrics</h2>
                <p class="text-gray-500 mb-8 text-sm">Data statistik terkini yang mencerminkan aktivitas dan pertumbuhan ekosistem manajemen pengetahuan di lingkungan Pemerintah Provinsi Lampung.</p>
                
                <div class="grid grid-cols-2 gap-8">
                    <div class="scroll-hidden obs-element" style="transition-delay: 100ms;">
                        <div class="text-3xl font-bold text-gold">12.487 <span class="text-xl">+</span></div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Total Public Documents</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 200ms;">
                        <div class="text-3xl font-bold text-gold">342</div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Active Regional IT Assets</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 300ms;">
                        <div class="text-3xl font-bold text-gold">8.956 <span class="text-xl">+</span></div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Resolved Support Tickets</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                    <div class="scroll-hidden obs-element" style="transition-delay: 400ms;">
                        <div class="text-3xl font-bold text-gold">156</div>
                        <div class="text-sm text-gray-800 font-medium mt-1">Government Agencies Connected</div>
                        <div class="text-xs text-green-500 mt-1 flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Live Data</div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 bg-gray-100 rounded-3xl p-12 flex justify-center items-center relative h-80 scroll-hidden obs-element hover:shadow-xl transition duration-500" style="transition-delay: 300ms;">
                <div class="absolute w-40 h-40 bg-white rounded-full shadow-lg flex flex-col items-center justify-center z-20 animate-float">
                    <div class="w-10 h-10 bg-gold rounded text-darkbg flex items-center justify-center font-bold mb-2">=</div>
                    <div class="text-xs font-bold text-gray-800">System Online</div>
                    <div class="text-[10px] text-gray-500">99.9% Uptime</div>
                </div>
                <div class="absolute top-10 right-10 w-24 h-24 bg-gray-200 rounded-2xl animate-float-delayed"></div>
                <div class="absolute bottom-10 left-10 w-32 h-32 bg-gray-200 rounded-full animate-float" style="animation-duration: 8s;"></div>
            </div>
        </div>
    </section>

    <!-- FOTO 3: DOKUMEN PUBLIK -->
    <section id="dokumen-publik" class="py-16 px-8 max-w-7xl mx-auto scroll-mt-20">
        <div class="flex justify-between items-end mb-8 scroll-hidden obs-element">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Public SOPs & Guidelines</h2>
                <p class="text-gray-500 mt-2 text-sm">Akses dokumen Standar Operasional Prosedur, pedoman TI, kebijakan, dan regulasi yang tersedia untuk publik.</p>
            </div>
            <a href="/knowledge-base" class="text-gray-600 font-medium text-sm flex items-center gap-1 hover:text-gold transition-colors duration-300">Lihat Semua <span class="group-hover:translate-x-1 transition-transform duration-300">→</span></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Kartu dengan transisi delay bertingkat dan hover scale -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-xl hover:-translate-y-2 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 100ms;">
                <div class="h-32 bg-gray-200 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-300"></div>
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Published</span>
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-xl hover:-translate-y-2 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 200ms;">
                <div class="h-32 bg-gray-300 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-300"></div>
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Published</span>
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-xl hover:-translate-y-2 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 300ms;">
                <div class="h-32 bg-gray-800 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white/10 group-hover:bg-transparent transition duration-300"></div>
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Published</span>
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

            <a href="/document/sop-siber" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-xl hover:-translate-y-2 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 400ms;">
                <div class="h-32 bg-gray-900 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-white/10 group-hover:bg-transparent transition duration-300"></div>
                    <span class="absolute top-3 right-3 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full z-10">Published</span>
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

    <!-- FOTO 4: TENTANG (Community Voices) -->
    <section id="tentang" class="py-16 px-8 max-w-7xl mx-auto scroll-mt-20">
        <div class="mb-10 scroll-hidden obs-element">
            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full mb-4">Community Voices</span>
            <h2 class="text-4xl font-bold text-gray-900 leading-tight">What Our Officials Say <br> About AKSARA</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 100ms;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Dr. Hj. Ratna Dewi, M.Si.</h4>
                        <p class="text-[11px] text-gray-500">Kepala Dinas<br>Dinas Kominfotik Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"AKSARA telah mentransformasi cara kami mengelola pengetahuan organisasi. Semua SOP dan dokumen teknis kini terpusat dan mudah diakses oleh seluruh pegawai."</p>
            </div>

            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 200ms;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Ahmad Fauzi, S.E., M.M.</h4>
                        <p class="text-[11px] text-gray-500">Sekretaris Daerah<br>Sekretariat Daerah Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Sebagai bagian dari transformasi digital Pemprov Lampung, AKSARA menjadi tulang punggung manajemen pengetahuan yang transparan dan akuntabel."</p>
            </div>

            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 300ms;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Ir. Hendra Gunawan</h4>
                        <p class="text-[11px] text-gray-500">Kepala Bappeda<br>Bappeda Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Integrasi data sektoral melalui AKSARA memungkinkan perencanaan pembangunan yang lebih evidence-based dan kolaboratif antar OPD."</p>
            </div>

            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 400ms;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Budi Santoso, S.Kom., M.T.</h4>
                        <p class="text-[11px] text-gray-500">Kabid Infrastruktur TI<br>Dinas Kominfotik Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Fitur AI summary dan version history sangat membantu tim kami dalam proses review dokumen. Waktu validasi berkurang hingga 60% sejak menggunakan platform ini."</p>
            </div>

            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 500ms;">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Dewi Anggraini, S.H.</h4>
                        <p class="text-[11px] text-gray-500">Kepala Biro Hukum<br>Biro Hukum Setda Provinsi Lampung</p>
                    </div>
                </div>
                <p class="text-gray-700 italic text-sm leading-relaxed">"Kemudahan pencarian dokumen hukum dan regulasi menggunakan smart search sangat menghemat waktu kerja kami. Interface-nya intuitif dan profesional."</p>
            </div>

            <div class="bg-white hover:bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 600ms;">
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

    <!-- SECTION: FEATURED KNOWLEDGE -->
    <section class="py-16 px-8 max-w-7xl mx-auto border-t border-gray-200">
        <div class="flex justify-between items-end mb-8 scroll-hidden obs-element">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Featured <span class="text-gold">Knowledge</span></h2>
                <p class="text-gray-500 mt-2 text-sm max-w-xl">Dokumen dan pedoman unggulan yang paling banyak diakses oleh instansi pemerintah daerah.</p>
            </div>
            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-4 py-1.5 rounded-full animate-bounce">Trending Now</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 100ms;">
                <div class="h-32 bg-stone-200 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">PEDOMAN TI</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">SPBE Architecture Framework...</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Kerangka arsitektur SPBE terbaru</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 4.520</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 200ms;">
                <div class="h-32 bg-teal-800 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">SOP</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Data Center Operations Manual</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Manual operasional pusat data</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 3.210</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 300ms;">
                <div class="h-32 bg-blue-100 relative"></div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">STANDAR</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Network Topology Standards</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Standar topologi jaringan daerah</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 2.890</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 400ms;">
                <div class="h-32 bg-indigo-900 relative flex items-center justify-center group">
                    <span class="text-white text-xs font-bold group-hover:scale-110 transition duration-300">INCIDENT RESPONSE</span>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="mb-2"><span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">SOP</span></div>
                    <h3 class="font-bold text-sm text-gray-900 leading-snug">Incident Response Playbook</h3>
                    <p class="text-[11px] text-gray-500 mt-1 mb-3">Panduan respons insiden siber</p>
                    <div class="mt-auto text-[11px] text-gray-400 font-medium">👁 5.150</div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col cursor-pointer hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 scroll-hidden obs-element" style="transition-delay: 500ms;">
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

    <!-- FOTO 5: KONTAK (Call to Action / Footer Area) -->
    <section id="kontak" class="max-w-7xl mx-auto bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-100 mb-16 flex flex-col md:flex-row mt-8 scroll-mt-24 scroll-hidden obs-element">
        <div class="w-full md:w-1/2 bg-gray-800 text-white p-12 relative overflow-hidden flex flex-col justify-end min-h-[300px] group">
            <div class="absolute inset-0 bg-darkbg opacity-90 group-hover:scale-105 transition-transform duration-700"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold tracking-wider text-gray-300 mb-2 block">PORTAL AKSES</span>
                <h2 class="text-3xl font-bold">Siap Berkontribusi<br>untuk Lampung?</h2>
            </div>
        </div>
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center items-center text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Masuk ke Portal<br>Internal AKSARA</h3>
            <p class="text-gray-500 text-sm mb-8 max-w-sm">Akses dashboard internal untuk mengelola dokumen, melakukan review, berkolaborasi dalam forum pengetahuan, dan berkontribusi pada ekosistem manajemen pengetahuan Pemprov Lampung.</p>
            <div class="flex gap-4">
                <a href="/login" class="bg-darkbg text-white px-6 py-2 rounded-md font-medium text-sm hover:bg-gray-800 hover:-translate-y-1 transition-all duration-300 shadow-md">Portal Pegawai →</a>
                <a href="/login" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-md font-medium text-sm hover:bg-gray-50 hover:-translate-y-1 transition-all duration-300">Portal Admin ⚙</a>
            </div>
        </div>
    </section>

    <footer class="bg-black text-white py-16">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-black font-bold">A</div>
                    <span class="font-bold text-lg">AKSARA</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung. Platform manajemen pengetahuan terintegrasi untuk tata kelola pemerintahan yang cerdas dan transparan.</p>
            </div>
            
            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Dapatkan update terbaru seputar dokumen dan kebijakan.</p>
                <div class="flex">
                    <input type="text" placeholder="Alamat Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold transition-colors">
                    <button class="bg-gold hover:bg-goldhover transition-colors px-3 py-2 rounded-r text-black">→</button>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-2">
                    <li><a href="/knowledge-base" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="#statistik" class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-gold transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-gold transition">Bantuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-xs tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2 hover:text-white transition-colors cursor-default"><span>📍</span> Jl. Wolter Monginsidi No.5, Bandar Lampung, Lampung 35213</li>
                    <li class="flex gap-2 hover:text-white transition-colors cursor-default"><span>📞</span> (0721) 486711</li>
                    <li class="flex gap-2 hover:text-white transition-colors cursor-default"><span>✉</span> aksara@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex justify-between items-center">
            <p>&copy; 2026 AKSARA — Pemerintah Provinsi Lampung. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">F</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">X</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">IG</a>
                <a href="#" class="hover:text-gold hover:-translate-y-1 transition-all duration-300">YT</a>
            </div>
        </div>
    </footer>

    <script>
        // --- 1. SCRIPT LOGIC UNTUK NAVBAR BERUBAH WARNA SAAT SCROLL ---
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            const logoText = document.getElementById('logo-text');
            const navLinks = document.querySelectorAll('.nav-link');
            const loginBtn = document.getElementById('login-btn');

            if (window.scrollY > 50) {
                // Tampilan Navbar saat di-scroll ke bawah (Light Mode)
                nav.classList.remove('bg-darkbg', 'border-gray-800');
                nav.classList.add('bg-white', 'border-gray-200', 'shadow-sm', 'bg-opacity-95', 'backdrop-blur-md');
                
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
                nav.classList.remove('bg-white', 'border-gray-200', 'shadow-sm', 'bg-opacity-95', 'backdrop-blur-md');
                
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

        // --- 2. SCRIPT INTERSECTION OBSERVER UNTUK ANIMASI KETIKA SCROLL ---
        document.addEventListener("DOMContentLoaded", function() {
            // Observer Configuration
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1 // Memicu animasi ketika 10% element terlihat
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Tambahkan kelas visible untuk menghidupkan animasi
                        entry.target.classList.add('scroll-visible');
                        entry.target.classList.remove('scroll-hidden');
                        
                        // Opsional: Unobserve jika animasi hanya ingin jalan sekali
                        observer.unobserve(entry.target); 
                    }
                });
            }, observerOptions);

            // Terapkan observer ke semua elemen yang memiliki class .obs-element
            const elements = document.querySelectorAll('.obs-element');
            elements.forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>