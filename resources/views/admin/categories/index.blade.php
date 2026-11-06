@extends('layouts.admin')

@section('title', 'Categories')
@section('eyebrow', 'content / categories')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Categories</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">Group case studies by discipline. Inactive categories are hidden from public filters.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">new category <span aria-hidden="true">+</span></a>
    </div>

    <form method="GET" action="{{ route('admin.categories.index') }}" class="mt-6 flex flex-wrap items-end gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4">
        <div class="min-w-56 flex-1">
            <label for="search" class="form-label">search</label>
            <input type="search" name="search" id="search" value="{{ $search }}" class="form-field" placeholder="Category name">
        </div>
        <button type="submit" class="btn-secondary !py-3">filter</button>
        @if ($search)
            <a href="{{ route('admin.categories.index') }}" class="btn-ghost !py-3">reset</a>
        @endif
    </form>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Projects</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <span class="h-8 w-1.5 rounded-full" style="background-color: {{ $category->color }}"></span>
                                    <div>
                                        <p class="text-[13px] text-slate-200">{{ $category->name }}</p>
                                        <p class="mt-0.5 font-mono text-[9px] text-slate-500">{{ $category->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="font-mono text-[10px] uppercase tracking-[0.1em] text-slate-400">{{ $category->type }}</td>
                            <td class="font-mono text-[11px] text-slate-300">{{ $category->portfolios_count }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $category->is_active ? 'border-matrix/30 bg-matrix/10 text-matrix' : 'border-slate-500/30 bg-slate-500/10 text-slate-400' }}">{{ $category->is_active ? 'active' : 'hidden' }}</span>
                            </td>
                            <td class="font-mono text-[11px] text-slate-500">{{ $category->sort_order }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete {{ addslashes($category->name) }}? Projects will become uncategorised.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center font-mono text-xs text-slate-500">No categories yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
