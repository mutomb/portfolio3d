@extends('layouts.app')

@section('title', $portfolio->title.' — '.($site['site_name'] ?? 'Portfolio3d'))

@section('content')
    @php
        $isData = $portfolio->project_type === 'data';
        $accent = $isData ? 'cyber' : 'matrix';
        $accentText = $isData ? 'text-cyber' : 'text-matrix';
        $accentBorder = $isData ? 'border-cyber/30' : 'border-matrix/30';
        $accentBg = $isData ? 'bg-cyber/10' : 'bg-matrix/10';
    @endphp

    <section class="relative overflow-hidden pb-16 pt-28 sm:pt-36">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        <div class="pointer-events-none absolute left-1/2 top-10 h-80 w-80 -translate-x-1/2 rounded-full {{ $isData ? 'bg-cyber/5' : 'bg-matrix/5' }} blur-[110px]"></div>

        <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
            <nav class="flex flex-wrap items-center gap-2 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition-colors hover:text-matrix">home</a>
                <span class="text-slate-700">/</span>
                <a href="{{ route('home') }}#work" class="transition-colors hover:text-matrix">work</a>
                <span class="text-slate-700">/</span>
                <span class="text-slate-300">{{ $portfolio->slug }}</span>
            </nav>

            <div class="mt-8 grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-end">
                <div class="reveal">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="chip border {{ $accentBorder }} {{ $accentBg }} {{ $accentText }}">
                            {{ $isData ? 'data / analytics' : 'software / build' }}
                        </span>
                        @if ($portfolio->category)
                            <span class="chip">{{ $portfolio->category->name }}</span>
                        @endif
                        @if ($portfolio->is_featured)
                            <span class="chip border-signal/25 bg-signal/5 text-signal">featured</span>
                        @endif
                    </div>

                    <h1 class="mt-5 max-w-3xl text-4xl font-semibold leading-[1.08] tracking-tight text-slate-100 sm:text-5xl">
                        {{ $portfolio->title }}
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-400">{{ $portfolio->tagline }}</p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        @if ($portfolio->live_url)
                            <a
                                href="{{ $portfolio->live_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                data-track-project
                                data-track-url="{{ route('projects.click', $portfolio) }}"
                                data-track-type="live"
                                class="btn-primary"
                            >
                                open live system <span aria-hidden="true">↗</span>
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
                                class="btn-secondary"
                            >
                                view dashboard <span aria-hidden="true">↗</span>
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
                                class="btn-ghost !px-4 !py-3"
                            >
                                source code <span aria-hidden="true">↗</span>
                            </a>
                        @endif
                        <a href="{{ route('home') }}#contact" class="btn-ghost !px-4 !py-3">discuss similar work →</a>
                    </div>
                </div>

                <div class="reveal">
                    <div class="relative overflow-hidden rounded-2xl border {{ $accentBorder }} bg-panel">
                        <img src="{{ $portfolio->thumbnailUrl() }}" alt="{{ $portfolio->title }} preview" class="aspect-[16/10] w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-void/80 via-transparent to-transparent"></div>
                        <div class="absolute inset-x-4 bottom-4 flex items-center justify-between gap-3 font-mono text-[9px] uppercase tracking-[0.16em]">
                            <span class="text-slate-300">{{ $portfolio->category?->name ?? 'uncategorised' }}</span>
                            <span class="{{ $accentText }}">{{ $portfolio->completed_at?->format('Y') ?? 'in progress' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ([
                    ['client', $portfolio->client ?? 'Independent'],
                    ['role', $portfolio->role ?? 'Design & build'],
                    ['timeline', $portfolio->duration ?? '—'],
                    ['shipped', $portfolio->completed_at?->format('M Y') ?? '—'],
                ] as [$label, $value])
                    <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">{{ $label }}</p>
                        <p class="mt-1.5 text-sm text-slate-200">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative py-8">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="grid gap-10 lg:grid-cols-[1fr_20rem] lg:gap-14">
                <div class="min-w-0">
                    @if ($portfolio->results)
                        <div class="rounded-2xl border {{ $accentBorder }} {{ $accentBg }} p-5 sm:p-6">
                            <p class="font-mono text-[9px] uppercase tracking-[0.2em] {{ $accentText }}">measured outcome</p>
                            <p class="mt-3 text-sm leading-7 text-slate-200">{{ $portfolio->results }}</p>
                        </div>
                    @endif

                    <div class="mt-6 rounded-2xl glass p-6 sm:p-8">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">overview</p>
                        <p class="mt-3 text-[15px] leading-8 text-slate-300">{{ $portfolio->description }}</p>
                    </div>

                    @if ($portfolio->content)
                        <div class="prose-neon mt-10">
                            {!! \Illuminate\Support\Str::markdown($portfolio->content) !!}
                        </div>
                    @endif

                    <div class="mt-10 flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-6">
                        <a href="{{ route('home') }}#work" class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 transition-colors hover:text-matrix">← back to all work</a>
                        <a href="{{ route('home') }}#contact" class="btn-secondary">start a similar project →</a>
                    </div>
                </div>

                <aside class="space-y-5 lg:sticky lg:top-28 lg:self-start">
                    <div class="rounded-2xl glass p-5">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">stack</p>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($portfolio->tech_stack ?? [] as $tech)
                                <span class="chip">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl glass p-5">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">links</p>
                        <div class="mt-3 space-y-2">
                            @if ($portfolio->live_url)
                                <a href="{{ $portfolio->live_url }}" target="_blank" rel="noopener noreferrer" data-track-project data-track-url="{{ route('projects.click', $portfolio) }}" data-track-type="live" class="flex items-center justify-between rounded-lg border border-white/10 px-3 py-2.5 font-mono text-[10px] text-slate-300 transition-colors hover:border-matrix/30 hover:text-matrix">
                                    live system <span>↗</span>
                                </a>
                            @endif
                            @if ($portfolio->github_url)
                                <a href="{{ $portfolio->github_url }}" target="_blank" rel="noopener noreferrer" data-track-project data-track-url="{{ route('projects.click', $portfolio) }}" data-track-type="github" class="flex items-center justify-between rounded-lg border border-white/10 px-3 py-2.5 font-mono text-[10px] text-slate-300 transition-colors hover:border-cyber/30 hover:text-cyber">
                                    source code <span>↗</span>
                                </a>
                            @endif
                            @if ($portfolio->dashboard_url)
                                <a href="{{ $portfolio->dashboard_url }}" target="_blank" rel="noopener noreferrer" data-track-project data-track-url="{{ route('projects.click', $portfolio) }}" data-track-type="dashboard" class="flex items-center justify-between rounded-lg border border-white/10 px-3 py-2.5 font-mono text-[10px] text-slate-300 transition-colors hover:border-plasma/30 hover:text-plasma">
                                    dashboard <span>↗</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">signals</p>
                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <div class="rounded-lg border border-white/10 bg-void/40 p-3">
                                <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">views</p>
                                <p class="mt-1 font-mono text-base {{ $accentText }}">{{ number_format($portfolio->views_count ?? 0) }}</p>
                            </div>
                            <div class="rounded-lg border border-white/10 bg-void/40 p-3">
                                <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">clicks</p>
                                <p class="mt-1 font-mono text-base text-slate-200">{{ number_format($portfolio->clicks_count ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($relatedProjects->isNotEmpty())
        <section class="relative py-16">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-matrix">related work</p>
                        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">More {{ $isData ? 'data' : 'software' }} case studies</h2>
                    </div>
                    <a href="{{ route('home') }}#work" class="hidden font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 transition-colors hover:text-matrix sm:block">view all →</a>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedProjects as $related)
                        <x-project-card :portfolio="$related" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
