@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
@php
    $kolom = fn ($nama) => $errors->has($nama)
        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15'
        : 'border-slate-300 focus:border-brand-600 focus:ring-brand-600/15';
@endphp
<section class="mx-auto flex max-w-7xl justify-center px-6 py-12">
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-10">
        <div class="flex justify-center">
            <x-logo size="lg" />
        </div>
        <h1 class="mt-6 text-center text-lg font-extrabold text-slate-800">Buat Akun Calon Siswa / Orang Tua</h1>
        <p class="mt-1 text-center text-xs text-slate-500">NIK akan digunakan sebagai username untuk masuk.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-4" novalidate>
            @csrf

            <div>
                <label for="name" class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap Calon Siswa</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name"
                       class="block w-full rounded-lg border bg-white px-4 py-3 text-sm focus:outline-none focus:ring-4 {{ $kolom('name') }}">
                @error('name') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="username" class="mb-1.5 block text-xs font-bold text-slate-600">NIK (16 digit)</label>
                <input id="username" name="username" type="text" inputmode="numeric" maxlength="16" value="{{ old('username') }}"
                       class="block w-full rounded-lg border bg-white px-4 py-3 text-sm focus:outline-none focus:ring-4 {{ $kolom('username') }}">
                @error('username') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="no_hp" class="mb-1.5 block text-xs font-bold text-slate-600">No. HP / WhatsApp</label>
                <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                       class="block w-full rounded-lg border bg-white px-4 py-3 text-sm focus:outline-none focus:ring-4 {{ $kolom('no_hp') }}">
                @error('no_hp') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-1.5 block text-xs font-bold text-slate-600">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                           class="block w-full rounded-lg border bg-white px-4 py-3 text-sm focus:outline-none focus:ring-4 {{ $kolom('password') }}">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-xs font-bold text-slate-600">Ulangi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm focus:border-brand-600 focus:outline-none focus:ring-4 focus:ring-brand-600/15">
                </div>
            </div>
            @error('password') <p class="-mt-2 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">
                Buat Akun
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
            </button>
        </form>

        <div class="my-6 flex items-center gap-3 text-xs text-slate-400">
            <span class="h-px flex-1 bg-slate-300"></span> atau <span class="h-px flex-1 bg-slate-300"></span>
        </div>

        <div class="flex items-center justify-between text-xs">
            <a href="{{ route('beranda') }}" class="font-bold text-blue-600 hover:underline">Kembali Ke Beranda</a>
            <span class="h-5 w-px bg-slate-300"></span>
            <span class="font-semibold text-slate-700">Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Masuk</a>
            </span>
        </div>
    </div>
</section>
@endsection
