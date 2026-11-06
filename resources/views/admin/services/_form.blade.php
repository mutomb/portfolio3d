@php
    $editing = isset($service) && $service;
    $featuresValue = old('features', $editing && is_array($service->features) ? implode("\n", $service->features) : '');
@endphp

<div class="grid gap-5 xl:grid-cols-[1.3fr_0.7fr]">
    <div class="glass rounded-2xl p-5 sm:p-6">
        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">service</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="form-label">title <span class="text-ember">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $service->title ?? '') }}" class="form-field @error('title') !border-ember/50 @enderror" required>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug" class="form-label">slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $service->slug ?? '') }}" class="form-field @error('slug') !border-ember/50 @enderror" placeholder="auto-generated">
                @error('slug')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="icon" class="form-label">icon</label>
                <select name="icon" id="icon" class="form-field @error('icon') !border-ember/50 @enderror">
                    @foreach (['code' => 'Code', 'database' => 'Database', 'chart' => 'Chart', 'shield' => 'Shield'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('icon', $service->icon ?? 'code') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('icon')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="form-label">description <span class="text-ember">*</span></label>
                <textarea name="description" id="description" rows="4" class="form-field resize-y @error('description') !border-ember/50 @enderror" required>{{ old('description', $service->description ?? '') }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="features" class="form-label">features</label>
                <textarea name="features" id="features" rows="6" class="form-field resize-y @error('features') !border-ember/50 @enderror" placeholder="Product discovery and scoping&#10;Laravel architecture and APIs">{{ $featuresValue }}</textarea>
                <p class="form-help">One feature per line. The first five appear on the public card.</p>
                @error('features')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">commercials</p>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="price_from" class="form-label">price from (USD)</label>
                    <input type="number" name="price_from" id="price_from" value="{{ old('price_from', $service->price_from ?? '') }}" min="0" step="0.01" class="form-field">
                    @error('price_from')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="delivery_time" class="form-label">delivery time</label>
                    <input type="text" name="delivery_time" id="delivery_time" value="{{ old('delivery_time', $service->delivery_time ?? '') }}" class="form-field" placeholder="4–12 weeks">
                    @error('delivery_time')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">visibility</p>
            <label class="mt-4 flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">active</span>
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
            </label>
            <div class="mt-4">
                <label for="sort_order" class="form-label">sort order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0" max="9999" class="form-field">
                @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary w-full">{{ $editing ? 'save service' : 'create service' }} <span aria-hidden="true">→</span></button>
            <a href="{{ route('admin.services.index') }}" class="btn-ghost w-full !justify-center">cancel</a>
        </div>
    </div>
</div>
