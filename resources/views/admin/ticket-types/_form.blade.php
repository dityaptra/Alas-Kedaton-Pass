<div class="space-y-5">
    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">
            Nama Tiket <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name"
               value="{{ old('name', $ticketType->name ?? '') }}"
               class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-500
                      @error('name') border-red-400 @enderror">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Kategori</label>
            <select name="category"
                    class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                           focus:outline-none focus:ring-2 focus:ring-green-500">
                @foreach (['asing' => 'Asing', 'domestik' => 'Domestik', 'lokal' => 'Lokal/Bali'] as $val => $label)
                <option value="{{ $val }}"
                        {{ old('category', $ticketType->category ?? '') === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Tipe Pengunjung</label>
            <select name="visitor_type"
                    class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                           focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">— Tidak ada —</option>
                @foreach (['dewasa' => 'Dewasa', 'anak' => 'Anak'] as $val => $label)
                <option value="{{ $val }}"
                        {{ old('visitor_type', $ticketType->visitor_type ?? '') === $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">
            Harga (Rp) <span class="text-red-500">*</span>
        </label>
        <input type="number" name="price" min="0"
               value="{{ old('price', $ticketType->price ?? '') }}"
               class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-500
                      @error('price') border-red-400 @enderror">
        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Deskripsi</label>
        <textarea name="description" rows="3"
                  class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                         focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $ticketType->description ?? '') }}</textarea>
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_active" id="is_active" value="1"
               {{ old('is_active', $ticketType->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-stone-300 text-green-700">
        <label for="is_active" class="text-sm text-stone-700">Tiket aktif (tampil di halaman publik)</label>
    </div>
</div>