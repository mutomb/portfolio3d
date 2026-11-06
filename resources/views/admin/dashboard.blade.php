@extends('layouts.admin')

@section('title', 'Dashboard')
@section('eyebrow', 'overview / live')

@section('content')
    @php
        $visitMax = max(1, (int) collect($visitSeries)->max('total'));
        $inquiryMax = max(1, (int) collect($inquirySeries)->max('total'));
        $leaderboardMax = max(1, (int) $topProjects->max('clicks_count'));
        $initialMetrics = [
            'total_visits' => $metrics['total_visits'],
            'visits_today' => $metrics['visits_today'],
            'total_views' => $metrics['total_views'],
            'total_clicks' => $metrics['total_clicks'],
            'unread_inquiries' => $metrics['inquiries_new'],
            'updated_at' => now()->format('H:i:s'),
        ];
    @endphp

    <div
        x-data="adminMetrics(@js($initialMetrics))"
        class="space-y-6"
    >
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-[0.24em] text-matrix">signal board</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">Everything that moved.</h2>
                <p class="mt-1.5 text-[13px] text-slate-400">Traffic, case study engagement and inquiry flow across the last 14 days.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 rounded-full border border-matrix/25 bg-matrix/5 px-3 py-1.5 font-mono text-[9px] uppercase tracking-[0.14em] text-matrix">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-matrix opacity-60"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-matrix"></span>
                    </span>
                    live · <span x-text="metrics.updated_at"></span>
                </span>
                <button type="button" @click="refresh()" class="btn-ghost !px-3 !py-2">↻ refresh</button>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['total visits', 'total_visits', 'text-slate-100', 'all time'],
                ['visits today', 'visits_today', 'text-matrix', 'since midnight'],
                ['case views', 'total_views', 'text-cyber', 'all projects'],
                ['outbound clicks', 'total_clicks', 'text-plasma', 'tracked links'],
            ] as [$label, $key, $color, $hint])
                <div class="glass rounded-xl p-5">
                    <div class="flex items-start justify-between gap-3">
                        <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">{{ $label }}</p>
                        <span class="h-1.5 w-1.5 rounded-full bg-white/20" :class="pulse ? 'bg-matrix' : ''"></span>
                    </div>
                    <p class="mt-3 font-mono text-3xl font-semibold {{ $color }}" x-text="Number(metrics['{{ $key }}']).toLocaleString()">{{ number_format($initialMetrics[$key]) }}</p>
                    <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">{{ $hint }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 xl:grid-cols-[1.35fr_0.65fr]">
            <div class="glass rounded-2xl p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">site traffic</p>
                        <p class="mt-1 text-sm font-medium text-slate-200">Visits · last 14 days</p>
                    </div>
                    <div class="flex items-center gap-4 font-mono text-[9px] uppercase tracking-[0.14em]">
                        <span class="text-slate-500">7d <span class="text-slate-200">{{ number_format($metrics['visits_7d']) }}</span></span>
                        <span class="text-slate-500">unique <span class="text-slate-200">{{ number_format($metrics['unique_visitors']) }}</span></span>
                    </div>
                </div>

                <div class="mt-6 flex h-44 items-end gap-1.5">
                    @foreach ($visitSeries as $point)
                        <div class="group relative flex flex-1 flex-col items-center justify-end gap-1">
                            <span class="pointer-events-none absolute -top-7 rounded border border-white/10 bg-void px-1.5 py-0.5 font-mono text-[9px] text-slate-300 opacity-0 transition-opacity group-hover:opacity-100">{{ $point['total'] }}</span>
                            <div
                                class="w-full rounded-t-sm bg-gradient-to-t from-matrix/25 to-matrix/80 transition-all duration-500 group-hover:from-cyber/30 group-hover:to-cyber"
                                style="height: {{ max(4, round(($point['total'] / $visitMax) * 100)) }}%"
                            ></div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-2 flex gap-1.5">
                    @foreach ($visitSeries as $point)
                        <span class="flex-1 truncate text-center font-mono text-[8px] text-slate-600">{{ $loop->even ? $point['date'] : '' }}</span>
                    @endforeach
                </div>
            </div>

            <div class="glass rounded-2xl p-5">
                <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">inquiry flow</p>
                <p class="mt-1 text-sm font-medium text-slate-200">New briefs · last 14 days</p>

                <div class="mt-6 flex h-32 items-end gap-1.5">
                    @foreach ($inquirySeries as $point)
                        <div class="group relative flex flex-1 flex-col items-center justify-end">
                            <div
                                class="w-full rounded-t-sm bg-gradient-to-t from-cyber/20 to-cyber/80 transition-all duration-500"
                                style="height: {{ max(4, round(($point['total'] / $inquiryMax) * 100)) }}%"
                                title="{{ $point['date'] }}: {{ $point['total'] }}"
                            ></div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 grid grid-cols-3 gap-2 border-t border-white/10 pt-4">
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">total</p>
                        <p class="mt-1 font-mono text-lg text-slate-100">{{ number_format($metrics['inquiries_total']) }}</p>
                    </div>
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">unread</p>
                        <p class="mt-1 font-mono text-lg text-matrix" x-text="metrics.unread_inquiries">{{ $metrics['inquiries_new'] }}</p>
                    </div>
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">ctr</p>
                        <p class="mt-1 font-mono text-lg text-cyber">{{ $metrics['click_through_rate'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-[1.35fr_0.65fr]">
            <div class="glass overflow-hidden rounded-2xl">
                <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">project leaderboard</p>
                        <p class="mt-1 text-sm font-medium text-slate-200">Outbound clicks</p>
                    </div>
                    <a href="{{ route('admin.portfolios.index') }}" class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500 transition-colors hover:text-matrix">manage →</a>
                </div>

                <div class="divide-y divide-white/5">
                    @forelse ($topProjects as $index => $project)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <span class="font-mono text-[10px] text-slate-600">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <img src="{{ $project->thumbnailUrl() }}" alt="" class="h-9 w-12 rounded border border-white/10 object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[13px] text-slate-200">{{ $project->title }}</p>
                                <p class="mt-0.5 font-mono text-[9px] uppercase tracking-[0.12em] text-slate-500">{{ $project->category?->name ?? 'uncategorised' }}</p>
                            </div>
                            <div class="hidden w-32 shrink-0 sm:block">
                                <div class="h-1.5 overflow-hidden rounded-full bg-white/5">
                                    <div class="h-full rounded-full bg-gradient-to-r from-matrix/70 to-cyber/80" style="width: {{ max(3, round(($project->clicks_count / $leaderboardMax) * 100)) }}%"></div>
                                </div>
                            </div>
                            <div class="w-20 shrink-0 text-right">
                                <p class="font-mono text-[11px] text-slate-200">{{ number_format($project->clicks_count) }}</p>
                                <p class="font-mono text-[8px] uppercase tracking-[0.1em] text-slate-600">{{ number_format($project->views_count) }} views</p>
                            </div>
                        </div>
                    @empty
                        <p class="px-5 py-10 text-center font-mono text-xs text-slate-500">No project engagement recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="glass overflow-hidden rounded-2xl">
                <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                    <div>
                        <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">latest visits</p>
                        <p class="mt-1 text-sm font-medium text-slate-200">Live tail</p>
                    </div>
                    <span class="font-mono text-[9px] text-matrix">●</span>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse ($latestVisits as $visit)
                        <div class="flex items-center justify-between gap-3 px-5 py-2.5">
                            <div class="min-w-0">
                                <p class="truncate font-mono text-[10px] text-slate-300">{{ $visit->path }}</p>
                                <p class="mt-0.5 font-mono text-[8px] text-slate-600">{{ $visit->ip_address ?? 'unknown' }}</p>
                            </div>
                            <span class="shrink-0 font-mono text-[9px] text-slate-500">{{ $visit->created_at?->diffForHumans(short: true) }}</span>
                        </div>
                    @empty
                        <p class="px-5 py-10 text-center font-mono text-xs text-slate-500">No visits recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="glass overflow-hidden rounded-2xl">
            <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
                <div>
                    <p class="font-mono text-[9px] uppercase tracking-[0.18em] text-slate-500">inbox</p>
                    <p class="mt-1 text-sm font-medium text-slate-200">Recent inquiries</p>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500 transition-colors hover:text-matrix">open inbox →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Received</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentInquiries as $inquiry)
                            <tr>
                                <td>
                                    <p class="text-slate-200">{{ $inquiry->name }}</p>
                                    <p class="font-mono text-[9px] text-slate-500">{{ $inquiry->email }}</p>
                                </td>
                                <td class="max-w-xs truncate">{{ $inquiry->subject }}</td>
                                <td>
                                    <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $inquiry->statusColor() }}">{{ $inquiry->status }}</span>
                                </td>
                                <td class="font-mono text-[10px] text-slate-500">{{ $inquiry->created_at?->diffForHumans(short: true) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="font-mono text-[10px] text-cyber transition-colors hover:text-matrix">open →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center font-mono text-xs text-slate-500">No inquiries yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">software clicks</p>
                <p class="mt-1.5 font-mono text-lg text-matrix">{{ number_format($metrics['software_clicks']) }}</p>
            </div>
            <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">data clicks</p>
                <p class="mt-1.5 font-mono text-lg text-cyber">{{ number_format($metrics['data_clicks']) }}</p>
            </div>
            <div class="rounded-xl border border-white/10 bg-white/[0.02] p-4">
                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500">all-time visitors</p>
                <p class="mt-1.5 font-mono text-lg text-slate-100">{{ number_format($metrics['unique_visitors']) }}</p>
            </div>
        </div>
    </div>
@endsection
