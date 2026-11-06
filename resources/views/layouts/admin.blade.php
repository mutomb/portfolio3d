<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#04070d">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') — {{ $site['site_name'] ?? 'Portfolio3d' }} control</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-void font-sans text-ink" x-data="{ sidebar: false }">
    <div class="pointer-events-none fixed inset-0 -z-20 bg-void"></div>
    <div class="pointer-events-none fixed inset-0 -z-10 grid-surface opacity-40"></div>

    <div
        x-show="sidebar"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-40 bg-void/80 backdrop-blur-sm lg:hidden"
        @click="sidebar = false"
    ></div>

    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-white/10 bg-abyss/95 backdrop-blur-xl transition-transform duration-300 lg:translate-x-0"
        :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="flex h-[4.5rem] items-center justify-between border-b border-white/10 px-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <span class="relative grid h-9 w-9 place-items-center overflow-hidden rounded-lg border border-matrix/30 bg-matrix/10">
                    <span class="absolute inset-0 bg-gradient-to-br from-matrix/20 via-transparent to-cyber/20"></span>
                    <span class="relative font-mono text-[10px] font-bold tracking-tighter text-matrix">P3D</span>
                </span>
                <span class="flex flex-col leading-none">
                    <span class="font-mono text-xs font-semibold text-slate-100">control center</span>
                    <span class="mt-1 font-mono text-[8px] uppercase tracking-[0.24em] text-slate-500">v3 · online</span>
                </span>
            </a>
            <button type="button" class="grid h-8 w-8 place-items-center rounded-lg border border-white/10 text-slate-400 lg:hidden" @click="sidebar = false" aria-label="Close sidebar">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-5" aria-label="Admin">
            @php
                $navGroups = [
                    'overview' => [
                        ['admin.dashboard', 'dashboard', '▦'],
                    ],
                    'content' => [
                        ['admin.portfolios.index', 'projects', '◇'],
                        ['admin.categories.index', 'categories', '⌗'],
                        ['admin.skills.index', 'skills', '⌁'],
                        ['admin.qualifications.index', 'credentials', '≡'],
                        ['admin.services.index', 'services', '⌘'],
                        ['admin.reviews.index', 'reviews', '★'],
                    ],
                    'inbox' => [
                        ['admin.inquiries.index', 'inquiries', '✉'],
                    ],
                    'system' => [
                        ['admin.settings.index', 'settings', '⚙'],
                        ['admin.profile.edit', 'profile', '◉'],
                    ],
                ];
            @endphp

            @foreach ($navGroups as $group => $items)
                <div class="{{ $loop->first ? '' : 'mt-6' }}">
                    <p class="px-3 font-mono text-[9px] uppercase tracking-[0.22em] text-slate-600">{{ $group }}</p>
                    <div class="mt-2 space-y-1">
                        @foreach ($items as [$route, $label, $icon])
                            @php
                                $active = request()->routeIs(str_replace('.index', '.*', $route)) || request()->routeIs($route);
                                if ($route === 'admin.dashboard') {
                                    $active = request()->routeIs('admin.dashboard');
                                }
                                if ($route === 'admin.profile.edit') {
                                    $active = request()->routeIs('admin.profile.*');
                                }
                            @endphp
                            <a
                                href="{{ route($route) }}"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 font-mono text-[11px] tracking-wide transition-colors {{ $active ? 'border border-matrix/25 bg-matrix/10 text-matrix' : 'border border-transparent text-slate-400 hover:bg-white/[0.04] hover:text-slate-200' }}"
                            >
                                <span class="w-4 text-center text-[12px] {{ $active ? 'text-matrix' : 'text-slate-600' }}">{{ $icon }}</span>
                                <span class="flex-1">{{ $label }}</span>
                                @if ($route === 'admin.inquiries.index' && ($adminUnreadCount ?? 0) > 0)
                                    <span class="rounded-full bg-matrix px-1.5 py-0.5 font-mono text-[9px] font-semibold text-void">{{ $adminUnreadCount }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="border-t border-white/10 p-3">
            <div class="rounded-xl border border-white/10 bg-white/[0.02] p-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full border border-white/15 object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xs font-medium text-slate-200">{{ auth()->user()->name }}</p>
                        <p class="truncate font-mono text-[9px] text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <a href="{{ route('home') }}" class="btn-ghost !justify-center !px-2 !py-1.5 !text-[10px]">site ↗</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-danger w-full !justify-center !px-2 !py-1.5 !text-[10px]">logout</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <div class="lg:pl-64">
        <header class="sticky top-0 z-30 flex h-[4.5rem] items-center justify-between gap-4 border-b border-white/10 bg-void/80 px-4 backdrop-blur-xl sm:px-6">
            <div class="flex items-center gap-3">
                <button type="button" class="grid h-9 w-9 place-items-center rounded-lg border border-white/10 text-slate-400 lg:hidden" @click="sidebar = true" aria-label="Open sidebar">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <div>
                    <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">@yield('eyebrow', 'control center')</p>
                    <h1 class="mt-0.5 text-sm font-semibold tracking-tight text-slate-100">@yield('title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="hidden items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3 py-2 font-mono text-[10px] uppercase tracking-[0.14em] text-slate-400 transition-colors hover:border-matrix/30 hover:text-matrix sm:flex">
                    view site ↗
                </a>
                <a href="{{ route('admin.inquiries.index') }}" class="relative grid h-9 w-9 place-items-center rounded-lg border border-white/10 bg-white/[0.03] text-slate-400 transition-colors hover:border-matrix/30 hover:text-matrix" aria-label="Inquiries">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/></svg>
                    @if (($adminUnreadCount ?? 0) > 0)
                        <span class="absolute -right-1 -top-1 grid h-4 min-w-4 place-items-center rounded-full bg-matrix px-1 font-mono text-[8px] font-bold text-void">{{ $adminUnreadCount }}</span>
                    @endif
                </a>
                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}" class="h-9 w-9 rounded-full border border-white/15 object-cover">
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 flex items-start justify-between gap-3 rounded-xl border border-matrix/30 bg-matrix/[0.06] px-4 py-3">
                    <p class="font-mono text-[11px] leading-5 text-matrix">✓ {{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 flex items-start justify-between gap-3 rounded-xl border border-ember/30 bg-ember/[0.06] px-4 py-3">
                    <p class="font-mono text-[11px] leading-5 text-ember">! {{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
