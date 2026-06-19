@extends('layouts.public')

@section('title', 'Cek Status Pesanan')

@section('content')

    <section class="bg-green-800 text-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-3">Cek Status Pesanan</h1>
            <p class="text-green-200">Masukkan nomor order dan nomor WhatsApp kamu</p>
        </div>
    </section>

    <section class="max-w-md mx-auto px-4 py-16">
        <div class="bg-white shadow-sm border border-stone-100 p-8">

            @if ($errors->has('not_found'))
                <div
                    class="bg-red-50 border border-red-200 text-red-600 text-sm
                    px-4 py-3 mb-6">
                    {{ $errors->first('not_found') }}
                </div>
            @endif

            <form action="{{ route('orders.check.status') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Nomor Order
                    </label>
                    <input type="text" name="order_number" value="{{ old('order_number') }}"
                        placeholder="Contoh: AK-20260606-0001"
                        class="w-full border border-stone-300 px-4 py-3 text-sm
                              focus:outline-none focus:ring-2 focus:ring-green-500
                              @error('order_number') border-red-400 @enderror">
                    @error('order_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Nomor WhatsApp
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
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white
                           font-bold py-3 transition">
                    Cek Pesanan
                </button>
            </form>
        </div>
    </section>

@endsection
