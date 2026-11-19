@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<section class="mx-auto flex max-w-7xl justify-center px-6 py-12">
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-10">
        <div class="flex justify-center">
            <x-logo size="lg" />
        </div>

        <form method="POST" action="{{ route('login') }}" class="mt-9 space-y-4" novalidate>
            @csrf

            <div>
                <label for="username" class="sr-only">NIK / Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" autofocus
                       placeholder="NIK / Username"
                       class="block w-full rounded-lg border bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 {{ $errors->has('username') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15' : 'border-slate-300 focus:border-brand-600 focus:ring-brand-600/15' }}">
                @error('username')
                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password"
                       placeholder="Password"
                       class="block w-full rounded-lg border bg-white px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15' : 'border-slate-300 focus:border-brand-600 focus:ring-brand-600/15' }}">
                @error('password')
                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-xs font-medium text-slate-500">
                <input type="checkbox" name="ingat" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                Ingat saya
            </label>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">
                Masuk
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
            </button>
        </form>

        <div class="my-6 flex items-center gap-3 text-xs text-slate-400">
            <span class="h-px flex-1 bg-slate-300"></span> atau <span class="h-px flex-1 bg-slate-300"></span>
        </div>

        <div class="flex items-center justify-between text-xs">
            <a href="{{ route('beranda') }}" class="font-bold text-blue-600 hover:underline">Kembali Ke Beranda</a>
            <span class="h-5 w-px bg-slate-300"></span>
            <span class="font-semibold text-slate-700">Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar</a>
            </span>
        </div>
    </div>
</section>
@endsection
