@extends('layouts.public')

@section('title', 'Pesan Tiket')

@section('content')

<section class="bg-green-800 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Pesan Tiket</h1>
        <p class="text-green-200">Isi data di bawah ini untuk melanjutkan pemesanan</p>
    </div>
</section>

<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <form action="{{ route('orders.store') }}" method="POST" x-data="orderForm()">
        @csrf

        {{-- Data Pemesan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-8 mb-6">
            <h2 class="text-lg font-bold text-stone-800 mb-6">Data Pemesan</h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="visitor_name"
                           value="{{ old('visitor_name') }}"
                           placeholder="Masukkan nama lengkap"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  @error('visitor_name') border-red-400 @enderror">
                    @error('visitor_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Nomor WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="visitor_phone"
                           value="{{ old('visitor_phone') }}"
                           placeholder="Contoh: 08123456789"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  @error('visitor_phone') border-red-400 @enderror">
                    @error('visitor_phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="visitor_email"
                           value="{{ old('visitor_email') }}"
                           placeholder="Contoh: nama@email.com"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  @error('visitor_email') border-red-400 @enderror">
                    <p class="text-xs text-stone-400 mt-1">E-ticket akan dikirim ke alamat ini.</p>
                    @error('visitor_email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Tanggal Kunjungan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="visit_date"
                           value="{{ old('visit_date') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-green-500
                                  @error('visit_date') border-red-400 @enderror">
                    @error('visit_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Pilih Tiket --}}
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-8 mb-6">
            <h2 class="text-lg font-bold text-stone-800 mb-6">Pilih Tiket</h2>

            @error('tickets')
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm
                        rounded-xl px-4 py-3 mb-4">
                {{ $message }}
            </div>
            @enderror

            <div class="space-y-4">
                @foreach ($tickets as $index => $ticket)
                <div class="flex items-center justify-between py-4 border-b border-stone-100 last:border-0">
                    <div class="flex-1">
                        <input type="hidden"
                               name="tickets[{{ $index }}][ticket_type_id]"
                               value="{{ $ticket->id }}">
                        <p class="font-medium text-stone-800">{{ $ticket->name }}</p>
                        <p class="text-amber-600 font-bold">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            <span class="text-stone-400 font-normal text-xs">/orang</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button"
                                @click="decrement({{ $index }})"
                                class="w-8 h-8 rounded-full border border-stone-300
                                       text-stone-600 hover:bg-stone-100 transition
                                       flex items-center justify-center font-bold">
                            −
                        </button>
                        <span x-text="quantities[{{ $index }}]"
                              class="w-6 text-center font-semibold text-stone-800">
                        </span>
                        <input type="hidden"
                               :name="'tickets[{{ $index }}][quantity]'"
                               :value="quantities[{{ $index }}]">
                        <button type="button"
                                @click="increment({{ $index }})"
                                class="w-8 h-8 rounded-full border border-stone-300
                                       text-stone-600 hover:bg-stone-100 transition
                                       flex items-center justify-center font-bold">
                            +
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan Total --}}
            <div class="mt-6 bg-stone-50 rounded-xl p-4">
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-stone-700">Total Tiket</span>
                    <span class="font-bold text-stone-800" x-text="totalTickets() + ' tiket'"></span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="font-semibold text-stone-700">Total Harga</span>
                    <span class="text-xl font-bold text-amber-600"
                          x-text="'Rp ' + totalPrice().toLocaleString('id-ID')">
                    </span>
                </div>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold
                       py-4 rounded-xl transition text-lg"
                :disabled="totalTickets() === 0"
                :class="totalTickets() === 0
                    ? 'opacity-50 cursor-not-allowed'
                    : 'opacity-100 cursor-pointer'">
            Lanjutkan Pemesanan
        </button>
    </form>
</section>

<script>
function orderForm() {
    return {
        quantities: @json(array_fill(0, $tickets->count(), 0)),
        prices: @json($tickets->pluck('price')->toArray()),

        increment(index) {
            if (this.quantities[index] < 50) this.quantities[index]++
        },
        decrement(index) {
            if (this.quantities[index] > 0) this.quantities[index]--
        },
        totalTickets() {
            return this.quantities.reduce((a, b) => a + b, 0)
        },
        totalPrice() {
            return this.quantities.reduce((sum, qty, i) => sum + (qty * this.prices[i]), 0)
        }
    }
}
</script>

@endsection