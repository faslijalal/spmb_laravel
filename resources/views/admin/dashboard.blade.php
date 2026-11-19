@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-12">
    <p class="text-sm font-semibold text-brand-600">Admin</p>
    <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-slate-900">Dashboard Verifikasi</h1>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ([
            ['Total Pendaftar', $total, 'text-slate-900', null],
            ['Menunggu Verifikasi', $hitung['menunggu_verifikasi'] ?? 0, 'text-brand-600', 'menunggu_verifikasi'],
            ['Berkas Bermasalah', $hitung['berkas_bermasalah'] ?? 0, 'text-amber-600', 'berkas_bermasalah'],
            ['Diterima', $hitung['diterima'] ?? 0, 'text-emerald-600', 'diterima'],
            ['Ditolak', $hitung['ditolak'] ?? 0, 'text-rose-600', 'ditolak'],
        ] as [$label, $jumlah, $warna, $status])
            <a href="{{ route('admin.pendaftar.index', $status ? ['status' => $status] : []) }}"
               class="rounded-2xl bg-white p-5 shadow-md shadow-sky-900/5 ring-1 ring-slate-200/60 transition hover:-translate-y-0.5 hover:shadow-lg">
                <p class="text-xs font-bold text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-extrabold {{ $warna }}">{{ $jumlah }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="overflow-hidden rounded-3xl bg-white shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h2 class="text-sm font-extrabold text-slate-900">Antrian Verifikasi Berkas</h2>
                <a href="{{ route('admin.pendaftar.index', ['status' => 'menunggu_verifikasi']) }}" class="text-xs font-bold text-brand-600 hover:underline">Lihat semua</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse ($antrian as $p)
                    <li class="flex items-center justify-between gap-4 px-6 py-4">
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ $p->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500">{{ $p->nomor_pendaftaran }}@if ($p->jumlah_kirim_ulang) &middot; kirim ulang ke-{{ $p->jumlah_kirim_ulang }}@endif</p>
                        </div>
                        <a href="{{ route('admin.pendaftar.show', $p) }}" class="rounded-lg bg-brand-600 px-4 py-2 text-xs font-extrabold text-white transition hover:bg-brand-700">Verifikasi</a>
                    </li>
                @empty
                    <li class="px-6 py-10 text-center text-sm text-slate-500">Tidak ada berkas yang menunggu verifikasi.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
            <h2 class="text-sm font-extrabold text-slate-900">Pengumuman Hasil</h2>
            <p class="mt-2 text-sm text-slate-600">
                Status:
                <strong class="{{ $pengumumanDibuka ? 'text-emerald-600' : 'text-slate-500' }}">{{ $pengumumanDibuka ? 'Dibuka' : 'Ditutup' }}</strong>
            </p>
            <p class="mt-2 text-xs leading-relaxed text-slate-500">Saat dibuka, calon siswa dapat melihat hasil dan daftar siswa diterima tampil di halaman pengumuman publik.</p>
            <form method="POST" action="{{ route('admin.pengumuman.toggle') }}" class="mt-5"
                  onsubmit="return confirm('{{ $pengumumanDibuka ? 'Tutup pengumuman?' : 'Buka pengumuman untuk umum?' }}')">
                @csrf
                <button type="submit" class="w-full rounded-lg px-5 py-3 text-sm font-extrabold transition focus:outline-none focus-visible:ring-4 {{ $pengumumanDibuka ? 'border border-rose-300 bg-white text-rose-600 hover:bg-rose-50 focus-visible:ring-rose-500/20' : 'bg-brand-600 text-white hover:bg-brand-700 focus-visible:ring-brand-600/25' }}">
                    {{ $pengumumanDibuka ? 'Tutup Pengumuman' : 'Buka Pengumuman' }}
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
