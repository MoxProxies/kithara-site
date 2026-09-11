<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotifyRequest;
use App\Mail\NotifySignup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class NotifyController extends Controller
{
    /** Sign-ups live in a CSV on the local disk; the site keeps no database. */
    public const LIST_FILE = 'notify-list.csv';

    public function store(NotifyRequest $request): RedirectResponse
    {
        $email = mb_strtolower(trim($request->validated('email')));

        if (! $this->alreadyListed($email)) {
            Storage::disk('local')->append(self::LIST_FILE, now()->toIso8601String().','.$email);
            Mail::to(config('kithara.contact_to'))->send(new NotifySignup($email));
        }

        return redirect()
            ->to(url('/#download'))
            ->with('notify_status', 'You are on the list. We will email you the day Kithara lands on Google Play.');
    }

    private function alreadyListed(string $email): bool
    {
        $disk = Storage::disk('local');

        if (! $disk->exists(self::LIST_FILE)) {
            return false;
        }

        foreach (explode("\n", $disk->get(self::LIST_FILE)) as $line) {
            if (str_ends_with(trim($line), ','.$email)) {
                return true;
            }
        }

        return false;
    }
}
