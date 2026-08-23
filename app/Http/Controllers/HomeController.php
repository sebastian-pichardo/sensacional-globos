<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $slides = config('globos.slides');

        if (! is_array($slides) || $slides === []) {
            $slides = [
                [
                    'image' => '/img/productos/globos-slider1.webp',
                    'imageMobile' => '/img/productos/globos-movil-slider1.webp',
                    'name' => '',
                    'sku' => '',
                    'description' => '',
                    'alt' => 'Globos Sensacionales — colección 1',
                    'href' => null,
                ],
            ];
        }

        return Inertia::render('Home', [
            'slides' => $slides,
            'states' => config('globos.states'),
        ]);
    }

    public function comingSoon(): Response
    {
        $titles = [
            'nosotros' => 'Nosotros',
            'productos' => 'Productos',
            'encuentra-un-distribuidor' => 'Encuentra un distribuidor',
            'inspirate' => 'Inspírate',
        ];

        $name = request()->route()?->getName() ?? 'home';

        return Inertia::render('ComingSoon', [
            'title' => $titles[$name] ?? 'Próximamente',
        ]);
    }

    public function nosotros(): Response
    {
        return Inertia::render('Nosotros');
    }

    public function productos(): Response
    {
        return Inertia::render('Productos');
    }

    public function hazloTuMismo(): Response
    {
        return Inertia::render('HazloTuMismo');
    }
}
