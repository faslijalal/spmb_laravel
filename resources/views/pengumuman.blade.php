@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<section class="mx-auto max-w-4xl px-6 py-14">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Pengumuman Hasil Pendaftaran</h1>
    <p class="mt-2 text-sm text-slate-600">Penerimaan Peserta Didik Baru {{ config('spmb.sekolah') }} TA {{ config('spmb.tahun_ajaran') }}</p>

    @if (! $dibuka)
        <div class="mt-8 rounded-3xl bg-white p-10 text-center shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-aqua-100 text-aqua-600">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            </div>
            <h2 class="mt-4 text-lg font-extrabold text-slate-900">Pengumuman belum dibuka</h2>
            <p class="mt-1 text-sm text-slate-500">Silakan kembali lagi nanti atau masuk ke akun Anda untuk memantau status pendaftaran.</p>
        </div>
    @else
        <div class="mt-8 overflow-hidden rounded-3xl bg-white shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
            <div class="border-b border-slate-100 px-6 py-4 text-sm font-bold text-slate-700">Daftar calon siswa yang DITERIMA</div>
            <table class="w-full text-left text-sm">
                <thead class="bg-aqua-100/60 text-xs font-bold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-6 py-3">No</th><th class="px-6 py-3">No. Pendaftaran</th><th class="px-6 py-3">Nama</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($diterima as $i => $p)
                        <tr>
                            <td class="px-6 py-3 text-slate-500">{{ $diterima->firstItem() + $i }}</td>
                            <td class="px-6 py-3 font-semibold text-slate-700">{{ $p->nomor_pendaftaran }}</td>
                            <td class="px-6 py-3 font-semibold text-slate-900">{{ $p->nama_lengkap }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-10 text-center text-slate-500">Belum ada calon siswa yang diterima.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $diterima->links() }}</div>
    @endif
</section>
@endsection
