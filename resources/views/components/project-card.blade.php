@props(['portfolio'])

@php
    $isData = $portfolio->project_type === 'data';
    $techStack = $portfolio->tech_stack ?? [];
    $hoverBorder = $isData ? 'hover:border-cyber/35' : 'hover:border-matrix/35';
    $badgeClasses = $isData ? 'border-cyber/30 bg-void/70 text-cyber' : 'border-matrix/30 bg-void/70 text-matrix';
    $dotClasses = $isData ? 'bg-cyber' : 'bg-matrix';
    $titleHover = $isData ? 'group-hover:text-cyber' : 'group-hover:text-matrix';
    $linkHover = $isData ? 'hover:text-cyber' : 'hover:text-matrix';
@endphp

<article {{ $attributes->merge(['class' => 'group relative flex flex-col overflow-hidden rounded-2xl glass transition-all duration-300 hover:-translate-y-1 '.$hoverBorder.' hover:shadow-[0_30px_80px_-50px_rgba(0,255,156,.45)]']) }}>
    <a href="{{ route('projects.show', $portfolio) }}" class="relative block aspect-[16/10] overflow-hidden bg-panel">
        <img
            src="{{ $portfolio->thumbnailUrl() }}"
            alt="{{ $portfolio->title }} project preview"
            loading="lazy"
            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.035]"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-void via-void/20 to-transparent"></div>
        <div class="absolute inset-x-4 top-4 flex items-center justify-between gap-2">
            <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 font-mono text-[9px] uppercase tracking-[0.16em] backdrop-blur {{ $badgeClasses }}">
                <span class="h-1 w-1 rounded-full {{ $dotClasses }}"></span>
                {{ $isData ? 'data / analytics' : 'software / build' }}
            </span>
            @if ($portfolio->is_featured)
                <span class="rounded-full border border-signal/30 bg-void/70 px-2.5 py-1 font-mono text-[9px] uppercase tracking-[0.16em] text-signal backdrop-blur">featured</span>
            @endif
        </div>
        <div class="absolute inset-x-4 bottom-3 flex items-end justify-between gap-3">
            <span class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-400">{{ $portfolio->category?->name ?? 'Uncategorised' }}</span>
            @if ($portfolio->completed_at)
                <span class="font-mono text-[9px] text-slate-500">{{ $portfolio->completed_at->format('Y') }}</span>
            @endif
        </div>
    </a>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-start justify-between gap-4">
            <h3 class="text-lg font-semibold tracking-tight text-slate-100">
                <a href="{{ route('projects.show', $portfolio) }}" class="transition-colors {{ $titleHover }}">{{ $portfolio->title }}</a>
            </h3>
            <div class="flex shrink-0 items-center gap-2 font-mono text-[9px] text-slate-500">
                <span title="Case study views">◉ {{ number_format($portfolio->views_count ?? 0) }}</span>
                <span title="Outbound clicks">↗ {{ number_format($portfolio->clicks_count ?? 0) }}</span>
            </div>
        </div>

        <p class="mt-2 line-clamp-3 text-[13px] leading-6 text-slate-400">{{ $portfolio->tagline }}</p>

        <div class="mt-4 flex flex-wrap gap-1.5">
            @foreach (array_slice($techStack, 0, 4) as $tech)
                <span class="chip">{{ $tech }}</span>
            @endforeach
            @if (count($techStack) > 4)
                <span class="chip text-slate-500">+{{ count($techStack) - 4 }}</span>
            @endif
        </div>

        <div class="mt-auto flex items-center justify-between gap-3 border-t border-white/10 pt-4">
            <a href="{{ route('projects.show', $portfolio) }}" class="inline-flex items-center gap-1.5 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-300 transition-colors {{ $linkHover }}">
                case study <span aria-hidden="true">→</span>
            </a>

            <div class="flex items-center gap-1">
                @if ($portfolio->live_url)
                    <a
                        href="{{ $portfolio->live_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        data-track-project
                        data-track-url="{{ route('projects.click', $portfolio) }}"
                        data-track-type="live"
                        class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 text-slate-400 transition-colors hover:border-matrix/40 hover:text-matrix"
                        title="Open live demo"
                        aria-label="Open live demo for {{ $portfolio->title }}"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H18m0 0v4.5M18 6l-7.5 7.5M6 8.5v9h9"/></svg>
                    </a>
                @endif
                @if ($portfolio->github_url)
                    <a
                        href="{{ $portfolio->github_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        data-track-project
                        data-track-url="{{ route('projects.click', $portfolio) }}"
                        data-track-type="github"
                        class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 text-slate-400 transition-colors hover:border-cyber/40 hover:text-cyber"
                        title="View source"
                        aria-label="View source for {{ $portfolio->title }}"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.58 2 12.26c0 4.53 2.87 8.37 6.84 9.73.5.1.68-.22.68-.49 0-.24-.01-.87-.01-1.71-2.78.62-3.37-1.37-3.37-1.37-.45-1.18-1.11-1.49-1.11-1.49-.91-.64.07-.63.07-.63 1 .07 1.53 1.06 1.53 1.06.89 1.57 2.34 1.12 2.91.86.09-.66.35-1.12.63-1.38-2.22-.26-4.56-1.14-4.56-5.06 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.71 0 0 .84-.28 2.75 1.05a9.4 9.4 0 0 1 5 0c1.91-1.33 2.75-1.05 2.75-1.05.55 1.41.2 2.45.1 2.71.64.72 1.03 1.63 1.03 2.75 0 3.93-2.34 4.8-4.57 5.05.36.32.68.94.68 1.9 0 1.37-.01 2.47-.01 2.81 0 .27.18.6.69.49A10.02 10.02 0 0 0 22 12.26C22 6.58 17.52 2 12 2Z"/></svg>
                    </a>
                @endif
                @if ($portfolio->dashboard_url)
                    <a
                        href="{{ $portfolio->dashboard_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        data-track-project
                        data-track-url="{{ route('projects.click', $portfolio) }}"
                        data-track-type="dashboard"
                        class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 text-slate-400 transition-colors hover:border-plasma/40 hover:text-plasma"
                        title="Open dashboard"
                        aria-label="Open dashboard for {{ $portfolio->title }}"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m5 10V5m5 14v-7m5 7V8"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
