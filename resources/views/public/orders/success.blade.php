@extends('layouts.public')

@section('title', 'Pemesanan Berhasil')

@section('content')

    @push('head')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-stone-800">Pesanan Berhasil Dibuat!</h1>
            <p class="text-stone-500 mt-2">
                Selesaikan pembayaran untuk mendapatkan e-ticket kamu.
            </p>
        </div>

        {{-- Nomor Order --}}
        <div class="bg-green-700 text-white p-6 text-center mb-6">
            <p class="text-green-200 text-sm mb-1">Nomor Order Kamu</p>
            <p class="text-3xl font-bold tracking-widest">{{ $order->order_number }}</p>
            <p class="text-green-200 text-xs mt-2">Simpan nomor ini untuk mengecek status pesanan</p>
        </div>

        {{-- Rincian Pesanan --}}
        <div class="bg-white shadow-sm border border-stone-300 p-6 mb-6">
            <h2 class="font-bold text-stone-800 mb-4">Rincian Pesanan</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-stone-500">Nama</span>
                    <span class="font-medium">{{ $order->visitor_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Tanggal Kunjungan</span>
                    <span class="font-medium">
                        {{ $order->visit_date->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Email</span>
                    <span class="font-medium">{{ $order->visitor_email }}</span>
                </div>
            </div>

            <div class="border-t border-stone-100 mt-4 pt-4 space-y-2">
                @foreach ($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-600">
                            {{ $item->ticketType->name }} × {{ $item->quantity }}
                        </span>
                        <span class="font-medium">
                            Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-stone-200 mt-4 pt-4 flex justify-between">
                <span class="font-bold text-stone-800">Total Pembayaran</span>
                <span class="font-bold text-xl text-amber-600">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Instruksi Pembayaran --}}
        <div class="border border-amber-200 overflow-hidden mb-6">
            <div class="bg-amber-500 px-6 py-4">
                <h2 class="font-bold text-white text-sm uppercase tracking-widest">
                    Cara Pembayaran
                </h2>
            </div>
            <div class="divide-y divide-amber-100 bg-amber-50">
                <div class="flex gap-4 px-6 py-4">
                    <span
                        class="flex-shrink-0 w-7 h-7 bg-amber-500 text-white rounded-full
                         flex items-center justify-center text-xs font-bold mt-0.5">
                        1
                    </span>
                    <div class="text-sm text-amber-800 leading-relaxed">
                        Transfer sejumlah
                        <span class="font-bold text-amber-900">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                        ke rekening BCA
                        <span class="font-bold text-amber-900">1234567890</span>
                        a/n Pengelola Alas Kedaton.
                    </div>
                </div>
                <div class="flex gap-4 px-6 py-4">
                    <span
                        class="flex-shrink-0 w-7 h-7 bg-amber-500 text-white rounded-full
                         flex items-center justify-center text-xs font-bold mt-0.5">
                        2
                    </span>
                    <div class="text-sm text-amber-800 leading-relaxed">
                        Klik tombol di bawah, lalu kirim pesan beserta
                        <span class="font-bold text-amber-900">foto bukti transfer</span>
                        ke WhatsApp pengelola. Pesan akan terisi otomatis dengan nomor order dan nama kamu.
                    </div>
                </div>
                <div class="flex gap-4 px-6 py-4">
                    <span
                        class="flex-shrink-0 w-7 h-7 bg-amber-500 text-white rounded-full
                         flex items-center justify-center text-xs font-bold mt-0.5">
                        3
                    </span>
                    <div class="text-sm text-amber-800 leading-relaxed">
                        E-ticket akan dikirim ke
                        <span class="font-bold text-amber-900">{{ $order->visitor_email }}</span>
                        setelah pembayaran dikonfirmasi oleh pengelola.
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol WA --}}
        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode(
            'Halo, saya ingin konfirmasi pembayaran order saya.' .
                "\n" .
                'Nomor Order: ' .
                $order->order_number .
                "\n" .
                'Nama: ' .
                $order->visitor_name,
        ) }}"
            target="_blank"
            class="flex items-center justify-center gap-3 w-full bg-green-500
              hover:bg-green-600 text-white font-bold py-4 transition mb-4">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            Kirim Bukti Pembayaran via WhatsApp
        </a>

        <a href="{{ route('orders.check') }}"
            class="block text-center text-sm text-stone-500 hover:text-green-700 transition">
            Cek status pesanan nanti →
        </a>

    </section>

@endsection
