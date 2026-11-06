<section id="about" class="relative scroll-mt-24 py-24">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <div class="reveal">
                <x-section-heading
                    eyebrow="operator profile / 01"
                    title="Engineering rigor. Analyst curiosity."
                    description="Most teams have either a builder or an analyst. I work in the seam between them: shipping the system, then proving what it changed."
                />

                <div class="mt-9 grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">base</p>
                        <p class="mt-2 text-sm text-slate-200">{{ $site['location'] ?? 'Nairobi · Remote' }}</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">focus</p>
                        <p class="mt-2 text-sm text-slate-200">Product systems · analytics</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">working style</p>
                        <p class="mt-2 text-sm text-slate-200">Small scope, deep work</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">next window</p>
                        <p class="mt-2 text-sm text-matrix">Q1 2027</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach (['Systems thinking', 'Evidence over opinion', 'Clear handover', 'Calm delivery'] as $principle)
                        <span class="chip border-cyber/20 bg-cyber/5 text-cyber">{{ $principle }}</span>
                    @endforeach
                </div>
            </div>

            <div class="reveal">
                <div class="terminal-shell overflow-hidden rounded-2xl">
                    <div class="flex items-center justify-between border-b border-white/10 bg-white/[0.02] px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="terminal-dots flex gap-1.5">
                                <span class="h-2 w-2 rounded-full"></span>
                                <span class="h-2 w-2 rounded-full"></span>
                                <span class="h-2 w-2 rounded-full"></span>
                            </div>
                            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">about.txt</span>
                        </div>
                        <span class="font-mono text-[9px] text-slate-600">read-only</span>
                    </div>

                    <div class="space-y-5 p-6 font-mono text-[12px] leading-7 sm:p-8">
                        <div>
                            <p class="text-matrix">$ cat about.txt</p>
                            <p class="mt-3 text-slate-400">
                                I am a software developer and data analyst with seven years of experience turning ambiguous operational problems into shipped systems and measurable outcomes.
                            </p>
                        </div>

                        <div class="rounded-xl border border-white/10 bg-void/60 p-4">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">current operating model</p>
                            <div class="mt-3 space-y-2 text-slate-300">
                                <p><span class="text-cyber">01</span> Understand the decision before the dashboard.</p>
                                <p><span class="text-cyber">02</span> Model the domain before the schema.</p>
                                <p><span class="text-cyber">03</span> Instrument the system before the launch.</p>
                                <p><span class="text-cyber">04</span> Hand over something the team can own.</p>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl border border-matrix/15 bg-matrix/[0.04] p-4">
                                <p class="text-[10px] uppercase tracking-[0.18em] text-matrix">builder mode</p>
                                <p class="mt-2 text-slate-400">Laravel · Livewire · APIs · queues · CI/CD · observability</p>
                            </div>
                            <div class="rounded-xl border border-cyber/15 bg-cyber/[0.04] p-4">
                                <p class="text-[10px] uppercase tracking-[0.18em] text-cyber">analyst mode</p>
                                <p class="mt-2 text-slate-400">SQL · dbt · warehouses · Python · dashboards · experiments</p>
                            </div>
                        </div>

                        <p class="text-slate-500"><span class="text-matrix">›</span> currently exploring: decision intelligence and agentic workflows<span class="ml-1 animate-blink text-matrix">_</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
