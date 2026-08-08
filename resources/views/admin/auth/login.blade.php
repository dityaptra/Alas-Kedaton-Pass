<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AlasKedatonPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-100 min-h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-stone-800">
                AlasKedaton<span class="text-amber-500">Pass</span>
            </h1>
            <p class="text-stone-500 text-sm mt-1">Panel Administrasi</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-8">
            <h2 class="text-lg font-bold text-stone-800 mb-6">Masuk ke Dashboard</h2>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm
                        rounded-xl px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           autofocus placeholder="admin@alaskedaton.com"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3
                                  text-sm focus:outline-none focus:ring-2 focus:ring-green-500
                                  @error('email') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-700 mb-1">
                        Password
                    </label>
                    <input type="password" name="password"
                           placeholder="••••••••"
                           class="w-full border border-stone-300 rounded-xl px-4 py-3
                                  text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                <button type="submit"
                        class="w-full bg-green-700 hover:bg-green-800 text-white
                               font-bold py-3 rounded-xl transition">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-stone-400 mt-6">
            <a href="{{ route('home') }}" class="hover:text-stone-600 transition">
                ← Kembali ke halaman utama
            </a>
        </p>
    </div>

</body>
</html>