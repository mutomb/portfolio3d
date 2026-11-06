@extends('layouts.auth')

@section('title', 'Control center login')

@section('content')
    <div class="w-full max-w-md">
        <a href="{{ route('home') }}" class="group mx-auto flex w-fit items-center gap-3">
            <span class="relative grid h-11 w-11 place-items-center overflow-hidden rounded-xl border border-matrix/30 bg-matrix/10 shadow-[0_0_24px_-6px_rgba(0,255,156,.5)]">
                <span class="absolute inset-0 bg-gradient-to-br from-matrix/20 via-transparent to-cyber/20"></span>
                <span class="relative font-mono text-[11px] font-bold tracking-tighter text-matrix">P3D</span>
            </span>
            <span class="flex flex-col leading-none">
                <span class="font-mono text-sm font-semibold tracking-tight text-slate-100">portfolio<span class="text-matrix">3d</span></span>
                <span class="mt-1 font-mono text-[9px] uppercase tracking-[0.28em] text-slate-500">control center</span>
            </span>
        </a>

        <div class="terminal-shell mt-8 overflow-hidden rounded-2xl">
            <div class="flex items-center justify-between border-b border-white/10 bg-white/[0.02] px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="terminal-dots flex gap-1.5">
                        <span class="h-2 w-2 rounded-full"></span>
                        <span class="h-2 w-2 rounded-full"></span>
                        <span class="h-2 w-2 rounded-full"></span>
                    </div>
                    <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">auth --secure</span>
                </div>
                <span class="font-mono text-[9px] text-slate-600">session required</span>
            </div>

            <div class="p-6 sm:p-8">
                <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-matrix">operator access</p>
                <h1 class="mt-3 text-2xl font-semibold tracking-tight text-slate-100">Enter the control center</h1>
                <p class="mt-2 text-[13px] leading-6 text-slate-400">Manage case studies, content, inquiries and site settings.</p>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-ember/30 bg-ember/[0.06] p-3.5">
                        @foreach ($errors->all() as $error)
                            <p class="font-mono text-[10px] leading-5 text-ember">! {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="form-label">email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', 'admin@portfolio3d.test') }}"
                            class="form-field @error('email') !border-ember/50 @enderror"
                            placeholder="admin@portfolio3d.test"
                            autocomplete="username"
                            required
                            autofocus
                        >
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label">password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-field @error('password') !border-ember/50 @enderror"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2 font-mono text-[10px] uppercase tracking-[0.14em] text-slate-500">
                        <input type="checkbox" name="remember" value="1" class="h-3.5 w-3.5 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
                        remember this device
                    </label>

                    <button type="submit" class="btn-primary w-full">authenticate <span aria-hidden="true">→</span></button>
                </form>

                <div class="mt-6 rounded-xl border border-white/10 bg-void/50 p-3.5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">demo credentials</p>
                    <p class="mt-1.5 font-mono text-[10px] text-slate-400">admin@portfolio3d.test <span class="text-slate-700">/</span> password</p>
                </div>

                <div class="mt-6 flex items-center justify-between gap-3 border-t border-white/10 pt-4 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-matrix">← back to site</a>
                    <span><span class="text-matrix">●</span> encrypted</span>
                </div>
            </div>
        </div>
    </div>
@endsection
