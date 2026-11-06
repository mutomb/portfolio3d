<a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[120] focus:rounded-lg focus:bg-matrix focus:px-4 focus:py-2 focus:font-mono focus:text-xs focus:text-void">
    Skip to content
</a>

<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = window.scrollY > 18"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="scrolled ? 'border-b border-white/10 bg-void/85 backdrop-blur-xl' : 'border-b border-transparent bg-transparent'"
>
    <div class="mx-auto flex h-[4.5rem] max-w-7xl items-center justify-between gap-4 px-5 sm:px-8">
        <a href="{{ route('home') }}" class="group flex items-center gap-3">
            <span class="relative grid h-10 w-10 place-items-center overflow-hidden rounded-xl border border-matrix/30 bg-matrix/10 shadow-[0_0_24px_-6px_rgba(0,255,156,.5)]">
                <span class="absolute inset-0 bg-gradient-to-br from-matrix/20 via-transparent to-cyber/20"></span>
                <span class="relative font-mono text-[11px] font-bold tracking-tighter text-matrix">P3D</span>
            </span>
            <span class="flex flex-col leading-none">
                <span class="font-mono text-sm font-semibold tracking-tight text-slate-100">portfolio<span class="text-matrix">3d</span></span>
                <span class="mt-1 font-mono text-[9px] uppercase tracking-[0.28em] text-slate-500">spatial portfolio v3</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
            @foreach ([
                ['#about', 'about'],
                ['#stack', 'stack'],
                ['#work', 'work'],
                ['#services', 'services'],
                ['#experience', 'experience'],
                ['#reviews', 'reviews'],
                ['#contact', 'contact'],
            ] as [$href, $label])
                <a href="{{ route('home') }}{{ $href }}" class="group relative rounded-lg px-3 py-2 font-mono text-[11px] uppercase tracking-[0.18em] text-slate-400 transition-colors hover:text-matrix">
                    <span class="text-matrix/50 transition-colors group-hover:text-matrix">/</span> {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            <button
                type="button"
                @click="$dispatch('open-command-palette')"
                class="hidden items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3 py-2 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-400 transition-colors hover:border-cyber/40 hover:text-cyber sm:flex"
                aria-label="Open command palette"
            >
                <span class="text-cyber">⌘</span> command
                <kbd class="rounded border border-white/10 bg-white/5 px-1.5 py-0.5 text-[9px] text-slate-500">K</kbd>
            </button>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-ghost hidden sm:inline-flex">
                    <span class="h-1.5 w-1.5 rounded-full bg-matrix"></span> control
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost hidden sm:inline-flex">control</a>
            @endauth

            <a href="{{ route('home') }}#contact" class="btn-primary hidden !px-4 !py-2.5 md:inline-flex">
                start a project
                <span aria-hidden="true">↗</span>
            </a>

            <button
                type="button"
                class="grid h-10 w-10 place-items-center rounded-lg border border-white/10 bg-white/[0.03] text-slate-300 lg:hidden"
                @click="open = !open"
                :aria-expanded="open"
                aria-label="Toggle navigation"
            >
                <svg x-show="!open" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition.origin.top class="border-t border-white/10 bg-void/95 px-5 pb-5 pt-3 backdrop-blur-xl lg:hidden">
        <nav class="grid gap-1" aria-label="Mobile">
            @foreach ([
                ['#about', 'about'],
                ['#stack', 'stack'],
                ['#work', 'work'],
                ['#analytics', 'analytics'],
                ['#services', 'services'],
                ['#experience', 'experience'],
                ['#reviews', 'reviews'],
                ['#contact', 'contact'],
            ] as [$href, $label])
                <a href="{{ route('home') }}{{ $href }}" @click="open = false" class="flex items-center justify-between rounded-lg px-3 py-3 font-mono text-xs uppercase tracking-[0.18em] text-slate-300 transition-colors hover:bg-white/5 hover:text-matrix">
                    {{ $label }} <span class="text-matrix/50">→</span>
                </a>
            @endforeach
            <div class="mt-3 grid grid-cols-2 gap-2">
                <button type="button" @click="open = false; $dispatch('open-command-palette')" class="btn-secondary !py-2.5">⌘ command</button>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-ghost !py-2.5">control center</a>
                @else
                    <a href="{{ route('login') }}" class="btn-ghost !py-2.5">admin login</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
