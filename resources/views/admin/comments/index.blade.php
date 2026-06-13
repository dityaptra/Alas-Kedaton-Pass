@extends('layouts.admin')

@section('title', 'Kelola Komentar')

@section('content')

    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-stone-100">
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Pengirim</th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden md:table-cell">
                            Artikel
                        </th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Komentar</th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden sm:table-cell">
                            Waktu
                        </th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse ($comments as $comment)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-stone-800">{{ $comment->name }}</p>
                                <p class="text-stone-400 text-xs">{{ $comment->email }}</p>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <a href="{{ route('articles.show', $comment->article->slug) }}" target="_blank"
                                    class="text-green-700 hover:text-green-800 transition
                                  text-xs line-clamp-1">
                                    {{ $comment->article->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-stone-600 max-w-xs">
                                <p class="line-clamp-2 text-sm">{{ $comment->content }}</p>
                            </td>
                            <td class="px-6 py-4 text-stone-400 text-xs hidden sm:table-cell">
                                {{ $comment->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                    onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf @method('DELETE')
                                    <button
                                        class="text-red-500 hover:text-red-700
                                           font-medium text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-stone-400">
                                Belum ada komentar masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($comments->hasPages())
            <div class="px-6 py-4 border-t border-stone-100">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

@endsection
