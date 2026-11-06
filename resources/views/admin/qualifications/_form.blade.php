@php $editing = isset($qualification) && $qualification; @endphp

<div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr]">
    <div class="glass rounded-2xl p-5 sm:p-6">
        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">credential</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="form-label">title <span class="text-ember">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $qualification->title ?? '') }}" class="form-field @error('title') !border-ember/50 @enderror" required>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="institution" class="form-label">institution <span class="text-ember">*</span></label>
                <input type="text" name="institution" id="institution" value="{{ old('institution', $qualification->institution ?? '') }}" class="form-field @error('institution') !border-ember/50 @enderror" required>
                @error('institution')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="type" class="form-label">type <span class="text-ember">*</span></label>
                <select name="type" id="type" class="form-field @error('type') !border-ember/50 @enderror" required>
                    @foreach (['education' => 'Education', 'certification' => 'Certification', 'award' => 'Award'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $qualification->type ?? 'education') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="started_at" class="form-label">started at</label>
                <input type="date" name="started_at" id="started_at" value="{{ old('started_at', $qualification?->started_at?->format('Y-m-d') ?? '') }}" class="form-field">
                @error('started_at')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="completed_at" class="form-label">completed at</label>
                <input type="date" name="completed_at" id="completed_at" value="{{ old('completed_at', $qualification?->completed_at?->format('Y-m-d') ?? '') }}" class="form-field">
                @error('completed_at')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="form-label">description</label>
                <textarea name="description" id="description" rows="4" class="form-field resize-y @error('description') !border-ember/50 @enderror">{{ old('description', $qualification->description ?? '') }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">state</p>
            <div class="mt-4 space-y-3">
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">currently studying</span>
                    <input type="checkbox" name="is_current" value="1" @checked(old('is_current', $qualification->is_current ?? false)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
                </label>
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">active</span>
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $qualification->is_active ?? true)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
                </label>
                <div>
                    <label for="sort_order" class="form-label">sort order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $qualification->sort_order ?? 0) }}" min="0" max="9999" class="form-field">
                    @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary w-full">{{ $editing ? 'save credential' : 'add credential' }} <span aria-hidden="true">→</span></button>
            <a href="{{ route('admin.qualifications.index') }}" class="btn-ghost w-full !justify-center">cancel</a>
        </div>
    </div>
</div>
