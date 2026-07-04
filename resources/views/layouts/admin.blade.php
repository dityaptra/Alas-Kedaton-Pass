<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin AlasKedatonPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-100 font-sans antialiased">

    {{-- Sidebar --}}
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-green-800 text-white
              transform transition-transform duration-200 ease-in-out
              -translate-x-full md:translate-x-0">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-6 border-b border-green-700">
            <span class="font-bold text-lg">
                AlasKedaton<span class="text-amber-400">Pass</span>
            </span>
        </div>

        {{-- Nav --}}
        <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.dashboard')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            @if (auth()->user()->isAdmin())
                <div class="pt-4 pb-1">
                    <p class="text-xs font-semibold text-green-400 uppercase tracking-widest px-3">
                        Transaksi
                    </p>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.orders.*')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Kelola Order
                    @php $pendingCount = \App\Models\Order::where('status','pending')->count() @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="ml-auto bg-amber-500 text-white text-xs font-bold
                         px-2 py-0.5 rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.ticket-types.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.ticket-types.*')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    Jenis Tiket
                </a>
            @endif

            <div class="pt-4 pb-1">
                <p class="text-xs font-semibold text-green-400 uppercase tracking-widest px-3">
                    Konten
                </p>
            </div>

            <a href="{{ route('admin.articles.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.articles.*')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Artikel & Berita
            </a>

            <a href="{{ route('admin.comments.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.comments.*')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863
                 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574
                 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Komentar
                @php $commentCount = \App\Models\Comment::whereDate('created_at', today())->count() @endphp
                @if ($commentCount > 0)
                    <span
                        class="ml-auto bg-amber-500 text-white text-xs font-bold
                         px-2 py-0.5 rounded-full">
                        {{ $commentCount }}
                    </span>
                @endif
            </a>

            @if (auth()->user()->isAdmin())
                <div class="pt-4 pb-1">
                    <p class="text-xs font-semibold text-green-400 uppercase tracking-widest px-3">
                        Pengaturan
                    </p>
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                  transition font-medium
                  {{ request()->routeIs('admin.users.*')
                      ? 'bg-white text-green-800'
                      : 'text-green-100 hover:bg-green-700 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Pengguna
                </a>
            @endif

            {{-- Logout --}}
            <div class="pt-4 border-t border-green-700 mt-4">
                <form action="{{ route('admin.logout') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                           w-full text-green-100 hover:bg-green-700 hover:text-white
                           transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

        </nav>
    </aside>

    {{-- Overlay Mobile --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 z-40 bg-black/50 md:hidden">
    </div>

    {{-- Main Content --}}
    <div class="md:ml-64 min-h-screen flex flex-col">

        {{-- Top Header --}}
        <header
            class="h-16 bg-white border-b border-stone-200 flex items-center
                       justify-between px-4 sm:px-6 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="md:hidden p-2 rounded-lg text-stone-500 hover:bg-stone-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-semibold text-stone-800">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-stone-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-stone-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <div
                    class="w-9 h-9 rounded-full bg-green-700 flex items-center
                            justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash Message --}}
        <div class="px-4 sm:px-6 pt-4">
            @if (session('success'))
                <div id="flash-success"
                    class="bg-green-50 border border-green-200 text-green-700 text-sm
                        rounded-xl px-4 py-3 mb-0 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="document.getElementById('flash-success').remove()"
                        class="text-green-500 hover:text-green-700 ml-4">✕</button>
                </div>
            @endif
            @if (session('error'))
                <div id="flash-error"
                    class="bg-red-50 border border-red-200 text-red-700 text-sm
                        rounded-xl px-4 py-3 mb-0 flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('flash-error').remove()"
                        class="text-red-500 hover:text-red-700 ml-4">✕</button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6">
            @yield('content')
        </main>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        toggleBtn.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>

</body>

</html>
