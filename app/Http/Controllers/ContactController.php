<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact', [
            'topics' => ContactRequest::TOPICS,
        ]);
    }

    public function send(ContactRequest $request): RedirectResponse
    {
        Mail::to(config('appollo.contact_to'))->send(new ContactMessage(
            name: $request->validated('name'),
            email: $request->validated('email'),
            topic: $request->topicLabel(),
            body: $request->validated('message'),
        ));

        return redirect()
            ->route('contact')
            ->with('status', "Thanks, {$request->validated('name')}, your message is on its way. We usually reply within one business day.");
    }
}
