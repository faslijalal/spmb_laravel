@props(['size' => 'md'])

@php($besar = $size === 'lg')

<span {{ $attributes->merge(['class' => 'inline-flex items-center ' . ($besar ? 'flex-col gap-1' : 'gap-2.5')]) }}>
    <svg viewBox="0 0 64 64" class="{{ $besar ? 'h-16 w-16' : 'h-9 w-9' }} text-slate-900" fill="currentColor" aria-hidden="true">
        <path d="M32 6 2 20l30 14 30-14L32 6Z"/>
        <path d="M14 31v11c0 5 8 10 18 10s18-5 18-10V31L32 40 14 31Z"/>
        <path d="M58 22v18" stroke="currentColor" stroke-width="3" stroke-linecap="round" fill="none"/>
        <circle cx="58" cy="43" r="3.5"/>
    </svg>
    <span class="{{ $besar ? 'text-3xl tracking-wide uppercase' : 'text-lg tracking-tight' }} font-extrabold leading-none text-slate-900">
        SPMB <span class="text-aqua-500">Online</span>
    </span>
</span>
