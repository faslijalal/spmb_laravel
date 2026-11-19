@props(['status'])

@php
    $kelas = match ($status) {
        'diterima' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'ditolak' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'berkas_bermasalah' => 'bg-amber-50 text-amber-700 ring-amber-600/25',
        'menunggu_verifikasi' => 'bg-brand-50 text-brand-600 ring-brand-600/20',
        default => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    };
    $label = \App\Models\Pendaftaran::daftarStatus()[$status] ?? $status;
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $kelas }}">{{ $label }}</span>
