@extends('layouts.public')

@section('title', 'Berita')

@section('content')

<section class="bg-green-800 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-3">Berita & Informasi</h1>
        <p class="text-green-200">Kabar terkini seputar Wisata Alas Kedaton</p>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    {{-- Filter Sort --}}
    <div class="flex justify-end mb-8">
        <div class="flex gap-2">
            <a href="{{ route('articles.index', ['sort' => 'newest']) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
                      {{ $sort === 'newest'
                          ? 'bg-green-700 text-white'
                          : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">
                Terbaru
            </a>
            <a href="{{ route('articles.index', ['sort' => 'oldest']) }}"
               class="px-4 py-2 rounded-xl text-sm font-medium transition
                      {{ $sort === 'oldest'
                          ? 'bg-green-700 text-white'
                          : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">
                Terlama
            </a>
        </div>
    </div>

    @if ($articles->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($articles as $article)
        <a href="{{ route('articles.show', $article->slug) }}"
           class="bg-white rounded-2xl overflow-hidden shadow-sm
                  hover:shadow-md transition group">
            @if ($article->thumbnail)
            <img src="{{ Storage::url($article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
            @else
            <div class="w-full h-48 bg-green-100 flex items-center justify-center">
                <span class="text-green-300 text-4xl">🌿</span>
            </div>
            @endif
            <div class="p-5">
                <p class="text-xs text-stone-400 mb-2">
                    {{ $article->published_at->translatedFormat('d F Y') }}
                </p>
                <h2 class="font-semibold text-stone-800 leading-snug
                           group-hover:text-green-700 transition line-clamp-2">
                    {{ $article->title }}
                </h2>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $articles->appends(['sort' => $sort])->links() }}
    </div>

    @else
    <div class="text-center py-20 text-stone-400">
        <p class="text-5xl mb-4">📰</p>
        <p class="text-lg font-medium">Belum ada berita yang dipublikasikan.</p>
    </div>
    @endif

</section>

@endsection