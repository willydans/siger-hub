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
</head>
<body class="font-sans antialiased text-gray-300 bg-darkbg min-h-screen flex items-center justify-center relative overflow-hidden" 
      style="background-image: radial-gradient(circle at 10% 20%, rgba(234, 179, 8, 0.08) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(234, 179, 8, 0.05) 0%, transparent 40%);">

    <!-- TOMBOL KEMBALI -->
    <a href="/" class="absolute top-8 left-8 flex items-center gap-2 text-gray-400 hover:text-gold transition-colors z-50 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Beranda
    </a>

    <!-- BACKGROUND MOTIF EMAS -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
        <svg class="absolute -top-20 -left-20 w-[600px] h-[600px] text-gold" viewBox="0 0 200 200" fill="none">
            <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" opacity="0.6"/>
            <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" opacity="0.4"/>
            <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" opacity="0.2"/>
        </svg>
        <svg class="absolute -bottom-20 -right-20 w-[600px] h-[600px] text-gold transform rotate-180" viewBox="0 0 200 200" fill="none">
            <path d="M-20,120 Q50,30 120,80 T250,50" stroke="currentColor" stroke-width="1.5" opacity="0.5"/>
            <path d="M-40,140 Q40,50 110,100 T230,70" stroke="currentColor" stroke-width="1" opacity="0.3"/>
            <path d="M-60,160 Q30,70 100,120 T210,90" stroke="currentColor" stroke-width="0.5" opacity="0.1"/>
        </svg>
    </div>

    <!-- MAIN AUTH CONTAINER -->
    <div class="w-full max-w-5xl mx-auto p-6 relative z-10 flex items-center justify-center min-h-[600px]">
        <div class="w-full bg-[#111827]/80 backdrop-blur-xl border border-cardborder rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden">
            
            <!-- LEFT PANEL (Branding) -->
            <div class="hidden md:flex flex-col justify-between w-1/2 p-12 bg-gradient-to-br from-[#0F172A] to-[#1E293B] border-r border-cardborder relative overflow-hidden">
                <!-- Inner glow -->
                <div class="absolute top-0 left-0 w-full h-full bg-gold/5 blur-3xl rounded-full"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-10 h-10 bg-gold rounded-lg text-[#0F172A] flex items-center justify-center font-extrabold text-xl">S</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-white text-xl leading-tight">SIGER-Hub</span>
                            <span class="text-xs text-gray-400">Pemprov Lampung</span>
                        </div>
                    </div>
                    
                    <h2 class="text-3xl font-bold text-white leading-tight mb-4">
                        Gerbang Pengetahuan <br> <span class="text-gold">Pemerintah Daerah</span>
                    </h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        Platform manajemen pengetahuan terintegrasi untuk mendukung tata kelola pemerintahan yang transparan, cerdas, dan kolaboratif di Provinsi Lampung.
                    </p>
                    
                    <!-- Stats / Trust Indicators -->
                    <div class="flex gap-6 mt-8">
                        <div>
                            <div class="text-xl font-bold text-white">12K+</div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wider">Dokumen Publik</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-white">156</div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wider">Instansi Terhubung</div>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-[10px] text-gray-500 mt-12">
                    &copy; 2026 Pemerintah Provinsi Lampung. Hak Cipta Dilindungi.
                </div>
            </div>

            <!-- RIGHT PANEL (Forms) -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex items-center justify-center relative">
                
                <!-- LOGIN FORM -->
                <div id="login-form" class="w-full max-w-sm transition-all duration-500 transform translate-x-0 opacity-100 block">
                    <div class="text-center md:text-left mb-8">
                        <h3 class="text-2xl font-bold text-white mb-2">Login ke Portal</h3>
                        <p class="text-sm text-gray-400">Masukkan kredensial Anda untuk mengakses sistem.</p>
                    </div>

                    <form action="#" method="POST" class="space-y-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                </div>
                                <input type="email" placeholder="email@lampungprov.go.id" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-3 pl-10 pr-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wide">Kata Sandi</label>
                                <a href="#" class="text-xs text-gold hover:text-goldhover transition-colors">Lupa sandi?</a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input type="password" placeholder="••••••••" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-3 pl-10 pr-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="remember" class="w-4 h-4 rounded border-gray-600 bg-inputbg text-gold focus:ring-gold focus:ring-offset-darkbg accent-gold cursor-pointer">
                            <label for="remember" class="ml-2 text-sm text-gray-400 cursor-pointer">Ingat saya selama 30 hari</label>
                        </div>

                        <button type="submit" class="w-full bg-gold hover:bg-goldhover text-[#0F172A] font-bold py-3 rounded-lg transition-colors shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_25px_rgba(234,179,8,0.4)] flex items-center justify-center gap-2">
                            Masuk
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>

                    <div class="mt-8 text-center text-sm text-gray-400">
                        Belum memiliki akses? 
                        <button onclick="toggleForm()" class="text-gold hover:text-white font-medium transition-colors">Daftar sekarang</button>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div id="register-form" class="w-full max-w-sm transition-all duration-500 transform translate-x-8 opacity-0 hidden absolute">
                    <div class="text-center md:text-left mb-6">
                        <h3 class="text-2xl font-bold text-white mb-2">Buat Akun Staf</h3>
                        <p class="text-sm text-gray-400">Daftar untuk berkontribusi pada ekosistem pengetahuan.</p>
                    </div>

                    <form action="#" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1 uppercase tracking-wide">Nama Lengkap</label>
                            <input type="text" placeholder="Nama sesuai identitas" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-2.5 px-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1 uppercase tracking-wide">NIP / Nomor Pegawai</label>
                            <input type="text" placeholder="Masukkan NIP Anda" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-2.5 px-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1 uppercase tracking-wide">Alamat Email Instansi</label>
                            <input type="email" placeholder="email@lampungprov.go.id" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-2.5 px-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1 uppercase tracking-wide">Kata Sandi</label>
                            <input type="password" placeholder="Minimal 8 karakter" class="w-full bg-inputbg border border-cardborder text-white rounded-lg py-2.5 px-4 outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors text-sm" required>
                        </div>

                        <button type="submit" class="w-full bg-gold hover:bg-goldhover text-[#0F172A] font-bold py-3 mt-2 rounded-lg transition-colors shadow-lg">
                            Daftar Akun
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-400">
                        Sudah punya akun? 
                        <button onclick="toggleForm()" class="text-gold hover:text-white font-medium transition-colors">Masuk ke portal</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JAVASCRIPT UNTUK TOGGLE LOGIN/REGISTER -->
    <script>
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        function toggleForm() {
            if (loginForm.classList.contains('hidden') === false) {
                // Sembunyikan Login, Tampilkan Register
                loginForm.classList.remove('opacity-100', 'translate-x-0');
                loginForm.classList.add('opacity-0', '-translate-x-8');
                
                setTimeout(() => {
                    loginForm.classList.add('hidden');
                    loginForm.classList.remove('block', 'absolute');
                    
                    registerForm.classList.remove('hidden');
                    registerForm.classList.add('block', 'absolute');
                    
                    // Trigger reflow
                    void registerForm.offsetWidth;
                    
                    registerForm.classList.remove('opacity-0', 'translate-x-8');
                    registerForm.classList.add('opacity-100', 'translate-x-0', 'relative');
                    registerForm.classList.remove('absolute');
                }, 300);

            } else {
                // Sembunyikan Register, Tampilkan Login
                registerForm.classList.remove('opacity-100', 'translate-x-0', 'relative');
                registerForm.classList.add('opacity-0', 'translate-x-8', 'absolute');
                
                setTimeout(() => {
                    registerForm.classList.add('hidden');
                    registerForm.classList.remove('block');
                    
                    loginForm.classList.remove('hidden');
                    loginForm.classList.add('block', 'absolute');
                    
                    // Trigger reflow
                    void loginForm.offsetWidth;
                    
                    loginForm.classList.remove('opacity-0', '-translate-x-8');
                    loginForm.classList.add('opacity-100', 'translate-x-0', 'relative');
                    loginForm.classList.remove('absolute');
                }, 300);
            }
        }
    </script>
</body>
</html>