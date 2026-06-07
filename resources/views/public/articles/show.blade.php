@extends('layouts.public')

@section('title', $article->title)

@section('content')

<article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <a href="{{ route('articles.index') }}"
       class="inline-flex items-center gap-1 text-sm text-stone-500
              hover:text-green-700 transition mb-8">
        ← Kembali ke Berita
    </a>

    @if ($article->thumbnail)
    <img src="{{ Storage::url($article->thumbnail) }}"
         alt="{{ $article->title }}"
         class="w-full h-72 object-cover rounded-2xl mb-8">
    @endif

    <div class="flex items-center gap-3 text-sm text-stone-400 mb-4">
        <span>{{ $article->published_at->translatedFormat('d F Y') }}</span>
        <span>·</span>
        <span>{{ $article->author->name }}</span>
    </div>

    <h1 class="text-3xl sm:text-4xl font-bold text-stone-800 leading-tight mb-8">
        {{ $article->title }}
    </h1>

    <div class="prose prose-stone prose-lg max-w-none">
        {!! $article->content !!}
    </div>

</article>

@endsection