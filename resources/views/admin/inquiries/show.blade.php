@extends('layouts.admin')

@section('title', 'Inquiry')
@section('eyebrow', 'inbox / inquiry detail')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.inquiries.index') }}" class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500 transition-colors hover:text-matrix">← inbox</a>
            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-100">{{ $inquiry->subject }}</h2>
            <p class="mt-1.5 font-mono text-[10px] text-slate-500">{{ $inquiry->name }} · {{ $inquiry->email }} · {{ $inquiry->created_at?->format('M j, Y H:i') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex rounded-full border px-3 py-1 font-mono text-[9px] uppercase tracking-[0.12em] {{ $inquiry->statusColor() }}">{{ $inquiry->status }}</span>
            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">delete</button>
            </form>
        </div>
    </div>

    <div class="grid gap-5 xl:grid-cols-[1.35fr_0.65fr]">
        <div class="space-y-5">
            <div class="glass rounded-2xl p-5 sm:p-6">
                <div class="flex items-center justify-between gap-3 border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full border border-cyber/25 bg-cyber/10 font-mono text-[11px] text-cyber">{{ strtoupper(substr($inquiry->name, 0, 2)) }}</span>
                        <div>
                            <p class="text-sm font-medium text-slate-200">{{ $inquiry->name }}</p>
                            <a href="mailto:{{ $inquiry->email }}" class="font-mono text-[10px] text-cyber hover:text-matrix">{{ $inquiry->email }}</a>
                        </div>
                    </div>
                    @if ($inquiry->budget)
                        <span class="chip border-signal/25 text-signal">{{ $inquiry->budget }}</span>
                    @endif
                </div>

                <div class="mt-5 whitespace-pre-line text-[13px] leading-7 text-slate-300">{{ $inquiry->message }}</div>

                <div class="mt-6 grid gap-2 border-t border-white/10 pt-4 font-mono text-[9px] uppercase tracking-[0.12em] text-slate-600 sm:grid-cols-2">
                    <p>ip · <span class="text-slate-400">{{ $inquiry->ip_address ?? 'unknown' }}</span></p>
                    <p>read · <span class="text-slate-400">{{ $inquiry->read_at?->format('M j, H:i') ?? 'unread' }}</span></p>
                </div>
            </div>

            @if ($inquiry->reply_message)
                <div class="rounded-2xl border border-matrix/25 bg-matrix/[0.04] p-5 sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-matrix">reply sent</p>
                        <span class="font-mono text-[9px] text-slate-500">{{ $inquiry->replied_at?->format('M j, Y H:i') }}</span>
                    </div>
                    <div class="mt-3 whitespace-pre-line text-[13px] leading-7 text-slate-300">{{ $inquiry->reply_message }}</div>
                </div>
            @endif

            <div class="glass rounded-2xl p-5 sm:p-6">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-cyber">compose reply</p>
                <p class="mt-1 text-[11px] text-slate-500">Sends a queued email to {{ $inquiry->email }} and marks this inquiry as replied.</p>

                <form method="POST" action="{{ route('admin.inquiries.reply', $inquiry) }}" class="mt-4">
                    @csrf
                    <label for="reply_message" class="form-label">message</label>
                    <textarea name="reply_message" id="reply_message" rows="8" class="form-field resize-y @error('reply_message') !border-ember/50 @enderror" placeholder="Hi {{ explode(' ', $inquiry->name)[0] }},&#10;&#10;Thanks for the brief…" required>{{ old('reply_message', $inquiry->reply_message) }}</textarea>
                    @error('reply_message')<p class="form-error">{{ $message }}</p>@enderror

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">reply-to: {{ $site['email'] ?? 'hello@portfolio3d.test' }}</p>
                        <button type="submit" class="btn-primary">send reply <span aria-hidden="true">→</span></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-5">
            <div class="glass rounded-2xl p-5">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">status</p>
                <form method="POST" action="{{ route('admin.inquiries.status', $inquiry) }}" class="mt-3 space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-field">
                        @foreach (\App\Models\ContactInquiry::STATUSES as $value => $label)
                            <option value="{{ $value }}" @selected($inquiry->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-secondary w-full">update status</button>
                </form>
            </div>

            <div class="glass rounded-2xl p-5">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">timeline</p>
                <div class="mt-4 space-y-4">
                    @foreach ([
                        ['received', $inquiry->created_at],
                        ['read', $inquiry->read_at],
                        ['replied', $inquiry->replied_at],
                    ] as [$label, $timestamp])
                        <div class="flex items-start gap-3">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full {{ $timestamp ? 'bg-matrix' : 'bg-slate-600' }}"></span>
                            <div>
                                <p class="font-mono text-[10px] uppercase tracking-[0.12em] {{ $timestamp ? 'text-slate-300' : 'text-slate-600' }}">{{ $label }}</p>
                                <p class="mt-0.5 font-mono text-[9px] text-slate-600">{{ $timestamp?->format('M j, Y · H:i') ?? 'pending' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
                <p class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">quick actions</p>
                <div class="mt-3 space-y-2">
                    <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: '.$inquiry->subject) }}" class="flex items-center justify-between rounded-lg border border-white/10 px-3 py-2.5 font-mono text-[10px] text-slate-300 transition-colors hover:border-cyber/30 hover:text-cyber">open in mail client <span>↗</span></a>
                    <a href="{{ route('admin.inquiries.index') }}" class="flex items-center justify-between rounded-lg border border-white/10 px-3 py-2.5 font-mono text-[10px] text-slate-300 transition-colors hover:border-matrix/30 hover:text-matrix">back to inbox <span>←</span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
