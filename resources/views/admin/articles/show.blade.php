<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel - AKSARA Admin</title>
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
        .article-content h1 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; color: #111827; }
        .article-content h2 { font-size: 1.25rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.75rem; color: #1f2937; }
        .article-content h3 { font-size: 1.125rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; color: #374151; }
        .article-content p { margin-bottom: 1rem; line-height: 1.8; color: #374151; }
        .article-content ul, .article-content ol { margin-left: 1.5rem; margin-bottom: 1rem; }
        .article-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1.5rem 0; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .info-item {
            background: #f9fafb;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #f3f4f6;
        }
        .info-item .label {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }
        .info-item .value {
            font-size: 0.9rem;
            font-weight: 500;
            color: #1f2937;
            margin-top: 0.25rem;
            word-break: break-word;
        }
        .attachment-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: 0.2s;
        }
        .attachment-item:hover {
            background: #f3f4f6;
        }
        .attachment-item a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
        }
        .attachment-item a:hover {
            text-decoration: underline;
        }
        .relation-chip {
            display: inline-flex;
            align-items: center;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            color: #1f2937;
            margin: 0.2rem;
        }
        .mermaid-preview {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            min-height: 60px;
            overflow-x: auto;
        }
        .mermaid-preview svg {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="font-sans antialiased bg-lightbg min-h-screen p-4 md:p-6">
    
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('admin.all-articles') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gold transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Artikel Admin
        </a>

        <!-- Card Utama -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-8">
            <!-- Header -->
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $article->title }}</h1>
                        <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ $article->category->name ?? 'Tanpa Kategori' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('D MMMM YYYY') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($article->views) }} views
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        @php
                            $statusColor = [
                                'published' => 'bg-green-100 text-green-700',
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'draft' => 'bg-gray-100 text-gray-600',
                                'archived' => 'bg-gray-200 text-gray-500'
                            ];
                        @endphp
                        <span class="{{ $statusColor[$article->status] ?? 'bg-gray-100 text-gray-600' }} px-3 py-1 rounded-full text-[11px] font-bold">{{ ucfirst($article->status) }}</span>
                        <a href="{{ route('admin.editor.edit', $article->id) }}" class="inline-flex items-center gap-2 text-sm font-medium text-gold hover:text-goldhover transition-colors bg-gold/10 px-3 py-1.5 rounded-full border border-gold/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                    </div>
                </div>

                <!-- Penulis & OPD -->
                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name ?? 'Anonim') . '&background=e5e7eb&color=1f2937' }}" alt="Author" class="w-8 h-8 rounded-full border border-gray-200">
                        <span class="font-medium text-gray-700">{{ $article->user->name ?? 'Anonim' }}</span>
                    </div>
                    @if($article->opd_unit)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ $article->opd_unit }}
                        </span>
                    @endif
                    @if($article->subcategory)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Sub: {{ $article->subcategory }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Konten Artikel -->
            <div class="article-content text-gray-800 prose prose-lg max-w-none">
                {!! $article->content !!}
            </div>

            <!-- Flowchart (jika ada) -->
            @if(!empty($article->flowchart))
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                        Flowchart / Diagram Alur
                    </h3>
                    <div class="mermaid-preview mt-3">
                        <div class="mermaid">{{ $article->flowchart }}</div>
                    </div>
                </div>
            @endif

            <!-- Metadata Grid -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Tambahan
                </h3>
                <div class="info-grid">
                    @if($article->subcategory)
                        <div class="info-item">
                            <div class="label">Subkategori</div>
                            <div class="value">{{ $article->subcategory }}</div>
                        </div>
                    @endif
                    @if($article->opd_unit)
                        <div class="info-item">
                            <div class="label">OPD / Unit</div>
                            <div class="value">{{ $article->opd_unit }}</div>
                        </div>
                    @endif
                    @if($article->version)
                        <div class="info-item">
                            <div class="label">Versi</div>
                            <div class="value">{{ $article->version }}</div>
                        </div>
                    @endif
                    @if($article->doc_code)
                        <div class="info-item">
                            <div class="label">Kode Dokumen</div>
                            <div class="value">{{ $article->doc_code }}</div>
                        </div>
                    @endif
                    @if($article->estimated_read_time)
                        <div class="info-item">
                            <div class="label">Estimasi Baca</div>
                            <div class="value">{{ $article->estimated_read_time }} menit</div>
                        </div>
                    @endif
                    @if($article->language)
                        <div class="info-item">
                            <div class="label">Bahasa</div>
                            <div class="value">{{ $article->language == 'id' ? 'Indonesia' : 'English' }}</div>
                        </div>
                    @endif
                    @if($article->visibility)
                        <div class="info-item">
                            <div class="label">Visibilitas</div>
                            <div class="value">{{ ucfirst($article->visibility) }}</div>
                        </div>
                    @endif
                    @if($article->meta_keywords)
                        <div class="info-item">
                            <div class="label">Keyword SEO</div>
                            <div class="value">{{ $article->meta_keywords }}</div>
                        </div>
                    @endif
                    @if($article->meta_description)
                        <div class="info-item">
                            <div class="label">Meta Deskripsi</div>
                            <div class="value">{{ $article->meta_description }}</div>
                        </div>
                    @endif
                    @if($article->rating_avg)
                        <div class="info-item">
                            <div class="label">Rating</div>
                            <div class="value">{{ number_format($article->rating_avg, 1) }} / 5 ({{ $article->rating_count ?? 0 }} suara)</div>
                        </div>
                    @endif
                    @if($article->valid_from)
                        <div class="info-item">
                            <div class="label">Berlaku Mulai</div>
                            <div class="value">{{ \Carbon\Carbon::parse($article->valid_from)->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    @endif
                    @if($article->valid_until)
                        <div class="info-item">
                            <div class="label">Berlaku Sampai</div>
                            <div class="value">{{ \Carbon\Carbon::parse($article->valid_until)->isoFormat('D MMMM YYYY') }}</div>
                        </div>
                    @endif
                </div>

                <!-- Tags -->
                @if(!empty($article->tags) && is_array($article->tags) && count($article->tags))
                    <div class="mt-4">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-2">Tags:</span>
                        @foreach($article->tags as $tag)
                            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full mr-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <!-- Relations -->
                @if(!empty($article->relations) && is_array($article->relations) && count($article->relations))
                    <div class="mt-4">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-2">Relasi:</span>
                        @foreach($article->relations as $rel)
                            <span class="relation-chip">{{ $rel }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Thumbnail -->
            @if($article->thumbnail)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Thumbnail</h3>
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="max-w-xs max-h-48 rounded-lg border border-gray-200 shadow-sm">
                </div>
            @endif

            <!-- Lampiran / Attachments -->
            @php
                $attachments = is_array($article->attachments) ? $article->attachments : (json_decode($article->attachments, true) ?? []);
            @endphp
            @if(!empty($attachments))
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Lampiran ({{ count($attachments) }})
                    </h3>
                    <div class="space-y-2">
                        @foreach($attachments as $file)
                            <div class="attachment-item">
                                <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <span class="truncate">{{ basename($file) }}</span>
                                </a>
                                <span class="text-xs text-gray-400 flex-shrink-0">{{ round(Storage::disk('public')->size($file) / 1024) }} KB</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap justify-between items-center gap-4">
                <p class="text-xs text-gray-400">
                    Dibuat: {{ $article->created_at->isoFormat('D MMMM YYYY, HH:mm') }} &bull;
                    Diperbarui: {{ $article->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('admin.articles.history', $article->id) }}" class="text-xs text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Revisi
                    </a>
                    <a href="{{ route('admin.editor.edit', $article->id) }}" class="text-xs text-gold hover:text-goldhover transition-colors flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Artikel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mermaid Script untuk render jika ada flowchart -->
    @if(!empty($article->flowchart))
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            mermaid.initialize({ startOnLoad: true, theme: 'default' });
            // Pastikan semua elemen .mermaid di-render
            mermaid.run({
                nodes: document.querySelectorAll('.mermaid')
            });
        });
    </script>
    @endif

</body>
</html>