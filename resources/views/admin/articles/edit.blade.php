@extends('layouts.admin')
@section('title', 'Edit Artikel')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.articles.index') }}"
       class="text-sm text-stone-500 hover:text-green-700 transition block mb-6">
        ← Kembali
    </a>
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-8">
        <h2 class="font-bold text-stone-800 mb-6">Edit Artikel</h2>
        <form action="{{ route('admin.articles.update', $article) }}"
              method="POST" enctype="multipart/form-data"
              class="space-y-5">
            @csrf @method('PUT')
            @include('admin.articles._form')
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white
                               font-semibold px-6 py-2.5 rounded-xl transition text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.articles.index') }}"
                   class="bg-stone-100 hover:bg-stone-200 text-stone-700
                          font-semibold px-6 py-2.5 rounded-xl transition text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection