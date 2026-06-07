@extends('layouts.public')

@section('title', 'Harga Tiket')

@section('content')

<section class="bg-green-800 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Harga Tiket Masuk</h1>
        <p class="text-green-200">Tersedia untuk wisatawan asing, domestik, dan warga lokal Bali</p>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($tickets as $ticket)
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100
                    hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="bg-gradient-to-r from-green-700 to-green-600 px-6 py-4">
                <span class="text-green-100 text-xs font-bold uppercase tracking-widest">
                    Tiket Masuk
                </span>
                <h3 class="text-white text-xl font-bold mt-1">{{ $ticket->name }}</h3>
            </div>
            <div class="p-6">
                <p class="text-stone-500 text-sm mb-6 min-h-[40px]">
                    {{ $ticket->description ?? 'Tiket masuk Wisata Alas Kedaton.' }}
                </p>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-3xl font-bold text-amber-600">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-stone-400 mt-1">per orang · sudah termasuk pajak</p>
                    </div>
                </div>
                <a href="{{ route('orders.create') }}"
                   class="mt-6 block w-full text-center bg-green-700 hover:bg-green-800
                          text-white font-semibold py-3 rounded-xl transition">
                    Pesan Sekarang
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-12 bg-amber-50 border border-amber-200 rounded-2xl p-6">
        <h3 class="font-semibold text-amber-800 mb-3">Informasi Penting</h3>
        <ul class="text-sm text-amber-700 space-y-2">
            <li>• Harga tiket sudah termasuk pajak dan biaya layanan.</li>
            <li>• Tiket anak berlaku untuk usia di bawah 12 tahun.</li>
            <li>• Tiket Lokal/Bali berlaku untuk pemegang KTP Bali.</li>
            <li>• E-ticket akan dikirim ke email setelah pembayaran dikonfirmasi.</li>
        </ul>
    </div>
</section>

@endsection