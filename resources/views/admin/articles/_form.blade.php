<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Judul <span class="text-red-500">*</span>
    </label>
    <input type="text" name="title"
           value="{{ old('title', $article->title ?? '') }}"
           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                  focus:outline-none focus:ring-2 focus:ring-green-500
                  @error('title') border-red-400 @enderror">
    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Thumbnail
    </label>
    @if (!empty($article->thumbnail))
    <img src="{{ Storage::url($article->thumbnail) }}"
         class="h-32 rounded-xl object-cover mb-2 border border-stone-200">
    @endif
    <input type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp"
           class="w-full text-sm text-stone-600 file:mr-3 file:py-2
                  file:px-4 file:rounded-lg file:border-0
                  file:bg-stone-100 file:text-stone-700 file:font-medium
                  hover:file:bg-stone-200 transition">
    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Konten <span class="text-red-500">*</span>
    </label>
    <textarea name="content" rows="12"
              class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                     focus:outline-none focus:ring-2 focus:ring-green-500
                     @error('content') border-red-400 @enderror">{{ old('content', $article->content ?? '') }}</textarea>
    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">Status</label>
    <select name="status"
            class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                   focus:outline-none focus:ring-2 focus:ring-green-500">
        <option value="draft"
                {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>
            Draft (tidak tampil di publik)
        </option>
        <option value="published"
                {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>
            Published (tampil di publik)
        </option>
    </select>
</div>