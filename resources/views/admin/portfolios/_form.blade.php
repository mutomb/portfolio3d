@php
    $editing = isset($portfolio) && $portfolio;
    $techValue = old('tech_stack', $editing && is_array($portfolio->tech_stack) ? implode(', ', $portfolio->tech_stack) : '');
    $completedValue = old('completed_at', $editing && $portfolio->completed_at ? $portfolio->completed_at->format('Y-m-d') : '');
@endphp

<div class="grid gap-5 xl:grid-cols-[1.35fr_0.65fr]">
    <div class="space-y-5">
        <div class="glass rounded-2xl p-5 sm:p-6">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">core</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="title" class="form-label">title <span class="text-ember">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title ?? '') }}" class="form-field @error('title') !border-ember/50 @enderror" required>
                    @error('title')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="slug" class="form-label">slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $portfolio->slug ?? '') }}" class="form-field @error('slug') !border-ember/50 @enderror" placeholder="auto-generated from title">
                    @error('slug')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="category_id" class="form-label">category <span class="text-ember">*</span></label>
                    <select name="category_id" id="category_id" class="form-field @error('category_id') !border-ember/50 @enderror" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id', $portfolio->category_id ?? 0) === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="project_type" class="form-label">discipline <span class="text-ember">*</span></label>
                    <select name="project_type" id="project_type" class="form-field @error('project_type') !border-ember/50 @enderror" required>
                        @foreach (['software' => 'Software engineering', 'data' => 'Data & analytics'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('project_type', $portfolio->project_type ?? 'software') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('project_type')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="completed_at" class="form-label">completed at</label>
                    <input type="date" name="completed_at" id="completed_at" value="{{ $completedValue }}" class="form-field @error('completed_at') !border-ember/50 @enderror">
                    @error('completed_at')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="tagline" class="form-label">tagline <span class="text-ember">*</span></label>
                    <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $portfolio->tagline ?? '') }}" class="form-field @error('tagline') !border-ember/50 @enderror" maxlength="255" required>
                    @error('tagline')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="form-label">description <span class="text-ember">*</span></label>
                    <textarea name="description" id="description" rows="4" class="form-field resize-y @error('description') !border-ember/50 @enderror" maxlength="2000" required>{{ old('description', $portfolio->description ?? '') }}</textarea>
                    @error('description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="tech_stack" class="form-label">tech stack</label>
                    <input type="text" name="tech_stack" id="tech_stack" value="{{ $techValue }}" class="form-field @error('tech_stack') !border-ember/50 @enderror" placeholder="Laravel, PostgreSQL, Redis, Tailwind CSS">
                    <p class="form-help">Comma-separated. First four appear on the project card.</p>
                    @error('tech_stack')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-5 sm:p-6">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyber">case study body</p>
            <p class="mt-1 text-[11px] text-slate-500">Markdown supported — headings, lists, bold and links.</p>
            <div class="mt-4">
                <label for="content" class="form-label">content</label>
                <textarea name="content" id="content" rows="14" class="form-field resize-y font-mono text-[12px] @error('content') !border-ember/50 @enderror" placeholder="## The brief&#10;&#10;…">{{ old('content', $portfolio->content ?? '') }}</textarea>
                @error('content')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="glass rounded-2xl p-5 sm:p-6">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-plasma">links</p>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                @foreach (['live_url' => 'live url', 'github_url' => 'github url', 'dashboard_url' => 'dashboard url'] as $field => $label)
                    <div class="{{ $field === 'dashboard_url' ? 'sm:col-span-2' : '' }}">
                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                        <input type="url" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, $portfolio->{$field} ?? '') }}" class="form-field @error($field) !border-ember/50 @enderror" placeholder="https://…">
                        @error($field)<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">publish</p>
            <div class="mt-4 space-y-3">
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">published</span>
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $portfolio->is_published ?? true)) class="h-4 w-4 rounded border-white/20 bg-void text-matrix focus:ring-matrix/30">
                </label>
                <label class="flex items-center justify-between gap-3 rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5">
                    <span class="font-mono text-[10px] uppercase tracking-[0.12em] text-slate-300">featured</span>
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $portfolio->is_featured ?? false)) class="h-4 w-4 rounded border-white/20 bg-void text-signal focus:ring-signal/30">
                </label>
                <div>
                    <label for="sort_order" class="form-label">sort order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $portfolio->sort_order ?? 0) }}" min="0" max="9999" class="form-field">
                    @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">thumbnail</p>
            @if ($editing && $portfolio->thumbnail)
                <img src="{{ $portfolio->thumbnailUrl() }}" alt="Current thumbnail" class="mt-3 aspect-[16/10] w-full rounded-xl border border-white/10 object-cover">
            @else
                <div class="mt-3 grid aspect-[16/10] place-items-center rounded-xl border border-dashed border-white/15 bg-void/40">
                    <span class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">no thumbnail</span>
                </div>
            @endif
            <div class="mt-3">
                <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp" class="form-field !px-2 !py-2 text-[11px] file:mr-3 file:rounded-md file:border-0 file:bg-matrix/15 file:px-2.5 file:py-1.5 file:font-mono file:text-[10px] file:text-matrix">
                <p class="form-help">JPG, PNG or WebP · max 4MB.</p>
                @error('thumbnail')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="glass rounded-2xl p-5">
            <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">delivery facts</p>
            <div class="mt-4 space-y-4">
                @foreach (['client' => 'client', 'role' => 'role', 'duration' => 'duration'] as $field => $label)
                    <div>
                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" id="{{ $field }}" value="{{ old($field, $portfolio->{$field} ?? '') }}" class="form-field @error($field) !border-ember/50 @enderror">
                        @error($field)<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                @endforeach
                <div>
                    <label for="results" class="form-label">results</label>
                    <textarea name="results" id="results" rows="3" class="form-field resize-y @error('results') !border-ember/50 @enderror" placeholder="63% lower p95 latency · 4x traffic headroom">{{ old('results', $portfolio->results ?? '') }}</textarea>
                    @error('results')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="btn-primary w-full">{{ $editing ? 'save changes' : 'create project' }} <span aria-hidden="true">→</span></button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn-ghost w-full !justify-center">cancel</a>
        </div>
    </div>
</div>
