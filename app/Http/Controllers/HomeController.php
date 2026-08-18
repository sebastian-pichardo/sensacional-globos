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
                    'image' => '/img/productos/slider1.webp',
                    'name' => '',
                    'sku' => '',
                    'description' => '',
                    'alt' => 'Catálogo de productos Sensacional 2026',
                    'href' => '/catalogo/2026/Catalogo-Sensacional-2026.php',
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
            'hazlo-tu-mismo' => 'Hazlo tú mismo',
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
}
