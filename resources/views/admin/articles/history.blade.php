<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Revisi - SIGER-Hub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('admin.all-articles') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gold transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Artikel
        </a>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Riwayat Revisi</h1>
                    <p class="text-sm text-gray-500 mt-1">Artikel: <strong>{{ $article->title }}</strong></p>
                </div>
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs font-medium">{{ $history->count() }} Perubahan</span>
            </div>

            @if($history->count() > 0)
                <div class="space-y-4 relative border-l-2 border-gray-200 ml-3">
                    @foreach($history as $log)
                    <div class="relative pl-6 pb-6">
                        <div class="absolute -left-[6px] top-0 w-3 h-3 rounded-full bg-gold ring-4 ring-white"></div>
                        <div class="flex flex-col md:flex-row justify-between">
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $log->description ?? 'Diperbarui oleh Admin' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Oleh: {{ $log->causer ? $log->causer->name : 'Sistem' }}</p>
                            </div>
                            <span class="text-xs text-gray-400 mt-1 md:mt-0 md:text-right">
                                {{ \Carbon\Carbon::parse($log->created_at)->isoFormat('DD/MM/YYYY - HH:mm') }}
                            </span>
                        </div>
                        @if(isset($log->properties) && !empty($log->properties))
                            <div class="mt-2 bg-gray-50 p-2 rounded border border-gray-100 text-[11px] text-gray-500">
                                <pre class="whitespace-pre-wrap">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-gray-500 border border-dashed border-gray-200 rounded-lg">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>Belum ada riwayat perubahan untuk artikel ini.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>