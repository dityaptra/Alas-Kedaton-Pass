@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

    {{-- Hero --}}
    <section class="relative text-white overflow-hidden">

        <div class="relative h-[600px] sm:h-[680px]">
            <img src="/images/alas-kedaton-hero.jpg" alt="Wisata Alas Kedaton"
                class="absolute inset-0 w-full h-full object-cover brightness-50">

            <div
                class="relative z-10 h-full flex flex-col items-center justify-center
                    text-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6 drop-shadow-lg">
                    Selamat Datang di<br>
                    <span class="text-amber-400">Alas Kedaton</span>
                </h1>
                <p class="text-lg text-stone-100 max-w-2xl mb-10 drop-shadow">
                    Hutan suci dengan ribuan kera dan pura bersejarah di jantung Tabanan, Bali.
                    Pesan tiket masuk kamu sekarang secara online.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.create') }}"
                        class="bg-amber-500 hover:bg-amber-600 text-white font-semibold
                          px-8 py-3 rounded-xl transition text-lg shadow-lg">
                        Beli Tiket Sekarang
                    </a>
                    <a href="{{ route('tickets.index') }}"
                        class="bg-white/20 hover:bg-white/30 text-white font-semibold
                          px-8 py-3 rounded-xl transition text-lg backdrop-blur-sm
                          border border-white/30 shadow-lg">
                        Lihat Harga Tiket
                    </a>
                </div>
            </div>
        </div>

    </section>

    {{-- Info Singkat --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-start gap-4">
                <div class="bg-green-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-stone-800">Jam Buka</p>
                    <p class="text-sm text-stone-500">08.00 – 18.00 WITA</p>
                    <p class="text-sm text-stone-500">Setiap hari</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-start gap-4">
                <div class="bg-amber-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-stone-800">Lokasi</p>
                    <p class="text-sm text-stone-500">Jl. Raya Kukuh</p>
                    <p class="text-sm text-stone-500">Tabanan, Bali</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-start gap-4">
                <div class="bg-blue-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-stone-800">Tiket Mulai</p>
                    <p class="text-sm text-stone-500">Rp 10.000/pax</p>
                    <p class="text-sm text-stone-500">Sudah termasuk pajak</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Harga Tiket --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-stone-800">Harga Tiket Masuk</h2>
            <p class="text-stone-500 mt-2">Pilih tiket sesuai kategori kunjunganmu</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tickets as $ticket)
                <div
                    class="bg-white rounded-2xl shadow-sm border border-stone-100
                    hover:shadow-md transition p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="text-xs font-bold uppercase tracking-widest
                             text-green-700 bg-green-50 px-2 py-1 rounded-full">
                            {{ $ticket->category }}
                        </span>
                        @if ($ticket->visitor_type)
                            <span class="text-xs text-stone-400">{{ ucfirst($ticket->visitor_type) }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-stone-800 mb-1">{{ $ticket->name }}</h3>
                    <p class="text-stone-400 text-sm mb-4 flex-1">
                        {{ $ticket->description ?? 'Tiket masuk Wisata Alas Kedaton.' }}
                    </p>
                    <div class="border-t border-stone-100 pt-4 flex items-end justify-between">
                        <div>
                            <p class="text-2xl font-bold text-amber-600">
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-stone-400">per orang · sudah termasuk pajak</p>
                        </div>
                        <a href="{{ route('orders.create') }}"
                            class="bg-green-700 hover:bg-green-800 text-white text-sm
                          font-medium px-4 py-2 rounded-lg transition">
                            Pesan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Berita Terbaru --}}
    @if ($articles->count())
        <section class="bg-stone-100 py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-stone-800">Berita Terbaru</h2>
                        <p class="text-stone-500 mt-1">Info dan kabar terkini dari Alas Kedaton</p>
                    </div>
                    <a href="{{ route('articles.index') }}"
                        class="text-green-700 hover:text-green-800 font-medium text-sm transition hidden sm:block">
                        Lihat semua →
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="bg-white rounded-2xl overflow-hidden shadow-sm
                      hover:shadow-md transition group">
                            @if ($article->thumbnail)
                                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-full h-48 object-cover group-hover:scale-105
                            transition duration-300">
                            @else
                                <div class="w-full h-48 bg-green-100 flex items-center justify-center">
                                    <span class="text-green-300 text-4xl">🌿</span>
                                </div>
                            @endif
                            <div class="p-5">
                                <p class="text-xs text-stone-400 mb-2">
                                    {{ $article->published_at->translatedFormat('d F Y') }}
                                </p>
                                <h3
                                    class="font-semibold text-stone-800 leading-snug
                               group-hover:text-green-700 transition line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-green-800 text-white py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Berkunjung?</h2>
            <p class="text-green-200 mb-8">
                Pesan tiket sekarang dan hindari antrean panjang di lokasi.
            </p>
            <a href="{{ route('orders.create') }}"
                class="inline-block bg-amber-500 hover:bg-amber-600 text-white
                  font-semibold px-10 py-4 rounded-xl transition text-lg">
                Beli Tiket Sekarang
            </a>
        </div>
    </section>

    <section class="bg-stone-100 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl overflow-hidden shadow-sm border border-stone-200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3416.532535999096!2d115.149883988855!3d-8.527533800000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23b164d2a8bb3%3A0x118812004a86244b!2sAlas%20Kedaton!5e1!3m2!1sid!2sid!4v1780797673656!5m2!1sid!2sid"
                    width="100%" height="450" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="Lokasi Wisata Alas Kedaton">
                </iframe>
            </div>

        </div>
    </section>

@endsection
