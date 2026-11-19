@props(['tahap' => 1])

@php
    $langkah = ['Daftar', 'Isi Formulir', 'Upload Berkas', 'Verifikasi', 'Pengumuman'];
@endphp

<ol class="grid grid-cols-5 gap-2">
    @foreach ($langkah as $i => $nama)
        @php
            $no = $i + 1;
            $selesai = $no < $tahap;
            $aktif = $no === $tahap;
        @endphp
        <li class="relative flex flex-col items-center text-center">
            @if (! $loop->last)
                <span class="absolute left-1/2 top-4 -z-0 h-0.5 w-full {{ $selesai ? 'bg-brand-600' : 'bg-slate-200' }}"></span>
            @endif
            <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold
                {{ $selesai ? 'bg-brand-600 text-white' : ($aktif ? 'bg-white text-brand-600 ring-4 ring-aqua-300 border-2 border-brand-600' : 'bg-white text-slate-400 border-2 border-slate-200') }}">
                @if ($selesai)
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
                @else
                    {{ $no }}
                @endif
            </span>
            <span class="mt-2 text-[11px] font-semibold leading-tight sm:text-xs {{ $aktif ? 'text-brand-600' : ($selesai ? 'text-slate-700' : 'text-slate-400') }}">{{ $nama }}</span>
        </li>
    @endforeach
</ol>
