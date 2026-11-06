<footer x-data class="relative mt-24 border-t border-white/10 bg-abyss/60">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px neon-line opacity-60"></div>

    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
        <div class="glass relative overflow-hidden rounded-3xl p-8 sm:p-12">
            <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-matrix/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 left-1/3 h-64 w-64 rounded-full bg-cyber/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="font-mono text-[10px] uppercase tracking-[0.3em] text-matrix">open channel / 04</p>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-slate-100 sm:text-4xl">
                        Have a system to build<br class="hidden sm:block"> or a signal to find?
                    </h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-400">
                        Send a short brief through the contact terminal. I reply within 24 hours with a point of view, a rough scope and the next useful step.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('home') }}#contact" class="btn-primary">open contact terminal <span aria-hidden="true">→</span></a>
                    <button type="button" @click="$dispatch('open-command-palette')" class="btn-secondary">⌘ command palette</button>
                </div>
            </div>
        </div>

        <div class="mt-14 grid gap-10 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-9 w-9 place-items-center rounded-lg border border-matrix/30 bg-matrix/10 font-mono text-[10px] font-bold text-matrix">P3D</span>
                    <span class="font-mono text-sm font-semibold text-slate-100">portfolio<span class="text-matrix">3d</span></span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-7 text-slate-500">
                    {{ $site['site_tagline'] ?? 'Software systems. Data stories. Real outcomes.' }}
                </p>
                <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-matrix/20 bg-matrix/5 px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.16em] text-matrix">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-matrix opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-matrix"></span>
                    </span>
                    {{ $site['availability_text'] ?? 'Available for select projects' }}
                </div>
            </div>

            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-slate-500">navigate</p>
                <ul class="mt-4 grid gap-2.5 text-sm">
                    @foreach ([['#about', 'About'], ['#stack', 'Stack matrix'], ['#work', 'Case studies'], ['#analytics', 'Live signals'], ['#services', 'Services'], ['#contact', 'Contact']] as [$href, $label])
                        <li><a href="{{ route('home') }}{{ $href }}" class="text-slate-400 transition-colors hover:text-matrix">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-slate-500">connect</p>
                <ul class="mt-4 grid gap-2.5 text-sm">
                    <li>
                        <a href="mailto:{{ $site['email'] ?? 'hello@portfolio3d.test' }}" class="inline-flex items-center gap-2 text-slate-400 transition-colors hover:text-matrix">
                            <span class="text-cyber">@</span> {{ $site['email'] ?? 'hello@portfolio3d.test' }}
                        </a>
                    </li>
                    @if (! empty($site['github_url']))
                        <li><a href="{{ $site['github_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-slate-400 transition-colors hover:text-matrix"><span class="text-cyber">↗</span> GitHub</a></li>
                    @endif
                    @if (! empty($site['linkedin_url']))
                        <li><a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-slate-400 transition-colors hover:text-matrix"><span class="text-cyber">↗</span> LinkedIn</a></li>
                    @endif
                    @if (! empty($site['twitter_url']))
                        <li><a href="{{ $site['twitter_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-slate-400 transition-colors hover:text-matrix"><span class="text-cyber">↗</span> X / Twitter</a></li>
                    @endif
                </ul>
                <p class="mt-5 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-600">{{ $site['location'] ?? 'Remote worldwide' }}</p>
            </div>
        </div>

        <div class="mt-14 flex flex-col gap-4 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-mono text-[10px] uppercase tracking-[0.18em] text-slate-600">
                © {{ date('Y') }} {{ $site['owner_name'] ?? 'Portfolio3d' }} · all systems nominal
            </p>
            <div class="flex flex-wrap items-center gap-4 font-mono text-[10px] uppercase tracking-[0.18em] text-slate-600">
                <span>Laravel {{ app()->version() }}</span>
                <span class="text-slate-700">/</span>
                <span>Tailwind 4</span>
                <span class="text-slate-700">/</span>
                <span>Alpine</span>
                <a href="#" class="transition-colors hover:text-matrix">back to top ↑</a>
            </div>
        </div>
    </div>
</footer>
