@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-16 lg:grid-cols-2 lg:py-24">
    <div>
        <span class="inline-flex items-center gap-2 rounded-full bg-white px-3.5 py-1.5 text-xs font-bold text-brand-600 shadow-sm ring-1 ring-brand-100">
            <span class="h-2 w-2 rounded-full bg-aqua-500"></span>
            Penerimaan Peserta Didik Baru {{ config('spmb.tahun_ajaran') }}
        </span>
        <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl">
            Daftar sekolah jadi <span class="text-aqua-600">lebih mudah</span>, dari mana saja.
        </h1>
        <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600">
            Buat akun, isi formulir, unggah berkas, lalu pantau hasil verifikasi dan pengumuman
            {{ config('spmb.sekolah') }} langsung dari satu tempat.
        </p>
        <div class="mt-8 flex flex-wrap items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">Buka Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">
                    Daftar Sekarang
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg border border-brand-600 bg-white px-6 py-3 text-sm font-extrabold text-brand-600 transition hover:bg-brand-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">Sudah punya akun? Masuk</a>
            @endauth
        </div>
    </div>

    <aside class="rounded-3xl bg-white p-7 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
        <h2 class="text-base font-extrabold text-slate-900">Siapkan berkas berikut</h2>
        <p class="mt-1 text-xs text-slate-500">Format JPG, PNG, atau PDF. Maksimal 2 MB per berkas.</p>
        <ul class="mt-5 space-y-3">
            @foreach (config('spmb.berkas') as $label)
                <li class="flex items-center gap-3 rounded-xl bg-aqua-100/60 px-4 py-3 text-sm font-semibold text-slate-700">
                    <svg class="h-5 w-5 shrink-0 text-brand-600" viewBox="0 0 20 20" fill="currentColor"><path d="M4 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H4Zm7 1.5L16.5 9H12a1 1 0 0 1-1-1V3.5Z"/></svg>
                    {{ $label }}
                </li>
            @endforeach
        </ul>
        <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs font-medium leading-relaxed text-amber-800">
            Jika berkas dinyatakan bermasalah, Anda dapat mengirim ulang maksimal
            <strong>{{ config('spmb.max_kirim_ulang') }} kali</strong>. Setelah batas tercapai, pendaftaran dinyatakan ditolak.
        </p>
    </aside>
</section>

<section class="mx-auto max-w-7xl px-6 pb-8">
    <h2 class="text-2xl font-extrabold text-slate-900">Alur Pendaftaran</h2>
    <ol class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ([
            ['Buat Akun', 'Daftar dengan NIK dan nomor HP, lalu masuk.'],
            ['Isi Formulir', 'Lengkapi data diri dan data orang tua / wali.'],
            ['Upload Berkas', 'Unggah berkas persyaratan lalu kirim.'],
            ['Verifikasi Admin', 'Admin memeriksa berkas. Bila bermasalah, kirim ulang.'],
            ['Pengumuman', 'Lihat hasil: diterima atau ditolak.'],
        ] as $i => [$judul, $isi])
            <li class="rounded-2xl bg-white p-5 shadow-md shadow-sky-900/5 ring-1 ring-slate-200/60">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-extrabold text-white">{{ $i + 1 }}</span>
                <h3 class="mt-4 text-sm font-extrabold text-slate-900">{{ $judul }}</h3>
                <p class="mt-1.5 text-xs leading-relaxed text-slate-500">{{ $isi }}</p>
            </li>
        @endforeach
    </ol>
</section>
@endsection
