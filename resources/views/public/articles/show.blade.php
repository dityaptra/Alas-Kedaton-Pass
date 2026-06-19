@extends('layouts.public')

@section('title', $article->title)

@section('content')

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <a href="{{ route('articles.index') }}"
            class="inline-flex items-center gap-1 text-sm text-stone-500
              hover:text-green-700 transition mb-8">
            ← Kembali
        </a>

        <h1 class="text-3xl sm:text-4xl font-bold text-stone-800 leading-tight mb-8">
            {{ $article->title }}
        </h1>

        @if ($article->thumbnail)
            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                class="w-full h-96 object-cover rounded-2xl mb-8">
        @endif

        <div class="flex items-center gap-8 mb-6">
            <div>
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mb-1">
                    Author
                </p>
                <p class="text-stone-600 text-sm">{{ $article->author->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-widest mb-1">
                    Published On
                </p>
                <p class="text-stone-600 text-sm">
                    {{ $article->published_at->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>

        <div class="prose prose-stone prose-lg max-w-none">
            {!! $article->content !!}
        </div>

    </article>

    {{-- Previous / Next --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-b border-stone-300 py-8 grid grid-cols-2 gap-4">
            <div>
                @if ($previous)
                    <a href="{{ route('articles.show', $previous->slug) }}" class="group flex items-start gap-3">
                        <span
                            class="text-stone-400 group-hover:text-green-700
                             transition text-lg leading-none mt-0.5">←</span>
                        <div>
                            <p
                                class="text-xs font-semibold text-stone-400 uppercase
                               tracking-widest mb-1">
                                Sebelumnya</p>
                            <p
                                class="text-stone-700 font-medium text-sm leading-snug
                               group-hover:text-green-700 transition line-clamp-2">
                                {{ $previous->title }}
                            </p>
                        </div>
                    </a>
                @endif
            </div>
            <div class="text-right">
                @if ($next)
                    <a href="{{ route('articles.show', $next->slug) }}" class="group flex items-start justify-end gap-3">
                        <div>
                            <p
                                class="text-xs font-semibold text-stone-400 uppercase
                               tracking-widest mb-1">
                                Berikutnya</p>
                            <p
                                class="text-stone-700 font-medium text-sm leading-snug
                               group-hover:text-green-700 transition line-clamp-2">
                                {{ $next->title }}
                            </p>
                        </div>
                        <span
                            class="text-stone-400 group-hover:text-green-700
                             transition text-lg leading-none mt-0.5">→</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- You May Also Like --}}
    @if ($related->count())
        <section class="bg-stone-50 py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-xs font-semibold text-green-700 uppercase tracking-[0.15em] mb-1">
                    Baca Juga
                </p>
                <h2 class="text-xl font-bold text-stone-900 mb-6">Artikel Lainnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($related as $item)
                        <a href="{{ route('articles.show', $item->slug) }}"
                            class="bg-white border border-stone-300 overflow-hidden
                      group hover:border-green-600 transition">
                            @if ($item->thumbnail)
                                <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}"
                                    class="w-full h-44 object-cover">
                            @else
                                <div
                                    class="w-full h-44 bg-green-900
                            flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <p class="text-xs text-stone-400 uppercase tracking-widest mb-2">
                                    {{ $item->published_at->format('d M Y') }}
                                </p>
                                <h3
                                    class="font-bold text-stone-800 text-sm leading-snug
                               group-hover:text-green-700 transition line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Komentar --}}
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="border-t border-stone-300 pt-12">

            <h2 class="text-xl font-bold text-stone-800 mb-8">
                Komentar
                @if ($article->comments->count())
                    <span class="text-sm font-normal text-stone-400 ml-2">
                        {{ $article->comments->count() }} komentar
                    </span>
                @endif
            </h2>

            {{-- Daftar Komentar --}}
            @if ($article->comments->count())
                <div class="space-y-6 mb-12">
                    @foreach ($article->comments as $comment)
                        <div class="flex gap-4">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100
                            flex items-center justify-center text-green-700
                            font-bold text-sm">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-stone-800 text-sm">
                                        {{ $comment->name }}
                                    </span>
                                    <span class="text-stone-400 text-xs">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-stone-600 text-sm leading-relaxed">
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 text-stone-400 mb-12">
                    <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                </div>
            @endif

            {{-- Form komentar --}}
            <div class="border border-stone-300 p-6 bg-stone-50">
                <h3 class="font-bold text-stone-800 mb-5">Tulis Komentar</h3>

                @if (session('comment_success'))
                    <div
                        class="bg-green-50 border border-green-200 text-green-700
                    text-sm px-4 py-3 mb-5">
                        {{ session('comment_success') }}
                    </div>
                @endif

                <form action="{{ route('articles.comment.store', $article->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-stone-600
                                  uppercase tracking-widest mb-2">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama kamu"
                                class="w-full border border-stone-300 px-4 py-2.5 text-sm
                                  bg-white focus:outline-none focus:ring-2
                                  focus:ring-green-500 transition
                                  @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-stone-600
                                  uppercase tracking-widest mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                                class="w-full border border-stone-300 px-4 py-2.5 text-sm
                                  bg-white focus:outline-none focus:ring-2
                                  focus:ring-green-500 transition
                                  @error('email') border-red-400 @enderror">
                            <p class="text-xs text-stone-400 mt-1">
                                Email tidak akan ditampilkan ke publik.
                            </p>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-stone-600
                              uppercase tracking-widest mb-2">
                            Komentar <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content" rows="4" placeholder="Tulis komentar kamu di sini..."
                            class="w-full border border-stone-300 px-4 py-2.5 text-sm
                                 bg-white focus:outline-none focus:ring-2
                                 focus:ring-green-500 transition resize-none
                                 @error('content') border-red-400 @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white
                           font-semibold px-6 py-2.5 text-sm transition">
                        Kirim Komentar
                    </button>
                </form>
            </div>

        </div>
    </section>

@endsection
