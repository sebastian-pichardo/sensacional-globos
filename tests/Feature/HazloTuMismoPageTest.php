<?php

namespace Tests\Feature;

use App\Models\GloboEstandar;
use App\Models\GloboMetal;
use App\Models\GloboModa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HazloTuMismoPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_hazlo_tu_mismo_page_is_rendered(): void
    {
        GloboEstandar::query()->create([
            'nombre' => 'ROJO',
            'color' => '#DC143C',
            'activo' => 'si',
        ]);
        GloboMetal::query()->create([
            'nombre' => 'SILVER',
            'color' => '#778899',
            'activo' => 'si',
        ]);
        GloboModa::query()->create([
            'nombre' => 'PINK',
            'color' => '#FF1493',
            'activo' => 'si',
        ]);

        $this->get(route('hazlo-tu-mismo'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('HazloTuMismo')
                ->has('lineasColor.estandar', 1)
                ->has('lineasColor.metal', 1)
                ->has('lineasColor.moda', 1)
                ->where('lineasColor.estandar.0.nombre', 'ROJO')
                ->where('lineasColor.estandar.0.color', '#DC143C')
                ->where('lineasColor.metal.0.nombre', 'SILVER')
                ->where('lineasColor.moda.0.nombre', 'PINK'));
    }
}
