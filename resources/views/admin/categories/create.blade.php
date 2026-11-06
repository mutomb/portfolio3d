@extends('layouts.admin')

@section('title', 'New category')
@section('eyebrow', 'content / categories / create')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← categories</a>
        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Add a category</h2>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        @include('admin.categories._form', ['category' => null])
    </form>
@endsection
