<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal - SIGER-Hub | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0F172A',
                        gold: '#EAB308',
                        goldhover: '#CA8A04',
                        inputbg: '#1E293B',
                        cardborder: '#334155'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ===== FLOWING BACKGROUND LINES ===== */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        /* Garis SVG mengalir dengan animasi stroke-dashoffset */
        .flow-path {
            fill: none;
            stroke: #EAB308;
            stroke-width: 1;
            opacity: 0;
            animation: flowLine 8s ease-in-out infinite;
        }
        .flow-path:nth-child(1)  { opacity:.18; stroke-width:1.2; animation-duration:9s;  animation-delay:0s;    }
        .flow-path:nth-child(2)  { opacity:.10; stroke-width:.8;  animation-duration:11s; animation-delay:-2s;   }
        .flow-path:nth-child(3)  { opacity:.14; stroke-width:1.0; animation-duration:10s; animation-delay:-4s;   }
        .flow-path:nth-child(4)  { opacity:.08; stroke-width:.6;  animation-duration:13s; animation-delay:-1s;   }
        .flow-path:nth-child(5)  { opacity:.12; stroke-width:.9;  animation-duration:12s; animation-delay:-6s;   }
        .flow-path:nth-child(6)  { opacity:.07; stroke-width:.5;  animation-duration:14s; animation-delay:-3s;   }
        .flow-path:nth-child(7)  { opacity:.15; stroke-width:1.1; animation-duration:10s; animation-delay:-8s;   }
        .flow-path:nth-child(8)  { opacity:.09; stroke-width:.7;  animation-duration:15s; animation-delay:-5s;   }
        .flow-path:nth-child(9)  { opacity:.11; stroke-width:.8;  animation-duration:11s; animation-delay:-7s;   }
        .flow-path:nth-child(10) { opacity:.06; stroke-width:.5;  animation-duration:16s; animation-delay:-9s;   }

        @keyframes flowLine {
            0%   { stroke-dashoffset: 1000; opacity: 0; }
            8%   { opacity: 1; }
            90%  { opacity: 1; }
            100% { stroke-dashoffset: 0; opacity: 0; }
        }

        /* Partikel titik emas bergerak */
        .dot-particle {
            position: absolute;
            border-radius: 50%;
            background: #EAB308;
            animation: floatDot linear infinite;
            pointer-events: none;
        }
        @keyframes floatDot {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: .6; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        /* ===== LOGO PULSE ===== */
        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(234,179,8,.4); }
            50%       { box-shadow: 0 0 0 8px rgba(234,179,8,0); }
        }
        .logo-mark { animation: logoPulse 2.8s ease-in-out infinite; }

        /* ===== CARD ENTRANCE ===== */
        .auth-card-wrap {
            animation: cardIn .65s cubic-bezier(.22,1,.36,1) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(28px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== TAB SWITCHER ===== */
        .tab-pill {
            position: absolute;
            top: 4px;
            height: calc(100% - 8px);
            background: #EAB308;
            border-radius: 8px;
            transition: left .3s cubic-bezier(.34,1.56,.64,1), width .3s cubic-bezier(.34,1.56,.64,1);
            pointer-events: none;
            box-shadow: 0 2px 10px rgba(234,179,8,.35);
        }
        .tab-btn {
            position: relative;
            z-index: 1;
            transition: color .25s;
        }
        .tab-btn.active { color: #0F172A; font-weight: 700; }
        .tab-btn:not(.active) { color: #94A3B8; }

        /* ===== FORM TRANSITION (không ngebug) ===== */
        .form-container {
            position: relative;
            /* tinggi menyesuaikan form aktif */
        }
        .form-pane {
            width: 100%;
            transition: opacity .35s ease, transform .35s ease;
        }
        .form-pane.is-hidden {
            opacity: 0;
            pointer-events: none;
            position: absolute;
            top: 0;
            left: 0;
        }
        .form-pane.slide-from-right { transform: translateX(24px); }
        .form-pane.slide-from-left  { transform: translateX(-24px); }
        .form-pane.is-visible {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        /* ===== INPUT FOCUS GLOW ===== */
        .inp {
            width: 100%;
            background: #1E293B;
            border: 1px solid #334155;
            color: #F1F5F9;
            border-radius: 10px;
            padding: .65rem .85rem .65rem 2.6rem;
            font-size: .875rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .inp::placeholder { color: #475569; }
        .inp:focus {
            border-color: #EAB308;
            box-shadow: 0 0 0 3px rgba(234,179,8,.15);
        }
        .inp-icon {
            position: absolute;
            left: .75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            pointer-events: none;
            transition: color .2s;
        }
        .inp-wrap:focus-within .inp-icon { color: #EAB308; }

        /* ===== SUBMIT BUTTON SHINE ===== */
        .btn-gold {
            position: relative;
            overflow: hidden;
            background: #EAB308;
            color: #0F172A;
            font-weight: 700;
            border-radius: 10px;
            padding: .75rem 1rem;
            width: 100%;
            font-size: .875rem;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            transition: background .2s, box-shadow .2s, transform .1s;
            box-shadow: 0 4px 18px rgba(234,179,8,.3);
        }
        .btn-gold::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.25) 50%, transparent 100%);
            transform: translateX(-110%);
            transition: transform .55s ease;
        }
        .btn-gold:hover { background: #CA8A04; box-shadow: 0 4px 24px rgba(234,179,8,.45); }
        .btn-gold:hover::after { transform: translateX(110%); }
        .btn-gold:active { transform: scale(.98); }
        .btn-gold svg { transition: transform .2s; }
        .btn-gold:hover svg { transform: translateX(3px); }

        /* ===== STAT BAR ===== */
        .stat-bar-inner {
            height: 2px;
            background: linear-gradient(90deg, #EAB308, transparent);
            border-radius: 2px;
            animation: statPulse 3s ease-in-out infinite alternate;
        }
        .stat-item:nth-child(2) .stat-bar-inner { animation-delay: -1.5s; }
        @keyframes statPulse {
            0%   { width: 20%; opacity: .5; }
            100% { width: 90%; opacity: 1; }
        }

        /* ===== PASSWORD STRENGTH ===== */
        .str-bar {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: #334155;
            transition: background .3s;
        }
        .str-bar.weak   { background: #ef4444; }
        .str-bar.medium { background: #EAB308; }
        .str-bar.strong { background: #22c55e; }

        /* ===== BACK BUTTON ===== */
        .back-btn {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: .4rem;
            color: #94A3B8;
            font-size: .8rem;
            font-weight: 500;
            text-decoration: none;
            padding: .4rem .75rem;
            border: 1px solid transparent;
            border-radius: 8px;
            transition: color .2s, border-color .2s, background .2s;
        }
        .back-btn:hover {
            color: #EAB308;
            border-color: rgba(234,179,8,.25);
            background: rgba(234,179,8,.06);
        }

        /* ===== COUNTER ===== */
        .cnt { display: inline-block; }

        /* ===== CHECKBOX ===== */
        .chk { accent-color: #EAB308; }

        @media (max-width: 640px) {
            .left-side { display: none !important; }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-300 bg-darkbg min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- ===== BACKGROUND FLOWING LINES ===== -->
    <div class="bg-canvas">
        <svg width="100%" height="100%" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Panjang path harus diset di JS, ini default -->
            </defs>
            <!-- Baris atas -->
            <path class="flow-path" id="p1"  d="M-100,120 C200,40  400,200 700,100 S1100,20  1560,140" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p2"  d="M-100,200 C150,120 450,280 750,180 S1150,80  1560,240" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p3"  d="M-100,60  C250,0   500,150 800,50  S1200,-30 1560,80"  stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <!-- Baris tengah -->
            <path class="flow-path" id="p4"  d="M-100,400 C300,320 600,480 900,380 S1300,260 1560,420" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p5"  d="M-100,480 C250,400 550,540 850,440 S1250,320 1560,500" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p6"  d="M-100,330 C350,260 650,400 950,310 S1350,200 1560,360" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <!-- Baris bawah -->
            <path class="flow-path" id="p7"  d="M-100,680 C200,600 500,740 800,640 S1200,520 1560,700" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p8"  d="M-100,760 C300,680 600,820 900,720 S1300,600 1560,780" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p9"  d="M-100,840 C250,760 550,880 850,780 S1250,680 1560,860" stroke-dasharray="1000" stroke-dashoffset="1000"/>
            <path class="flow-path" id="p10" d="M-100,580 C350,500 650,640 950,540 S1350,420 1560,600" stroke-dasharray="1000" stroke-dashoffset="1000"/>
        </svg>

        <!-- Titik partikel emas -->
        <div id="particles"></div>
    </div>

    <!-- ===== TOMBOL KEMBALI ===== -->
    <a href="/" class="back-btn">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Beranda
    </a>

    <!-- ===== MAIN AUTH CONTAINER ===== -->
    <div class="w-full max-w-5xl mx-auto px-4 py-8 relative z-10 flex items-center justify-center min-h-screen">
        <div class="auth-card-wrap w-full">
            <div class="w-full bg-[#111827]/85 backdrop-blur-xl border border-cardborder rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden"
                 style="box-shadow: 0 25px 60px rgba(0,0,0,.55), 0 0 0 1px rgba(255,255,255,.03);">

                <!-- ===== LEFT PANEL (Branding) ===== -->
                <div class="left-side flex-col justify-between w-full md:w-[44%] p-10 border-b md:border-b-0 md:border-r border-cardborder relative overflow-hidden"
                     style="background: linear-gradient(145deg,#0F172A 0%,#1E293B 100%); display:flex;">

                    <!-- Inner ambient glow -->
                    <div class="absolute -top-16 -left-16 w-72 h-72 rounded-full pointer-events-none"
                         style="background:radial-gradient(circle,rgba(234,179,8,.1),transparent 70%);"></div>
                    <div class="absolute -bottom-16 -right-16 w-56 h-56 rounded-full pointer-events-none"
                         style="background:radial-gradient(circle,rgba(234,179,8,.06),transparent 70%);"></div>

                    <!-- Dekorasi garis sudut -->
                    <svg class="absolute bottom-0 right-0 opacity-20 pointer-events-none" width="200" height="200" viewBox="0 0 200 200" fill="none">
                        <path d="M20,180 Q80,100 150,140 T220,80"  stroke="#EAB308" stroke-width="1.2"/>
                        <path d="M40,200 Q100,120 170,160 T240,100" stroke="#EAB308" stroke-width=".7"/>
                        <circle cx="150" cy="140" r="3" fill="#EAB308" opacity=".7"/>
                        <circle cx="95"  cy="115" r="2" fill="#EAB308" opacity=".5"/>
                    </svg>

                    <div class="relative z-10">
                        <!-- Logo -->
                        <div class="flex items-center gap-3 mb-10">
                            <div class="logo-mark w-10 h-10 bg-gold rounded-lg text-darkbg flex items-center justify-center font-extrabold text-xl select-none">S</div>
                            <div class="flex flex-col">
                                <span class="font-bold text-white text-xl leading-tight">SIGER-Hub</span>
                                <span class="text-xs text-gray-500">Pemprov Lampung</span>
                            </div>
                        </div>

                        <!-- Headline -->
                        <h2 class="text-3xl font-bold text-white leading-tight mb-4">
                            Gerbang Pengetahuan<br>
                            <span class="text-gold">Pemerintah Daerah</span>
                        </h2>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                            Platform manajemen pengetahuan terintegrasi untuk mendukung tata kelola pemerintahan yang transparan, cerdas, dan kolaboratif di Provinsi Lampung.
                        </p>

                        <!-- Stats -->
                        <div class="flex gap-5 mt-9">
                            <div class="stat-item">
                                <div class="text-xl font-bold text-white mb-0.5">
                                    <span class="cnt" id="stat-docs">0</span><span id="stat-docs-suffix"></span>
                                </div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1.5">Dokumen Publik</div>
                                <div class="w-20 h-1 rounded-full overflow-hidden bg-cardborder">
                                    <div class="stat-bar-inner"></div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="text-xl font-bold text-white mb-0.5">
                                    <span class="cnt" id="stat-inst">0</span>
                                </div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-widest mb-1.5">Instansi Terhubung</div>
                                <div class="w-20 h-1 rounded-full overflow-hidden bg-cardborder">
                                    <div class="stat-bar-inner"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 text-[10px] text-gray-600 mt-10">
                        &copy; 2026 Pemerintah Provinsi Lampung. Hak Cipta Dilindungi.
                    </div>
                </div>

                <!-- ===== RIGHT PANEL (Forms) ===== -->
                <div class="flex-1 p-8 md:p-11 flex items-start justify-center">
                    <div class="w-full max-w-sm">

                        <!-- TAB SWITCHER -->
                        <div class="relative flex bg-white/5 border border-cardborder rounded-xl p-1 mb-7 gap-1" id="tab-wrap">
                            <div class="tab-pill" id="tab-indicator"></div>
                            <button id="btn-tab-login" class="tab-btn active flex-1 py-2 text-sm rounded-lg transition-colors" onclick="switchForm('login')">
                                Masuk
                            </button>
                            <button id="btn-tab-register" class="tab-btn flex-1 py-2 text-sm rounded-lg transition-colors" onclick="switchForm('register')">
                                Daftar
                            </button>
                        </div>

                        <!-- FORM CONTAINER -->
                        <div class="form-container">

                            <!-- LOGIN FORM -->
                            <div id="pane-login" class="form-pane is-visible">
                                <div class="mb-7">
                                    <h3 class="text-2xl font-bold text-white mb-1.5">Selamat datang kembali</h3>
                                    <p class="text-sm text-gray-400">Masukkan kredensial Anda untuk mengakses sistem.</p>
                                </div>

                                <form action="#" method="POST" class="space-y-4">
                                    <!-- Email -->
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1.5 uppercase tracking-wider">Alamat Email</label>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                                </svg>
                                            </div>
                                            <input type="email" class="inp" placeholder="email@lampungprov.go.id" required>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1.5">
                                            <label class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">Kata Sandi</label>
                                            <a href="#" class="text-xs text-gold hover:text-goldhover transition-colors">Lupa sandi?</a>
                                        </div>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <input type="password" class="inp" placeholder="••••••••" required>
                                        </div>
                                    </div>

                                    <!-- Remember -->
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" id="remember" class="chk w-4 h-4 rounded border-gray-600 bg-inputbg cursor-pointer">
                                        <label for="remember" class="text-sm text-gray-400 cursor-pointer">Ingat saya selama 30 hari</label>
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" class="btn-gold mt-1">
                                        Masuk
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </button>
                                </form>

                                <p class="mt-6 text-center text-sm text-gray-400">
                                    Belum memiliki akses?
                                    <button onclick="switchForm('register')" class="text-gold hover:text-white font-semibold transition-colors ml-1">Daftar sekarang</button>
                                </p>
                            </div>

                            <!-- REGISTER FORM -->
                            <div id="pane-register" class="form-pane is-hidden slide-from-right">
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold text-white mb-1.5">Buat Akun Staf</h3>
                                    <p class="text-sm text-gray-400">Daftar untuk berkontribusi pada ekosistem pengetahuan.</p>
                                </div>

                                <form action="#" method="POST" class="space-y-3.5">
                                    <!-- Nama -->
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <input type="text" class="inp" placeholder="Nama sesuai identitas" required>
                                        </div>
                                    </div>

                                    <!-- NIP -->
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1.5 uppercase tracking-wider">NIP / Nomor Pegawai</label>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                                                </svg>
                                            </div>
                                            <input type="text" class="inp" placeholder="Masukkan NIP Anda" required>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1.5 uppercase tracking-wider">Alamat Email Instansi</label>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                                </svg>
                                            </div>
                                            <input type="email" class="inp" placeholder="email@lampungprov.go.id" required>
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                                        <div class="inp-wrap relative">
                                            <div class="inp-icon">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <input type="password" class="inp" placeholder="Minimal 8 karakter" id="reg-pass" oninput="updateStrength(this.value)" required>
                                        </div>
                                        <!-- Password strength -->
                                        <div class="flex gap-1 mt-2" id="str-bars">
                                            <div class="str-bar"></div>
                                            <div class="str-bar"></div>
                                            <div class="str-bar"></div>
                                            <div class="str-bar"></div>
                                        </div>
                                        <p class="text-[10px] text-gray-600 mt-1" id="str-label"></p>
                                    </div>

                                    <!-- Submit -->
                                    <button type="submit" class="btn-gold mt-1">
                                        Daftar Akun
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                </form>

                                <p class="mt-4 text-[11px] text-gray-600 text-center leading-relaxed">
                                    Dengan mendaftar, Anda menyetujui kebijakan privasi dan<br>ketentuan penggunaan Pemprov Lampung.
                                </p>

                                <p class="mt-3 text-center text-sm text-gray-400">
                                    Sudah punya akun?
                                    <button onclick="switchForm('login')" class="text-gold hover:text-white font-semibold transition-colors ml-1">Masuk ke portal</button>
                                </p>
                            </div>

                        </div><!-- /form-container -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    /* ============================================================
       TAB + FORM SWITCH — tidak ada position:absolute di luar waktu transisi
       ============================================================ */
    let currentForm = 'login';

    function initIndicator() {
        const wrap = document.getElementById('tab-wrap');
        const btnLogin = document.getElementById('btn-tab-login');
        const ind = document.getElementById('tab-indicator');
        ind.style.width  = btnLogin.offsetWidth  + 'px';
        ind.style.height = btnLogin.offsetHeight + 'px';
        ind.style.left   = (btnLogin.offsetLeft) + 'px';
        ind.style.top    = '4px';
    }

    function switchForm(target) {
        if (target === currentForm) return;

        const fromId = 'pane-' + currentForm;
        const toId   = 'pane-' + target;
        const fromEl = document.getElementById(fromId);
        const toEl   = document.getElementById(toId);

        const goRight = (target === 'register');

        /* Siapkan pane tujuan: hidden tapi dengan posisi awal */
        toEl.classList.remove('is-visible');
        toEl.classList.add('is-hidden', goRight ? 'slide-from-right' : 'slide-from-left');
        toEl.style.display = 'block';  /* pastikan visible untuk ukur tinggi */

        /* Slide keluar pane asal */
        fromEl.style.transform = goRight ? 'translateX(-24px)' : 'translateX(24px)';
        fromEl.style.opacity   = '0';

        setTimeout(() => {
            /* Sembunyikan pane asal */
            fromEl.classList.remove('is-visible');
            fromEl.classList.add('is-hidden');
            fromEl.style.transform = '';
            fromEl.style.opacity   = '';

            /* Munculkan pane tujuan */
            toEl.classList.remove('is-hidden', 'slide-from-right', 'slide-from-left');
            toEl.classList.add('is-visible');
        }, 280);

        /* Update tab indicator */
        const btnTarget = document.getElementById('btn-tab-' + target);
        const btnFrom   = document.getElementById('btn-tab-' + currentForm);
        const ind = document.getElementById('tab-indicator');

        btnFrom.classList.remove('active');
        btnTarget.classList.add('active');
        ind.style.left  = btnTarget.offsetLeft + 'px';
        ind.style.width = btnTarget.offsetWidth + 'px';

        currentForm = target;
    }

    window.addEventListener('load', initIndicator);
    window.addEventListener('resize', initIndicator);


    /* ============================================================
       COUNTER ANIMASI
       ============================================================ */
    function animCounter(elId, target, suffix, duration) {
        const el = document.getElementById(elId);
        const suffixEl = document.getElementById(elId + '-suffix');
        let startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            const progress = Math.min((ts - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(ease * target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target;
                if (suffixEl) suffixEl.textContent = suffix || '';
            }
        }
        requestAnimationFrame(step);
    }

    setTimeout(() => {
        animCounter('stat-docs', 12, 'K+', 1500);
        animCounter('stat-inst', 156, '', 1700);
    }, 400);


    /* ============================================================
       FLOWING LINES — update stroke-dasharray sesuai panjang path
       ============================================================ */
    window.addEventListener('load', () => {
        document.querySelectorAll('.flow-path').forEach(path => {
            const len = path.getTotalLength();
            path.style.strokeDasharray  = len;
            path.style.strokeDashoffset = len;
        });
    });


    /* ============================================================
       PARTIKEL EMAS MENGAMBANG
       ============================================================ */
    function createParticles() {
        const container = document.getElementById('particles');
        const count = 18;
        for (let i = 0; i < count; i++) {
            const dot = document.createElement('div');
            dot.className = 'dot-particle';
            const size = Math.random() * 3 + 1;
            dot.style.cssText = `
                width:${size}px; height:${size}px;
                left:${Math.random() * 100}%;
                opacity:${Math.random() * .5 + .1};
                animation-duration:${Math.random() * 12 + 8}s;
                animation-delay:${Math.random() * -15}s;
            `;
            container.appendChild(dot);
        }
    }
    createParticles();


    /* ============================================================
       PASSWORD STRENGTH
       ============================================================ */
    function updateStrength(val) {
        const bars  = document.querySelectorAll('.str-bar');
        const label = document.getElementById('str-label');
        bars.forEach(b => { b.className = 'str-bar'; });
        if (!val) { label.textContent = ''; return; }

        let score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const cls   = score <= 1 ? 'weak' : score <= 2 ? 'medium' : 'strong';
        const texts = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
        const colors= ['', '#ef4444', '#EAB308', '#22c55e', '#22c55e'];

        for (let i = 0; i < score; i++) bars[i].classList.add(cls);
        label.textContent = texts[score] || '';
        label.style.color = colors[score] || '';
    }
    </script>

</body>
</html>
