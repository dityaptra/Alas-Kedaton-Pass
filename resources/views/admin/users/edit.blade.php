@extends('layouts.admin')
@section('title', 'Edit Pengguna')
@section('content')
<div class="max-w-lg">
    <a href="{{ route('admin.users.index') }}"
       class="text-sm text-stone-500 hover:text-green-700 transition block mb-6">← Kembali</a>
    <div class="bg-white rounded-2xl border border-stone-100 shadow-sm p-8">
        <h2 class="font-bold text-stone-800 mb-6">Edit Pengguna</h2>
        <form action="{{ route('admin.users.update', $user) }}"
              method="POST" class="space-y-5">
            @csrf @method('PUT')
            @include('admin.users._form')
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white
                               font-semibold px-6 py-2.5 rounded-xl transition text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="bg-stone-100 hover:bg-stone-200 text-stone-700
                          font-semibold px-6 py-2.5 rounded-xl transition text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection