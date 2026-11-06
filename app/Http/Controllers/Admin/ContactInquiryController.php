<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyToInquiryRequest;
use App\Mail\InquiryReplyMail;
use App\Models\ContactInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = trim((string) $request->query('search'));

        $inquiries = ContactInquiry::query()
            ->when($status && array_key_exists($status, ContactInquiry::STATUSES), fn ($query) => $query->where('status', $status))
            ->when($status === 'unread', fn ($query) => $query->whereNull('read_at'))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = ContactInquiry::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $counts['unread'] = ContactInquiry::query()->whereNull('read_at')->count();

        return view('admin.inquiries.index', compact('inquiries', 'counts', 'status', 'search'));
    }

    public function show(ContactInquiry $inquiry): View
    {
        $inquiry->markAsRead();

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function reply(ReplyToInquiryRequest $request, ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->update([
            'reply_message' => $request->validated()['reply_message'],
            'status' => 'replied',
            'replied_at' => now(),
            'read_at' => $inquiry->read_at ?? now(),
        ]);

        try {
            Mail::to($inquiry->email)->queue((new InquiryReplyMail($inquiry))->afterCommit());
        } catch (Throwable $exception) {
            report($exception);
        }

        return redirect()
            ->route('admin.inquiries.show', $inquiry)
            ->with('success', 'Reply sent to '.$inquiry->email.'.');
    }

    public function updateStatus(Request $request, ContactInquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,read,replied,archived'],
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'read_at' => $validated['status'] === 'new' ? null : ($inquiry->read_at ?? now()),
        ]);

        return redirect()->back()->with('success', 'Inquiry marked as '.$validated['status'].'.');
    }

    public function destroy(ContactInquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
