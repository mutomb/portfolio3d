@php $editing = isset($category) && $category; @endphp

<div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr]">
    <div class="glass rounded-2xl p-5 sm:p-6">
        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">category</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="form-label">name <span class="text-ember">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" class="form-field @error('name') !border-ember/50 @enderror" required>
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug" class="form-label">slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}" class="form-field @error('slug') !border-ember/50 @enderror" placeholder="auto-generated">
                @error('slug')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="type" class="form-label">type <span class="text-ember">*</span></label>
                <select name="type" id="type" class="form-field @error('type') !border-ember/50 @enderror" required>
                    @foreach (['software' => 'Software', 'data' => 'Data', 'hybrid' => 'Hybrid'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('type', $category->type ?? 'software') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="color" class="form-label">accent colour <span class="text-ember">*</span></label>
                <div class="flex items-center gap-2">
                    <input type="color" name="color" id="color" value="{{ old('color', $category->color ?? '#00ff9c') }}" class="h-11 w-14 rounded-lg border border-white/10 bg-void p-1">
                    <input type="text" value="{{ old('color', $category->color ?? '#00ff9c') }}" class="form-field" readonly aria-label="Accent colour value">
                </div>
                @error('color')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="sort_order" class="form-label">sort order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0" max="9999" class="form-field">
                @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="form-label">description</label>
                <textarea name="description" id="description" rows="3" class="form-field resize-y @error('description') !border-ember/50 @enderror">{{ old('description', $category->description ?? '') }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">visibility</p>
            <label class="mt-4 flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">active</span>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
            </label>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary w-full">{{ $editing ? 'save category' : 'create category' }} <span aria-hidden="true">→</span></button>
            <a href="{{ route('admin.categories.index') }}" class="btn-ghost w-full !justify-center">cancel</a>
        </div>
    </div>
</div>
