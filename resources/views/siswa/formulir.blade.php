@extends('layouts.app')

@section('title', 'Formulir Pendaftaran')

@section('content')
@php
    $f = fn ($n) => $errors->has($n)
        ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/15'
        : 'border-slate-300 focus:border-brand-600 focus:ring-brand-600/15';
    $nilai = fn ($n) => old($n, $pendaftaran->$n);
    $input = 'block w-full rounded-lg border bg-white px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-4 disabled:bg-slate-100 disabled:text-slate-500';
    $kunci = ! $pendaftaran->bolehDiubah();
@endphp
<section class="mx-auto max-w-5xl px-6 py-12">
    <a href="{{ route('siswa.dashboard') }}" class="text-sm font-bold text-brand-600 hover:underline">&larr; Dashboard</a>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Formulir Pendaftaran</h1>

    <div class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        <x-stepper :tahap="$pendaftaran->tahap()" />
    </div>

    @if ($kunci)
        <p class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">Formulir tidak dapat diubah karena berkas sedang diverifikasi.</p>
    @endif

    <form method="POST" action="{{ route('siswa.formulir.simpan') }}" class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8" novalidate>
        @csrf
        <fieldset @disabled($kunci) class="space-y-8">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Data Calon Siswa</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="nama_lengkap" class="mb-1.5 block text-xs font-bold text-slate-600">Nama Lengkap</label>
                        <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ $nilai('nama_lengkap') }}" class="{{ $input }} {{ $f('nama_lengkap') }}">
                        @error('nama_lengkap') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nisn" class="mb-1.5 block text-xs font-bold text-slate-600">NISN (10 digit)</label>
                        <input id="nisn" name="nisn" type="text" inputmode="numeric" maxlength="10" value="{{ $nilai('nisn') }}" class="{{ $input }} {{ $f('nisn') }}">
                        @error('nisn') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="mb-1.5 block text-xs font-bold text-slate-600">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="{{ $input }} {{ $f('jenis_kelamin') }}">
                            <option value="">Pilih...</option>
                            <option value="L" @selected($nilai('jenis_kelamin') === 'L')>Laki-laki</option>
                            <option value="P" @selected($nilai('jenis_kelamin') === 'P')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="mb-1.5 block text-xs font-bold text-slate-600">Tempat Lahir</label>
                        <input id="tempat_lahir" name="tempat_lahir" type="text" value="{{ $nilai('tempat_lahir') }}" class="{{ $input }} {{ $f('tempat_lahir') }}">
                        @error('tempat_lahir') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="mb-1.5 block text-xs font-bold text-slate-600">Tanggal Lahir</label>
                        <input id="tanggal_lahir" name="tanggal_lahir" type="date"
                               value="{{ old('tanggal_lahir', optional($pendaftaran->tanggal_lahir)->format('Y-m-d')) }}" class="{{ $input }} {{ $f('tanggal_lahir') }}">
                        @error('tanggal_lahir') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="asal_sekolah" class="mb-1.5 block text-xs font-bold text-slate-600">Asal Sekolah</label>
                        <input id="asal_sekolah" name="asal_sekolah" type="text" value="{{ $nilai('asal_sekolah') }}" class="{{ $input }} {{ $f('asal_sekolah') }}">
                        @error('asal_sekolah') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="alamat" class="mb-1.5 block text-xs font-bold text-slate-600">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="3" class="{{ $input }} {{ $f('alamat') }}">{{ $nilai('alamat') }}</textarea>
                        @error('alamat') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-base font-extrabold text-slate-900">Data Orang Tua / Wali</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="nama_wali" class="mb-1.5 block text-xs font-bold text-slate-600">Nama Orang Tua / Wali</label>
                        <input id="nama_wali" name="nama_wali" type="text" value="{{ $nilai('nama_wali') }}" class="{{ $input }} {{ $f('nama_wali') }}">
                        @error('nama_wali') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="no_hp_wali" class="mb-1.5 block text-xs font-bold text-slate-600">No. HP Orang Tua / Wali</label>
                        <input id="no_hp_wali" name="no_hp_wali" type="tel" value="{{ $nilai('no_hp_wali') }}" class="{{ $input }} {{ $f('no_hp_wali') }}">
                        @error('no_hp_wali') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </fieldset>

        @unless ($kunci)
            <div class="mt-8 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">Simpan &amp; Lanjut Upload Berkas</button>
            </div>
        @endunless
    </form>
</section>
@endsection
