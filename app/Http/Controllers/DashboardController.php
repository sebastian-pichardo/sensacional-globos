<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'votaciones' => Promocion::resumenVotacion(),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255'],
            ],
            [
                'email.required' => 'Indica el correo cuyos votos quieres eliminar.',
                'email.email' => 'El correo indicado no tiene un formato válido.',
            ]
        );

        $email = strtolower(trim($validated['email']));
        $eliminadas = Promocion::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->delete();

        if ($eliminadas === 0) {
            return back()->withErrors([
                'votaciones' => 'No hay votos registrados con ese correo.',
            ]);
        }

        return back()->with(
            'success',
            'Se eliminaron los votos de '.$email.'. Ese correo puede volver a participar.',
        );
    }

    public function destroyAll(): RedirectResponse
    {
        $eliminadas = Promocion::query()->delete();

        if ($eliminadas === 0) {
            return back()->withErrors([
                'votaciones' => 'No hay votos por eliminar.',
            ]);
        }

        return back()->with(
            'success',
            'Se eliminaron todos los votos de la promoción. Los correos pueden volver a participar.',
        );
    }
}
