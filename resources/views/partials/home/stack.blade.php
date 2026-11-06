@php
    $skillGroups = $skills->groupBy('category');
    $averageProficiency = $skills->isNotEmpty() ? (int) round($skills->avg('proficiency')) : 0;
    $topSkills = $skills->sortByDesc('proficiency')->take(3);
@endphp

<section id="stack" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <x-section-heading
                eyebrow="stack matrix / 02"
                title="Tools I reach for. Depth where it matters."
                description="A working inventory, not a logo wall. Every row is something I have shipped with — the percentage reflects how deep I can go without a search engine."
            />

            <div class="grid shrink-0 grid-cols-3 gap-3">
                <div class="rounded-xl border border-white/10 bg-white/[0.02] px-4 py-3">
                    <p class="font-mono text-2xl font-semibold text-slate-100">{{ $skills->count() }}</p>
                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">tools tracked</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-white/[0.02] px-4 py-3">
                    <p class="font-mono text-2xl font-semibold text-slate-100">{{ $skillGroups->count() }}</p>
                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">disciplines</p>
                </div>
                <div class="rounded-xl border border-matrix/20 bg-matrix/[0.04] px-4 py-3">
                    <p class="font-mono text-2xl font-semibold text-matrix">{{ $averageProficiency }}<span class="text-sm">%</span></p>
                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">avg depth</p>
                </div>
            </div>
        </div>

        <div x-data="{ filter: 'all' }" class="mt-12">
            <div class="terminal-shell overflow-hidden rounded-2xl">
                <div class="flex flex-col gap-3 border-b border-white/10 bg-white/[0.02] px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="terminal-dots flex gap-1.5">
                            <span class="h-2 w-2 rounded-full"></span>
                            <span class="h-2 w-2 rounded-full"></span>
                            <span class="h-2 w-2 rounded-full"></span>
                        </div>
                        <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">stack --matrix --interactive</span>
                    </div>
                    <span class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-600">
                        <span class="text-matrix">●</span> live inventory
                    </span>
                </div>

                <div class="flex flex-wrap gap-2 border-b border-white/10 bg-void/40 px-4 py-3">
                    <button
                        type="button"
                        @click="filter = 'all'"
                        class="rounded-full border px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors"
                        :class="filter === 'all' ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 text-slate-400 hover:border-white/20 hover:text-slate-200'"
                    >
                        all <span class="text-slate-600">({{ $skills->count() }})</span>
                    </button>
                    @foreach (\App\Models\Skill::CATEGORIES as $key => $label)
                        @if ($skillGroups->has($key))
                            <button
                                type="button"
                                @click="filter = '{{ $key }}'"
                                class="rounded-full border px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors"
                                :class="filter === '{{ $key }}' ? 'border-cyber/40 bg-cyber/10 text-cyber' : 'border-white/10 text-slate-400 hover:border-white/20 hover:text-slate-200'"
                            >
                                {{ $label }} <span class="text-slate-600">({{ $skillGroups[$key]->count() }})</span>
                            </button>
                        @endif
                    @endforeach
                </div>

                <div class="grid gap-3 p-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills as $skill)
                        <article
                            x-show="filter === 'all' || filter === '{{ $skill->category }}'"
                            x-transition.opacity.duration.180ms
                            class="group rounded-xl border border-white/10 bg-white/[0.02] p-4 transition-colors hover:border-white/20 hover:bg-white/[0.035]"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg border border-white/10 bg-void/60 font-mono text-[11px] font-semibold" style="color: {{ $skill->color }}">
                                        {{ strtoupper(substr($skill->name, 0, 2)) }}
                                    </span>
                                    <div>
                                        <p class="font-mono text-xs font-medium text-slate-100">{{ $skill->name }}</p>
                                        <p class="mt-0.5 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">{{ $skill->categoryLabel() }}</p>
                                    </div>
                                </div>
                                <span class="font-mono text-[11px] font-semibold" style="color: {{ $skill->color }}">{{ $skill->proficiency }}%</span>
                            </div>

                            <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-white/5">
                                <div
                                    class="h-full rounded-full transition-all duration-700"
                                    style="width: {{ $skill->proficiency }}%; background-color: {{ $skill->color }}; box-shadow: 0 0 12px {{ $skill->color }}66;"
                                ></div>
                            </div>

                            <div class="mt-3 flex items-center justify-between gap-2">
                                <p class="line-clamp-1 text-[11px] leading-5 text-slate-500">{{ $skill->description }}</p>
                                @if ($skill->years_experience)
                                    <span class="shrink-0 font-mono text-[9px] text-slate-600">{{ rtrim(rtrim(number_format((float) $skill->years_experience, 1), '0'), '.') }}y</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-white/10 bg-white/[0.02] px-4 py-3 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">
                    <span><span class="text-matrix">›</span> deepest signal: {{ $topSkills->pluck('name')->implode(' · ') }}</span>
                    <span class="text-slate-700">select a discipline to filter</span>
                </div>
            </div>
        </div>
    </div>
</section>
