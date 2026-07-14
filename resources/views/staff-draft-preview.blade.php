<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Draft - {{ $article->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .ck-content img { max-width: 100%; height: auto; }
    </style>
</head>
<body class="bg-gray-50 py-10 px-4 md:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $article->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">Status: <span class="font-semibold text-yellow-600">Draft</span></p>

        <div class="ck-content prose max-w-none">
            {!! $article->content !!}
        </div>

        @if($article->attachments)
            @php
                $attachments = is_array($article->attachments) ? $article->attachments : json_decode($article->attachments, true);
            @endphp
            @if(is_array($attachments) && count($attachments) > 0)
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Lampiran</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($attachments as $path)
                            @php
                                // ✅ Gunakan Storage::url() agar aman di Ngrok dan Multi Domain
                                $url = \Illuminate\Support\Facades\Storage::disk('public')->url($path);
                                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                            @endphp

                            @if(in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']))
                                <!-- Video -->
                                <div class="relative group">
                                    <video controls class="w-full rounded-lg shadow-sm border border-gray-200">
                                        <source src="{{ $url }}" type="video/{{ $ext === 'mov' ? 'quicktime' : $ext }}">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                            @elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <!-- Gambar -->
                                <img src="{{ $url }}" alt="Lampiran" class="w-full rounded-lg shadow-sm border border-gray-200 object-cover max-h-64">
                            @elseif(in_array($ext, ['pdf']))
                                <!-- PDF -->
                                <a href="{{ $url }}" target="_blank" class="flex items-center gap-2 p-4 bg-red-50 rounded-lg border border-red-200 hover:bg-red-100 transition">
                                    <span class="text-red-600 text-2xl">📄</span>
                                    <span class="text-sm font-medium text-gray-700">Lihat PDF</span>
                                </a>
                            @else
                                <!-- File umum -->
                                <a href="{{ $url }}" target="_blank" class="flex items-center gap-2 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                    <span class="text-gray-600 text-2xl">📎</span>
                                    <span class="text-sm font-medium text-gray-700">{{ basename($path) }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="mt-8 flex gap-3">
            <a href="{{ route('staff.editor.edit', $article->id) }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                Edit Draft
            </a>
            <a href="{{ route('staff.draft') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                Kembali
            </a>
        </div>
    </div>
</body>
</html>