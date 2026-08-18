<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return back()->with(
            'success',
            '¡Gracias! Recibimos tu mensaje y nos pondremos en contacto. Envíos a todo México.',
        );
    }
}
