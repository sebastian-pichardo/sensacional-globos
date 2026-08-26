<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Mail\NewsletterSubscriptionMail;
use App\Models\NewsletterSubscriber;
use App\Support\SiteMail;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(StoreNewsletterRequest $request): RedirectResponse
    {
        $email = $request->validated('email');

        NewsletterSubscriber::create([
            'email' => $email,
        ]);

        SiteMail::notify(new NewsletterSubscriptionMail($email));

        return back()->with('success', '¡Gracias por registrarte!');
    }
}
