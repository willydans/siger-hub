<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#EAB308',
                        goldhover: '#CA8A04',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Input OTP dengan gaya yang elegan */
        .otp-input {
            width: 100%;
            max-width: 320px;
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 1rem 0.5rem;
            text-align: center;
            font-size: 2.5rem;
            letter-spacing: 0.5em;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: #1F2937;
            outline: none;
            transition: all 0.2s ease;
        }
        .otp-input:focus {
            border-color: #EAB308;
            box-shadow: 0 0 0 4px rgba(234,179,8,0.15);
        }

        /* Tombol emas */
        .btn-gold {
            background: #EAB308;
            color: #0F172A;
            font-weight: 700;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(234,179,8,0.3);
        }
        .btn-gold:hover {
            background: #CA8A04;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(234,179,8,0.4);
        }
        .btn-gold:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 md:p-10 relative overflow-hidden">
        <!-- Dekorasi ringan -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-gold/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-gold/5 rounded-full pointer-events-none"></div>

        <div class="relative z-10 text-center">
            <!-- Logo / Icon -->
            <div class="w-16 h-16 bg-gold rounded-2xl mx-auto mb-6 flex items-center justify-center text-darkbg text-3xl font-extrabold shadow-lg shadow-gold/20">
                S
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Email</h2>
            <p class="text-sm text-gray-500 mb-6">
                Kami telah mengirimkan kode OTP ke <br>
                <strong class="text-gold">{{ session('email') ?? auth()->user()->email }}</strong>
            </p>

            @error('otp')
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4 text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror

            <!-- Form Verifikasi -->
            <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
                @csrf
                <div class="flex justify-center">
                    <input type="text" name="otp" class="otp-input" placeholder="000000" maxlength="6" autofocus required>
                </div>
                <button type="submit" class="btn-gold w-full">
                    Verifikasi Akun
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>

            <!-- Resend OTP -->
            <form action="{{ route('otp.resend') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gold transition-colors">
                    Tidak menerima kode? <span class="font-medium">Kirim ulang</span>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-[11px] text-gray-400">
                    Kode OTP berlaku selama 10 menit. Jangan bagikan kode ini kepada siapapun.
                </p>
            </div>
        </div>
    </div>
</body>
</html>