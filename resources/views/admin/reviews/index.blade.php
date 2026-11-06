@extends('layouts.admin')

@section('title', 'Reviews')
@section('eyebrow', 'content / reviews')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Client reviews</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $reviews->total() }} reviews · featured items appear first on the homepage.</p>
        </div>
        <a href="{{ route('admin.reviews.create') }}" class="btn-primary">new review <span aria-hidden="true">+</span></a>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.reviews.index') }}" class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors {{ ! $rating ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 text-slate-400 hover:text-slate-200' }}">all</a>
        @for ($i = 5; $i >= 1; $i--)
            <a href="{{ route('admin.reviews.index', ['rating' => $i]) }}" class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors {{ (string) $rating === (string) $i ? 'border-signal/40 bg-signal/10 text-signal' : 'border-white/10 text-slate-400 hover:text-slate-200' }}">{{ $i }} ★</a>
        @endfor
    </div>

    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($reviews as $review)
            <article class="glass flex flex-col rounded-2xl p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ $review->avatarUrl() }}" alt="{{ $review->client_name }}" class="h-10 w-10 rounded-full border border-white/15 object-cover">
                        <div>
                            <p class="text-[13px] font-medium text-slate-200">{{ $review->client_name }}</p>
                            <p class="font-mono text-[9px] uppercase tracking-[0.1em] text-slate-500">{{ collect([$review->client_role, $review->company])->filter()->implode(' · ') }}</p>
                        </div>
                    </div>
                    <span class="shrink-0 font-mono text-[10px] text-signal">{{ str_repeat('★', $review->rating) }}</span>
                </div>

                <p class="mt-3 line-clamp-4 flex-1 text-[12px] leading-6 text-slate-400">{{ $review->content }}</p>

                <div class="mt-4 flex flex-wrap items-center gap-1.5">
                    <span class="chip {{ $review->is_active ? 'border-matrix/25 text-matrix' : 'text-slate-500' }}">{{ $review->is_active ? 'active' : 'hidden' }}</span>
                    @if ($review->is_featured)
                        <span class="chip border-signal/25 text-signal">featured</span>
                    @endif
                    <span class="chip text-slate-500">#{{ $review->sort_order }}</span>
                </div>

                <div class="mt-4 flex items-center justify-end gap-1.5 border-t border-white/10 pt-3">
                    <a href="{{ route('admin.reviews.edit', $review) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete review from {{ addslashes($review->client_name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-white/15 bg-white/[0.02] p-12 text-center font-mono text-xs text-slate-500">No reviews match this filter.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
@endsection
