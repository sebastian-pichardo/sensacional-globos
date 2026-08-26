<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDecoratorApplicationRequest;
use App\Mail\DecoratorApplicationMail;
use App\Models\DecoratorApplication;
use App\Support\SiteMail;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class InspirateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Inspirate');
    }

    public function store(StoreDecoratorApplicationRequest $request): RedirectResponse
    {
        $application = DecoratorApplication::create($request->validated());

        SiteMail::notify(new DecoratorApplicationMail($application));

        return back()->with(
            'success',
            '¡Listo! Recibimos tu inscripción. Pronto sabrás más de la comunidad de decoradores Sensacional.',
        );
    }
}
