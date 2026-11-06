@php
    $typeMeta = [
        'education' => ['label' => 'education', 'accent' => 'text-matrix', 'border' => 'border-matrix/25', 'bg' => 'bg-matrix/[0.04]'],
        'certification' => ['label' => 'certification', 'accent' => 'text-cyber', 'border' => 'border-cyber/25', 'bg' => 'bg-cyber/[0.04]'],
        'award' => ['label' => 'award', 'accent' => 'text-signal', 'border' => 'border-signal/25', 'bg' => 'bg-signal/[0.04]'],
    ];
    $grouped = $qualifications->groupBy('type');
@endphp

<section id="experience" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
            <div class="reveal lg:sticky lg:top-28 lg:self-start">
                <x-section-heading
                    eyebrow="credentials / 06"
                    title="Evidence of the fundamentals."
                    description="Formal training matters less than what it lets you do. These are the programmes, certifications and awards behind the practice."
                />

                <div class="mt-8 grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    @foreach ($typeMeta as $type => $meta)
                        <div class="rounded-xl border {{ $meta['border'] }} {{ $meta['bg'] }} p-4">
                            <p class="font-mono text-[9px] uppercase tracking-[0.16em] {{ $meta['accent'] }}">{{ $meta['label'] }}</p>
                            <p class="mt-1 font-mono text-xl font-semibold text-slate-100">{{ $grouped->get($type, collect())->count() }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 rounded-xl border border-white/10 bg-white/[0.02] p-4">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">currently learning</p>
                    <p class="mt-2 text-[13px] leading-6 text-slate-400">Decision intelligence, agentic workflows and the unglamorous work of making data pipelines observable.</p>
                </div>
            </div>

            <div class="relative">
                <div class="absolute bottom-2 left-[7px] top-2 w-px bg-gradient-to-b from-matrix/40 via-cyber/25 to-transparent"></div>

                <div class="space-y-5">
                    @forelse ($qualifications as $qualification)
                        @php $meta = $typeMeta[$qualification->type] ?? $typeMeta['education']; @endphp
                        <article class="reveal relative pl-9">
                            <span class="absolute left-0 top-5 grid h-[15px] w-[15px] place-items-center rounded-full border {{ $meta['border'] }} bg-void">
                                <span class="h-1.5 w-1.5 rounded-full {{ $qualification->is_current ? 'bg-matrix animate-pulse' : 'bg-slate-500' }}"></span>
                            </span>

                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5 transition-colors hover:border-white/20 hover:bg-white/[0.035] sm:p-6">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="chip border-white/10 {{ $meta['accent'] }}">{{ $meta['label'] }}</span>
                                            @if ($qualification->is_current)
                                                <span class="chip border-matrix/25 bg-matrix/5 text-matrix">in progress</span>
                                            @endif
                                        </div>
                                        <h3 class="mt-3 text-lg font-semibold tracking-tight text-slate-100">{{ $qualification->title }}</h3>
                                        <p class="mt-1 font-mono text-[11px] text-slate-400">{{ $qualification->institution }}</p>
                                    </div>
                                    <span class="shrink-0 rounded-lg border border-white/10 bg-void/50 px-2.5 py-1 font-mono text-[10px] text-slate-400">{{ $qualification->period_label }}</span>
                                </div>

                                @if ($qualification->description)
                                    <p class="mt-3 text-[13px] leading-6 text-slate-400">{{ $qualification->description }}</p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="pl-9 font-mono text-xs text-slate-500">No qualifications published yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
