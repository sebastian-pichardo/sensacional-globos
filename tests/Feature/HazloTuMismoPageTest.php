<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\Globo;
use App\Models\GloboEstandar;
use App\Models\GloboMetal;
use App\Models\GloboModa;
use App\Models\GloboTieneColor;
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
                ->where('lineasColor.moda.0.nombre', 'PINK')
                ->has('tiposGlobo', 0));
    }

    public function test_hazlo_tu_mismo_includes_balloon_sizes_and_related_colors(): void
    {
        $globo = Globo::query()->create([
            'nombre' => 'globos de 18 cm (7")',
            'medida' => '18 cm',
            'descripcion' => 'Globo de prueba',
        ]);
        $color = Color::query()->create([
            'nombre' => 'Amarillo',
            'pantone' => '13-0753 TCX',
            'rgb' => 'rgb(239, 215, 25)',
            'hexadecimal' => '#efd719',
        ]);
        GloboTieneColor::query()->create([
            'globo_id' => $globo->id,
            'color_id' => $color->id,
            'globo_imagen' => 'globo.webp',
            'color' => '13-0753 TCX',
        ]);

        $this->get(route('hazlo-tu-mismo'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('HazloTuMismo')
                ->has('tiposGlobo', 1)
                ->where('tiposGlobo.0.nombre', 'globos de 18 cm (7")')
                ->where('tiposGlobo.0.medida', '18 cm')
                ->has('tiposGlobo.0.colores', 1)
                ->where('tiposGlobo.0.colores.0.nombre', 'Amarillo')
                ->where('tiposGlobo.0.colores.0.hexadecimal', '#EFD719'));
    }
}
