@extends('layouts.admin')

@section('title', 'Jenis Tiket')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <p class="text-stone-500 text-sm">{{ $ticketTypes->count() }} jenis tiket terdaftar</p>
        <a href="{{ route('admin.ticket-types.create') }}"
            class="bg-green-700 hover:bg-green-800 text-white text-sm font-medium
              px-4 py-2 rounded-xl transition">
            + Tambah Tiket
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100">
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Nama Tiket</th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden sm:table-cell">
                            Kategori
                        </th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Harga</th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse ($ticketTypes as $ticket)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-stone-800">{{ $ticket->name }}</p>
                                @if ($ticket->visitor_type)
                                    <p class="text-xs text-stone-400 capitalize">{{ $ticket->visitor_type }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-stone-500 capitalize hidden sm:table-cell">
                                {{ $ticket->category }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-amber-600">
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                     text-xs font-semibold
                                     {{ $ticket->is_active ? 'bg-green-100 text-green-700' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('admin.ticket-types.edit', $ticket) }}"
                                        class="text-green-700 hover:text-green-800 font-medium
                  text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.ticket-types.destroy', $ticket) }}" method="POST"
                                        onsubmit="return confirm('Hapus tiket ini?')" style="display:contents">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700
                           font-medium text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-stone-400">
                                Belum ada jenis tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
