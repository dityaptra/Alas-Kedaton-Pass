@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-stone-500 text-sm">{{ $users->count() }} pengguna terdaftar</p>
    <a href="{{ route('admin.users.create') }}"
       class="bg-green-700 hover:bg-green-800 text-white text-sm font-medium
              px-4 py-2 rounded-xl transition">
        + Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-stone-100">
                <th class="text-left text-xs font-semibold text-stone-400
                           uppercase tracking-wider px-6 py-3">Nama</th>
                <th class="text-left text-xs font-semibold text-stone-400
                           uppercase tracking-wider px-6 py-3 hidden sm:table-cell">Email</th>
                <th class="text-left text-xs font-semibold text-stone-400
                           uppercase tracking-wider px-6 py-3">Role</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-50">
            @forelse ($users as $user)
            <tr class="hover:bg-stone-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-700 flex items-center
                                    justify-center text-white font-bold text-xs flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-stone-800">{{ $user->name }}</span>
                        @if ($user->id === auth()->id())
                        <span class="text-xs text-stone-400">(kamu)</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 text-stone-500 hidden sm:table-cell">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                 text-xs font-semibold capitalize
                                 {{ $user->role === 'admin'
                                     ? 'bg-purple-100 text-purple-700'
                                     : 'bg-blue-100 text-blue-700' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-green-700 hover:text-green-800 font-medium text-xs">
                            Edit
                        </a>
                        @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700
                                           font-medium text-xs transition">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-16 text-center text-stone-400">
                    Belum ada pengguna.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection