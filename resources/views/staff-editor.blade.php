<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Artikel - SIGER-Hub</title>
    
    <!-- 🚀 PERBAIKAN: Paksa Browser Jangan Cache Halaman Ini -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- ✅ TAMBAHAN: Meta CSRF agar aman jika menggunakan Fetch API -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ✅ PERBAIKAN KRUSIAL: Tambahkan jQuery SEBELUM Toastr agar tidak error -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    
    <!-- 🚀 PERBAIKAN: Tambahkan Cache Buster ?v={{ time() }} -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js?v={{ time() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    
    <!-- 🚀 PERBAIKAN: Cache Buster untuk CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js?v={{ time() }}"></script>
    
    <style>
        .fade-in-up { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); }
        #sidebar-mobile { transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        .preview-btn { transition: all 0.2s ease; }
        .preview-btn.active { background-color: #EAB308; color: #0F172A; border-color: #EAB308; }
        .block-card { transition: all 0.2s ease; }
        .block-card:hover { transform: scale(1.02); border-color: #EAB308; }
        .ck-editor__editable_inline { min-height: 400px; }
        .ck-content { font-family: 'Inter', sans-serif; color: #334155; }
        .dropzone { border: 2px dashed #d1d5db; border-radius: 0.5rem; background: #f9fafb; transition: all 0.3s; }
        .dropzone:hover { border-color: #EAB308; }
        .dropzone .dz-message { font-size: 0.875rem; color: #6b7280; }
        .dropzone .dz-message i { font-size: 2rem; display: block; margin-bottom: 0.5rem; }
        .relation-chip-wrapper { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem; }
        .relation-chip { display: inline-flex; align-items: center; background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.85rem; color: #1f2937; }
        .relation-chip .remove-btn { margin-left: 0.5rem; cursor: pointer; color: #9ca3af; transition: color 0.2s; }
        .relation-chip .remove-btn:hover { color: #ef4444; }
    </style>
</head>
<body class="font-sans antialiased text-textmain bg-lightbg flex h-screen overflow-hidden">
    @php $user = auth()->user(); @endphp
    
    @if(session('success'))
    <script>document.addEventListener('DOMContentLoaded', function() { toastr.success('{{ session('success') }}', 'Sukses', { positionClass: 'toast-top-right' }); });</script>
    @endif
    @if($errors->any())
    <script>document.addEventListener('DOMContentLoaded', function() { toastr.error('Ada kesalahan pada form. Periksa kembali.', 'Error', { positionClass: 'toast-top-right' }); });</script>
    @endif

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden opacity-0" onclick="toggleSidebar()"></div>

    <aside id="sidebar-mobile" class="w-64 bg-darkbg text-gray-300 flex flex-col border-r border-gray-800 shadow-2xl z-40 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 flex-shrink-0">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-800">
            <div class="w-8 h-8 bg-gold rounded text-darkbg flex items-center justify-center font-bold text-lg">S</div>
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">SIGER-Hub</span>
                <span class="text-[10px] text-gold uppercase tracking-widest">Portal Penulis</span>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <a href="{{ route('home.public') }}" class="flex items-center justify-center gap-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 hover:text-blue-300 border border-blue-500/30 px-3 py-2.5 rounded-lg text-xs font-bold transition-colors mb-6 shadow-sm hover:scale-[1.02] duration-200">
                <i class="fas fa-external-link-alt w-4 h-4"></i> Lihat Portal Publik
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Menu Konten</p>
            <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-th-large w-5 h-5"></i> Analitik Dashboard
            </a>
            <a href="{{ route('staff.articles') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-file-alt w-5 h-5"></i> Artikel Saya
            </a>
            <a href="{{ route('staff.draft') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-pen-square w-5 h-5"></i> Draft
            </a>
            <a href="{{ route('staff.revision') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-history w-5 h-5"></i> Revision
            </a>
            <a href="{{ route('staff.notification') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-bell w-5 h-5"></i> Notification
            </a>
            <a href="{{ route('staff.editor') }}" class="flex items-center gap-3 bg-gray-800/50 text-white px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border border-gray-700">
                <i class="fas fa-pen-fancy w-5 h-5 text-gold"></i> Tulis Artikel Baru
            </a>
            <p class="px-2 text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-6 mb-2">Pengaturan</p>
            <a href="{{ route('staff.profile') }}" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800/50 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-user w-5 h-5"></i> Profil Saya
            </a>
        </div>
        <div class="border-t border-gray-800 p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Guest') }}&background=eab308&color=0f172a" class="w-9 h-9 rounded-full">
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-white">{{ $user->name ?? 'Guest' }}</span>
                    <span class="text-[10px] text-gray-400">Kontributor</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gray-800 hover:bg-red-500/20 text-gray-300 hover:text-red-400 py-2 rounded-lg text-xs font-medium border border-gray-700 transition cursor-pointer">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-[#F8FAFC] p-4 md:p-8 relative w-full">
        <div class="flex justify-between items-center mb-4 md:hidden">
            <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-900 p-2 -ml-2 rounded-lg hover:bg-gray-100">
                <i class="fas fa-bars w-6 h-6"></i>
            </button>
            <h2 class="text-xl font-bold text-gray-900">Tulis Artikel</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4 fade-in-up delay-1">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="p-2 bg-gold/10 text-gold rounded-lg hidden md:block">
                    <i class="fas fa-pen-fancy text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 hidden md:block">Tulis Artikel / Dokumen Baru</h1>
                    <span class="text-xs text-gray-400 block md:hidden text-center w-full">Pastikan konten Anda relevan dan akurat.</span>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto justify-end flex-wrap">
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full hidden md:inline-block">
                    Status: <span class="font-bold {{ isset($article) && $article->status == 'draft' ? 'text-yellow-500' : 'text-green-500' }}">{{ isset($article) ? ucfirst($article->status) : 'Draft Baru' }}</span>
                </span>
                <button type="button" onclick="openAIAssistant()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors flex items-center gap-2">
                    <i class="fas fa-magic"></i> AI Assistant
                </button>
            </div>
        </div>

        <form id="editorForm" method="POST" action="{{ isset($article) ? route('staff.editor.update', $article->id) : route('staff.editor.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @if(isset($article)) @method('POST') @endif

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-2 hover-lift">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input id="title-input" name="title" type="text" value="{{ old('title', $article->title ?? '') }}" placeholder="Masukkan judul yang jelas dan deskriptif..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg font-medium focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-colors duration-200" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    
                    <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-2 text-xs text-gray-400">
                        <span class="font-medium text-gray-500">Slug Otomatis:</span>
                        <div class="flex items-center gap-1 w-full sm:w-auto bg-gray-50 border border-gray-200 rounded px-3 py-1.5">
                            <span class="text-gray-500 font-mono">sigerhub.lampungprov.go.id/</span>
                            <span id="slug-output" class="text-gray-800 font-mono font-medium">{{ $article->slug ?? 'judul-artikel-anda' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden fade-in-up delay-3 hover-lift">
                    <div class="p-4">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Konten Artikel <span class="text-red-500">*</span></label>
                        <textarea id="editor" name="content">{{ old('content', $article->content ?? '') }}</textarea>
                        @error('content') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 fade-in-up delay-3">
                    <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                        <i class="fas fa-paperclip text-gold"></i>
                        Upload Lampiran
                    </h3>

                    {{-- ✅ FIX: Tampilkan kembali lampiran yang sudah tersimpan sebelumnya --}}
                    @php
                        $existingAttachments = [];
                        if (isset($article) && $article->attachments) {
                            $existingAttachments = is_array($article->attachments)
                                ? $article->attachments
                                : (json_decode($article->attachments, true) ?? []);
                        }
                    @endphp
                    <div id="existing-attachments-list" class="space-y-2 mb-3">
                        @foreach($existingAttachments as $attachmentPath)
                            <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm attachment-item">
                                <a href="{{ asset('storage/' . $attachmentPath) }}" target="_blank" class="text-blue-600 hover:underline truncate flex items-center gap-2 flex-1 min-w-0">
                                    <i class="fas fa-file-alt flex-shrink-0"></i>
                                    <span class="truncate">{{ basename($attachmentPath) }}</span>
                                </a>
                                <input type="hidden" name="uploaded_attachments[]" value="{{ $attachmentPath }}">
                                <button type="button" onclick="removeExistingAttachment(this)" class="text-gray-400 hover:text-red-500 ml-2 flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="dropzone" id="myDropzone">
                        <div class="dz-message needsclick">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Tarik file ke sini atau klik untuk upload.</span>
                            <span class="block text-xs text-gray-400 mt-1">Maks 20MB per file. Format: PDF, Word, Excel, PPT, ZIP, Video, Audio, Gambar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6 sticky top-6 h-fit">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-2 hover-lift sidebar-scroll max-h-[500px] overflow-y-auto">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Kategori Utama <span class="text-red-500">*</span></label>
                            <select id="category-select" name="category" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->name }}" {{ (isset($article) && $article->category == $cat->name) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Subkategori</label>
                            <select id="subcategory-select" name="subcategory" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                <option value="">Pilih Subkategori...</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->name }}" {{ (isset($article) && $article->subcategory == $sub->name) ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">OPD / Unit</label>
                                <select id="opd-select" name="opd_unit" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                    <option value="">Pilih OPD...</option>
                                    @foreach($opds as $opd)
                                        <option value="{{ $opd->name }}" {{ (isset($article) && $article->opd_unit == $opd->name) ? 'selected' : '' }}>
                                            {{ $opd->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tags</label>
                                <input type="text" name="tags" id="tags-input" value="{{ old('tags', isset($article) && is_array($article->tags) ? implode(', ', $article->tags) : '') }}" placeholder="cth: ssl, nginx" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Visibilitas</h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="public" {{ (old('visibility', $article->visibility ?? 'public') == 'public') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Public</span><span class="text-[10px] text-gray-500">Semua orang bisa akses</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="internal" {{ (old('visibility', $article->visibility ?? '') == 'internal') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Internal</span><span class="text-[10px] text-gray-500">Hanya ASN Prov. Lampung</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="restricted" {{ (old('visibility', $article->visibility ?? '') == 'restricted') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Restricted</span><span class="text-[10px] text-gray-500">Login dengan akses khusus</span></div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input type="radio" name="visibility" value="private" {{ (old('visibility', $article->visibility ?? '') == 'private') ? 'checked' : '' }} class="mt-0.5 text-gold focus:ring-gold">
                                <div><span class="block text-sm font-bold text-gray-800">Private</span><span class="text-[10px] text-gray-500">Hanya author & admin</span></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <h4 class="text-xs font-bold text-gray-600 mb-3">Thumbnail / Cover Image <span class="text-red-500">*</span></h4>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gold transition-colors bg-gray-50/50 cursor-pointer relative group">
                            <input type="file" name="thumbnail" id="thumbnailInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewThumbnail(event)" {{ isset($article) ? '' : 'required' }}>
                            <div id="thumbnailPreviewContainer" class="flex flex-col items-center pointer-events-none">
                                @if(isset($article) && $article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-auto max-h-32 object-contain rounded mb-2 shadow-sm">
                                @endif
                                <div id="thumbnailPlaceholder" class="{{ isset($article) && $article->thumbnail ? 'hidden' : '' }} flex flex-col items-center">
                                    <i class="fas fa-image text-4xl text-gray-400 group-hover:text-gold transition-colors mb-2"></i>
                                    <span class="text-xs font-medium text-gray-600">Drag & Drop</span>
                                    <span class="text-[10px] text-gray-400">atau klik untuk upload</span>
                                </div>
                            </div>
                        </div>
                        @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <details class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift group open:border-gold/50 transition-all duration-200">
                    <summary class="flex justify-between items-center cursor-pointer list-none font-bold text-gray-800">
                        <span><i class="fas fa-tags mr-2"></i> Metadata & SEO</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform duration-200"><i class="fas fa-chevron-down"></i></span>
                    </summary>
                    <div class="mt-4 space-y-3 border-t border-gray-100 pt-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Keyword SEO</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $article->meta_keywords ?? '') }}" placeholder="Masukkan keyword" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Deskripsi (Meta)</label>
                            <textarea name="meta_description" rows="2" placeholder="Deskripsi singkat" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold resize-none">{{ old('meta_description', $article->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Estimasi Waktu Baca</label>
                                <input type="number" name="estimated_read_time" value="{{ old('estimated_read_time', $article->estimated_read_time ?? '') }}" placeholder="Menit" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Bahasa</label>
                                <select name="language" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                                    <option value="id" {{ (old('language', $article->language ?? 'id') == 'id') ? 'selected' : '' }}>Bahasa Indonesia</option>
                                    <option value="en" {{ (old('language', $article->language ?? '') == 'en') ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Versi</label>
                            <input type="text" name="version" value="{{ old('version', $article->version ?? '') }}" placeholder="v1.0" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Nomor SOP / Kode Dokumen</label>
                            <input type="text" name="doc_code" value="{{ old('doc_code', $article->doc_code ?? '') }}" placeholder="cth: SOP-CSIRT-004" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tanggal Berlaku</label>
                                <input type="date" name="valid_from" value="{{ old('valid_from', $article->valid_from ?? '') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Tanggal Kadaluarsa</label>
                                <input type="date" name="valid_until" value="{{ old('valid_until', $article->valid_until ?? '') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                            </div>
                        </div>
                    </div>
                </details>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm"><i class="fas fa-link mr-2 text-gold"></i> Knowledge Relation</h3>
                    <p class="text-xs text-gray-500 mb-2">Artikel ini berhubungan dengan (tekan Enter untuk menambah relasi baru):</p>
                    <div class="flex items-center gap-2">
                        <input type="text" id="relation-input" placeholder="Ketik nama relasi..." class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold">
                        <button type="button" onclick="addRelation()" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded text-sm font-medium border border-blue-200 transition-colors">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>
                    <div id="relation-list" class="relation-chip-wrapper">
                        @if(isset($article) && $article->relations)
                            @foreach(json_decode($article->relations, true) as $rel)
                                <div class="relation-chip">
                                    <span>{{ $rel }}</span>
                                    <input type="hidden" name="relations[]" value="{{ $rel }}">
                                    <span class="remove-btn" onclick="removeRelation(this)"><i class="fas fa-times"></i></span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 fade-in-up delay-3 hover-lift">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-sm"><i class="fas fa-project-diagram mr-2 text-gold"></i> Flowchart (SOP)</h3>
                    <p class="text-xs text-gray-500 mb-2">Tulis kode Mermaid untuk membuat diagram alur.</p>
                    <textarea id="mermaid-input" rows="4" placeholder="flowchart TD
A[Start] --> B[Process]
B --> C[End]" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none transition focus:border-gold resize-none">{{ old('flowchart', $article->flowchart ?? '') }}</textarea>
                    <button type="button" onclick="renderFlowchart()" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-medium flex items-center gap-1">
                        <i class="fas fa-sync-alt"></i> Render
                    </button>
                    <div id="mermaid-preview" class="mt-3 border border-gray-200 rounded bg-white p-2 min-h-[60px]"></div>
                </div>

                <div class="flex flex-col gap-2 mt-6">
                    <button type="submit" class="w-full border border-gray-300 text-gray-700 font-bold py-3 px-4 rounded-lg text-sm bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Draf
                    </button>
                    
                    <button type="button" onclick="openPreview()" class="w-full bg-darkbg text-white font-bold py-3 px-4 rounded-lg text-sm hover:bg-gray-800 transition-all duration-200 hover:shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-eye"></i> Preview
                    </button>

                    @if(isset($article))
                        <form action="{{ route('staff.editor.submit', $article->id) }}" method="POST" id="submitForm" class="w-full">
                            @csrf
                            <button type="button" onclick="confirmSubmit()" class="w-full bg-gold text-darkbg font-bold py-3 px-4 rounded-lg text-sm hover:bg-goldhover transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> Submit Approval
                            </button>
                        </form>
                    @else
                        <button type="button" onclick="Swal.fire('Info', 'Silakan simpan draft terlebih dahulu sebelum melakukan Submit Approval!', 'info')" class="w-full bg-gold/50 text-darkbg/50 cursor-not-allowed font-bold py-3 px-4 rounded-lg text-sm shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> Submit Approval
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-mobile');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
            } else {
                overlay.classList.add('opacity-0');
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        const titleInput = document.getElementById('title-input');
        const slugOutput = document.getElementById('slug-output');
        if(titleInput) {
            titleInput.addEventListener('input', function(e) {
                const text = e.target.value;
                const slug = text.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') 
                    .replace(/\s+/g, '-') 
                    .replace(/-+/g, '-') 
                    .replace(/^-|-$/g, '');
                slugOutput.textContent = slug || 'judul-artikel-anda';
            });
        }

        function previewThumbnail(event) {
            const input = event.target;
            const container = document.getElementById('thumbnailPreviewContainer');
            const placeholder = document.getElementById('thumbnailPlaceholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-auto max-h-32 object-contain rounded mb-2 shadow-sm';
                    container.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
                if(placeholder) placeholder.classList.add('hidden');
            }
        }

        function MyUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }
        
        class MyUploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    
                    // 🚀 DEBUGGING: Cek URL yang dipanggil via Console Log
                    const uploadUrl = "{{ route('staff.editor.upload.image') }}";
                    console.log("📸 CKEditor akan mengirim request ke:", uploadUrl);

                    fetch(uploadUrl, { 
                        method: 'POST',
                        headers: { 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest' // ✅ Tambahan header
                        },
                        body: data
                    })
                    .then(async response => {
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error("Server returned HTML/Error:", errorText);
                            throw new Error(`Gagal terhubung ke server (${response.status}). Cek console untuk detail.`);
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (result.url) {
                            resolve({ default: result.url });
                        } else {
                            reject('Gagal mengupload gambar: Response tidak memiliki URL');
                        }
                    })
                    .catch(error => {
                        console.error('CKEditor Upload Error:', error);
                        toastr.error(error.message || 'Terjadi kesalahan upload gambar', 'Gagal');
                        reject(error);
                    });
                }));
            }
            abort() {}
        }

        const editorElement = document.querySelector('#editor');
        if (editorElement) {
            ClassicEditor
                .create( editorElement, {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'link', 'blockQuote', 'insertTable', 'imageUpload', 'mediaEmbed', '|',
                            'alignment', 'outdent', 'indent', '|',
                            'undo', 'redo'
                        ]
                    },
                    alignment: { options: [ 'left', 'center', 'right', 'justify' ] },
                    image: { toolbar: [ 'imageTextAlternative', 'imageStyle:full', 'imageStyle:side' ] },
                    table: { contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ] },
                    extraPlugins: [ MyUploadAdapterPlugin ]
                })
                .catch( error => console.error(error) );
        }

        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category-select');
            if (categorySelect) {
                new TomSelect(categorySelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const subcategorySelect = document.getElementById('subcategory-select');
            if (subcategorySelect) {
                new TomSelect(subcategorySelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const opdSelect = document.getElementById('opd-select');
            if (opdSelect) {
                new TomSelect(opdSelect, {
                    create: true,
                    plugins: ['remove_button']
                });
            }
            const tagsInput = document.getElementById('tags-input');
            if (tagsInput) {
                new TomSelect(tagsInput, {
                    delimiter: ',',
                    persist: false,
                    create: function(input) { return { value: input, text: input }; },
                });
            }
        });

        // ✅ PERBAIKAN: DROPZONE menggunakan Route Helper
        Dropzone.options.myDropzone = {
            // 🚀 DEBUGGING: Cek URL Dropzone via Console Log
            url: "{{ route('staff.editor.upload.attachment') }}", 
            paramName: "file",
            maxFilesize: 20,
            acceptedFiles: '.pdf,.docx,.mp4,.zip,.jpg,.jpeg,.png,.webp',
            addRemoveLinks: true,
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest' 
            },
            init: function() {
                this.on("success", function(file, response) {
                    console.log("Upload Success:", response);
                    if (response.success) {
                        let hiddenInput = document.createElement('input');
                        hiddenInput.setAttribute('type', 'hidden');
                        hiddenInput.setAttribute('name', 'uploaded_attachments[]');
                        hiddenInput.setAttribute('value', response.path);
                        hiddenInput.setAttribute('data-file-id', file.upload.uuid);
                        document.getElementById('editorForm').appendChild(hiddenInput);
                        toastr.success('File berhasil diupload!', 'Sukses');
                    } else {
                        toastr.error('Gagal upload', 'Error');
                    }
                });
                this.on("removedfile", function(file) {
                    let hiddenInputs = document.querySelectorAll('input[name="uploaded_attachments[]"]');
                    hiddenInputs.forEach(function(input) {
                        if (input.getAttribute('data-file-id') === file.upload.uuid) {
                            input.remove();
                        }
                    });
                });
                this.on("error", function(file, errorMessage, xhr) {
                    console.error("Dropzone Error:", errorMessage);
                    if (xhr && xhr.responseText) {
                        console.error("Full Server Response (HTML):", xhr.responseText);
                        if (xhr.responseText.includes('<!DOCTYPE html>')) {
                            toastr.error('Server mengembalikan halaman error 404/500. Pastikan sudah run php artisan route:clear!', 'Error');
                            return;
                        }
                    }
                    toastr.error('Upload gagal! Buka Console (F12) untuk detail error.', 'Error');
                });
            }
        };

        mermaid.initialize({ startOnLoad: false });
        function renderFlowchart() {
            const code = document.getElementById('mermaid-input').value;
            const preview = document.getElementById('mermaid-preview');
            if (code.trim() === '') {
                preview.innerHTML = '<p class="text-gray-400 text-sm">Belum ada flowchart.</p>';
                return;
            }
            preview.innerHTML = `<div class="mermaid">${code}</div>`;
            try {
                mermaid.run({ nodes: [preview] });
            } catch(e) {
                preview.innerHTML = '<p class="text-red-500 text-xs">Kode Mermaid tidak valid.</p>';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('mermaid-input').value.trim() !== '') {
                renderFlowchart();
            }
        });

        function addRelation() {
            const input = document.getElementById('relation-input');
            const val = input.value.trim();
            if (!val) {
                toastr.warning('Masukkan nama relasi terlebih dahulu!', 'Peringatan');
                return;
            }
            const list = document.getElementById('relation-list');
            const existing = list.querySelectorAll('input[name="relations[]"]');
            for (let e of existing) {
                if (e.value === val) {
                    toastr.warning('Relasi "' + val + '" sudah ada!', 'Duplikat');
                    return;
                }
            }
            const chip = document.createElement('div');
            chip.className = 'relation-chip';
            chip.innerHTML = `
                <span>${val}</span>
                <input type="hidden" name="relations[]" value="${val}">
                <span class="remove-btn" onclick="removeRelation(this)"><i class="fas fa-times"></i></span>
            `;
            list.appendChild(chip);
            input.value = '';
            input.focus();
        }

        function removeRelation(element) {
            const chip = element.parentElement;
            chip.remove();
        }

        function removeExistingAttachment(button) {
            const item = button.closest('.attachment-item');
            if (item) item.remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('relation-input');
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addRelation();
                }
            });
        });

        function confirmSubmit() {
            Swal.fire({
                title: 'Kirim ke Admin?',
                text: "Artikel akan direview oleh Admin. Anda tidak bisa mengubahnya sampai disetujui.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EAB308',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-check-circle"></i> Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('submitForm').submit();
                }
            });
        }

        function openAIAssistant() {
            const rawContent = getCKEditorContent();
            const plainText = rawContent.replace(/<[^>]*>?/gm, '').trim();

            if (!plainText || plainText.length < 50) {
                if (rawContent.length > 0 && plainText.length < 50) {
                    Swal.fire('Peringatan', 'Konten artikel terlalu pendek untuk AI. Minimal 50 karakter teks (tanpa tag HTML).', 'warning');
                } else {
                    Swal.fire('Peringatan', 'Konten artikel terlalu pendek untuk AI. Minimal 50 karakter.', 'warning');
                }
                return;
            }

            Swal.fire({
                title: '<i class="fas fa-magic text-purple-500"></i> AI Assistant',
                html: `
                    <div style="text-align: left;">
                        <p class="mb-2 text-sm text-gray-600">Pilih aksi AI untuk konten Anda:</p>
                        <div class="grid grid-cols-2 gap-2">
                            <button class="ai-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-xs" data-action="Ringkas Artikel">
                                <i class="fas fa-compress"></i> Ringkas
                            </button>
                            <button class="ai-btn bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-xs" data-action="Generate Keyword">
                                <i class="fas fa-key"></i> Keyword
                            </button>
                            <button class="ai-btn bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-xs" data-action="Buat FAQ">
                                <i class="fas fa-question-circle"></i> FAQ
                            </button>
                            <button class="ai-btn bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded text-xs" data-action="Perbaiki Tata Bahasa">
                                <i class="fas fa-spell-check"></i> EYD
                            </button>
                            <button class="ai-btn bg-pink-500 hover:bg-pink-600 text-white px-3 py-2 rounded text-xs" data-action="Generate Tag">
                                <i class="fas fa-tags"></i> Tag
                            </button>
                            <button class="ai-btn bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded text-xs" data-action="Buat Deskripsi SEO">
                                <i class="fas fa-search"></i> SEO
                            </button>
                        </div>
                        <div id="ai-result" class="mt-4 p-3 border rounded bg-gray-100 hidden text-sm max-h-60 overflow-y-auto"></div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Tutup',
                showConfirmButton: true,
                didOpen: () => {
                    document.querySelectorAll('.ai-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const action = this.getAttribute('data-action');
                            const content = getCKEditorContent();
                            const resultDiv = document.getElementById('ai-result');
                            
                            resultDiv.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin text-gold"></i> AI sedang memproses...</div>';
                            resultDiv.classList.remove('hidden');
                            
                            const targetUrl = "{{ route('staff.editor.ai') }}";

                            fetch(targetUrl, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ action: action, content: content }),
                                credentials: 'same-origin'
                            })
                            .then(async (response) => {
                                if (!response.ok) {
                                    const errorText = await response.text();
                                    throw new Error(`Server Error ${response.status}: ${errorText.substring(0, 150)}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                resultDiv.innerHTML = '<b>Hasil ' + action + ':</b><br>' + data.result;
                            })
                            .catch(err => {
                                // ✅ TAMBAHAN NOTIFIKASI TOASTR SAAT AI ERROR
                                toastr.error(err.message || 'Terjadi kesalahan pada AI Assistant', 'Gagal');
                                resultDiv.innerHTML = '<p class="text-red-500">Terjadi kesalahan: ' + err.message + '</p>';
                            });
                        });
                    });
                }
            });
        }

        function getCKEditorContent() {
            const editor = document.querySelector('#editor');
            if (editor && editor.ckeditorInstance) {
                return editor.ckeditorInstance.getData();
            }
            return editor ? editor.value : '';
        }

        function setPreview(device) {
            const buttons = document.querySelectorAll('.preview-btn');
            buttons.forEach(btn => btn.classList.remove('active', 'bg-gold', 'text-darkbg', 'border-gold'));
            const activeBtn = Array.from(buttons).find(btn => btn.textContent.toLowerCase().includes(device));
            if(activeBtn) {
                activeBtn.classList.add('active', 'bg-gold', 'text-darkbg', 'border-gold');
            }
        }

        function openPreview() {
            const title = document.querySelector('input[name="title"]').value;
            const content = getCKEditorContent();
            const win = window.open('', '_blank');
            win.document.write(`
                <html><head><title>Preview: ${title}</title>
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
                <script src="https://cdn.tailwindcss.com"><\/script>
                <style>body { font-family: 'Inter', sans-serif; padding: 40px; max-width: 800px; margin: 0 auto; }</style>
                </head><body>
                    <h1 class="text-3xl font-bold mb-6">${title}</h1>
                    <div class="ck-content">${content}</div>
                </body></html>
            `);
            win.document.close();
        }
    </script>
</body>
</html>