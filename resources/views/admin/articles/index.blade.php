@extends('layouts.admin')

@section('title', 'Artikel & Berita')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <p class="text-stone-500 text-sm">{{ $articles->total() }} artikel</p>
        <a href="{{ route('admin.articles.create') }}"
            class="bg-green-700 hover:bg-green-800 text-white text-sm font-medium
              px-4 py-2 rounded-xl transition">
            + Tulis Artikel
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
                            Judul</th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden md:table-cell">
                            Penulis
                        </th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3 hidden sm:table-cell">
                            Tanggal
                        </th>
                        <th
                            class="text-left text-xs font-semibold text-stone-400
                               uppercase tracking-wider px-6 py-3">
                            Status</th>
                        <th class="px-6 py-3 w-24"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @forelse ($articles as $article)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-stone-800 line-clamp-1">
                                    {{ $article->title }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-stone-500 hidden md:table-cell">
                                {{ $article->author->name }}
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
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                        class="text-green-700 hover:text-green-800 font-medium text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                        onsubmit="return confirm('Hapus artikel ini?')" style="display:contents">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 font-medium text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-stone-400">
                                Belum ada artikel.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($articles->hasPages())
            <div class="px-6 py-4 border-t border-stone-100">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

@endsection
