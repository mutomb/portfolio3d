@php
    $avatarPath = $site['avatar_path'] ?? 'images/avatar.svg';
    $avatarUrl = str_starts_with($avatarPath, 'http')
        ? $avatarPath
        : (str_starts_with($avatarPath, 'images/') ? asset($avatarPath) : asset('uploads/'.$avatarPath));
    $availability = $site['availability_status'] ?? 'available';
    $availabilityClass = match ($availability) {
        'limited' => 'border-signal/30 bg-signal/10 text-signal',
        'unavailable' => 'border-ember/30 bg-ember/10 text-ember',
        default => 'border-matrix/30 bg-matrix/10 text-matrix',
    };
@endphp

<section id="home" class="relative overflow-hidden pb-16 pt-32 sm:pt-40">
    <div class="pointer-events-none absolute left-1/2 top-24 h-[36rem] w-[36rem] -translate-x-1/2 rounded-full bg-matrix/5 blur-[130px]"></div>
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-matrix/40 to-transparent"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid items-center gap-16 lg:grid-cols-[1.08fr_0.92fr]">
            <div class="reveal">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 font-mono text-[10px] uppercase tracking-[0.18em] {{ $availabilityClass }}">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-current opacity-50"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-current"></span>
                        </span>
                        {{ $site['availability_text'] ?? 'Available for select projects' }}
                    </span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-600">build 2026.11 / online</span>
                </div>

                <p class="mt-8 font-mono text-[11px] uppercase tracking-[0.28em] text-slate-500">
                    <span class="text-matrix">//</span> {{ $site['location'] ?? 'Nairobi · Remote worldwide' }}
                </p>

                <h1 class="mt-4 max-w-3xl text-[2.7rem] font-semibold leading-[1.05] tracking-tight text-slate-100 sm:text-6xl lg:text-[4.25rem]">
                    Building <span class="text-gradient">software</span><br>
                    that makes data<br>
                    <span class="text-gradient-matrix">trustworthy.</span>
                </h1>

                <div class="mt-6 flex min-h-8 items-center gap-2 font-mono text-sm text-slate-400 sm:text-base">
                    <span class="text-matrix">$</span>
                    <span class="text-slate-500">whoami</span>
                    <span class="text-cyber" x-data="typewriter" x-text="text"></span>
                    <span class="inline-block h-5 w-[2px] animate-blink bg-matrix align-middle"></span>
                </div>

                <p class="mt-6 max-w-xl text-[15px] leading-8 text-slate-400">
                    I am {{ $site['owner_name'] ?? 'Jeanluc Mutomb' }} — a {{ strtolower($site['owner_title'] ?? 'software developer and data analyst') }} who ships production systems and the analytics layers that make them measurable. Seven years across product engineering, SQL architecture and decision-ready dashboards.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="#work" class="btn-primary">
                        explore the work <span aria-hidden="true">→</span>
                    </a>
                    <a href="#contact" class="btn-secondary">
                        <span class="text-matrix">▸</span> open contact terminal
                    </a>
                    @if (! empty($site['resume_path']))
                        <a href="{{ route('resume') }}" class="btn-ghost !px-4 !py-3">
                            <span aria-hidden="true">↓</span> download CV
                        </a>
                    @endif
                </div>

                <div class="mt-10 grid max-w-lg grid-cols-3 divide-x divide-white/10 rounded-xl border border-white/10 bg-white/[0.02]">
                    <div class="px-4 py-3.5">
                        <p class="font-mono text-2xl font-semibold text-slate-100">{{ $site['years_experience'] ?? 7 }}<span class="text-matrix">+</span></p>
                        <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">years shipping</p>
                    </div>
                    <div class="px-4 py-3.5">
                        <p class="font-mono text-2xl font-semibold text-slate-100">{{ $site['projects_completed'] ?? 48 }}<span class="text-cyber">+</span></p>
                        <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">projects shipped</p>
                    </div>
                    <div class="px-4 py-3.5">
                        <p class="font-mono text-2xl font-semibold text-slate-100">{{ $site['satisfaction_rate'] ?? 98 }}<span class="text-plasma">%</span></p>
                        <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">client rating</p>
                    </div>
                </div>

                <p class="mt-6 flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-600">
                    <span class="rounded border border-white/10 bg-white/5 px-1.5 py-0.5 text-slate-400">⌘ K</span>
                    keyboard-first navigation
                    <span class="text-slate-700">/</span>
                    <span class="text-matrix/70">try “help”</span>
                </p>
            </div>

            <div class="reveal relative mx-auto h-[30rem] w-full max-w-[31rem] sm:h-[34rem]">
                <div class="absolute inset-8 rounded-full border border-matrix/15"></div>
                <div class="absolute inset-14 rounded-full border border-dashed border-cyber/20 animate-spin-slow"></div>
                <div class="absolute inset-20 animate-spin-slow rounded-full border border-plasma/15" style="animation-direction: reverse; animation-duration: 16s;"></div>
                <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-matrix/5 blur-3xl"></div>

                <div class="absolute left-1/2 top-[38%] -translate-x-1/2 -translate-y-1/2">
                    <div class="relative h-44 w-44 overflow-hidden rounded-full border border-matrix/30 bg-panel shadow-[0_0_80px_-20px_rgba(0,255,156,.45)] sm:h-52 sm:w-52">
                        <img src="{{ $avatarUrl }}" alt="{{ $site['owner_name'] ?? 'Portfolio owner' }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-void/70 via-transparent to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-3 text-center font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">operator / online</div>
                    </div>
                </div>

                <div class="glass-soft absolute left-0 top-8 rounded-xl px-3.5 py-3 sm:left-2">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">backend</p>
                    <p class="mt-1 font-mono text-xs text-slate-200">Laravel · PHP 8.5</p>
                    <p class="mt-1 font-mono text-[9px] text-matrix">p95 680ms</p>
                </div>

                <div class="glass-soft absolute right-0 top-24 rounded-xl px-3.5 py-3">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">analytics</p>
                    <p class="mt-1 font-mono text-xs text-slate-200">dbt · BigQuery</p>
                    <p class="mt-1 font-mono text-[9px] text-cyber">120 tests passing</p>
                </div>

                <div class="glass-soft absolute bottom-24 left-2 rounded-xl px-3.5 py-3 sm:bottom-28 sm:left-6">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">sql</p>
                    <p class="mt-1 font-mono text-xs text-slate-200">window functions</p>
                    <p class="mt-1 font-mono text-[9px] text-plasma">98% proficiency</p>
                </div>

                <div class="terminal-shell absolute inset-x-3 bottom-0 rounded-xl p-3.5 sm:inset-x-6">
                    <div class="flex items-center gap-2 border-b border-white/10 pb-2">
                        <div class="terminal-dots flex gap-1.5">
                            <span class="h-1.5 w-1.5 rounded-full"></span>
                            <span class="h-1.5 w-1.5 rounded-full"></span>
                            <span class="h-1.5 w-1.5 rounded-full"></span>
                        </div>
                        <span class="font-mono text-[8px] uppercase tracking-[0.18em] text-slate-500">~/portfolio · status</span>
                    </div>
                    <div class="mt-2.5 space-y-1 font-mono text-[10px] leading-5">
                        <p class="text-slate-500"><span class="text-matrix">›</span> deploy --target production</p>
                        <p class="text-slate-300"><span class="text-matrix">✓</span> 48 projects · 32 clients · 0 open incidents</p>
                        <p class="text-slate-500"><span class="text-cyber">›</span> awaiting next brief<span class="ml-1 animate-blink text-matrix">_</span></p>
                    </div>
                </div>

                <div class="absolute -right-2 top-1/2 hidden -translate-y-1/2 rotate-90 font-mono text-[8px] uppercase tracking-[0.4em] text-slate-700 sm:block">spatial index 03</div>
            </div>
        </div>

        @php
            $tickerItems = ['Laravel', 'PHP 8.5', 'Python', 'PostgreSQL', 'dbt', 'BigQuery', 'Tailwind CSS', 'Alpine.js', 'Redis', 'Docker', 'Looker', 'Power BI', 'Snowflake', 'scikit-learn'];
        @endphp
        <div class="mask-fade-x relative mt-20 overflow-hidden border-y border-white/10 bg-white/[0.015] py-4">
            <div class="flex w-max animate-marquee items-center gap-8">
                @foreach (array_merge($tickerItems, $tickerItems) as $item)
                    <span class="flex items-center gap-8 font-mono text-[10px] uppercase tracking-[0.22em] text-slate-500">
                        {{ $item }}
                        <span class="text-matrix/40">◆</span>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>
