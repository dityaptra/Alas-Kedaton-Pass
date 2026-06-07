@extends('layouts.admin')

@section('title', 'Kelola Order')

@section('content')

{{-- Filter Status --}}
<div class="flex gap-2 mb-6 flex-wrap">
    @foreach (['all' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'cancelled' => 'Dibatalkan'] as $value => $label)
    <a href="{{ route('admin.orders.index', ['status' => $value]) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition
              {{ $status === $value
                  ? 'bg-green-700 text-white'
                  : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-stone-100">
                    <th class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">Nomor Order</th>
                    <th class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">Pemesan</th>
                    <th class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden md:table-cell">
                        Kunjungan
                    </th>
                    <th class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden lg:table-cell">
                        Total
                    </th>
                    <th class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">Status</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                @forelse ($orders as $order)
                <tr class="hover:bg-stone-50 transition">
                    <td class="px-6 py-4 font-mono font-medium text-stone-700">
                        {{ $order->order_number }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-stone-800">{{ $order->visitor_name }}</p>
                        <p class="text-stone-400 text-xs">{{ $order->visitor_phone }}</p>
                    </td>
                    <td class="px-6 py-4 text-stone-500 hidden md:table-cell">
                        {{ $order->visit_date->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 font-medium text-stone-700 hidden lg:table-cell">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @include('admin.partials.status-badge', ['status' => $order->status])
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-green-700 hover:text-green-800 font-medium text-xs transition">
                            Detail →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-stone-400">
                        Tidak ada order ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($orders->hasPages())
    <div class="px-6 py-4 border-t border-stone-100">
        {{ $orders->appends(['status' => $status])->links() }}
    </div>
    @endif
</div>

@endsection