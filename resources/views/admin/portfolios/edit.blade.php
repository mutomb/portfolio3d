@extends('layouts.admin')

@section('title', 'Edit project')
@section('eyebrow', 'content / projects / edit')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.portfolios.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← projects</a>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Edit “{{ $portfolio->title }}”</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">Changes go live immediately if the project is published.</p>
        </div>
        <div class="flex items-center gap-2">
            @if ($portfolio->is_published)
                <a href="{{ route('projects.show', $portfolio) }}" target="_blank" rel="noopener noreferrer" class="btn-ghost">view public ↗</a>
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.portfolios._form', ['portfolio' => $portfolio, 'categories' => $categories])
    </form>
@endsection
