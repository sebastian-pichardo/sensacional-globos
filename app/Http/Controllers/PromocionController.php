<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PromocionController extends Controller
{
    private const PARTICIPANTES = [
        'los_villanos',
        'hola_frankie',
        'arco_halloween',
        'monstruo_frankie',
    ];

    public function index(): Response
    {
        return Inertia::render('PromocionesHalloween2026');
    }

    public function store(Request $request): RedirectResponse
    {
        $email = is_string($request->input('email'))
            ? strtolower(trim($request->input('email')))
            : '';

        $request->merge([
            'email' => $email,
        ]);

        $validated = $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255'],
                'tercero' => ['required', 'string', Rule::in(self::PARTICIPANTES)],
                'segundo' => ['required', 'string', Rule::in(self::PARTICIPANTES)],
                'primero' => ['required', 'string', Rule::in(self::PARTICIPANTES)],
                'accept_terms' => ['accepted'],
            ],
            [
                'email.required' => 'Por favor ingresa tu correo electrónico.',
                'email.email' => 'Por favor ingresa un correo electrónico con formato válido.',
                'tercero.required' => 'Debes seleccionar el tercer lugar.',
                'tercero.in' => 'El participante seleccionado para tercer lugar no es válido.',
                'segundo.required' => 'Debes seleccionar el segundo lugar.',
                'segundo.in' => 'El participante seleccionado para segundo lugar no es válido.',
                'primero.required' => 'Debes seleccionar el primer lugar.',
                'primero.in' => 'El participante seleccionado para primer lugar no es válido.',
                'accept_terms.accepted' => 'Debes aceptar los términos y condiciones de esta promoción.',
            ]
        );

        $yaRegistrado = Promocion::query()
            ->where('email', $validated['email'])
            ->exists();

        if ($yaRegistrado) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Este correo electrónico ya ha sido registrado en esta promoción.',
                ]);
        }

        DB::transaction(function () use ($validated) {
            $registros = [
                ['lugar' => 'tercero', 'participante' => $validated['tercero']],
                ['lugar' => 'segundo', 'participante' => $validated['segundo']],
                ['lugar' => 'primero', 'participante' => $validated['primero']],
            ];

            foreach ($registros as $registro) {
                Promocion::create([
                    'email' => $validated['email'],
                    'participante' => $registro['participante'],
                    'lugar' => $registro['lugar'],
                ]);
            }
        });

        return back()->with(
            'success',
            '¡Gracias por participar! Tus votos de la promoción de Halloween 2026 han sido registrados con éxito.',
        );
    }
}
