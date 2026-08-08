@extends('layouts.public')

@section('title', 'Status Pesanan ' . $order->order_number)

@section('content')

    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        @php
            $statusConfig = [
                'pending' => ['label' => 'Menunggu Konfirmasi', 'color' => 'amber'],
                'confirmed' => ['label' => 'Pembayaran Dikonfirmasi', 'color' => 'green'],
                'cancelled' => ['label' => 'Dibatalkan', 'color' => 'red'],
                'expired' => ['label' => 'Kedaluwarsa', 'color' => 'stone'],
            ];
            $s = $statusConfig[$order->status];
        @endphp

        <div class="text-center mb-8">

            {{-- Ikon SVG berdasarkan status --}}
            @if ($order->status === 'confirmed')
                <div
                    class="w-16 h-16 bg-green-100 rounded-full flex items-center
                    justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            @elseif ($order->status === 'pending')
                <div
                    class="w-16 h-16 bg-amber-100 rounded-full flex items-center
                    justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            @elseif ($order->status === 'cancelled')
                <div
                    class="w-16 h-16 bg-red-100 rounded-full flex items-center
                    justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            @else
                <div
                    class="w-16 h-16 bg-stone-100 rounded-full flex items-center
                    justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-stone-800">{{ $s['label'] }}</h1>
            <p class="text-stone-500 mt-1">
                Nomor Order: <strong>{{ $order->order_number }}</strong>
            </p>
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
                    <span class="font-semibold text-{{ $s['color'] }}-600">
                        {{ $s['label'] }}
                    </span>
                </div>
            </div>

            <div class="border-t border-stone-100 mt-4 pt-4 space-y-2">
                @foreach ($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-stone-600">
                            {{ $item->ticketType->name }} × {{ $item->quantity }}
                        </span>
                        <span>
                            Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}
                        </span>
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
                <p class="text-green-700 font-semibold mb-2">Pembayaran sudah dikonfirmasi</p>
                <p class="text-green-600 text-sm">
                    Tunjukkan nomor order ini kepada petugas saat tiba di lokasi.
                </p>
            </div>
        @elseif ($order->isPending())
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-center">
                <p class="text-amber-700 font-semibold mb-2">Pesanan menunggu konfirmasi pembayaran</p>
                <p class="text-amber-600 text-sm">
                    Pastikan kamu sudah mengirim bukti transfer ke WhatsApp pengelola.
                </p>
            </div>
        @endif

        {{-- Form Upload Bukti jika masih pending --}}
        @if ($order->isPending())
            <div class="bg-white border border-stone-300 p-6 mb-6">
                <h2 class="font-bold text-stone-800 mb-1">Upload Bukti Pembayaran</h2>
                <p class="text-stone-400 text-sm mb-5">
                    Sudah transfer tapi belum upload bukti? Upload di sini.
                </p>

                @if (session('proof_success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 text-sm
                px-4 py-3 mb-4">
                        {{ session('proof_success') }}
                    </div>
                @endif

                @if ($order->payment_proof)
                    <div class="mb-4">
                        <p class="text-xs text-stone-500 mb-2">Bukti yang sudah diupload:</p>
                        <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran"
                            class="max-h-48 border border-stone-200 object-contain">
                        <p class="text-xs text-green-600 mt-2 font-medium">
                            Bukti pembayaran sudah diterima. Pesanan kamu sedang diverifikasi.
                        </p>
                    </div>
                @endif

                <form action="{{ route('orders.uploadProof', $order->order_number) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div id="preview-container-status" class="hidden mb-4">
                        <img id="preview-image-status" src="" alt="Preview"
                            class="max-h-48 border border-stone-200 object-contain">
                        <p class="text-xs text-stone-400 mt-1">Preview bukti yang akan diupload</p>
                    </div>

                    <div class="flex gap-3">
                        <input type="file" name="payment_proof" id="proof-input-status" accept=".jpg,.jpeg,.png"
                            class="flex-1 text-sm text-stone-600 file:mr-3 file:py-2
                          file:px-4 file:border-0 file:bg-stone-100
                          file:text-stone-700 file:font-medium file:text-sm
                          hover:file:bg-stone-200 transition">
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white
                           text-sm font-medium px-5 py-2 transition">
                            Upload
                        </button>
                    </div>
                    @error('payment_proof')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>

                <script>
                    document.getElementById('proof-input-status').addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('preview-image-status').src = e.target.result;
                            document.getElementById('preview-container-status').classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    });
                </script>
            </div>
        @endif

        <a href="{{ route('orders.check') }}"
            class="mt-6 block text-center text-sm text-stone-500 hover:text-green-700 transition">
            ← Cek pesanan lain
        </a>

    </section>

@endsection
