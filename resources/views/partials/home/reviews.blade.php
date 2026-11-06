@php
    $featured = $reviews->where('is_featured', true)->take(3);
    $averageRating = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : 0;
@endphp

<section id="reviews" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-signal/20 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <x-section-heading
                eyebrow="client signal / 07"
                title="What it is like to work together."
                description="Outcomes matter, but so does the process. These are unedited notes from the people who lived through the delivery."
            />

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-1 text-signal" aria-hidden="true">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="{{ $i <= round($averageRating) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.2">
                            <path d="M10 1.8l2.47 5.01 5.53.8-4 3.9.94 5.51L10 14.42l-4.94 2.6.94-5.51-4-3.9 5.53-.8L10 1.8Z"/>
                        </svg>
                    @endfor
                </div>
                <span class="font-mono text-[10px] uppercase tracking-[0.16em] text-slate-500">{{ $averageRating }} / 5 · {{ $reviews->count() }} reviews</span>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($reviews as $index => $review)
                <article class="group relative flex flex-col overflow-hidden rounded-2xl glass p-6 {{ $index === 0 ? 'xl:col-span-2' : '' }}">
                    <div class="pointer-events-none absolute -right-10 -top-10 font-mono text-8xl text-white/[0.03]">“</div>

                    <div class="relative flex items-center justify-between gap-3">
                        <div class="flex items-center gap-1 text-signal">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.2">
                                    <path d="M10 1.8l2.47 5.01 5.53.8-4 3.9.94 5.51L10 14.42l-4.94 2.6.94-5.51-4-3.9 5.53-.8L10 1.8Z"/>
                                </svg>
                            @endfor
                        </div>
                        @if ($review->is_featured)
                            <span class="chip border-signal/25 bg-signal/5 text-signal">featured</span>
                        @endif
                    </div>

                    <blockquote class="relative mt-4 flex-1 text-[13px] leading-7 text-slate-300 {{ $index === 0 ? 'sm:text-sm' : '' }}">
                        “{{ $review->content }}”
                    </blockquote>

                    <div class="relative mt-6 flex items-center justify-between gap-4 border-t border-white/10 pt-5">
                        <div class="flex min-w-0 items-center gap-3">
                            <img src="{{ $review->avatarUrl() }}" alt="{{ $review->client_name }}" loading="lazy" class="h-10 w-10 rounded-full border border-white/15 object-cover">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-100">{{ $review->client_name }}</p>
                                <p class="truncate font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">
                                    {{ collect([$review->client_role, $review->company])->filter()->implode(' · ') }}
                                </p>
                            </div>
                        </div>
                        @if ($review->project_url)
                            <a href="{{ $review->project_url }}" target="_blank" rel="noopener noreferrer" class="shrink-0 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500 transition-colors hover:text-matrix" aria-label="View {{ $review->company }} project">
                                project ↗
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
