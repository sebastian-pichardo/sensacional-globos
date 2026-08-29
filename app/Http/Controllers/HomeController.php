<?php

namespace App\Http\Controllers;

use App\Models\GloboEstandar;
use App\Models\GloboMetal;
use App\Models\GloboModa;
use Illuminate\Support\Collection;
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
        return Inertia::render('HazloTuMismo', [
            'lineasColor' => [
                'estandar' => $this->coloresActivos(GloboEstandar::class),
                'metal' => $this->coloresActivos(GloboMetal::class),
                'moda' => $this->coloresActivos(GloboModa::class),
            ],
        ]);
    }

    /**
     * @param  class-string  $model
     * @return list<array{id: int, nombre: string, color: string}>
     */
    private function coloresActivos(string $model): array
    {
        /** @var Collection<int, object> $rows */
        $rows = $model::query()
            ->where('activo', 'si')
            ->whereNotNull('color')
            ->orderBy('id')
            ->get(['id', 'nombre', 'color']);

        return $rows
            ->unique(fn ($row) => strtoupper(trim((string) $row->color)))
            ->values()
            ->map(fn ($row) => [
                'id' => (int) $row->id,
                'nombre' => (string) $row->nombre,
                'color' => (string) $row->color,
            ])
            ->all();
    }

    public function avisoPrivacidad(): Response
    {
        return Inertia::render('AvisoPrivacidad');
    }
}
