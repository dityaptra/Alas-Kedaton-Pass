<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Nama <span class="text-red-500">*</span>
    </label>
    <input type="text" name="name"
           value="{{ old('name', $user->name ?? '') }}"
           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                  focus:outline-none focus:ring-2 focus:ring-green-500
                  @error('name') border-red-400 @enderror">
    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Email <span class="text-red-500">*</span>
    </label>
    <input type="email" name="email"
           value="{{ old('email', $user->email ?? '') }}"
           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                  focus:outline-none focus:ring-2 focus:ring-green-500
                  @error('email') border-red-400 @enderror">
    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">
        Password
        @isset($user)
        <span class="text-stone-400 font-normal">(kosongkan jika tidak ingin mengubah)</span>
        @endisset
    </label>
    <input type="password" name="password"
           class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                  focus:outline-none focus:ring-2 focus:ring-green-500
                  @error('password') border-red-400 @enderror">
    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-stone-700 mb-1">Role</label>
    <select name="role"
            class="w-full border border-stone-300 rounded-xl px-4 py-3 text-sm
                   focus:outline-none focus:ring-2 focus:ring-green-500">
        <option value="editor"
                {{ old('role', $user->role ?? 'editor') === 'editor' ? 'selected' : '' }}>
            Editor (hanya kelola artikel)
        </option>
        <option value="admin"
                {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>
            Admin (akses penuh)
        </option>
    </select>
</div>