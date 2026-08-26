<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Support\SiteMail;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $message = ContactMessage::create($request->validated());

        SiteMail::notify(new ContactMessageMail($message));

        return back()->with(
            'success',
            '¡Gracias por registrarte! Recibimos tu mensaje y nos pondremos en contacto.',
        );
    }
}
