<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $site['site_description'] ?? 'Software developer and data analyst portfolio.' }}">
    <meta name="keywords" content="{{ $site['meta_keywords'] ?? 'software developer, data analyst' }}">
    <meta name="theme-color" content="#04070d">
    <meta property="og:title" content="{{ $site['site_name'] ?? 'Portfolio3d' }} — {{ $site['site_tagline'] ?? '' }}">
    <meta property="og:description" content="{{ $site['site_description'] ?? '' }}">
    <meta property="og:type" content="website">
    <title>@yield('title', ($site['site_name'] ?? 'Portfolio3d').' — '.($site['owner_title'] ?? 'Software Developer & Data Analyst'))</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen overflow-x-hidden bg-void font-sans text-ink">
    <div class="pointer-events-none fixed inset-0 -z-20 bg-void"></div>
    <div class="pointer-events-none fixed inset-0 -z-10 grid-surface opacity-70"></div>
    <div class="pointer-events-none fixed -top-40 left-1/2 -z-10 h-[42rem] w-[42rem] -translate-x-1/2 rounded-full bg-matrix/5 blur-[120px]"></div>
    <div class="pointer-events-none fixed -right-40 top-1/3 -z-10 h-[32rem] w-[32rem] rounded-full bg-cyber/5 blur-[110px]"></div>
    <div class="pointer-events-none fixed -left-48 bottom-0 -z-10 h-[30rem] w-[30rem] rounded-full bg-plasma/5 blur-[120px]"></div>

    <div class="pointer-events-none fixed inset-x-0 top-0 z-0 h-px bg-gradient-to-r from-transparent via-matrix/30 to-transparent"></div>

    @include('partials.nav')

    <main id="main-content" class="relative z-10">
        @yield('content')
    </main>

    @include('partials.footer')

    <x-command-palette />

    @stack('scripts')
</body>
</html>
