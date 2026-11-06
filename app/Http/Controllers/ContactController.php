<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactInquiryRequest;
use App\Mail\NewInquiryMail;
use App\Models\ContactInquiry;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ContactController extends Controller
{
    public function store(ContactInquiryRequest $request): RedirectResponse
    {
        $inquiry = ContactInquiry::create([
            ...$request->safe()->except(['website']),
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 500),
        ]);

        $recipient = Setting::get('email', config('mail.from.address'));

        try {
            Mail::to($recipient)->queue((new NewInquiryMail($inquiry))->afterCommit());
        } catch (Throwable $exception) {
            report($exception);
        }

        return redirect()
            ->to(route('home').'#contact')
            ->with('contact_sent', 'Transmission received. I will get back to you within 24 hours.');
    }
}
