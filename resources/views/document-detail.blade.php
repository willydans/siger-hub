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
    <style>
        /* Animasi interaktif ringan untuk Like */
        .like-active {
            transform: scale(1.2);
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        /* Animasi interaktif ringan untuk Bookmark */
        .bookmark-active {
            transform: rotate(10deg);
            transition: transform 0.2s ease-in-out;
        }
        /* Animasi untuk komentar baru */
        .fade-in-new-comment {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-white">

    <!-- NAVBAR (Light Mode Default for Reading Pages) -->
    <nav class="bg-white text-gray-800 py-4 px-8 flex justify-between items-center border-b border-gray-200 sticky top-0 z-50 shadow-sm">
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
            <a href="/login" class="border border-gray-300 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300 hover:shadow-md">
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
                        <a href="/" class="hover:text-gray-900 transition hover:underline underline-offset-4">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <a href="/knowledge-base" class="hover:text-gray-900 transition hover:underline underline-offset-4">Public Directory</a>
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
            <div class="mb-6 border-b border-gray-100 pb-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-yellow-100 text-yellow-800 text-[11px] font-bold px-2.5 py-1 rounded">SOP</span>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded">Published</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    SOP Penanganan Insiden Keamanan Siber Pemerintah Daerah
                </h1>
                
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=CSIRT&background=cbd5e1&color=374151" alt="CSIRT Avatar" class="w-10 h-10 rounded-full border border-gray-200">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-[13px]">CSIRT Lampung</span>
                                    <!-- TOMBOL LIHAT PROFIL PENULIS -->
                                    <a href="#" class="inline-flex items-center gap-1 text-[11px] text-navy bg-blue-50 hover:bg-blue-100 transition-colors duration-200 px-2 py-0.5 rounded-full border border-blue-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Profil
                                    </a>
                                </div>
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

                <!-- ACTION BAR: Bookmark, Like, Rating, Share -->
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-3 sm:gap-4">
                    
                    <!-- 1. BOOKMARK -->
                    <button id="btn-bookmark" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-gold">
                        <svg id="icon-bookmark" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        <span class="text-xs font-medium hidden sm:inline">Bookmark</span>
                    </button>

                    <!-- 2. LIKE -->
                    <button id="btn-like" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300 hover:border-red-300">
                        <svg id="icon-like" class="w-4 h-4 transition-all duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        <span id="like-count" class="text-xs font-medium">127</span>
                    </button>

                    <!-- 3. RATING BINTANG (⭐⭐⭐⭐⭐) -->
                    <div class="flex items-center gap-1 px-3 py-1.5 rounded-full border border-gray-200 bg-white">
                        <span class="text-[10px] font-medium text-gray-400 mr-1">Beri Rating:</span>
                        <div class="flex">
                            <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="1">☆</button>
                            <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="2">☆</button>
                            <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="3">☆</button>
                            <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="4">☆</button>
                            <button class="star-rating text-gray-300 hover:text-yellow-400 transition-colors duration-200 text-base leading-none px-0.5" data-value="5">☆</button>
                        </div>
                    </div>

                    <!-- 4. SHARE -->
                    <div class="relative group/share inline-block">
                        <button id="btn-share" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            <span class="text-xs font-medium hidden sm:inline">Bagikan</span>
                        </button>
                        <!-- Tooltip Share Popup (Simple implementation) -->
                        <div class="absolute right-0 top-full mt-2 w-max bg-white border border-gray-200 rounded-lg shadow-xl p-3 hidden group-hover/share:block z-20 transition-opacity duration-200">
                            <p class="text-xs font-medium text-gray-500 mb-2">Salin tautan:</p>
                            <div class="flex items-center gap-2 bg-gray-50 rounded border border-gray-200 px-2 py-1">
                                <input id="share-url-input" type="text" value="https://sigerhub.lampungprov.go.id/sop-csirt-004" readonly class="bg-transparent border-none text-xs text-gray-700 w-48 outline-none p-0">
                                <button onclick="copyShareLink()" class="bg-navy hover:bg-gray-800 text-white text-[10px] px-2 py-1 rounded transition-colors">Salin</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- AI Summary Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-10 hover:shadow-md transition-shadow duration-300">
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
                    <div class="bg-[#0D1117] rounded-xl overflow-hidden border border-gray-800 shadow-lg transition-shadow duration-300 hover:shadow-[0_0_20px_rgba(234,179,8,0.1)]">
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

            <!-- BAGIAN KOMENTAR -->
            <section class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Komentar <span class="text-sm font-normal text-gray-400 ml-2">(12)</span></h3>
                </div>

                <!-- Form Komentar -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <img src="https://ui-avatars.com/api/?name=User+Baru&background=f3f4f6" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                    <div class="flex-1 flex flex-col gap-3">
                        <textarea id="comment-input" placeholder="Tulis komentar Anda tentang SOP ini..." class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent transition-all duration-300 h-20 bg-white shadow-sm"></textarea>
                        <div class="flex justify-end">
                            <button id="btn-submit-comment" class="bg-navy hover:bg-gray-800 text-white text-sm font-medium px-5 py-2 rounded-full transition-all duration-300 shadow-sm hover:shadow-md hover:scale-105 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Komentar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- List Komentar -->
                <div id="comment-list" class="space-y-6">
                    <!-- Komentar 1 -->
                    <div class="flex gap-4">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=d1fae5&color=065f46" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-gray-900 text-sm">Budi Santoso</span>
                                <span class="text-[11px] text-gray-400">2 jam lalu</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">SOP ini sangat jelas, terutama bagian identifikasi insiden dan eskalasinya. Terima kasih CSIRT Lampung.</p>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                <button class="hover:text-navy transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    8
                                </button>
                                <button class="hover:text-navy transition-colors">Balas</button>
                            </div>
                        </div>
                    </div>

                    <!-- Komentar 2 -->
                    <div class="flex gap-4">
                        <img src="https://ui-avatars.com/api/?name=Anita+Wulandari&background=f3e8ff&color=7e22ce" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-gray-900 text-sm">Anita Wulandari</span>
                                <span class="text-[11px] text-gray-400">5 jam lalu</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">Apakah ada format baku untuk laporan insiden yang harus digunakan setiap OPD? Mohon info lebih lanjut.</p>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                <button class="hover:text-navy transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                    5
                                </button>
                                <button class="hover:text-navy transition-colors">Balas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- RIGHT COLUMN (Sticky Sidebar / Metadata) -->
        <aside class="w-full lg:w-1/3 xl:w-[30%]">
            <div class="sticky top-24 space-y-6">
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button class="w-full bg-navy hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </button>
                    <button class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-3 px-4 rounded-lg flex items-center justify-center gap-2 transition-all duration-300 hover:shadow-md hover:scale-[1.01]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                        Print Document
                    </button>
                </div>

                <!-- Document Details Card -->
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
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
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
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
                <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4">Related Documents</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight group-hover:underline underline-offset-2">Panduan Audit Jaringan Internal</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight group-hover:underline underline-offset-2">Kebijakan Keamanan Informasi dan Perlindungan Data Pribadi</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="group flex items-start gap-2 text-sm text-gray-600 hover:text-navy transition">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gold mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-tight group-hover:underline underline-offset-2">Pedoman Tata Kelola Data Sektoral dan Satu Data Indonesia</span>
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
                    <input type="text" placeholder="Alamat Email" class="w-full px-3 py-2 text-xs bg-gray-900 border border-gray-800 rounded-l outline-none text-white focus:border-gold transition-colors">
                    <button class="bg-gold hover:bg-goldhover px-3 py-2 rounded-r text-[#0B1120] transition-colors">→</button>
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

    <!-- SCRIPT INTERAKTIF RINGAN UNTUK FITUR BARU -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. FITUR BOOKMARK
            const bookmarkBtn = document.getElementById('btn-bookmark');
            const bookmarkIcon = document.getElementById('icon-bookmark');
            let isBookmarked = false;

            bookmarkBtn.addEventListener('click', function() {
                isBookmarked = !isBookmarked;
                if(isBookmarked) {
                    bookmarkIcon.setAttribute('fill', '#EAB308');
                    bookmarkIcon.setAttribute('stroke', '#EAB308');
                    bookmarkIcon.classList.add('bookmark-active');
                    setTimeout(() => { bookmarkIcon.classList.remove('bookmark-active'); }, 300);
                    bookmarkBtn.querySelector('span').textContent = 'Disimpan';
                    bookmarkBtn.classList.add('border-gold', 'bg-yellow-50');
                } else {
                    bookmarkIcon.setAttribute('fill', 'none');
                    bookmarkIcon.setAttribute('stroke', 'currentColor');
                    bookmarkBtn.querySelector('span').textContent = 'Bookmark';
                    bookmarkBtn.classList.remove('border-gold', 'bg-yellow-50');
                }
            });

            // 2. FITUR LIKE
            const likeBtn = document.getElementById('btn-like');
            const likeIcon = document.getElementById('icon-like');
            const likeCount = document.getElementById('like-count');
            let isLiked = false;

            likeBtn.addEventListener('click', function() {
                isLiked = !isLiked;
                let count = parseInt(likeCount.textContent);
                if(isLiked) {
                    likeIcon.setAttribute('fill', '#EF4444');
                    likeIcon.setAttribute('stroke', '#EF4444');
                    likeIcon.classList.add('like-active');
                    likeBtn.classList.add('border-red-300', 'bg-red-50');
                    count++;
                    setTimeout(() => { likeIcon.classList.remove('like-active'); }, 300);
                } else {
                    likeIcon.setAttribute('fill', 'none');
                    likeIcon.setAttribute('stroke', 'currentColor');
                    likeBtn.classList.remove('border-red-300', 'bg-red-50');
                    count--;
                }
                likeCount.textContent = count;
            });

            // 3. FITUR RATING BINTANG
            const stars = document.querySelectorAll('.star-rating');
            let currentRating = 0;

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    currentRating = (currentRating === val) ? 0 : val;
                    updateStars();
                });

                star.addEventListener('mouseenter', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    highlightStars(val);
                });

                star.addEventListener('mouseleave', function() {
                    highlightStars(currentRating);
                });
            });

            function updateStars() {
                stars.forEach(s => {
                    const val = parseInt(s.getAttribute('data-value'));
                    if(val <= currentRating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                        s.textContent = '★';
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                        s.textContent = '☆';
                    }
                });
            }

            function highlightStars(val) {
                stars.forEach(s => {
                    const starVal = parseInt(s.getAttribute('data-value'));
                    if(starVal <= val) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                        s.textContent = '★';
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                        s.textContent = '☆';
                    }
                });
                // Reset to current rating if mouse leaves
                if(val === 0) {
                    stars.forEach(s => s.classList.remove('text-yellow-400'));
                }
            }

            // 4. FITUR SHARE COPY LINK
            window.copyShareLink = function() {
                const input = document.getElementById('share-url-input');
                input.select();
                input.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(input.value).then(() => {
                    const btn = input.nextElementSibling;
                    const originalText = btn.textContent;
                    btn.textContent = 'Tersalin!';
                    btn.classList.add('bg-green-500');
                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.classList.remove('bg-green-500');
                    }, 2000);
                }).catch(err => {
                    console.error('Gagal menyalin', err);
                });
            }

            // 5. FITUR KOMENTAR
            const submitBtn = document.getElementById('btn-submit-comment');
            const commentInput = document.getElementById('comment-input');
            const commentList = document.getElementById('comment-list');

            submitBtn.addEventListener('click', function() {
                const text = commentInput.value.trim();
                if(text) {
                    const now = new Date();
                    const timeString = "Baru saja";
                    
                    const newCommentHTML = `
                        <div class="flex gap-4 fade-in-new-comment">
                            <img src="https://ui-avatars.com/api/?name=Anda&background=ffffff&color=333" class="w-10 h-10 rounded-full flex-shrink-0 border border-gray-200">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-gray-900 text-sm">Anda</span>
                                    <span class="text-[11px] text-gray-400">${timeString}</span>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">${text}</p>
                                <div class="mt-2 flex items-center gap-4 text-xs text-gray-400">
                                    <button class="hover:text-navy transition-colors flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                        0
                                    </button>
                                    <button class="hover:text-navy transition-colors">Balas</button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    commentList.insertAdjacentHTML('afterbegin', newCommentHTML);
                    commentInput.value = '';
                    commentInput.style.height = '5rem';
                    
                    // Update comment count
                    const countSpan = document.querySelector('h3 span');
                    let currentCount = parseInt(countSpan.textContent.replace(/[^0-9]/g, ''));
                    countSpan.textContent = `(${currentCount + 1})`;
                } else {
                    commentInput.classList.add('border-red-300');
                    setTimeout(() => commentInput.classList.remove('border-red-300'), 2000);
                }
            });
        });
    </script>
</body>
</html>