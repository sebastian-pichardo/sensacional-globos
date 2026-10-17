<?php

namespace Tests\Feature;

use App\Models\Color;
use App\Models\DiyGloboSeleccion;
use App\Models\Globo;
use App\Models\GloboTieneColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiyGloboApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_configuracion_returns_layers_ordered_with_public_png_and_colors(): void
    {
        $grande = $this->globo('globos de 43 cm (17")', '43 cm', 'grupo4-43cm.png');
        $chico = $this->globo('globos de 18 cm (7")', '18 cm', 'grupo1-18cm.png');
        $rojo = $this->color('Rojo', '#e02f39');
        $blanco = $this->color('Blanco', 'EFF0EA');
        $this->relacionar($grande, $rojo);
        $this->relacionar($chico, $blanco);
        $this->relacionar($chico, $rojo);

        $this->getJson(route('diy-globos.configuracion'))
            ->assertOk()
            ->assertJsonPath('fondo_url', '/img/productos/arco-globossensacional.webp')
            ->assertJsonCount(2, 'globos')
            ->assertJsonPath('globos.0.id', $chico->id)
            ->assertJsonPath('globos.0.capa', 1)
            ->assertJsonPath('globos.0.imagen', 'grupo1-18cm.png')
            ->assertJsonPath('globos.0.imagen_url', '/img/productos/grupo1-18cm.png')
            ->assertJsonPath('globos.0.colores.0.nombre', 'Rojo')
            ->assertJsonPath('globos.0.colores.0.hexadecimal', '#E02F39')
            ->assertJsonPath('globos.0.colores.1.hexadecimal', '#EFF0EA')
            ->assertJsonPath('globos.1.capa', 4)
            ->assertJsonPath('globos.1.imagen_url', '/img/productos/grupo4-43cm.png')
            ->assertJsonPath('globos.1.colores.0.nombre', 'Rojo');
    }

    public function test_configuracion_falls_back_to_layer_png_when_image_is_missing(): void
    {
        $this->globo('globos de 30 cm (12")', '30 cm', null);

        $this->getJson(route('diy-globos.configuracion'))
            ->assertOk()
            ->assertJsonPath('globos.0.medida', '30 cm')
            ->assertJsonPath('globos.0.capa', 3)
            ->assertJsonPath('globos.0.imagen', 'grupo3-30cm.png')
            ->assertJsonPath('globos.0.imagen_url', '/img/productos/grupo3-30cm.png');
    }

    public function test_configuracion_hides_soft_deleted_color_relations(): void
    {
        $globo = $this->globo('globos de 23 cm (9")', '23 cm', 'grupo2-23cm.png');
        $color = $this->color('Rosa', '#F3A4C4');
        $relacion = $this->relacionar($globo, $color);
        $relacion->delete();

        $this->getJson(route('diy-globos.configuracion'))
            ->assertOk()
            ->assertJsonPath('globos.0.colores', []);
    }

    public function test_guardar_seleccion_persists_the_current_combination(): void
    {
        $globo = $this->globo('globos de 18 cm (7")', '18 cm', 'grupo1-18cm.png');
        $color = $this->color('Verde', '#009760');
        $this->relacionar($globo, $color);

        $this->postJson(route('diy-globos.guardar-seleccion'), [
            'seleccion' => [[
                'globo_id' => $globo->id,
                'color_id' => $color->id,
                'hexadecimal' => '009760',
            ]],
        ])
            ->assertCreated()
            ->assertJsonPath('message', 'Combinación guardada.')
            ->assertJsonPath('seleccion.0.globo_id', $globo->id)
            ->assertJsonPath('seleccion.0.color_id', $color->id)
            ->assertJsonPath('seleccion.0.hexadecimal', '#009760');

        $registro = DiyGloboSeleccion::query()->first();
        $this->assertNotNull($registro);
        $this->assertSame('#009760', $registro->seleccion[0]['hexadecimal']);
    }

    public function test_guardar_seleccion_rejects_a_color_that_does_not_belong_to_the_balloon(): void
    {
        $globo = $this->globo('globos de 18 cm (7")', '18 cm', 'grupo1-18cm.png');
        $color = $this->color('Oro', '#C4A15A');

        $this->postJson(route('diy-globos.guardar-seleccion'), [
            'seleccion' => [[
                'globo_id' => $globo->id,
                'color_id' => $color->id,
                'hexadecimal' => '#C4A15A',
            ]],
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['seleccion.0.color_id']);

        $this->assertSame(0, DiyGloboSeleccion::query()->count());
    }

    private function globo(string $nombre, string $medida, ?string $imagen): Globo
    {
        return Globo::query()->create([
            'nombre' => $nombre,
            'medida' => $medida,
            'descripcion' => 'Globo de prueba',
            'imagen' => $imagen,
        ]);
    }

    private function color(string $nombre, string $hex): Color
    {
        return Color::query()->create([
            'nombre' => $nombre,
            'pantone' => '00-0000 TCX',
            'hexadecimal' => $hex,
        ]);
    }

    private function relacionar(Globo $globo, Color $color): GloboTieneColor
    {
        return GloboTieneColor::query()->create([
            'globo_id' => $globo->id,
            'color_id' => $color->id,
            'globo_imagen' => $globo->imagen ?: 'globo.png',
        ]);
    }
}
