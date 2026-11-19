@extends('layouts.app')

@section('title', 'Verifikasi Berkas')

@section('content')
<section class="mx-auto max-w-5xl px-6 py-12">
    <a href="{{ route('admin.pendaftar.index') }}" class="text-sm font-bold text-brand-600 hover:underline">&larr; Data Pendaftar</a>

    <div class="mt-2 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Verifikasi Berkas</h1>
        <x-status-badge :status="$p->status" />
    </div>
    <p class="mt-1 text-sm text-slate-500">{{ $p->nomor_pendaftaran }} &middot; Kirim ulang {{ $p->jumlah_kirim_ulang }} dari {{ config('spmb.max_kirim_ulang') }}</p>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
            <h2 class="text-sm font-extrabold text-slate-900">Data Pendaftar</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @foreach ([
                    'Nama Lengkap' => $p->nama_lengkap,
                    'NIK' => $p->user->username,
                    'NISN' => $p->nisn,
                    'Tempat, Tgl Lahir' => $p->tempat_lahir ? $p->tempat_lahir . ', ' . optional($p->tanggal_lahir)->translatedFormat('d F Y') : null,
                    'Jenis Kelamin' => $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : null),
                    'Asal Sekolah' => $p->asal_sekolah,
                    'Alamat' => $p->alamat,
                    'Orang Tua / Wali' => $p->nama_wali,
                    'No. HP Wali' => $p->no_hp_wali,
                    'No. HP Akun' => $p->user->no_hp,
                ] as $label => $isi)
                    <div class="grid grid-cols-3 gap-3">
                        <dt class="font-semibold text-slate-500">{{ $label }}</dt>
                        <dd class="col-span-2 font-semibold text-slate-900">{{ $isi ?: '-' }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60">
            <h2 class="text-sm font-extrabold text-slate-900">Berkas</h2>
            <ul class="mt-4 space-y-3">
                @foreach (config('spmb.berkas') as $jenis => $label)
                    @php($b = $p->berkas->firstWhere('jenis', $jenis))
                    <li class="flex items-center justify-between gap-3 rounded-xl bg-aqua-100/50 px-4 py-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-900">{{ $label }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $b ? $b->nama_asli : 'Belum diunggah' }}</p>
                        </div>
                        @if ($b)
                            <a href="{{ route('berkas.tampil', $b) }}" target="_blank" class="shrink-0 rounded-lg bg-white px-3 py-1.5 text-xs font-extrabold text-brand-600 ring-1 ring-brand-100 transition hover:bg-brand-50">Lihat</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-6 rounded-3xl bg-white p-6 shadow-xl shadow-sky-900/10 ring-1 ring-slate-200/60 sm:p-8">
        <h2 class="text-sm font-extrabold text-slate-900">Hasil Verifikasi</h2>

        @if ($p->status === 'menunggu_verifikasi')
            <div class="mt-5 grid gap-6 lg:grid-cols-2">
                <form method="POST" action="{{ route('admin.pendaftar.terima', $p) }}"
                      class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5"
                      onsubmit="return confirm('Nyatakan pendaftar ini DITERIMA?')">
                    @csrf
                    <h3 class="text-sm font-extrabold text-emerald-900">Berkas sesuai</h3>
                    <p class="mt-1 text-xs text-emerald-800">Pendaftar dinyatakan diterima dan menunggu pengumuman.</p>
                    <button class="mt-4 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-emerald-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-600/25">Terima</button>
                </form>

                <form method="POST" action="{{ route('admin.pendaftar.bermasalah', $p) }}" class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                    @csrf
                    <h3 class="text-sm font-extrabold text-amber-900">Berkas bermasalah</h3>
                    <p class="mt-1 text-xs text-amber-800">
                        @if ($p->kirimUlangHabis())
                            Batas kirim ulang ({{ config('spmb.max_kirim_ulang') }}x) sudah tercapai. Pendaftar akan <strong>DITOLAK</strong>.
                        @else
                            Pendaftar diminta mengirim ulang (sisa {{ $p->sisaKirimUlang() }} kali).
                        @endif
                    </p>
                    <label for="catatan_admin" class="sr-only">Catatan</label>
                    <textarea id="catatan_admin" name="catatan_admin" rows="3" placeholder="Jelaskan berkas mana yang bermasalah"
                              class="mt-3 block w-full rounded-lg border bg-white px-4 py-3 text-sm focus:outline-none focus:ring-4 {{ $errors->has('catatan_admin') ? 'border-rose-400 focus:ring-rose-500/15' : 'border-amber-300 focus:border-amber-500 focus:ring-amber-500/15' }}">{{ old('catatan_admin') }}</textarea>
                    @error('catatan_admin') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    <button class="mt-3 rounded-lg bg-amber-600 px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-amber-700 focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-600/25">
                        {{ $p->kirimUlangHabis() ? 'Tolak Pendaftar' : 'Minta Kirim Ulang' }}
                    </button>
                </form>
            </div>
        @else
            <p class="mt-3 text-sm text-slate-600">
                Pendaftar ini berstatus <strong>{{ $p->status_label }}</strong>.
                @if ($p->status === 'draft') Belum mengirim berkas untuk diverifikasi. @endif
                @if ($p->status === 'berkas_bermasalah') Menunggu pendaftar mengirim ulang berkas. @endif
            </p>
            @if ($p->catatan_admin)
                <p class="mt-3 rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-700"><strong>Catatan:</strong> {{ $p->catatan_admin }}</p>
            @endif
        @endif
    </div>
</section>
@endsection
