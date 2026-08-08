@extends('layouts.public')

@section('title', 'Pemesanan Berhasil')

@section('content')

    @push('head')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-green-100
                    rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-stone-800">Pesanan Berhasil Dibuat!</h1>
            <p class="text-stone-500 mt-2">
                Selesaikan pembayaran dan upload bukti transfer di bawah ini.
            </p>
        </div>

        {{-- Nomor Order --}}
        <div class="bg-green-700 text-white p-6 text-center mb-6">
            <p class="text-green-200 text-sm mb-1">Nomor Order Kamu</p>
            <p class="text-3xl font-bold tracking-widest">{{ $order->order_number }}</p>
            <p class="text-green-200 text-xs mt-2">Simpan nomor ini untuk mengecek status pesanan</p>
        </div>

        {{-- Peringatan --}}
        <div class="bg-amber-50 border border-amber-200 px-5 py-4 mb-6 flex gap-3 items-start">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
            <div class="text-sm text-amber-800">
                <p class="font-semibold mb-1">Simpan nomor order sebelum menutup halaman ini.</p>
                <p>Nomor order diperlukan untuk mengecek status pesanan. Screenshot halaman ini atau catat nomor order di
                    atas sebelum melanjutkan.</p>
            </div>
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
                        Upload
                        <span class="font-bold text-amber-900">foto bukti transfer</span>
                        melalui form di bawah ini.
                    </div>
                </div>
                <div class="flex gap-4 px-6 py-4">
                    <span
                        class="flex-shrink-0 w-7 h-7 bg-amber-500 text-white rounded-full
                             flex items-center justify-center text-xs font-bold mt-0.5">
                        3
                    </span>
                    <div class="text-sm text-amber-800 leading-relaxed">
                        Pengelola akan memverifikasi bukti transfer dan mengkonfirmasi pesanan kamu.
                        Tunjukkan nomor order saat tiba di lokasi.
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Upload Bukti Pembayaran --}}
        <div class="bg-white border border-stone-300 p-6 mb-6">
            <h2 class="font-bold text-stone-800 mb-1">Upload Bukti Pembayaran</h2>
            <p class="text-stone-400 text-sm mb-5">
                Upload foto atau screenshot bukti transfer kamu di sini.
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

            @if (!$order->isConfirmed())
                <form action="{{ route('orders.uploadProof', $order->order_number) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Preview --}}
                    <div id="preview-container" class="hidden mb-4">
                        <img id="preview-image" src="" alt="Preview"
                            class="max-h-48 border border-stone-200 object-contain">
                        <p class="text-xs text-stone-400 mt-1">Preview bukti yang akan diupload</p>
                    </div>

                    <div class="flex gap-3">
                        <input type="file" name="payment_proof" id="proof-input" accept=".jpg,.jpeg,.png"
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
                    document.getElementById('proof-input').addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('preview-image').src = e.target.result;
                            document.getElementById('preview-container').classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    });
                </script>
            @endif
        </div>

        <a href="{{ route('orders.check') }}"
            class="block text-center text-sm text-stone-500 hover:text-green-700 transition">
            Cek status pesanan nanti →
        </a>

    </section>

@endsection
