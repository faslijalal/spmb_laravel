<header class="relative z-20 border-b border-slate-100 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">
        <a href="{{ route('beranda') }}" aria-label="SPMB Online - Beranda">
            <x-logo />
        </a>

        <nav class="flex items-center gap-4 text-sm font-bold sm:gap-7">
            <a href="{{ route('beranda') }}"
               class="hidden transition hover:text-brand-600 sm:inline {{ request()->routeIs('beranda') ? 'text-slate-700' : 'text-slate-500' }}">Beranda</a>
            <a href="{{ route('pengumuman') }}"
               class="hidden transition hover:text-brand-600 sm:inline {{ request()->routeIs('pengumuman') ? 'text-slate-700' : 'text-slate-500' }}">Pengumuman</a>

            @auth
                <a href="{{ route('dashboard') }}" class="text-slate-500 transition hover:text-brand-600">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">
                        Keluar
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-slate-500 transition hover:text-brand-600">Masuk</a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">
                    Daftar
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                </a>
            @endauth
        </nav>
    </div>
</header>
