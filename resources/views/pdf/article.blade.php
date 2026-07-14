<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $article->title }} - PDF</title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; font-size: 12px; line-height: 1.6; }
        .header { border-bottom: 2px solid #EAB308; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; color: #0F172A; margin: 0; }
        .header .meta { font-size: 11px; color: #6b7280; margin-top: 5px; }
        .content { margin-top: 20px; }
        .content img { max-width: 100%; height: auto; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $article->title }}</h1>
        <div class="meta">
            Dipublikasikan oleh: {{ $article->author_name }} |
            Tanggal: {{ $article->created_at_formatted }} |
            Versi: {{ $article->version }}
            @if($article->doc_code)
                | No. Dokumen: {{ $article->doc_code }}
            @endif
            @if($article->valid_until)
                <br>Berlaku hingga: {{ $article->valid_until->format('d M Y') }}
            @endif
        </div>
    </div>

    <div class="content">
        {{-- Proses konten: ubah path relatif gambar menjadi absolut --}}
        @php
            $content = $article->content;

            // Tangani path yang dimulai dengan "/storage/"
            $content = preg_replace(
                '/src="\/storage\/(.*?)"/',
                'src="' . storage_path('app/public/$1') . '"',
                $content
            );

            // Tangani path yang dimulai dengan "/uploads/" atau "/images/" dll. (di dalam public)
            $content = preg_replace(
                '/src="\/(uploads|images|assets)\/(.*?)"/',
                'src="' . public_path('/$1/$2') . '"',
                $content
            );

            // Pastikan tidak ada gambar yang masih menggunakan src relatif biasa tanpa domain
            // (sisanya dianggap sudah absolut jika diawali http)
        @endphp

        {!! $content !!}
    </div>

    <div class="footer">
        Dokumen ini diunduh dari AKSARA - Pemprov Lampung
    </div>
</body>
</html>