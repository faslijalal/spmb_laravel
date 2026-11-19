<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Beranda') | {{ config('spmb.nama') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen overflow-x-hidden">

    {{-- Latar dekoratif: gelombang biru muda, gelembung, dan ikon buku --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <svg class="absolute right-0 top-20 h-[calc(100%-5rem)] w-[88%] text-aqua-200" viewBox="0 0 800 800" preserveAspectRatio="none">
            <path d="M800 0v800H90c150-150 30-330 250-430C540 280 520 110 640 0Z" fill="currentColor"/>
        </svg>
        <div class="absolute right-[10%] top-36 hidden md:block">
            <div class="h-24 w-36 rounded-[2rem] bg-aqua-100"></div>
            <div class="-mt-2 ml-2 h-7 w-7 rounded-full bg-aqua-100"></div>
            <div class="ml-[-1.5rem] mt-1 h-4 w-4 rounded-full bg-aqua-100"></div>
        </div>
        <svg class="absolute -bottom-6 right-4 hidden h-56 w-72 text-white/60 md:block" viewBox="0 0 288 224" fill="none" stroke="currentColor" stroke-width="10" stroke-linejoin="round" stroke-linecap="round">
            <path d="M144 40C112 20 60 20 24 36v156c36-16 88-16 120 4 32-20 84-20 120-4V36c-36-16-88-16-120 4ZM144 40v156"/>
        </svg>
    </div>

    @include('partials.navbar')

    <main class="relative z-10">
        @if (session('sukses') || session('error'))
            <div class="mx-auto mt-6 max-w-5xl px-6">
                @if (session('sukses'))
                    <div class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4L9 10.6 7.7 9.3a1 1 0 0 0-1.4 1.4l2 2a1 1 0 0 0 1.4 0l4-4Z" clip-rule="evenodd"/></svg>
                        <span>{{ session('sukses') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800" role="alert">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM9 6a1 1 0 0 1 2 0v4a1 1 0 1 1-2 0V6Zm1 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="relative z-10 mt-16 pb-8 text-center text-xs font-medium text-slate-500">
        &copy; {{ date('Y') }} {{ config('spmb.nama') }} &middot; {{ config('spmb.sekolah') }} &middot; TA {{ config('spmb.tahun_ajaran') }}
    </footer>
</body>
</html>
