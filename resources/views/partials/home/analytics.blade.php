@php
    $totalViews = max(0, (int) ($analytics['views'] ?? 0));
    $totalClicks = max(0, (int) ($analytics['clicks'] ?? 0));
    $clickThrough = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 1) : 0;
    $topProjects = $projects->sortByDesc('views_count')->take(5);
    $maxViews = max(1, (int) $topProjects->max('views_count'));
    $topProject = $analytics['top_project'] ?? null;
@endphp

<section id="analytics" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyber/20 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-end">
            <x-section-heading
                eyebrow="live signals / 04"
                title="The portfolio measures itself."
                description="Every case study view and outbound click is recorded. This is the same analytics layer I build for clients — small, honest and useful."
            />

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">case views</p>
                    <p class="mt-2 font-mono text-2xl font-semibold text-slate-100">{{ number_format($totalViews) }}</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">outbound</p>
                    <p class="mt-2 font-mono text-2xl font-semibold text-slate-100">{{ number_format($totalClicks) }}</p>
                </div>
                <div class="rounded-xl border border-cyber/20 bg-cyber/[0.04] p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">click rate</p>
                    <p class="mt-2 font-mono text-2xl font-semibold text-cyber">{{ $clickThrough }}<span class="text-sm">%</span></p>
                </div>
                <div class="rounded-xl border border-matrix/20 bg-matrix/[0.04] p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">signals</p>
                    <p class="mt-2 font-mono text-2xl font-semibold text-matrix">{{ number_format($totalViews + $totalClicks) }}</p>
                </div>
            </div>
        </div>

        <div class="mt-12 grid gap-5 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="terminal-shell overflow-hidden rounded-2xl">
                <div class="flex items-center justify-between border-b border-white/10 bg-white/[0.02] px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="terminal-dots flex gap-1.5">
                            <span class="h-2 w-2 rounded-full"></span>
                            <span class="h-2 w-2 rounded-full"></span>
                            <span class="h-2 w-2 rounded-full"></span>
                        </div>
                        <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">analytics --top-projects</span>
                    </div>
                    <span class="font-mono text-[9px] uppercase tracking-[0.16em] text-matrix">● live</span>
                </div>

                <div class="space-y-4 p-5 sm:p-6">
                    @forelse ($topProjects as $index => $project)
                        <div>
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="font-mono text-[10px] text-slate-600">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <a href="{{ route('projects.show', $project) }}" class="truncate text-sm text-slate-200 transition-colors hover:text-matrix">{{ $project->title }}</a>
                                </div>
                                <span class="shrink-0 font-mono text-[10px] text-slate-400">{{ number_format($project->views_count) }} views</span>
                            </div>
                            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-white/5">
                                <div
                                    class="h-full rounded-full bg-gradient-to-r from-matrix/80 to-cyber/80"
                                    style="width: {{ max(4, round(($project->views_count / $maxViews) * 100)) }}%"
                                ></div>
                            </div>
                        </div>
                    @empty
                        <p class="font-mono text-xs text-slate-500">No traffic recorded yet. The first signal will appear here.</p>
                    @endforelse

                    <div class="border-t border-white/10 pt-4 font-mono text-[10px] leading-6 text-slate-500">
                        <p><span class="text-matrix">›</span> query: <span class="text-slate-300">select project, count(*) from events group by project</span></p>
                        <p><span class="text-cyber">›</span> window: last 28 days · anonymous, no cookies</p>
                    </div>
                </div>
            </div>

            <div class="glass flex flex-col justify-between rounded-2xl p-6">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-500">top outbound signal</p>
                    @if ($topProject)
                        <a href="{{ route('projects.show', $topProject) }}" class="group mt-3 block">
                            <h3 class="text-xl font-semibold tracking-tight text-slate-100 transition-colors group-hover:text-matrix">{{ $topProject->title }}</h3>
                            <p class="mt-2 line-clamp-2 text-[13px] leading-6 text-slate-400">{{ $topProject->tagline }}</p>
                        </a>
                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-xl border border-white/10 bg-void/40 p-3">
                                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">clicks</p>
                                <p class="mt-1 font-mono text-lg text-matrix">{{ number_format($topProject->clicks_count) }}</p>
                            </div>
                            <div class="rounded-xl border border-white/10 bg-void/40 p-3">
                                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">views</p>
                                <p class="mt-1 font-mono text-lg text-cyber">{{ number_format($topProject->views_count) }}</p>
                            </div>
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-500">No outbound signals yet.</p>
                    @endif
                </div>

                <div class="mt-6 rounded-xl border border-white/10 bg-void/40 p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">what gets measured</p>
                    <ul class="mt-3 space-y-2 font-mono text-[10px] leading-5 text-slate-400">
                        <li><span class="text-matrix">✓</span> case study views, once per session</li>
                        <li><span class="text-matrix">✓</span> live, source and dashboard clicks</li>
                        <li><span class="text-matrix">✓</span> no advertising pixels or third parties</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
