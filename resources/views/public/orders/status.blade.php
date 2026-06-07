@extends('layouts.public')

@section('title', 'Status Pesanan ' . $order->order_number)

@section('content')

<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    @php
        $statusConfig = [
            'pending'   => ['label' => 'Menunggu Konfirmasi', 'color' => 'amber',  'icon' => '⏳'],
            'confirmed' => ['label' => 'Pembayaran Dikonfirmasi', 'color' => 'green', 'icon' => '✅'],
            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'red',   'icon' => '❌'],
            'expired'   => ['label' => 'Kedaluwarsa', 'color' => 'stone', 'icon' => '🕒'],
        ];
        $s = $statusConfig[$order->status];
    @endphp

    <div class="text-center mb-8">
        <p class="text-4xl mb-3">{{ $s['icon'] }}</p>
        <h1 class="text-2xl font-bold text-stone-800">{{ $s['label'] }}</h1>
        <p class="text-stone-500 mt-1">Nomor Order: <strong>{{ $order->order_number }}</strong></p>
    </div>

    {{-- Detail Order --}}
    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 mb-6">
        <h2 class="font-bold text-stone-800 mb-4">Detail Pesanan</h2>
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
                <span class="text-stone-500">Status</span>
                <span class="font-semibold text-{{ $s['color'] }}-600">{{ $s['label'] }}</span>
            </div>
        </div>

        <div class="border-t border-stone-100 mt-4 pt-4 space-y-2">
            @foreach ($order->items as $item)
            <div class="flex justify-between text-sm">
                <span class="text-stone-600">
                    {{ $item->ticketType->name }} × {{ $item->quantity }}
                </span>
                <span>Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="border-t border-stone-200 mt-4 pt-4 flex justify-between">
            <span class="font-bold text-stone-800">Total</span>
            <span class="font-bold text-amber-600">
                Rp {{ number_format($order->total, 0, ',', '.') }}
            </span>
        </div>
    </div>

    @if ($order->isConfirmed())
    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
        <p class="text-green-700 font-semibold mb-2">E-ticket sudah dikirim ke email kamu!</p>
        <p class="text-green-600 text-sm">{{ $order->visitor_email }}</p>
    </div>
    @elseif ($order->isPending())
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
        <p class="text-amber-700 font-semibold mb-2">Pesanan menunggu konfirmasi pembayaran</p>
        <p class="text-amber-600 text-sm">
            Pastikan kamu sudah mengirim bukti transfer ke WhatsApp pengelola.
        </p>
    </div>
    @endif

    <a href="{{ route('orders.check') }}"
       class="mt-6 block text-center text-sm text-stone-500 hover:text-green-700 transition">
        ← Cek pesanan lain
    </a>

</section>

@endsection