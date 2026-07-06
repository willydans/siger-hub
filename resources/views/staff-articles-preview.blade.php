<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $article->title }} - SIGER-Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        darkbg: '#0F172A', 
                        gold: '#EAB308', 
                        goldhover: '#CA8A04', 
                        lightbg: '#F8FAFC', 
                        cardborder: '#E2E8F0', 
                        textmain: '#334155' 
                    } 
                } 
            } 
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Artikel Content Styling (WYSIWYG) */
        .article-content h1 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; color: #111827; }
        .article-content h2 { font-size: 1.25rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.75rem; color: #1f2937; }
        .article-content h3 { font-size: 1.125rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; color: #374151; }
        .article-content p { margin-bottom: 1rem; line-height: 1.8; color: #374151; }
        .article-content ul, .article-content ol { margin-left: 1.5rem; margin-bottom: 1rem; }
        .article-content li { margin-bottom: 0.5rem; }
        .article-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1.5rem 0; }
        .article-content blockquote { border-left: 4px solid #EAB308; padding-left: 1rem; font-style: italic; color: #4b5563; margin: 1.5rem 0; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">

    <!-- Preview Mode Warning Banner -->
    <div class="w-full bg-gold/20 border-b border-gold/30 py-3 px-4 md:px-8 flex justify-between items-center sticky top-0 z-40 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <span class="bg-gold text-darkbg text-xs font-bold px-2.5 py-1 rounded">PREVIEW</span>
            <span class="text-sm text-gray-700 font-medium">Anda sedang melihat pratinjau artikel internal.</span>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('staff.articles') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <a href="{{ route('staff.editor.edit', $article->id) }}" class="text-sm font-bold bg-darkbg text-white px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-colors">Edit</a>
        </div>
    </div>

    <main class="flex-1 w-full max-w-4xl mx-auto py-8 px-4 md:px-8">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-8 fade-in">
            
            <div class="border-b border-gray-200 pb-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $article->title }}</h1>
                <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        {{ $article->category ?? '-' }}
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMMM YYYY') }}
                    </span>
                    @php
                        $statusColor = [
                            'published' => 'bg-green-100 text-green-700',
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'draft' => 'bg-gray-100 text-gray-600',
                            'archived' => 'bg-gray-200 text-gray-500'
                        ];
                    @endphp
                    <span class="{{ $statusColor[$article->status] ?? 'bg-gray-100 text-gray-600' }} px-3 py-1 rounded-full text-[11px] font-bold ml-auto">{{ ucfirst($article->status) }}</span>
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="article-content text-gray-800">
                {!! $article->content !!}
            </div>

            <!-- Meta Info Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 text-xs text-gray-400 text-center">
                Artikel ini akan tampil untuk publik setelah berstatus <strong>Published</strong>.
            </div>
        </div>
    </main>

</body>
</html>