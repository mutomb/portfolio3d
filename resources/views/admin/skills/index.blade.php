@extends('layouts.admin')

@section('title', 'Skills')
@section('eyebrow', 'content / skills')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Stack matrix</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $skills->total() }} tools · shown on the public stack section.</p>
        </div>
        <a href="{{ route('admin.skills.create') }}" class="btn-primary">new skill <span aria-hidden="true">+</span></a>
    </div>

    <form method="GET" action="{{ route('admin.skills.index') }}" class="mt-6 grid gap-3 rounded-2xl border border-white/10 bg-white/[0.02] p-4 sm:grid-cols-[1.4fr_0.8fr_auto]">
        <div>
            <label for="search" class="form-label">search</label>
            <input type="search" name="search" id="search" value="{{ $search }}" class="form-field" placeholder="Skill name">
        </div>
        <div>
            <label for="category" class="form-label">discipline</label>
            <select name="category" id="category" class="form-field">
                <option value="">All disciplines</option>
                @foreach ($categories as $value => $label)
                    <option value="{{ $value }}" @selected($category === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-secondary !py-3">filter</button>
            @if ($search || $category)
                <a href="{{ route('admin.skills.index') }}" class="btn-ghost !py-3">reset</a>
            @endif
        </div>
    </form>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Skill</th>
                        <th>Discipline</th>
                        <th>Depth</th>
                        <th>Years</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skills as $skill)
                        <tr>
                            <td>
                                <div class="flex items-center gap-2.5">
                                    <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $skill->color }}"></span>
                                    <span class="text-[13px] text-slate-200">{{ $skill->name }}</span>
                                </div>
                            </td>
                            <td class="font-mono text-[10px] uppercase tracking-[0.1em] text-slate-400">{{ $skill->categoryLabel() }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-20 overflow-hidden rounded-full bg-white/5">
                                        <div class="h-full rounded-full" style="width: {{ $skill->proficiency }}%; background-color: {{ $skill->color }}"></div>
                                    </div>
                                    <span class="font-mono text-[10px] text-slate-400">{{ $skill->proficiency }}%</span>
                                </div>
                            </td>
                            <td class="font-mono text-[11px] text-slate-400">{{ $skill->years_experience ? rtrim(rtrim(number_format((float) $skill->years_experience, 1), '0'), '.') : '—' }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $skill->is_active ? 'border-matrix/30 bg-matrix/10 text-matrix' : 'border-slate-500/30 bg-slate-500/10 text-slate-400' }}">{{ $skill->is_active ? 'active' : 'hidden' }}</span>
                            </td>
                            <td class="font-mono text-[11px] text-slate-500">{{ $skill->sort_order }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                                    <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Remove {{ addslashes($skill->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center font-mono text-xs text-slate-500">No skills match this filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $skills->links() }}</div>
@endsection
