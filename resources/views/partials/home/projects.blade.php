@php
    $softwareCount = $projects->where('project_type', 'software')->count();
    $dataCount = $projects->where('project_type', 'data')->count();
    $featuredCount = $projects->where('is_featured', true)->count();
@endphp

<section id="work" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-matrix/20 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <x-section-heading
                eyebrow="case studies / 03"
                title="Systems shipped. Outcomes measured."
                description="Each case study covers the brief, the architecture decisions and the numbers that changed. Filter by discipline or start with the featured work."
            />

            <div class="flex flex-wrap items-center gap-3">
                <span class="chip border-matrix/20 bg-matrix/5 text-matrix">{{ $projects->count() }} published</span>
                <span class="chip border-cyber/20 bg-cyber/5 text-cyber">{{ $softwareCount }} software</span>
                <span class="chip border-plasma/20 bg-plasma/5 text-plasma">{{ $dataCount }} data</span>
            </div>
        </div>

        <div x-data="{ filter: 'all' }" class="mt-12">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap gap-2">
                    @foreach ([
                        ['all', 'all work', $projects->count()],
                        ['featured', 'featured', $featuredCount],
                        ['software', 'software', $softwareCount],
                        ['data', 'data & analytics', $dataCount],
                    ] as [$key, $label, $count])
                        <button
                            type="button"
                            @click="filter = '{{ $key }}'"
                            class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.16em] transition-colors"
                            :class="filter === '{{ $key }}' ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 bg-white/[0.02] text-slate-400 hover:border-white/25 hover:text-slate-200'"
                        >
                            {{ $label }} <span class="text-slate-600">/ {{ $count }}</span>
                        </button>
                    @endforeach
                </div>

                <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-600">
                    sorted by signal <span class="text-matrix">↘</span>
                </p>
            </div>

            <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($projects as $project)
                    <x-project-card
                        :portfolio="$project"
                        x-show="filter === 'all' || filter === '{{ $project->project_type }}' || (filter === 'featured' && {{ $project->is_featured ? 'true' : 'false' }})"
                        x-transition.opacity.duration.180ms
                    />
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-white/15 bg-white/[0.02] p-12 text-center">
                        <p class="font-mono text-sm text-slate-300">No case studies published yet.</p>
                        <p class="mt-2 font-mono text-[11px] text-slate-500">The work is being documented. Check back shortly.</p>
                    </div>
                @endforelse
            </div>

            @if ($projects->isNotEmpty())
                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-white/10 bg-white/[0.02] px-4 py-3">
                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">
                        <span class="text-matrix">›</span> click a card to open the full case study
                    </p>
                    <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-600">
                        outbound links are tracked anonymously
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
