<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { darkbg: '#0F172A', gold: '#EAB308', lightbg: '#F8FAFC', cardborder: '#E2E8F0', textmain: '#334155' } } } }
    </script>
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
            <a href="/admin/dashboard" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Analitik Utama
            </a>
            
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Manajemen</p>
            <a href="/admin/articles" class="flex items-center justify-between text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Verifikasi & Artikel
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

    <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Analitik & Sistem KMS</h2>
                <p class="text-sm text-gray-500">Pusat kendali seluruh data, verifikasi, dan status server.</p>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2 border border-gray-200 rounded-lg shadow-sm">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs font-bold text-gray-700">Database & API Online</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                <p class="text-[11px] font-bold text-gray-500 uppercase mb-2">Total Dokumen Publik</p>
                <p class="text-3xl font-bold text-gray-900">12,487</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                <p class="text-[11px] font-bold text-blue-500 uppercase mb-2">Menunggu Verifikasi Admin</p>
                <p class="text-3xl font-bold text-gray-900">3</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                <p class="text-[11px] font-bold text-purple-500 uppercase mb-2">Total Pengguna (Staf+User)</p>
                <p class="text-3xl font-bold text-gray-900">2,410</p>
            </div>
            <div class="bg-white border border-cardborder rounded-xl p-5 shadow-sm">
                <p class="text-[11px] font-bold text-gold uppercase mb-2">Trafik Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900">142.5K</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white border border-cardborder rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4">Grafik Pengunjung Portal & API Request</h3>
                <div class="w-full h-72">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>

            <div class="bg-white border border-cardborder rounded-xl shadow-sm p-6">
                <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Status Integrasi API</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 p-2 rounded"><svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
                            <span class="text-sm font-medium text-gray-700">OpenAI API (Auto-Summary)</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">22ms</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 p-2 rounded"><svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></div>
                            <span class="text-sm font-medium text-gray-700">PostgreSQL Database</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Normal</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-100 p-2 rounded"><svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg></div>
                            <span class="text-sm font-medium text-gray-700">Satu Data Regional API</span>
                        </div>
                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">Timeout</span>
                    </li>
                </ul>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('trafficChart').getContext('2d');
            
            // Konfigurasi Chart
            new Chart(ctx, {
                type: 'line', // Jenis grafik
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'], // Sumbu X
                    datasets: [
                        {
                            label: 'Pengunjung Portal',
                            data: [65000, 78000, 90000, 81000, 105000, 120000, 142500], // Sumbu Y Data 1
                            borderColor: '#EAB308', // Warna garis (Gold Siger)
                            backgroundColor: 'rgba(234, 179, 8, 0.1)', // Warna area bawah garis
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4 // Membuat garis melengkung
                        },
                        {
                            label: 'API Request',
                            data: [40000, 55000, 60000, 50000, 75000, 85000, 110000], // Sumbu Y Data 2
                            borderColor: '#3B82F6', // Warna garis (Biru)
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5], // Garis putus-putus
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#F1F5F9', // Warna garis grid tipis
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value / 1000 + 'k'; // Format angka jadi 'k' (contoh: 50k)
                                },
                                font: {
                                    family: "'Inter', sans-serif"
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false, // Hilangkan garis vertikal
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: "'Inter', sans-serif"
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>