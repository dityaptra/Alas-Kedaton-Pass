@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

    {{-- Hero --}}
    <section class="relative text-white overflow-hidden">
        <div class="relative h-[90vh] min-h-[560px] max-h-[800px]">
            <img src="/images/alas-kedaton-hero.webp" alt="Wisata Alas Kedaton"
                class="absolute inset-0 w-full h-full object-cover">
            {{-- Gradient overlay dari bawah agar teks atas tetap terlihat --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10"></div>

            {{-- Konten di tengah bawah --}}
            <div
                class="absolute bottom-0 left-0 right-0 z-10 pb-16 px-4 sm:px-10 lg:px-20
                    max-w-6xl mx-auto">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold leading-none mb-5">
                    Alas Kedaton
                </h1>
                <p class="text-stone-300 text-base sm:text-lg max-w-xl mb-8 leading-relaxed">
                    Selamat datang di Alas Kedaton, rumah bagi ribuan kera ekor panjang
                    dan pura bersejarah yang menarik.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('orders.create') }}"
                        class="bg-amber-500 hover:bg-amber-400 text-white font-semibold
                          px-7 py-3 transition text-sm uppercase tracking-wider">
                        Beli Tiket
                    </a>
                    <a href="{{ route('tickets.index') }}"
                        class="border border-white/40 hover:border-white text-white
                          font-medium px-7 py-3 transition text-sm uppercase tracking-wider">
                        Lihat Harga
                    </a>
                </div>
            </div>

            {{-- Info strip di pojok kanan bawah --}}
            <div
                class="absolute bottom-0 right-0 z-10 pb-16 pr-4 sm:pr-10 lg:pr-20
                    hidden lg:flex flex-col gap-2 text-right">
                <p class="text-white/50 text-xs uppercase tracking-widest">Buka setiap hari</p>
                <p class="text-white font-semibold text-sm">08.00 - 18.00 WITA</p>
            </div>
        </div>
    </section>

    {{-- Strip fakta singkat --}}
    <section class="bg-green-800 text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 divide-x divide-green-600">
                <div class="py-6 px-6 sm:px-10">
                    <p class="text-white text-2xl sm:text-3xl font-bold mb-1">100rb+</p>
                    <p class="text-green-200 text-xs sm:text-sm">Pengunjung per tahun</p>
                </div>
                <div class="py-6 px-6 sm:px-10">
                    <p class="text-white text-2xl sm:text-3xl font-bold mb-1">5 Jenis</p>
                    <p class="text-green-200 text-xs sm:text-sm">Kategori tiket tersedia</p>
                </div>
                <div class="py-6 px-6 sm:px-10">
                    <p class="text-white text-2xl sm:text-3xl font-bold mb-1">Rp 10rb</p>
                    <p class="text-green-200 text-xs sm:text-sm">Tiket mulai dari</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Tiket --}}
    <section class="py-20 bg-stone-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                <div>
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-[0.15em] mb-2">
                        Tiket Masuk
                    </p>
                    <h2 class="text-3xl sm:text-4xl font-bold text-stone-900 leading-tight">
                        Harga yang transparan,<br>tanpa biaya tersembunyi
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($tickets as $ticket)
                    <div
                        class="bg-white p-7 flex flex-col gap-4 border border-stone-400
                        hover:border-green-600 hover:shadow-sm transition">
                        <div>
                            <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">
                                {{ $ticket->category === 'asing' ? 'Wisatawan Asing' : ($ticket->category === 'domestik' ? 'Wisatawan Domestik' : 'Warga Lokal') }}
                            </p>
                            <h3 class="text-lg font-bold text-stone-800">{{ $ticket->name }}</h3>
                        </div>
                        <p class="text-stone-400 text-sm leading-relaxed flex-1">
                            {{ $ticket->description ?? 'Tiket masuk Wisata Alas Kedaton.' }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-stone-400">
                            <div>
                                <p class="text-2xl font-bold text-stone-900">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-stone-400 mt-0.5">per orang | sudah termasuk pajak</p>
                            </div>
                            <a href="{{ route('orders.create') }}"
                                class="text-green-700 hover:text-green-800 text-sm font-semibold
                              transition flex items-center gap-1">
                                Pesan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach

                {{-- Pengisi agar baris terakhir tetap 3 kolom --}}
                @if ($tickets->count() % 3 === 2)
                    <div class="hidden sm:block"></div>
                @endif
            </div>

        </div>
    </section>

    {{-- Cara pesan --}}
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div>
                    <p class="text-green-700 text-xs font-semibold uppercase tracking-[0.15em] mb-3">
                        Cara Pesan
                    </p>
                    <h2 class="text-3xl sm:text-4xl font-bold text-stone-900 leading-tight mb-6">
                        Pesan dari rumah,<br>langsung masuk saat tiba
                    </h2>
                    <p class="text-stone-500 leading-relaxed mb-10">
                        Tidak perlu antre di loket. Isi form, selesaikan pembayaran,
                        dan tunjukkan e-ticket saat masuk.
                    </p>
                    <a href="{{ route('orders.create') }}"
                        class="inline-flex items-center gap-2 bg-green-700 hover:bg-green-800
                          text-white font-medium px-7 py-3 transition text-sm">
                        Mulai Pesan
                    </a>
                </div>

                <div class="flex flex-col gap-0 border border-stone-100">
                    <div class="flex gap-5 p-6 border-b border-stone-100">
                        <span class="text-3xl font-bold text-stone-200 leading-none flex-shrink-0">01</span>
                        <div>
                            <p class="font-semibold text-stone-800 mb-1">Isi data & pilih tiket</p>
                            <p class="text-stone-400 text-sm leading-relaxed">
                                Masukkan nama, email, tanggal kunjungan, dan pilih jenis tiket yang sesuai.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-5 p-6 border-b border-stone-100">
                        <span class="text-3xl font-bold text-stone-200 leading-none flex-shrink-0">02</span>
                        <div>
                            <p class="font-semibold text-stone-800 mb-1">Transfer & konfirmasi via WA</p>
                            <p class="text-stone-400 text-sm leading-relaxed">
                                Transfer sesuai total, lalu kirim bukti ke WhatsApp pengelola beserta nomor order.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-5 p-6">
                        <span class="text-3xl font-bold text-stone-200 leading-none flex-shrink-0">03</span>
                        <div>
                            <p class="font-semibold text-stone-800 mb-1">Terima e-ticket</p>
                            <p class="text-stone-400 text-sm leading-relaxed">
                                E-ticket dikirim ke email setelah pembayaran dikonfirmasi. Tunjukkan saat masuk.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Berita --}}
    @if ($articles->count())
        <section class="py-20 bg-stone-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex items-end justify-between mb-12">
                    <div>
                        <p class="text-green-700 text-xs font-semibold uppercase tracking-[0.15em] mb-2">
                            Berita & Info
                        </p>
                        <h2 class="text-3xl sm:text-4xl font-bold text-stone-900">
                            Kabar terkini dari<br>Alas Kedaton
                        </h2>
                    </div>
                    <a href="{{ route('articles.index') }}"
                        class="text-sm text-stone-500 hover:text-green-700 transition
                      hidden sm:flex items-center gap-1 font-medium">
                        Semua berita
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="bg-white border border-stone-300 overflow-hidden group">
                            @if ($article->thumbnail)
                                <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                    class="w-full h-52 object-cover">
                            @else
                                <div
                                    class="w-full h-52 bg-gradient-to-br from-green-900 to-green-700
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
                                <h3
                                    class="font-bold text-stone-800 leading-snug mb-3 line-clamp-2
                       group-hover:text-green-700 transition">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-stone-400 text-sm leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($article->content), 90) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-8 sm:hidden">
                    <a href="{{ route('articles.index') }}"
                        class="text-green-700 text-sm font-medium hover:text-green-800 transition">
                        Semua berita→
                    </a>
                </div>

            </div>
        </section>
    @endif

    {{-- Peta --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-stone-900">Lokasi Alas Kedaton</h2>
            </div>
            <div class="overflow-hidden border border-stone-200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3416.532535999096!2d115.149883988855!3d-8.527533800000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23b164d2a8bb3%3A0x118812004a86244b!2sAlas%20Kedaton!5e1!3m2!1sid!2sid!4v1780797673656!5m2!1sid!2sid"
                    width="100%" height="580" style="border:0; display:block;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="Lokasi Wisata Alas Kedaton">
                </iframe>
            </div>
        </div>
    </section>

@endsection
