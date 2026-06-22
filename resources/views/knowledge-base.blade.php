<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base - SIGER-Hub | Pemprov Lampung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkbg: '#0F172A', // Warna gelap background navbar & hero
                        darkerbg: '#0B1120',
                        gold: '#EAB308',   
                        goldhover: '#CA8A04',
                        lightbg: '#F8FAFC', // Background abu-abu sangat muda untuk konten
                        cardborder: '#E2E8F0'
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
            <a href="/" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Beranda</a>
            <a href="/knowledge-base" id="active-link" class="text-white hover:text-gray-200 transition-colors duration-300">Knowledge Base</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Dokumen Publik</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Statistik</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Tentang</a>
            <a href="#" class="nav-link text-gray-300 hover:text-white transition-colors duration-300">Kontak</a>
        </div>
        <div>
            <a href="/login" id="login-btn" class="bg-white/10 border border-gray-600 text-white hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login Portal
            </a>
        </div>
    </nav>

    <section class="bg-darkbg text-center py-20 px-8">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 border border-gold/30 bg-gold/10 text-gold px-4 py-1.5 rounded-full text-xs font-semibold mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>KNOWLEDGE BASE</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                Find documentation, tutorials, and system guides
            </h1>
            
            <p class="text-gray-400 text-base mb-10 max-w-2xl mx-auto">
                Access comprehensive technical documentation, step-by-step tutorials, and best-practice guides curated for developers and IT professionals.
            </p>
            
            <div class="relative max-w-2xl mx-auto mb-6">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Search articles, keywords, or topics..." class="w-full bg-white text-gray-900 rounded-lg py-4 pl-12 pr-4 outline-none focus:ring-2 focus:ring-gold shadow-lg">
            </div>

            <div class="flex flex-wrap justify-center items-center gap-3 text-sm">
                <span class="text-gray-500">Popular:</span>
                <a href="#" class="bg-white/5 border border-gray-700 text-gray-300 hover:text-white hover:border-gray-500 px-3 py-1 rounded-full transition-colors">Docker</a>
                <a href="#" class="bg-white/5 border border-gray-700 text-gray-300 hover:text-white hover:border-gray-500 px-3 py-1 rounded-full transition-colors">Kubernetes</a>
                <a href="#" class="bg-white/5 border border-gray-700 text-gray-300 hover:text-white hover:border-gray-500 px-3 py-1 rounded-full transition-colors">OWASP</a>
                <a href="#" class="bg-white/5 border border-gray-700 text-gray-300 hover:text-white hover:border-gray-500 px-3 py-1 rounded-full transition-colors">VLAN</a>
                <a href="#" class="bg-white/5 border border-gray-700 text-gray-300 hover:text-white hover:border-gray-500 px-3 py-1 rounded-full transition-colors">NGINX</a>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-8 py-12 flex flex-col md:flex-row gap-10">
        <aside class="w-full md:w-1/4">
            <div class="bg-white rounded-xl border border-cardborder p-4 mb-6">
                <h3 class="text-xs font-bold text-gray-500 tracking-wider mb-4 px-2">CATEGORIES</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="#" class="flex justify-between items-center bg-[#0F172A] text-white px-3 py-2.5 rounded-lg text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span>All Topics</span>
                            </div>
                            <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">9</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center hover:bg-gray-50 text-gray-700 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                <span>Web Development</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center hover:bg-gray-50 text-gray-700 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                <span>Server Infrastructure</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center hover:bg-gray-50 text-gray-700 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span>Security & Pentest</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center hover:bg-gray-50 text-gray-700 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                <span>Network Configurations</span>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full">2</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bg-[#FFFBEB] rounded-xl border border-yellow-200 p-6 flex flex-col items-start">
                <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center text-white mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Contribute</h3>
                <p class="text-xs text-gray-600 mb-6 leading-relaxed">Share your knowledge with the community. Submit tutorials and guides.</p>
                <button class="w-full bg-gold hover:bg-goldhover text-darkbg font-bold py-2.5 rounded-lg text-sm transition-colors">Submit Article</button>
            </div>
        </aside>

        <main class="w-full md:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <p class="text-sm text-gray-600">Showing <span class="font-bold text-gray-900">6</span> of <span class="font-bold text-gray-900">9</span> articles</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Code" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded">Web Development</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">Building Scalable REST APIs with Node.js and Express</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">A comprehensive guide to designing and implementing production-ready RESTful AP...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Rizky+Pratama&background=bfdbfe&color=1e3a8a" alt="Avatar">
                                </div>
                                <span>Rizky Pratama</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 12 min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Server" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold px-2 py-1 rounded">Server Infrastructure</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">Docker Container Orchestration for Government Systems</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">Learn how to orchestrate Docker containers for scalable government applications,...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Andi+Kusuma&background=bbf7d0&color=166534" alt="Avatar">
                                </div>
                                <span>Andi Kusuma</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 15 min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Security" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-teal-50 text-teal-700 border border-teal-200 text-[10px] font-bold px-2 py-1 rounded">Security & Pentest</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">OWASP Top 10: Web Application Security Guide</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">An in-depth walkthrough of the OWASP Top 10 vulnerabilities with practical examples an...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-pink-100 rounded-full flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Dian+Permata&background=fbcfe8&color=9d174d" alt="Avatar">
                                </div>
                                <span>Dian Permata</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 18 min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Network" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-1 rounded">Network Configurations</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">Configuring VLANs and Network Segmentation</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">Step-by-step guide to configuring VLANs, implementing network segmentation, and...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-purple-100 rounded-full flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=e9d5ff&color=6b21a8" alt="Avatar">
                                </div>
                                <span>Budi Santoso</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 10 min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1507721999472-8ed4421c4af2?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="CSS" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-orange-100 text-orange-800 text-[10px] font-bold px-2 py-1 rounded">Web Development</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">Modern CSS Grid and Flexbox Layout Patterns</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">Master modern CSS layout techniques with real-world examples. Covers Grid, Flexbox,...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-red-100 rounded-full flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Siti+Nuraini&background=fecaca&color=b91c1c" alt="Avatar">
                                </div>
                                <span>Siti Nuraini</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 8 min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-cardborder rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col cursor-pointer">
                    <div class="relative h-40 bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Cloud" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold px-2 py-1 rounded">Server Infrastructure</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-[15px] leading-snug mb-2">Kubernetes Cluster Setup and Management Guide</h3>
                        <p class="text-xs text-gray-500 mb-6 line-clamp-2">Complete walkthrough for setting up a production-ready Kubernetes cluster,...</p>
                        <div class="mt-auto flex items-center justify-between text-[11px] text-gray-400 font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=Andi+Kusuma&background=bbf7d0&color=166534" alt="Avatar">
                                </div>
                                <span>Andi Kusuma</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 20 min</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-12 text-center">
                <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-2.5 px-6 rounded-lg text-sm inline-flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    Load More Articles
                </button>
            </div>

        </main>
    </div>

    <footer class="bg-[#0B1120] text-white py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
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
            const activeLink = document.getElementById('active-link');
            const loginBtn = document.getElementById('login-btn');

            if (window.scrollY > 50) {
                // Tampilan Navbar saat di-scroll ke bawah (Putih/Terang)
                nav.classList.remove('bg-darkbg', 'border-gray-800');
                nav.classList.add('bg-white', 'border-gray-200', 'shadow-sm');
                
                logoText.classList.remove('text-white');
                logoText.classList.add('text-gray-900');

                // Active Link (Knowledge Base)
                activeLink.classList.remove('text-white', 'hover:text-gray-200');
                activeLink.classList.add('text-gray-900', 'font-bold');

                navLinks.forEach(link => {
                    link.classList.remove('text-gray-300', 'hover:text-white');
                    link.classList.add('text-gray-600', 'hover:text-gray-900');
                });

                loginBtn.classList.remove('bg-white/10', 'border-gray-600', 'text-white', 'hover:bg-white/20');
                loginBtn.classList.add('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50');
            } else {
                // Tampilan Navbar saat di atas (Gelap)
                nav.classList.add('bg-darkbg', 'border-gray-800');
                nav.classList.remove('bg-white', 'border-gray-200', 'shadow-sm');
                
                logoText.classList.add('text-white');
                logoText.classList.remove('text-gray-900');

                // Active Link (Knowledge Base)
                activeLink.classList.add('text-white', 'hover:text-gray-200');
                activeLink.classList.remove('text-gray-900', 'font-bold');

                navLinks.forEach(link => {
                    link.classList.add('text-gray-300', 'hover:text-white');
                    link.classList.remove('text-gray-600', 'hover:text-gray-900');
                });

                loginBtn.classList.add('bg-white/10', 'border-gray-600', 'text-white', 'hover:bg-white/20');
                loginBtn.classList.remove('border-gray-300', 'text-gray-700', 'hover:text-gray-900', 'hover:bg-gray-50');
            }
        });
    </script>
</body>
</html>