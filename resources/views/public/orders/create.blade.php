@extends('layouts.public')

@section('title', 'Pesan Tiket')

@section('content')

    <section class="bg-green-800 text-white py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-2">Pesan Tiket</h1>
            <p class="text-green-200">Isi data di bawah ini untuk melanjutkan pemesanan</p>
        </div>
    </section>

    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            {{-- Data Pemesan --}}
            <div class="bg-white shadow-sm border border-stone-100 p-8 mb-5">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-stone-800">Data Pemesan</h2>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="visitor_name" value="{{ old('visitor_name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full border border-stone-200  px-4 py-3 text-sm
                                  bg-stone-50 focus:bg-white focus:outline-none
                                  focus:ring-2 focus:ring-green-500 focus:border-transparent
                                  transition placeholder-stone-400
                                  @error('visitor_name') border-red-400 bg-red-50 @enderror">
                        @error('visitor_name')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">
                                Nomor WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2
                                         text-stone-400 text-sm font-medium">+62</span>
                                <input type="text" name="visitor_phone" value="{{ old('visitor_phone') }}"
                                    placeholder="81234567890"
                                    class="w-full border border-stone-200 pl-12 pr-4
                                          py-3 text-sm bg-stone-50 focus:bg-white focus:outline-none
                                          focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition placeholder-stone-400
                                          @error('visitor_phone') border-red-400 bg-red-50 @enderror">
                            </div>
                            @error('visitor_phone')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1.5">
                                Tanggal Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="visit_date" value="{{ old('visit_date') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full border border-stone-200 px-4 py-3
                                      text-sm bg-stone-50 focus:bg-white focus:outline-none
                                      focus:ring-2 focus:ring-green-500 focus:border-transparent
                                      transition text-stone-700
                                      @error('visit_date') border-red-400 bg-red-50 @enderror">
                            @error('visit_date')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1.5">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="visitor_email" value="{{ old('visitor_email') }}"
                            placeholder="nama@email.com"
                            class="w-full border border-stone-200 px-4 py-3 text-sm
                                  bg-stone-50 focus:bg-white focus:outline-none
                                  focus:ring-2 focus:ring-green-500 focus:border-transparent
                                  transition placeholder-stone-400
                                  @error('visitor_email') border-red-400 bg-red-50 @enderror">
                        <p class="text-xs text-stone-400 mt-1.5">
                            E-ticket akan dikirim ke alamat ini setelah pembayaran dikonfirmasi
                        </p>
                        @error('visitor_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Pilih Tiket --}}
            <div class="bg-white shadow-sm border border-stone-100 p-8 mb-5">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-amber-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-stone-800">Pilih Tiket</h2>
                </div>

                @error('tickets')
                    <div
                        class="bg-red-50 border border-red-200 text-red-600 text-sm
                        px-4 py-3 mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <div class="divide-y divide-stone-100">
                    @foreach ($tickets as $index => $ticket)
                        <div class="flex items-center justify-between py-4">
                            <div>
                                <input type="hidden" name="tickets[{{ $index }}][ticket_type_id]"
                                    value="{{ $ticket->id }}">
                                <input type="hidden" id="qty-{{ $index }}"
                                    name="tickets[{{ $index }}][quantity]" value="0">
                                <p class="font-medium text-stone-800 text-sm">{{ $ticket->name }}</p>
                                <p class="text-amber-600 font-bold text-sm mt-0.5">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                    <span class="text-stone-400 font-normal text-xs">/orang</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="changeQty({{ $index }}, -1)"
                                    class="w-8 h-8 bg-stone-100 hover:bg-stone-200
                                       text-stone-600 transition flex items-center justify-center
                                       text-lg font-medium leading-none">
                                    −
                                </button>
                                <span id="display-{{ $index }}"
                                    class="w-6 text-center font-semibold text-stone-800 text-sm">
                                    0
                                </span>
                                <button type="button" onclick="changeQty({{ $index }}, 1)"
                                    class="w-8 h-8 bg-stone-100 hover:bg-stone-200
                                       text-stone-600 transition flex items-center justify-center
                                       text-lg font-medium leading-none">
                                    +
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan --}}
                <div class="mt-4 bg-stone-50 p-4 space-y-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-stone-500">Total Tiket</span>
                        <span id="total-tiket" class="font-semibold text-stone-700">0 tiket</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-stone-500">Total Harga</span>
                        <span id="total-harga" class="text-lg font-bold text-amber-600">Rp 0</span>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold
                       py-4 transition text-base flex items-center
                       justify-center gap-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                             M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lanjutkan Pemesanan
            </button>

        </form>
    </section>

    <script>
        const prices = @json($tickets->pluck('price')->values()->toArray());
        const quantities = new Array(prices.length).fill(0);

        function changeQty(index, delta) {
            const newVal = quantities[index] + delta;
            if (newVal < 0 || newVal > 50) return;

            quantities[index] = newVal;
            document.getElementById('qty-' + index).value = newVal;
            document.getElementById('display-' + index).textContent = newVal;

            updateSummary();
        }

        function updateSummary() {
            const totalTiket = quantities.reduce((a, b) => a + b, 0);
            const totalHarga = quantities.reduce((sum, qty, i) => sum + (qty * prices[i]), 0);

            document.getElementById('total-tiket').textContent = totalTiket + ' tiket';
            document.getElementById('total-harga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
        }
    </script>

@endsection
