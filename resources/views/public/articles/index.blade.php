@extends('layouts.public')

@section('title', 'Berita & Informasi')

@section('content')

    <section class="bg-green-800 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">Berita & Informasi</h1>
            <p class="text-green-200">Kabar terkini seputar Wisata Alas Kedaton</p>
        </div>
    </section>

    <section class="py-12 bg-stone-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Search & Filter --}}
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center
                    justify-between gap-4 mb-10">

                <p class="text-sm text-stone-500">
                    @if ($search)
                        Hasil pencarian
                        <span class="font-semibold text-stone-700">"{{ $search }}"</span>
                        — {{ $articles->total() }} artikel
                    @else
                        {{ $articles->total() }} artikel tersedia
                    @endif
                </p>

                <form method="GET" action="{{ route('articles.index') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari berita..."
                            class="w-64 pl-9 pr-3 py-2 border border-stone-200
                                  text-sm bg-white focus:outline-none focus:ring-2
                                  focus:ring-green-500 focus:border-transparent transition">
                    </div>
                    <select name="sort" onchange="this.form.submit()"
                        class="border border-stone-200 px-3 py-2 text-sm bg-white
                               focus:outline-none focus:ring-2 focus:ring-green-500
                               text-stone-600 transition">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white
                               px-4 py-2 text-sm transition">
                        Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('articles.index', ['sort' => $sort]) }}"
                            class="p-2 bg-stone-100 hover:bg-stone-200 text-stone-500 transition" title="Reset pencarian">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            {{-- Grid Artikel --}}
            @if ($articles->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="bg-white border border-stone-300 overflow-hidden group
                      hover:border-green-600 transition">
                            @if ($article->thumbnail)
                                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-green-900 to-green-700
                            flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <p class="text-xs text-stone-400 uppercase tracking-widest mb-3">
                                    {{ $article->published_at->format('d M Y') }}
                                </p>
                                <h2
                                    class="font-bold text-stone-800 leading-snug mb-3 line-clamp-2
                               group-hover:text-green-700 transition">
                                    {{ $article->title }}
                                </h2>
                                <p class="text-stone-400 text-sm leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($article->content), 90) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-20 text-stone-400">
                    <p class="text-5xl mb-4">📰</p>
                    @if ($search)
                        <p class="text-lg font-medium">Tidak ada artikel yang cocok dengan "{{ $search }}"</p>
                        <p class="text-sm mt-2">Coba kata kunci yang berbeda</p>
                    @else
                        <p class="text-lg font-medium">Belum ada berita yang dipublikasikan.</p>
                    @endif
                </div>
            @endif

        </div>
    </section>

@endsection
