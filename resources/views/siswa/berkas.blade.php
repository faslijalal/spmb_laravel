@extends('layouts.app')

@section('title', 'Upload Berkas')

@section('content')
@php
    $kunci = ! $pendaftaran->bolehDiubah();
    $lengkap = $pendaftaran->berkasLengkap();
@endphp
<section class="mx-auto max-w-5xl px-6 py-12">
    <a href="{{ route('siswa.dashboard') }}" class="text-sm font-bold text-brand-600 hover:underline">&larr; Dashboard</a>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Upload Berkas</h1>

    <div class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        <x-stepper :tahap="$pendaftaran->tahap()" />
    </div>

    @if ($pendaftaran->status === 'berkas_bermasalah')
        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5">
            <h2 class="text-sm font-extrabold text-amber-900">Catatan dari admin</h2>
            <p class="mt-1 text-sm leading-relaxed text-amber-900">{{ $pendaftaran->catatan_admin }}</p>
            <p class="mt-2 text-xs font-bold text-amber-800">Sisa kesempatan kirim ulang: {{ $pendaftaran->sisaKirimUlang() }} dari {{ config('spmb.max_kirim_ulang') }}</p>
        </div>
    @elseif ($kunci)
        <p class="mt-6 rounded-xl border border-aqua-300 bg-aqua-100 px-4 py-3 text-sm font-medium text-brand-900">Berkas sudah dikirim dan sedang diverifikasi. Berkas tidak dapat diubah.</p>
    @endif

    <form method="POST" action="{{ route('siswa.berkas.simpan') }}" enctype="multipart/form-data"
          class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        @csrf
        <p class="text-xs text-slate-500">Format JPG, PNG, atau PDF (pas foto: JPG/PNG). Maksimal 2 MB per berkas.</p>

        <ul class="mt-5 divide-y divide-slate-100">
            @foreach (config('spmb.berkas') as $jenis => $label)
                @php($ada = $berkas->get($jenis))
                <li class="flex flex-col gap-3 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-extrabold text-slate-900">{{ $label }}</p>
                        @if ($ada)
                            <p class="mt-1 flex items-center gap-2 text-xs font-semibold text-emerald-700">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
                                Terunggah:
                                <a href="{{ route('berkas.tampil', $ada) }}" target="_blank" class="underline hover:text-emerald-900">{{ $ada->nama_asli }}</a>
                            </p>
                        @else
                            <p class="mt-1 text-xs font-semibold text-slate-400">Belum diunggah</p>
                        @endif
                        @error($jenis) <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    @unless ($kunci)
                        <div class="sm:w-72">
                            <input type="file" name="{{ $jenis }}" accept="{{ $jenis === 'foto' ? '.jpg,.jpeg,.png' : '.jpg,.jpeg,.png,.pdf' }}"
                                   aria-label="Pilih file {{ $label }}"
                                   class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-xs text-slate-600 file:mr-3 file:cursor-pointer file:border-0 file:bg-aqua-100 file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-brand-600 hover:file:bg-aqua-200">
                        </div>
                    @endunless
                </li>
            @endforeach
        </ul>

        @unless ($kunci)
            <div class="mt-4 flex justify-end">
                <button type="submit" class="inline-flex rounded-lg border border-brand-600 bg-white px-6 py-3 text-sm font-extrabold text-brand-600 transition hover:bg-brand-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">Simpan Berkas</button>
            </div>
        @endunless
    </form>

    @unless ($kunci)
        <form method="POST" action="{{ route('siswa.berkas.kirim') }}" class="mt-6 flex flex-wrap items-center justify-between gap-4 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
            @csrf
            <p class="max-w-md text-sm {{ $lengkap ? 'text-slate-600' : 'text-slate-400' }}">
                {{ $lengkap ? 'Semua berkas sudah lengkap. Kirim untuk diverifikasi admin.' : 'Lengkapi semua berkas terlebih dahulu sebelum mengirim.' }}
            </p>
            <button type="submit" @disabled(! $lengkap)
                    class="inline-flex rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25 disabled:cursor-not-allowed disabled:bg-slate-300">
                {{ $pendaftaran->status === 'berkas_bermasalah' ? 'Kirim Ulang Berkas' : 'Kirim Berkas' }}
            </button>
        </form>
    @endunless
</section>
@endsection
