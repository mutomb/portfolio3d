@extends('layouts.admin')

@section('title', 'Projects')
@section('eyebrow', 'content / projects')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Case studies</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $portfolios->total() }} projects · {{ $portfolios->getCollection()->where('is_published', true)->count() }} published on this page.</p>
        </div>
        <a href="{{ route('admin.portfolios.create') }}" class="btn-primary">new project <span aria-hidden="true">+</span></a>
    </div>

    <form method="GET" action="{{ route('admin.portfolios.index') }}" class="mt-6 grid gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 sm:grid-cols-2 xl:grid-cols-[1.4fr_0.7fr_0.7fr_0.9fr_auto]">
        <div>
            <label for="search" class="form-label">search</label>
            <input type="search" name="search" id="search" value="{{ $search }}" class="form-field" placeholder="Title, tagline or client">
        </div>
        <div>
            <label for="type" class="form-label">discipline</label>
            <select name="type" id="type" class="form-field">
                <option value="">All</option>
                <option value="software" @selected($type === 'software')>Software</option>
                <option value="data" @selected($type === 'data')>Data</option>
            </select>
        </div>
        <div>
            <label for="status" class="form-label">status</label>
            <select name="status" id="status" class="form-field">
                <option value="">All</option>
                <option value="published" @selected($status === 'published')>Published</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
            </select>
        </div>
        <div>
            <label for="category" class="form-label">category</label>
            <select name="category" id="category" class="form-field">
                <option value="">All categories</option>
                @foreach ($categories as $categoryOption)
                    <option value="{{ $categoryOption->id }}" @selected((string) $categoryId === (string) $categoryOption->id)>{{ $categoryOption->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-secondary !py-3">filter</button>
            @if ($search || $type || $status || $categoryId)
                <a href="{{ route('admin.portfolios.index') }}" class="btn-ghost !py-3">reset</a>
            @endif
        </div>
    </form>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Clicks</th>
                        <th>Order</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($portfolios as $project)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $project->thumbnailUrl() }}" alt="" class="h-10 w-14 rounded border border-white/10 object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-[13px] text-slate-200">{{ $project->title }}</p>
                                        <p class="mt-0.5 max-w-xs truncate font-mono text-[9px] text-slate-500">{{ $project->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $project->project_type === 'data' ? 'border-cyber/30 bg-cyber/10 text-cyber' : 'border-matrix/30 bg-matrix/10 text-matrix' }}">{{ $project->project_type }}</span>
                            </td>
                            <td class="text-[12px] text-slate-400">{{ $project->category?->name ?? '—' }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $project->is_published ? 'border-matrix/30 bg-matrix/10 text-matrix' : 'border-slate-500/30 bg-slate-500/10 text-slate-400' }}">{{ $project->is_published ? 'published' : 'draft' }}</span>
                            </td>
                            <td class="font-mono text-[11px] text-slate-400">{{ number_format($project->views_count) }}</td>
                            <td class="font-mono text-[11px] text-slate-400">{{ number_format($project->clicks_count) }}</td>
                            <td class="font-mono text-[11px] text-slate-500">{{ $project->sort_order }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    @if ($project->is_published)
                                        <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener noreferrer" class="btn-ghost !px-2 !py-1.5" title="View public page">↗</a>
                                    @endif
                                    <a href="{{ route('admin.portfolios.edit', $project) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                                    <form method="POST" action="{{ route('admin.portfolios.destroy', $project) }}" onsubmit="return confirm('Delete {{ addslashes($project->title) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center font-mono text-xs text-slate-500">No projects match this filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $portfolios->links() }}</div>
@endsection
