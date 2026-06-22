<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOP Penanganan Insiden Keamanan Siber - SIGER-Hub</title>
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
                        cardborder: '#E5E7EB',
                        textmain: '#374151',
                        navy: '#0F172A'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['Fira Code', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', "Liberation Mono", "Courier New", 'monospace'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased text-textmain bg-white">

    <!-- NAVBAR (Light Mode Default for Reading Pages) -->
    <nav class="bg-white text-gray-800 py-4 px-8 flex justify-between items-center border-b border-gray-200 sticky top-0 z-50">
        <div class="flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-gray-900 leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gray-500">Pemprov Lampung</span>
            </div>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-sm">
            <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Beranda</a>
            <a href="/knowledge-base" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Knowledge Base</a>
            <a href="#" class="text-gray-900 font-bold transition-colors duration-300">Dokumen Publik</a>
            <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Statistik</a>
            <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-300">Tentang</a>
        </div>
        <div>
            <a href="/login" class="border border-gray-300 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Portal
            </a>
        </div>
    </nav>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="max-w-[1400px] mx-auto px-8 py-8 flex flex-col lg:flex-row gap-12">
        
        <!-- LEFT COLUMN (Main Document Content) -->
        <main class="w-full lg:w-2/3 xl:w-[70%]">
            
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li class="inline-flex items-center">
                        <a href="/" class="hover:text-gray-900 transition">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <a href="/knowledge-base" class="hover:text-gray-900 transition">Public Directory</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="hover:text-gray-900 transition cursor-pointer">SOP</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="text-gray-900 font-medium">Cybersecurity</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Document Header -->
            <div class="mb-8 border-b border-gray-100 pb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-yellow-100 text-yellow-800 text-[11px] font-bold px-2.5 py-1 rounded">SOP</span>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded">Published</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-6">
                    SOP Penanganan Insiden Keamanan Siber Pemerintah Daerah
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=CSIRT&background=cbd5e1&color=374151" alt="CSIRT Avatar" class="w-10 h-10 rounded-full border border-gray-200">
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-900 text-[13px]">CSIRT Lampung</span>
                            <span class="text-[11px]">Computer Security Incident Response Team</span>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>20 Feb 2026</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>1.876 Views</span>
                    </div>
                </div>
            </div>

            <!-- AI Summary Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-10">
                <div class="flex items-center gap-2 mb-3">
                    <div class="bg-gold text-white p-1 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">AI Document Summary</h3>
                </div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Dokumen ini menetapkan prosedur standar untuk penanganan insiden keamanan siber di lingkungan Pemerintah Provinsi Lampung. Protokol mencakup tahapan identifikasi, analisis, penanganan, dan pemulihan insiden keamanan informasi. SOP ini juga mengatur mekanisme eskalasi dan pelaporan insiden kepada pihak terkait serta panduan vulnerability assessment berkala.
                </p>
            </div>

            <!-- Document Content Body -->
            <article class="prose prose-gray max-w-none text-[15px] leading-loose">
                
                <h2 class="text-xl font-bold text-gray-900 mt-8 mb-4">1. Prosedur Vulnerability Assessment</h2>
                <p class="mb-4">
                    Vulnerability Assessment merupakan langkah awal yang kritis dalam siklus penanganan insiden keamanan siber. Prosedur ini bertujuan untuk mengidentifikasi, mengklasifikasikan, dan memprioritaskan kerentanan pada sistem informasi yang dikelola oleh Pemerintah Provinsi Lampung. Setiap OPD wajib melakukan assessment secara berkala minimal satu kali dalam tiga bulan.
                </p>
                <p class="mb-4">
                    Tahapan pelaksanaan Vulnerability Assessment meliputi perencanaan ruang lingkup assessment, pemindaian sistem menggunakan tools yang telah disetujui, analisis hasil pemindaian, dan penyusunan laporan rekomendasi perbaikan. Seluruh aktivitas scanning wajib dicatat dalam log sistem dan dilaporkan kepada Kepala Dinas Kominfotik.
                </p>
                <p class="mb-8">
                    Prosedur ini berlaku untuk seluruh unit kerja dan sistem informasi di lingkungan Pemerintah Provinsi Lampung. Setiap insiden keamanan siber wajib dicatat, dianalisis, dan ditindaklanjuti sesuai dengan tahapan yang telah ditetapkan dalam dokumen ini. Insiden yang dimaksud mencakup namun tidak terbatas pada serangan malware, akses tidak sah, defacement, kebocoran data, dan serangan denial of service.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-10 mb-4">2. Protokol Identifikasi dan Klasifikasi Insiden</h2>
                <p class="mb-4">
                    Setiap insiden yang terdeteksi harus segera diklasifikasikan berdasarkan tingkat keparahan: Level 1 (Kritis), Level 2 (Tinggi), Level 3 (Sedang), atau Level 4 (Rendah). Klasifikasi ini menentukan jalur eskalasi dan waktu respons yang diperlukan. Insiden Level 1 wajib dilaporkan dalam waktu 1 jam sejak terdeteksi.
                </p>
                <p class="mb-8">
                    Proses eskalasi mengikuti hierarki: Tim Teknis CSIRT → Kabid Keamanan Informasi → Kadis Kominfotik → Sekretaris Daerah. Setiap level memiliki kewenangan pengambilan keputusan yang berbeda sesuai dengan tingkat dampak insiden terhadap layanan pemerintahan.
                </p>

                <!-- Terminal / Code Block -->
                <div class="mt-8 mb-10">
                    <div class="flex items-center gap-2 mb-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        PROTOKOL SCANNING KEAMANAN STANDAR
                    </div>
                    <div class="bg-[#0D1117] rounded-xl overflow-hidden border border-gray-800 shadow-lg">
                        <!-- Terminal Header (Mac Style) -->
                        <div class="bg-[#1E293B] px-4 py-2 flex items-center gap-2 border-b border-gray-700">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <div class="ml-auto text-[10px] text-gray-400 font-mono">bash</div>
                        </div>
                        <!-- Terminal Content -->
                        <div class="p-5 font-mono text-[13px] leading-relaxed overflow-x-auto">
                            <span class="text-green-400"># Vulnerability Assessment Scanning Commands</span><br>
                            <span class="text-green-400"># Nmap Network Scanning</span><br>
                            <span class="text-gray-300">nmap -sV -sC -O -p 1-65535 </span><span class="text-blue-300">target.lampungprov.go.id</span><br><br>
                            
                            <span class="text-green-400"># OWASP ZAP Baseline Scan</span><br>
                            <span class="text-gray-300">docker run -t owasp/zap2docker-stable zap-baseline.py \</span><br>
                            <span class="text-gray-300">  -t </span><span class="text-blue-300">https://target.lampungprov.go.id</span><span class="text-gray-300"> \</span><br>
                            <span class="text-gray-300">  -r zap_baseline_report.html</span><br><br>

                            <span class="text-green-400"># Nikto Web Server Scanner</span><br>
                            <span class="text-gray-300">nikto -h </span><span class="text-blue-300">https://target.lampungprov.go.id</span><span class="text-gray-300"> \</span><br>
                            <span class="text-gray-300">  -o nikto_report.html -Format html</span><br><br>

                            <span class="text-green-400"># Check SSL/TLS Configuration</span><br>
                            <span class="text-gray-300">testssl.sh </span><span class="text-blue-300">https://target.lampungprov.go.id</span>
                        </div>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mt-10 mb-4">3. Prosedur Pemulihan dan Pelaporan</h2>
                <p class="mb-4">
                    Setelah insiden berhasil ditangani, tim CSIRT wajib melakukan langkah pemulihan sistem sesuai dengan Rencana Pemulihan Bencana (DRP) yang telah ditetapkan. Pemulihan mencakup restorasi data dari backup terverifikasi, penerapan patch keamanan, dan validasi integritas sistem sebelum layanan kembali online.
                </p>
                <p class="mb-4">
                    Laporan insiden final harus disusun dalam waktu maksimal 3x24 jam setelah insiden dinyatakan selesai. Laporan mencakup kronologi kejadian, analisis akar penyebab, tindakan yang diambil, rekomendasi pencegahan, dan lessons learned. Format laporan mengacu pada template LAP-CSIRT-001 yang tersedia di repositori dokumen.
                </p>
                <p class="mb-4">
                    Seluruh dokumentasi terkait insiden keamanan siber bersifat rahasia dan hanya dapat diakses oleh personel yang berwenang. Pelanggaran terhadap kerahasiaan dokumen insiden dapat dikenakan sanksi sesuai dengan Peraturan Gubernur tentang Keamanan Informasi.
                </p>

            </article>
        </main>

        <!-- RIGHT COLUMN (Sticky Sidebar / Metadata) -->
        <aside class="w-full lg:w-1/3 xl:w-[30%]">
            <div class="sticky top-24 space-y-6">
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button class="w-full bg-navy hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </button>
                    <button class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                        Print Document
                    </button>
                </div>

                <!-- Document Details Card -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Document Details</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">DOCUMENT ID</span>
                            <span class="font-semibold text-gray-900 text-sm">SOP-CSIRT-004</span>
                        </div>
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">CURRENT VERSION</span>
                            <span class="font-medium text-gray-900 text-sm">v2.1</span>
                        </div>
                        <div>
                            <span class="block text-[11px] text-gray-500 mb-1">LAST UPDATED</span>
                            <span class="font-medium text-gray-900 text-sm">2 days ago</span>
                        </div>
                    </div>
                </div>

                <!-- Version History Card (Timeline) -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-5">Version History</h3>
                    <div class="relative border-l border-gray-200 ml-2 space-y-6">
                        
                        <!-- Timeline Item 1 (Current) -->
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-gold ring-4 ring-white"></span>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-900 text-sm">v2.1</span>
                                <span class="bg-yellow-100 text-yellow-800 text-[10px] px-1.5 py-0.5 rounded">Current</span>
                            </div>
                            <p class="text-xs text-gray-700 mb-1">Approved & Published</p>
                            <span class="text-[11px] text-gray-400">20 Feb 2026</span>
                        </div>

                        <!-- Timeline Item 2 -->
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-gray-300 ring-4 ring-white"></span>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-900 text-sm">v2.0</span>
                            </div>
                            <p class="text-xs text-gray-700 mb-1">Security patch update added by Admin</p>
                            <span class="text-[11px] text-gray-400">05 Jan 2026</span>
                        </div>

                        <!-- Timeline Item 3 -->
                        <div class="relative pl-5">
                            <span class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-gray-300 ring-4 ring-white"></span>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-900 text-sm">v1.0</span>
                            </div>
                            <p class="text-xs text-gray-700 mb-1">Initial Draft</p>
                            <span class="text-[11px] text-gray-400">12 Nov 2025</span>
                        </div>

                    </div>
                </div>

                <!-- Related Documents Card -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Related Documents</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight">Panduan Audit Jaringan Internal</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight">Kebijakan Keamanan Informasi dan Perlindungan Data Pribadi</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight">Pedoman Tata Kelola Data Sektoral dan Satu Data Indonesia</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </aside>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#0B1120] text-white py-16 mt-12 border-t border-gray-800">
        <div class="max-w-[1400px] mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gold rounded flex items-center justify-center text-[#0B1120] font-bold">S</div>
                    <span class="font-bold text-lg">SIGER-Hub</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">Sistem Informasi dan Gerbang Pengetahuan Pemerintah Provinsi Lampung. Platform manajemen pengetahuan terintegrasi untuk tata kelola pemerintahan yang cerdas dan transparan.</p>
            </div>
            
            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">NEWSLETTER</h4>
                <p class="text-gray-400 text-xs mb-3">Dapatkan update terbaru seputar dokumen dan kebijakan.</p>
                <div class="flex">
                    <input type="text" placeholder="Alamat Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold">
                    <button class="bg-gold hover:bg-goldhover px-3 py-2 rounded-r text-[#0B1120]">→</button>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">TAUTAN CEPAT</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li><a href="#" class="hover:text-gold transition">Dokumen Publik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Statistik</a></li>
                    <li><a href="#" class="hover:text-gold transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="hover:text-gold transition">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-gold transition">Bantuan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4 text-[11px] tracking-wider text-gold">HUBUNGI KAMI</h4>
                <ul class="text-gray-400 text-xs space-y-3">
                    <li class="flex gap-2"><span>📍</span> Jl. Wolter Monginsidi No.5, Bandar Lampung, Lampung 35213</li>
                    <li class="flex gap-2"><span>📞</span> (0721) 486711</li>
                    <li class="flex gap-2 text-gold"><span>✉</span> sigerhub@lampungprov.go.id</li>
                </ul>
            </div>
        </div>
        
        <div class="max-w-[1400px] mx-auto px-8 mt-12 pt-8 border-t border-gray-800 text-xs text-gray-500 flex justify-between items-center">
            <p>&copy; 2026 SIGER-Hub — Pemerintah Provinsi Lampung. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-white transition">F</a>
                <a href="#" class="hover:text-white transition">X</a>
                <a href="#" class="hover:text-white transition">IG</a>
                <a href="#" class="hover:text-white transition">YT</a>
            </div>
        </div>
    </footer>

</body>
</html>