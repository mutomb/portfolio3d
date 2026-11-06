<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#04070d">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Control center login') — {{ $site['site_name'] ?? 'Portfolio3d' }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-void font-sans text-ink">
    <div class="pointer-events-none fixed inset-0 -z-20 bg-void"></div>
    <div class="pointer-events-none fixed inset-0 -z-10 grid-surface opacity-60"></div>
    <div class="pointer-events-none fixed left-1/2 top-0 -z-10 h-[38rem] w-[38rem] -translate-x-1/2 rounded-full bg-matrix/5 blur-[120px]"></div>

    <main class="relative flex min-h-screen items-center justify-center px-5 py-12">
        @yield('content')
    </main>
</body>
</html>
