@extends('layouts.admin')

@section('title', 'Services')
@section('eyebrow', 'content / services')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-100">Engagement modes</h2>
            <p class="mt-1.5 text-[13px] text-slate-400">{{ $services->total() }} services · shown in the public services section.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn-primary">new service <span aria-hidden="true">+</span></a>
    </div>

    <div class="mt-5 glass overflow-hidden rounded-2xl">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Price from</th>
                        <th>Delivery</th>
                        <th>Features</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>
                                <p class="text-[13px] text-slate-200">{{ $service->title }}</p>
                                <p class="mt-0.5 max-w-xs truncate font-mono text-[9px] text-slate-500">{{ $service->slug }}</p>
                            </td>
                            <td class="font-mono text-[11px] text-slate-300">{{ $service->price_from ? '$'.number_format((float) $service->price_from) : '—' }}</td>
                            <td class="font-mono text-[10px] text-slate-400">{{ $service->delivery_time ?: '—' }}</td>
                            <td class="font-mono text-[11px] text-slate-400">{{ count($service->features ?? []) }}</td>
                            <td>
                                <span class="inline-flex rounded-full border px-2 py-0.5 font-mono text-[9px] uppercase tracking-[0.1em] {{ $service->is_active ? 'border-matrix/30 bg-matrix/10 text-matrix' : 'border-slate-500/30 bg-slate-500/10 text-slate-400' }}">{{ $service->is_active ? 'active' : 'hidden' }}</span>
                            </td>
                            <td class="font-mono text-[11px] text-slate-500">{{ $service->sort_order }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn-ghost !px-2 !py-1.5">edit</a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete {{ addslashes($service->title) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger !px-2 !py-1.5">delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center font-mono text-xs text-slate-500">No services yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $services->links() }}</div>
@endsection
