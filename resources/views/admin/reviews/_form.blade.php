@php $editing = isset($review) && $review; @endphp

<div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr]">
    <div class="glass rounded-2xl p-5 sm:p-6">
        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">review</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
                <label for="client_name" class="form-label">client name <span class="text-ember">*</span></label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $review->client_name ?? '') }}" class="form-field @error('client_name') !border-ember/50 @enderror" required>
                @error('client_name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="company" class="form-label">company</label>
                <input type="text" name="company" id="company" value="{{ old('company', $review->company ?? '') }}" class="form-field @error('company') !border-ember/50 @enderror">
                @error('company')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="client_role" class="form-label">role</label>
                <input type="text" name="client_role" id="client_role" value="{{ old('client_role', $review->client_role ?? '') }}" class="form-field @error('client_role') !border-ember/50 @enderror" placeholder="VP Engineering">
                @error('client_role')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="rating" class="form-label">rating <span class="text-ember">*</span></label>
                <select name="rating" id="rating" class="form-field @error('rating') !border-ember/50 @enderror" required>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected((int) old('rating', $review->rating ?? 5) === $i)>{{ $i }} star{{ $i === 1 ? '' : 's' }}</option>
                    @endfor
                </select>
                @error('rating')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="content" class="form-label">review <span class="text-ember">*</span></label>
                <textarea name="content" id="content" rows="6" class="form-field resize-y @error('content') !border-ember/50 @enderror" required>{{ old('content', $review->content ?? '') }}</textarea>
                @error('content')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="project_url" class="form-label">project url</label>
                <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $review->project_url ?? '') }}" class="form-field @error('project_url') !border-ember/50 @enderror" placeholder="https://…">
                @error('project_url')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">avatar</p>
            @if ($editing && $review->avatar)
                <img src="{{ $review->avatarUrl() }}" alt="{{ $review->client_name }}" class="mt-3 h-20 w-20 rounded-full border border-white/15 object-cover">
            @else
                <div class="mt-3 grid h-20 w-20 place-items-center rounded-full border border-dashed border-white/15 bg-void/40 font-mono text-[10px] text-slate-600">none</div>
            @endif
            <div class="mt-3">
                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-field !px-2 !py-2 text-[11px] file:mr-3 file:rounded-md file:border-0 file:bg-matrix/15 file:px-2.5 file:py-1.5 file:font-mono file:text-[10px] file:text-matrix">
                <p class="form-help">Square image works best · max 2MB.</p>
                @error('avatar')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">visibility</p>
            <div class="mt-4 space-y-3">
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">featured</span>
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $review->is_featured ?? false)) class="h-4 w-4 rounded border-white/20 bg-void text-signal focus:ring-signal/30">
                </label>
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">active</span>
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $review->is_active ?? true)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
                </label>
                <div>
                    <label for="sort_order" class="form-label">sort order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $review->sort_order ?? 0) }}" min="0" max="9999" class="form-field">
                    @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary w-full">{{ $editing ? 'save review' : 'add review' }} <span aria-hidden="true">→</span></button>
            <a href="{{ route('admin.reviews.index') }}" class="btn-ghost w-full !justify-center">cancel</a>
        </div>
    </div>
</div>
