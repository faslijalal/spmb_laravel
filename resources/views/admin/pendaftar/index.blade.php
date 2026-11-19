@extends('layouts.app')

@section('title', 'Data Pendaftar')

@section('content')
<section class="mx-auto max-w-6xl px-6 py-12">
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-brand-600 hover:underline">&larr; Dashboard</a>
    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Data Pendaftar</h1>

    <form method="GET" class="mt-6 flex flex-wrap gap-3">
        <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama, no. pendaftaran, atau NISN"
               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-brand-600 focus:outline-none focus:ring-4 focus:ring-brand-600/15 sm:w-80">
        <select name="status" aria-label="Filter status"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-brand-600 focus:outline-none focus:ring-4 focus:ring-brand-600/15">
            <option value="">Semua status</option>
            @foreach (\App\Models\Pendaftaran::daftarStatus() as $kode => $label)
                <option value="{{ $kode }}" @selected($status === $kode)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-brand-700">Terapkan</button>
    </form>

    <div class="mt-6 overflow-x-auto rounded-3xl bg-white shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="bg-aqua-100/60 text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-3">No. Pendaftaran</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kirim Ulang</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pendaftar as $p)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-slate-700">{{ $p->nomor_pendaftaran }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $p->nama_lengkap }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $p->jumlah_kirim_ulang }} / {{ config('spmb.max_kirim_ulang') }}</td>
                        <td class="px-6 py-4"><x-status-badge :status="$p->status" /></td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.pendaftar.show', $p) }}" class="text-xs font-extrabold text-brand-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Tidak ada data pendaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $pendaftar->links() }}</div>
</section>
@endsection
