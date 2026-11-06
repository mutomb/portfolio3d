@extends('layouts.admin')

@section('title', 'Credentials')
@section('eyebrow', 'content / credentials')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Qualifications & awards</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $qualifications->total() }} credentials in the timeline.</p>
        </div>
        <a href="{{ route('admin.qualifications.create') }}" class="btn-primary">new credential <span aria-hidden="true">+</span></a>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.qualifications.index') }}" class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors {{ ! $type ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 text-slate-400 hover:text-slate-200' }}">all</a>
        @foreach (['education' => 'education', 'certification' => 'certification', 'award' => 'awards'] as $value => $label)
            <a href="{{ route('admin.qualifications.index', ['type' => $value]) }}" class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors {{ $type === $value ? 'border-cyber/40 bg-cyber/10 text-cyber' : 'border-white/10 text-slate-400 hover:text-slate-200' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Institution</th>
                        <th>Type</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qualifications as $qualification)
                        <tr>
                            <td class="text-[13px] text-slate-200">{{ $qualification->title }}</td>
                            <td class="text-[12px] text-slate-400">{{ $qualification->institution }}</td>
                            <td class="font-mono text-[10px] uppercase tracking-[0.1em] text-slate-400">{{ $qualification->type }}</td>
                            <td class="font-mono text-[10px] text-slate-400">{{ $qualification->period_label ?: '—' }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $qualification->is_active ? 'border-matrix/30 bg-matrix/10 text-matrix' : 'border-slate-500/30 bg-slate-500/10 text-slate-400' }}">{{ $qualification->is_current ? 'current' : ($qualification->is_active ? 'active' : 'hidden') }}</span>
                            </td>
                            <td class="font-mono text-[11px] text-slate-500">{{ $qualification->sort_order }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.qualifications.edit', $qualification) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                                    <form method="POST" action="{{ route('admin.qualifications.destroy', $qualification) }}" onsubmit="return confirm('Delete {{ addslashes($qualification->title) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center font-mono text-xs text-slate-500">No credentials match this filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $qualifications->links() }}</div>
@endsection
