@php
    $serviceIcons = [
        'code' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 9l-4 3 4 3m8-6 4 3-4 3M14 5l-4 14"/>',
        'database' => '<ellipse cx="12" cy="6" rx="8" ry="3"/><path stroke-linecap="round" d="M4 6v6c0 1.66 3.58 3 8 3s8-1.34 8-3V6M4 12v6c0 1.66 3.58 3 8 3s8-1.34 8-3v-6"/>',
        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 19V9m5 10V5m5 14v-7m5 7V8"/>',
        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/>',
    ];
@endphp

<section id="services" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-plasma/20 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-section-heading
            eyebrow="engagement modes / 05"
            title="Ways to put me to work."
            description="Clear scopes, fixed starting points and a bias toward shipping. Every engagement ends with documentation and a handover the team can own."
        />

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($services as $service)
                <article class="group relative flex flex-col overflow-hidden rounded-2xl glass p-6 transition-all duration-300 hover:-translate-y-1 hover:border-plasma/30">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-plasma/10 blur-3xl opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>

                    <div class="relative flex items-start justify-between gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-xl border border-plasma/25 bg-plasma/10 text-plasma">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                {!! $serviceIcons[$service->icon] ?? $serviceIcons['code'] !!}
                            </svg>
                        </span>
                        <span class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">{{ $service->delivery_time }}</span>
                    </div>

                    <h3 class="relative mt-5 text-lg font-semibold tracking-tight text-slate-100">{{ $service->title }}</h3>
                    <p class="relative mt-2 text-[13px] leading-6 text-slate-400">{{ $service->description }}</p>

                    <ul class="relative mt-5 space-y-2">
                        @foreach (array_slice($service->features ?? [], 0, 5) as $feature)
                            <li class="flex items-start gap-2 font-mono text-[10px] leading-5 text-slate-400">
                                <span class="mt-0.5 text-matrix">▸</span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="relative mt-auto flex items-end justify-between gap-3 border-t border-white/10 pt-5">
                        <div>
                            <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">from</p>
                            <p class="mt-1 font-mono text-lg font-semibold text-slate-100">
                                ${{ number_format((float) $service->price_from) }}
                            </p>
                        </div>
                        <a href="{{ route('home') }}#contact" class="btn-ghost !border-plasma/25 !text-plasma hover:!border-plasma/50 hover:!bg-plasma/10">
                            brief me <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6 grid gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 sm:grid-cols-4">
            @foreach ([
                ['01', 'Frame', 'One call to align on the decision and constraints.'],
                ['02', 'Scope', 'A short written plan with milestones and risks.'],
                ['03', 'Build', 'Weekly demos, visible progress, no surprises.'],
                ['04', 'Handover', 'Docs, tests and a walkthrough the team owns.'],
            ] as [$step, $title, $description])
                <div class="flex gap-3 rounded-xl border border-white/5 bg-void/40 p-4">
                    <span class="font-mono text-[10px] text-matrix">{{ $step }}</span>
                    <div>
                        <p class="font-mono text-[10px] uppercase tracking-[0.14em] text-slate-200">{{ $title }}</p>
                        <p class="mt-1 text-[11px] leading-5 text-slate-500">{{ $description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
