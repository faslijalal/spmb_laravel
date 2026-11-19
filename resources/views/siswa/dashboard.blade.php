@extends('layouts.app')

@section('title', 'Dashboard Calon Siswa')

@section('content')
<section class="mx-auto max-w-5xl px-6 py-12">
    <p class="text-sm font-semibold text-brand-600">Calon Siswa / Orang Tua</p>
    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-900">Halo, {{ auth()->user()->name }}</h1>

    <div class="mt-8 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        <x-stepper :tahap="$pendaftaran ? $pendaftaran->tahap() : 1" />
    </div>

    <div class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        @if (! $pendaftaran)
            <h2 class="text-lg font-extrabold text-slate-900">Anda belum memulai pendaftaran</h2>
            <p class="mt-1 text-sm text-slate-600">Klik tombol berikut untuk membuat data pendaftaran dan mendapatkan nomor pendaftaran.</p>
            <form method="POST" action="{{ route('siswa.daftar') }}" class="mt-6">
                @csrf
                <button class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-600/25">Mulai Pendaftaran</button>
            </form>
        @else
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">No. Pendaftaran</p>
                    <p class="mt-1 text-xl font-extrabold text-slate-900">{{ $pendaftaran->nomor_pendaftaran }}</p>
                </div>
                <x-status-badge :status="$pendaftaran->status" />
            </div>

            <hr class="my-6 border-slate-100">

            @switch($pendaftaran->status)
                @case('draft')
                    @if (! $pendaftaran->form_lengkap)
                        <h2 class="text-lg font-extrabold text-slate-900">Lengkapi formulir pendaftaran</h2>
                        <p class="mt-1 text-sm text-slate-600">Isi data diri dan data orang tua / wali untuk melanjutkan.</p>
                        <a href="{{ route('siswa.formulir') }}" class="mt-6 inline-flex rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700">Isi Formulir</a>
                    @else
                        <h2 class="text-lg font-extrabold text-slate-900">Unggah berkas persyaratan</h2>
                        <p class="mt-1 text-sm text-slate-600">Berkas terunggah: {{ $pendaftaran->berkas->count() }} dari {{ count(config('spmb.berkas')) }}.</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('siswa.berkas') }}" class="inline-flex rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700">Upload Berkas</a>
                            <a href="{{ route('siswa.formulir') }}" class="inline-flex rounded-lg border border-brand-600 bg-white px-6 py-3 text-sm font-extrabold text-brand-600 transition hover:bg-brand-50">Ubah Formulir</a>
                        </div>
                    @endif
                    @break

                @case('menunggu_verifikasi')
                    <h2 class="text-lg font-extrabold text-slate-900">Berkas sedang diverifikasi</h2>
                    <p class="mt-1 text-sm text-slate-600">Admin sedang memeriksa berkas Anda. Mohon menunggu pengumuman.</p>
                    @break

                @case('berkas_bermasalah')
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                        <h2 class="text-base font-extrabold text-amber-900">Berkas Anda bermasalah</h2>
                        <p class="mt-2 text-sm leading-relaxed text-amber-900">{{ $pendaftaran->catatan_admin }}</p>
                        <p class="mt-3 text-xs font-bold text-amber-800">Sisa kesempatan kirim ulang: {{ $pendaftaran->sisaKirimUlang() }} dari {{ config('spmb.max_kirim_ulang') }}</p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('siswa.berkas') }}" class="inline-flex rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700">Perbaiki &amp; Upload Ulang</a>
                    </div>
                    @break

                @default
                    <h2 class="text-lg font-extrabold text-slate-900">Verifikasi selesai</h2>
                    <p class="mt-1 text-sm text-slate-600">
                        {{ $pengumumanDibuka ? 'Hasil pendaftaran sudah diumumkan.' : 'Hasil akan terlihat setelah pengumuman dibuka. Mohon menunggu.' }}
                    </p>
                    @if ($pengumumanDibuka)
                        <a href="{{ route('siswa.hasil') }}" class="mt-6 inline-flex rounded-lg bg-brand-600 px-6 py-3 text-sm font-extrabold text-white transition hover:bg-brand-700">Lihat Hasil Pendaftaran</a>
                    @endif
            @endswitch
        @endif
    </div>
</section>
@endsection
