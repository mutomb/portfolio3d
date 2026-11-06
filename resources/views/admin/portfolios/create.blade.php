@extends('layouts.admin')

@section('title', 'New project')
@section('eyebrow', 'content / projects / create')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.portfolios.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← projects</a>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a case study</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">The card appears in the public showcase as soon as it is published.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.portfolios._form', ['portfolio' => null, 'categories' => $categories])
    </form>
@endsection
