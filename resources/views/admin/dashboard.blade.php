@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    @if (auth()->user()->isAdmin())

        {{-- Stat Cards untuk Admin --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Order Hari Ini</p>
                <p class="text-3xl font-bold text-stone-800">{{ $stats['orders_today'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Menunggu Konfirmasi</p>
                <p class="text-3xl font-bold text-amber-500">{{ $stats['orders_pending'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Total Order</p>
                <p class="text-3xl font-bold text-stone-800">{{ $stats['orders_total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Artikel Publik</p>
                <p class="text-3xl font-bold text-stone-800">{{ $stats['articles_total'] }}</p>
            </div>
        </div>

        {{-- Order Terbaru untuk Admin --}}
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-stone-100">
                <h2 class="font-semibold text-stone-800">Order Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-sm text-green-700 hover:text-green-800 font-medium transition">
                    Lihat semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-stone-100">
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                                Nomor Order
                            </th>
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                                Pemesan
                            </th>
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden sm:table-cell">
                                Tanggal Pesan
                            </th>
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        @forelse ($recentOrders as $order)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="px-6 py-4 font-mono font-medium text-stone-700">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 text-stone-700">
                                    {{ $order->visitor_name }}
                                </td>
                                <td class="px-6 py-4 text-stone-400 hidden sm:table-cell">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @include('admin.partials.status-badge', ['status' => $order->status])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-stone-400">
                                    Belum ada order masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- Stat Cards untuk Editor --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Artikel Publik</p>
                <p class="text-3xl font-bold text-stone-800">{{ $stats['articles_total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-6">
                <p class="text-sm text-stone-500 mb-1">Komentar Masuk Hari Ini</p>
                <p class="text-3xl font-bold text-stone-800">
                    {{ \App\Models\Comment::whereDate('created_at', today())->count() }}
                </p>
            </div>
        </div>

        {{-- Artikel Terbaru untuk Editor --}}
        <div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-stone-100">
                <h2 class="font-semibold text-stone-800">Artikel Terbaru</h2>
                <a href="{{ route('admin.articles.index') }}"
                    class="text-sm text-green-700 hover:text-green-800 font-medium transition">
                    Lihat semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-stone-100">
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                                Judul
                            </th>
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden sm:table-cell">
                                Tanggal
                            </th>
                            <th
                                class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                        @forelse (\App\Models\Article::latest()->limit(5)->get() as $article)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="px-6 py-4 font-medium text-stone-700 max-w-xs">
                                    <p class="line-clamp-1">{{ $article->title }}</p>
                                </td>
                                <td class="px-6 py-4 text-stone-400 hidden sm:table-cell">
                                    {{ $article->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                     text-xs font-semibold
                                     {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-stone-100 text-stone-500' }}">
                                        {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-stone-400">
                                    Belum ada artikel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endif

@endsection
