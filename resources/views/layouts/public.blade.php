<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-800 font-sans antialiased">

    {{-- Navbar --}}
    <header class="bg-white shadow-sm sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="text-green-700 font-bold text-xl tracking-tight">
                        AlasKedaton<span class="text-amber-600">Pass</span>
                    </span>
                </a>

                {{-- Nav Desktop --}}
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                    <a href="{{ route('home') }}"
                        class="text-stone-600 hover:text-green-700 transition
                              {{ request()->routeIs('home') ? 'text-green-700 font-semibold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tickets.index') }}"
                        class="text-stone-600 hover:text-green-700 transition
                              {{ request()->routeIs('tickets.*') ? 'text-green-700 font-semibold' : '' }}">
                        Tiket
                    </a>
                    <a href="{{ route('articles.index') }}"
                        class="text-stone-600 hover:text-green-700 transition
                              {{ request()->routeIs('articles.*') ? 'text-green-700 font-semibold' : '' }}">
                        Berita
                    </a>
                    <a href="{{ route('orders.check') }}"
                        class="text-stone-600 hover:text-green-700 transition
                              {{ request()->routeIs('orders.check*') ? 'text-green-700 font-semibold' : '' }}">
                        Cek Pesanan
                    </a>
                    <a href="{{ route('orders.create') }}"
                        class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm
                              hover:bg-green-800 transition font-medium">
                        Beli Tiket
                    </a>
                </nav>

                {{-- Hamburger Mobile --}}
                <button @click="open = !open" class="md:hidden p-2 rounded-lg text-stone-600 hover:bg-stone-100">
                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Nav Mobile --}}
            <div x-show="open" x-transition class="md:hidden pb-4 space-y-1">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-lg text-stone-600 hover:bg-stone-100 text-sm">
                    Beranda
                </a>
                <a href="{{ route('tickets.index') }}"
                    class="block px-3 py-2 rounded-lg text-stone-600 hover:bg-stone-100 text-sm">
                    Tiket
                </a>
                <a href="{{ route('articles.index') }}"
                    class="block px-3 py-2 rounded-lg text-stone-600 hover:bg-stone-100 text-sm">
                    Berita
                </a>
                <a href="{{ route('orders.check') }}"
                    class="block px-3 py-2 rounded-lg text-stone-600 hover:bg-stone-100 text-sm">
                    Cek Pesanan
                </a>
                <a href="{{ route('orders.create') }}"
                    class="block px-3 py-2 rounded-lg bg-green-700 text-white text-sm font-medium text-center mt-2">
                    Beli Tiket
                </a>
            </div>
        </div>
    </header>

    {{-- Konten Utama --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="background-color: #1e4d2b;" class="text-white mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <h3 class="text-white font-bold text-lg mb-3">
                        AlasKedaton<span class="text-amber-400">Pass</span>
                    </h3>
                    <p class="text-sm leading-relaxed text-white/80">
                        Platform pembelian tiket online Wisata Alas Kedaton,
                        Tabanan, Bali.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3">Informasi</h4>
                    <ul class="space-y-2 text-sm text-white/80">
                        <li>Jl. Raya Kukuh, Tabanan, Bali</li>
                        <li>Buka setiap hari: 08.00 – 18.00 WITA</li>
                        <li>
                            <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}" target="_blank"
                                class="hover:text-white transition">
                                Hubungi kami via WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 mt-8 pt-6 text-center text-xs text-white/60">
                &copy; {{ date('Y') }} AlasKedatonPass. Hak cipta dilindungi.
            </div>
        </div>
    </footer>

</body>

</html>
