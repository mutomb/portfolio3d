@extends('layouts.admin')

@section('title', 'Site settings')
@section('eyebrow', 'system / settings')

@section('content')
    @php
        $fieldGroups = [
            'identity' => [
                'label' => 'Identity',
                'class' => 'text-matrix',
                'fields' => [
                    ['site_name', 'Site name', 'text', 'Portfolio3d'],
                    ['site_tagline', 'Site tagline', 'text', 'Software systems. Data stories. Real outcomes.'],
                    ['site_description', 'Site description', 'textarea', 'A short description used in meta tags.'],
                    ['owner_name', 'Owner name', 'text', 'Jeanluc Mutomb'],
                    ['owner_title', 'Owner title', 'text', 'Software Developer & Data Analyst'],
                    ['meta_keywords', 'Meta keywords', 'text', 'software developer, data analyst'],
                ],
            ],
            'contact' => [
                'label' => 'Contact & availability',
                'class' => 'text-cyber',
                'fields' => [
                    ['email', 'Email', 'email', 'hello@portfolio3d.test'],
                    ['phone', 'Phone', 'text', '+254 …'],
                    ['location', 'Location', 'text', 'Nairobi, Kenya · Remote worldwide'],
                    ['availability_text', 'Availability text', 'text', 'Available for select projects'],
                ],
            ],
            'social' => [
                'label' => 'Social links',
                'class' => 'text-plasma',
                'fields' => [
                    ['github_url', 'GitHub URL', 'url', 'https://github.com/…'],
                    ['linkedin_url', 'LinkedIn URL', 'url', 'https://linkedin.com/in/…'],
                    ['twitter_url', 'X / Twitter URL', 'url', 'https://x.com/…'],
                    ['dribbble_url', 'Dribbble URL', 'url', 'https://dribbble.com/…'],
                ],
            ],
            'stats' => [
                'label' => 'Hero statistics',
                'class' => 'text-signal',
                'fields' => [
                    ['years_experience', 'Years experience', 'number', '7'],
                    ['projects_completed', 'Projects completed', 'number', '48'],
                    ['clients_served', 'Clients served', 'number', '32'],
                    ['satisfaction_rate', 'Satisfaction rate (%)', 'number', '98'],
                ],
            ],
        ];
    @endphp

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Site settings</h2>
                <p class="mt-1.5 text-[13px] text-slate-400">Identity, contact details, hero statistics and media assets.</p>
            </div>
            <button type="submit" class="btn-primary">save settings <span aria-hidden="true">→</span></button>
        </div>

        <div class="mt-6 grid gap-5 xl:grid-cols-2">
            @foreach ($fieldGroups as $groupKey => $group)
                <div class="glass rounded-2xl p-5 sm:p-6">
                    <p class="font-mono text-[9px] uppercase tracking-[0.2em] {{ $group['class'] }}">{{ $group['label'] }}</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach ($group['fields'] as [$key, $label, $type, $placeholder])
                            <div class="{{ $type === 'textarea' ? 'sm:col-span-2' : '' }}">
                                <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                                @if ($type === 'textarea')
                                    <textarea name="{{ $key }}" id="{{ $key }}" rows="3" class="form-field resize-y @error($key) !border-ember/50 @enderror" placeholder="{{ $placeholder }}">{{ old($key, $values[$key] ?? '') }}</textarea>
                                @else
                                    <input type="{{ $type }}" name="{{ $key }}" id="{{ $key }}" value="{{ old($key, $values[$key] ?? '') }}" class="form-field @error($key) !border-ember/50 @enderror" placeholder="{{ $placeholder }}" @if ($type === 'number') min="0" @endif>
                                @endif
                                @error($key)<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        @endforeach

                        @if ($groupKey === 'contact')
                            <div class="sm:col-span-2">
                                <label for="availability_status" class="form-label">availability status</label>
                                <select name="availability_status" id="availability_status" class="form-field @error('availability_status') !border-ember/50 @enderror">
                                    @foreach (['available' => 'Available', 'limited' => 'Limited capacity', 'unavailable' => 'Unavailable'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('availability_status', $values['availability_status'] ?? 'available') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('availability_status')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="glass rounded-2xl p-5 sm:p-6 xl:col-span-2">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-ember">Media & assets</p>
                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <div>
                        <p class="form-label">resume</p>
                        @if (! empty($values['resume_path']))
                            <p class="mb-2 font-mono text-[10px] text-slate-400">current · {{ $values['resume_path'] }}</p>
                        @endif
                        <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" class="form-field !px-2 !py-2 text-[11px] file:mr-3 file:rounded-md file:border-0 file:bg-matrix/15 file:px-2.5 file:py-1.5 file:font-mono file:text-[10px] file:text-matrix">
                        <p class="form-help">PDF or Word · max 5MB. Powers the “download CV” button.</p>
                        @error('resume')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <p class="form-label">avatar</p>
                        <div class="mb-2 flex items-center gap-3">
                            <img src="{{ str_starts_with($values['avatar_path'] ?? '', 'images/') ? asset($values['avatar_path']) : asset('uploads/'.($values['avatar_path'] ?? 'images/avatar.svg')) }}" alt="Current avatar" class="h-12 w-12 rounded-full border border-white/15 object-cover">
                            <p class="font-mono text-[10px] text-slate-500">current asset</p>
                        </div>
                        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-field !px-2 !py-2 text-[11px] file:mr-3 file:rounded-md file:border-0 file:bg-matrix/15 file:px-2.5 file:py-1.5 file:font-mono file:text-[10px] file:text-matrix">
                        <p class="form-help">Square image · max 2MB. Used in the hero.</p>
                        @error('avatar')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button type="submit" class="btn-primary">save settings <span aria-hidden="true">→</span></button>
        </div>
    </form>
@endsection
