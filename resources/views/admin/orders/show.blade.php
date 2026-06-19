@extends('layouts.admin')

@section('title', 'Detail Order ' . $order->order_number)

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-stone-500 hover:text-green-700 transition">
            ← Kembali ke daftar order
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kiri: Rincian Order --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Info Pemesan --}}
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-stone-800">Informasi Pemesan</h2>
                    @include('admin.partials.status-badge', ['status' => $order->status])
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-stone-400 mb-1">Nama</p>
                        <p class="font-medium text-stone-800">{{ $order->visitor_name }}</p>
                    </div>
                    <div>
                        <p class="text-stone-400 mb-1">Nomor WhatsApp</p>
                        <p class="font-medium text-stone-800">{{ $order->visitor_phone }}</p>
                    </div>
                    <div>
                        <p class="text-stone-400 mb-1">Email</p>
                        <p class="font-medium text-stone-800">{{ $order->visitor_email }}</p>
                    </div>
                    <div>
                        <p class="text-stone-400 mb-1">Tanggal Kunjungan</p>
                        <p class="font-medium text-stone-800">
                            {{ $order->visit_date->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-stone-400 mb-1">Tanggal Pesan</p>
                        <p class="font-medium text-stone-800">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    @if ($order->confirmed_at)
                        <div>
                            <p class="text-stone-400 mb-1">Dikonfirmasi</p>
                            <p class="font-medium text-green-700">
                                {{ $order->confirmed_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Rincian Tiket --}}
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <h2 class="font-bold text-stone-800 mb-4">Rincian Tiket</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div
                            class="flex justify-between items-center py-3
                            border-b border-stone-50 last:border-0">
                            <div>
                                <p class="font-medium text-stone-800">{{ $item->ticketType->name }}</p>
                                <p class="text-xs text-stone-400">
                                    Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}
                                    × {{ $item->quantity }}
                                </p>
                            </div>
                            <p class="font-semibold text-stone-700">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-stone-200">
                    <span class="font-bold text-stone-800">Total Pembayaran</span>
                    <span class="text-xl font-bold text-amber-600">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Bukti Bayar --}}
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <h2 class="font-bold text-stone-800 mb-4">Bukti Pembayaran</h2>

                @if ($order->payment_proof)
                    <div class="mb-4">
                        <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran"
                            onclick="document.getElementById('modal-bukti').classList.remove('hidden')"
                            class="max-h-64 rounded-xl border border-stone-200 object-contain
                            cursor-pointer hover:opacity-90 transition">
                        <p class="text-xs text-stone-400 mt-2">Klik gambar untuk memperbesar</p>
                    </div>

                    <a href="{{ Storage::url($order->payment_proof) }}" download
                        class="inline-flex items-center gap-2 bg-stone-100 hover:bg-stone-200
                      text-stone-700 text-sm font-medium px-4 py-2 rounded-lg transition mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Bukti Pembayaran
                    </a>

                    {{-- Modal lightbox --}}
                    <div id="modal-bukti"
                        class="hidden fixed inset-0 z-50 bg-black/80 flex items-center
                        justify-center p-4"
                        onclick="this.classList.add('hidden')">
                        <div class="relative max-w-3xl w-full">
                            <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran"
                                class="w-full max-h-[85vh] object-contain rounded-xl">
                            <button onclick="document.getElementById('modal-bukti').classList.add('hidden')"
                                class="absolute top-3 right-3 bg-white/20 hover:bg-white/40
                                   text-white w-8 h-8 rounded-full flex items-center
                                   justify-center transition text-lg font-bold">
                                ✕
                            </button>
                            <p class="text-center text-white/50 text-xs mt-3">
                                Klik di mana saja untuk menutup
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-stone-400 text-sm mb-4">Belum ada bukti pembayaran diunggah.</p>
                @endif

                @if ($order->isPending())
                    <form action="{{ route('admin.orders.proof', $order) }}" method="POST" enctype="multipart/form-data"
                        class="{{ $order->payment_proof ? 'mt-4 border-t border-stone-100 pt-4' : '' }}">
                        @csrf

                        <div id="preview-container" class="hidden mb-4">
                            <img id="preview-image" src="" alt="Preview Bukti"
                                class="max-h-48 rounded-xl border border-stone-200 object-contain">
                            <p class="text-xs text-stone-400 mt-1">Preview bukti yang akan diupload</p>
                        </div>

                        <div class="flex gap-3">
                            <input type="file" name="payment_proof" id="payment_proof_input" accept=".jpg,.jpeg,.png"
                                class="flex-1 text-sm text-stone-600 file:mr-3 file:py-2
                                  file:px-4 file:rounded-lg file:border-0
                                  file:bg-stone-100 file:text-stone-700
                                  file:font-medium file:text-sm
                                  hover:file:bg-stone-200 transition">
                            <button type="submit"
                                class="bg-stone-700 hover:bg-stone-800 text-white
                                   text-sm font-medium px-4 py-2 rounded-lg transition">
                                Upload
                            </button>
                        </div>
                        @error('payment_proof')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </form>

                    <script>
                        document.getElementById('payment_proof_input').addEventListener('change', function(e) {
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

        </div>

        {{-- Kanan: Aksi --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <h2 class="font-bold text-stone-800 mb-4">Aksi</h2>

                @if ($order->isPending())
                    <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" onclick="return confirm('Konfirmasi pembayaran order ini?')"
                            class="w-full bg-green-700 hover:bg-green-800 text-white
                               font-semibold py-3 rounded-xl transition text-sm">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Batalkan order ini?')"
                            class="w-full bg-red-50 hover:bg-red-100 text-red-600
                               font-semibold py-3 rounded-xl transition text-sm">
                            Batalkan Order
                        </button>
                    </form>
                @elseif ($order->isConfirmed())
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <p class="text-green-700 text-sm font-medium">Order sudah dikonfirmasi</p>
                        <p class="text-green-500 text-xs mt-1">
                            E-ticket dikirim ke {{ $order->visitor_email }}
                        </p>
                    </div>
                @else
                    <div class="bg-stone-50 rounded-xl p-4 text-center">
                        <p class="text-stone-500 text-sm">Tidak ada aksi tersedia</p>
                    </div>
                @endif
            </div>

            {{-- Nomor Order --}}
            <div class="bg-stone-50 rounded-2xl border border-stone-100 p-5">
                <p class="text-xs text-stone-400 mb-1">Nomor Order</p>
                <p class="font-mono font-bold text-stone-800 text-lg">
                    {{ $order->order_number }}
                </p>
            </div>
        </div>

    </div>

@endsection
