@extends('layouts.public')

@section('title', 'Harga Tiket')

@section('content')

    <section class="bg-green-800 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-3">Harga Tiket Masuk</h1>
            <p class="text-green-200">Tersedia untuk wisatawan asing, domestik, dan warga lokal Bali</p>
        </div>
    </section>

    <section class="py-16 bg-stone-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
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
                                <p class="text-xs text-stone-400 mt-0.5">per orang · sudah termasuk pajak</p>
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

            {{-- Informasi penting --}}
            <div class="border border-amber-200 bg-amber-50 p-6">
                <h3 class="font-semibold text-amber-800 mb-3">Informasi Penting</h3>
                <ul class="text-sm text-amber-700 space-y-2">
                    <li>• Harga tiket sudah termasuk pajak dan biaya layanan.</li>
                    <li>• Tiket anak berlaku untuk usia di bawah 12 tahun.</li>
                    <li>• Tiket Lokal/Bali berlaku untuk pemegang KTP Bali.</li>
                    <li>• E-ticket akan dikirim ke email setelah pembayaran dikonfirmasi.</li>
                </ul>
            </div>

        </div>
    </section>

@endsection
