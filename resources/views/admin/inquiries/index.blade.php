@extends('layouts.admin')

@section('title', 'Inquiries')
@section('eyebrow', 'inbox / inquiries')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Inbox</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $inquiries->total() }} conversations · {{ $counts['unread'] ?? 0 }} unread.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="chip border-matrix/25 bg-matrix/5 text-matrix">{{ $counts['unread'] ?? 0 }} unread</span>
            <span class="chip">{{ $counts['replied'] ?? 0 }} replied</span>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-2">
            @php
                $tabs = [
                    '' => ['all', $inquiries->total()],
                    'unread' => ['unread', $counts['unread'] ?? 0],
                    'new' => ['new', $counts['new'] ?? 0],
                    'read' => ['read', $counts['read'] ?? 0],
                    'replied' => ['replied', $counts['replied'] ?? 0],
                    'archived' => ['archived', $counts['archived'] ?? 0],
                ];
            @endphp
            @foreach ($tabs as $value => [$label, $count])
                <a href="{{ route('admin.inquiries.index', $value ? ['status' => $value] : []) }}" class="rounded-full border px-3.5 py-2 font-mono text-[10px] uppercase tracking-[0.14em] transition-colors {{ (string) $status === (string) $value ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 text-slate-400 hover:text-slate-200' }}">
                    {{ $label }} <span class="text-slate-600">/ {{ $count }}</span>
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-end gap-2">
            @if ($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div>
                <label for="search" class="sr-only">Search inquiries</label>
                <input type="search" name="search" id="search" value="{{ $search }}" class="form-field !py-2.5" placeholder="Search name, email, subject">
            </div>
            <button type="submit" class="btn-secondary !py-2.5">search</button>
        </form>
    </div>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inquiries as $inquiry)
                        <tr class="{{ ! $inquiry->read_at ? 'bg-matrix/[0.025]' : '' }}">
                            <td>
                                <div class="flex items-center gap-2">
                                    @if (! $inquiry->read_at)
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-matrix"></span>
                                    @endif
                                    <div>
                                        <p class="text-[13px] {{ $inquiry->read_at ? 'text-slate-300' : 'font-medium text-slate-100' }}">{{ $inquiry->name }}</p>
                                        <p class="font-mono text-[9px] text-slate-500">{{ $inquiry->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-xs">
                                <p class="truncate text-[12px] text-slate-300">{{ $inquiry->subject }}</p>
                                <p class="mt-0.5 truncate text-[11px] text-slate-500">{{ $inquiry->message }}</p>
                            </td>
                            <td class="font-mono text-[10px] text-slate-400">{{ $inquiry->budget ?: '—' }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $inquiry->statusColor() }}">{{ $inquiry->status }}</span>
                            </td>
                            <td class="font-mono text-[10px] text-slate-500">{{ $inquiry->created_at?->diffForHumans(short: true) }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn-ghost !px-2 !py-1.5">open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center font-mono text-xs text-slate-500">No inquiries match this filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $inquiries->links() }}</div>
@endsection
