@extends('layouts.app')

@section('title', 'Hasil Pendaftaran')

@section('content')
<section class="mx-auto max-w-2xl px-6 py-14">
    <a href="{{ route('siswa.dashboard') }}" class="text-sm font-bold text-brand-600 hover:underline">&larr; Dashboard</a>

    <div class="mt-4 rounded-3xl bg-white p-8 text-center shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-12">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Pengumuman Hasil Pendaftaran</p>

        @if (! $pengumumanDibuka || ! in_array($pendaftaran->status, ['diterima', 'ditolak']))
            <div class="mx-auto mt-6 flex h-16 w-16 items-center justify-center rounded-full bg-aqua-100 text-aqua-600">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            </div>
            <h1 class="mt-5 text-2xl font-extrabold text-slate-900">Menunggu Pengumuman</h1>
            <p class="mt-2 text-sm text-slate-600">
                @if (! $pengumumanDibuka)
                    Pengumuman belum dibuka. Silakan cek kembali nanti.
                @else
                    Berkas Anda belum selesai diverifikasi. Status saat ini: <strong>{{ $pendaftaran->status_label }}</strong>.
                @endif
            </p>
        @elseif ($pendaftaran->status === 'diterima')
            <div class="mx-auto mt-6 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <svg class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
            </div>
            <h1 class="mt-5 text-2xl font-extrabold text-slate-900">Selamat, Anda DITERIMA!</h1>
            <p class="mt-2 text-sm text-slate-600">{{ $pendaftaran->nama_lengkap }} dinyatakan diterima di {{ config('spmb.sekolah') }}.</p>
        @else
            <div class="mx-auto mt-6 flex h-16 w-16 items-center justify-center rounded-full bg-rose-50 text-rose-600">
                <svg class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor"><path d="M5.3 5.3a1 1 0 0 1 1.4 0L10 8.6l3.3-3.3a1 1 0 1 1 1.4 1.4L11.4 10l3.3 3.3a1 1 0 0 1-1.4 1.4L10 11.4l-3.3 3.3a1 1 0 0 1-1.4-1.4L8.6 10 5.3 6.7a1 1 0 0 1 0-1.4Z"/></svg>
            </div>
            <h1 class="mt-5 text-2xl font-extrabold text-slate-900">Mohon maaf, Anda belum diterima</h1>
            <p class="mt-2 text-sm text-slate-600">{{ $pendaftaran->nama_lengkap }} dinyatakan tidak lolos seleksi berkas.</p>
            @if ($pendaftaran->catatan_admin)
                <p class="mt-4 rounded-xl bg-rose-50 px-4 py-3 text-xs font-medium text-rose-800">Catatan: {{ $pendaftaran->catatan_admin }}</p>
            @endif
        @endif

        <p class="mt-8 text-xs font-semibold text-slate-400">No. Pendaftaran: {{ $pendaftaran->nomor_pendaftaran }}</p>
    </div>
</section>
@endsection
