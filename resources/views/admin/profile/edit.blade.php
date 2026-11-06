@extends('layouts.admin')

@section('title', 'Profile')
@section('eyebrow', 'system / profile')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Operator profile</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">Your admin identity and credentials.</p>
        </div>
        <span class="chip border-matrix/25 bg-matrix/5 text-matrix">administrator</span>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr]">
            <div class="glass rounded-2xl p-5 sm:p-6">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">identity</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="form-label">name <span class="text-ember">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-field @error('name') !border-ember/50 @enderror" required>
                        @error('name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="form-label">email <span class="text-ember">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-field @error('email') !border-ember/50 @enderror" required>
                        @error('email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="title" class="form-label">title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $user->title) }}" class="form-field @error('title') !border-ember/50 @enderror">
                        @error('title')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="bio" class="form-label">bio</label>
                        <textarea name="bio" id="bio" rows="5" class="form-field resize-y @error('bio') !border-ember/50 @enderror">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 border-t border-white/10 pt-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyber">change password</p>
                    <p class="mt-1 text-[11px] text-slate-500">Leave blank to keep the current password.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="current_password" class="form-label">current password</label>
                            <input type="password" name="current_password" id="current_password" class="form-field @error('current_password') !border-ember/50 @enderror" autocomplete="current-password">
                            @error('current_password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password" class="form-label">new password</label>
                            <input type="password" name="password" id="password" class="form-field @error('password') !border-ember/50 @enderror" autocomplete="new-password">
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="form-label">confirm password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-field" autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="glass rounded-2xl p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">avatar</p>
                    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="mt-3 h-24 w-24 rounded-full border border-white/15 object-cover">
                    <div class="mt-3">
                        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-field !px-2 !py-2 text-[11px] file:mr-3 file:rounded-md file:border-0 file:bg-matrix/15 file:px-2.5 file:py-1.5 file:font-mono file:text-[10px] file:text-matrix">
                        <p class="form-help">Square image · max 2MB.</p>
                        @error('avatar')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
                    <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">session</p>
                    <p class="mt-2 font-mono text-[10px] leading-5 text-slate-400">Signed in as <span class="text-slate-200">{{ $user->email }}</span></p>
                    <p class="mt-1 font-mono text-[10px] text-slate-500">Role · {{ $user->role ?? 'admin' }}</p>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="btn-danger w-full !justify-center">end session</button>
                    </form>
                </div>

                <button type="submit" class="btn-primary w-full">save profile <span aria-hidden="true">→</span></button>
            </div>
        </div>
    </form>
@endsection
