@props([
    'eyebrow',
    'title',
    'description' => null,
    'align' => 'left',
])

<div {{ $attributes->merge(['class' => 'max-w-3xl '.($align === 'center' ? 'mx-auto text-center' : '')]) }}>
    <div class="flex items-center gap-3 font-mono text-[10px] uppercase tracking-[0.3em] text-matrix {{ $align === 'center' ? 'justify-center' : '' }}">
        <span class="h-px w-8 bg-matrix/50"></span>
        {{ $eyebrow }}
        <span class="h-px w-8 bg-matrix/50 {{ $align === 'center' ? '' : 'hidden' }}"></span>
    </div>
    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-100 sm:text-4xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-4 text-sm leading-7 text-slate-400 sm:text-base">{{ $description }}</p>
    @endif
</div>
