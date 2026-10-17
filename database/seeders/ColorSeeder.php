<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    private array $colors = [
        [
            'nombre' => 'Amarillo',
            'pantone' => '13-0753 TCX',
            'rgb' => 'rgb(239, 215, 25)',
            'hexadecimal' => '#EFD719',
            'imagen' => null,
        ],
        [
            'nombre' => 'Naranja',
            'pantone' => '15-1051 TCX',
            'rgb' => 'rgb(219, 147, 45)',
            'hexadecimal' => '#DB932D',
            'imagen' => null,
        ],
        [
            'nombre' => 'Rosa bebé',
            'pantone' => '15-3412 TCX',
            'rgb' => 'rgb(207, 170, 198)',
            'hexadecimal' => '#CFAAC6',
            'imagen' => null,
        ],
        [
            'nombre' => 'Rojo',
            'pantone' => '17-1664 TCX',
            'rgb' => 'rgb(224, 47, 57)',
            'hexadecimal' => '#E02F39',
            'imagen' => null,
        ],
        [
            'nombre' => 'Azul bebé',
            'pantone' => '13-4103 TCX',
            'rgb' => 'rgb(201, 210, 220)',
            'hexadecimal' => '#C9D2DC',
            'imagen' => null,
        ],
        [
            'nombre' => 'Azul océano',
            'pantone' => '18-1413 TCX',
            'rgb' => 'rgb(49, 113, 177)',
            'hexadecimal' => '#3171B1',
            'imagen' => null,
        ],
        [
            'nombre' => 'Verde',
            'pantone' => '15-5534 TCX',
            'rgb' => 'rgb(0, 151, 96)',
            'hexadecimal' => '#009760',
            'imagen' => null,
        ],
        [
            'nombre' => 'Blanco',
            'pantone' => '11-4202 TCX',
            'rgb' => 'rgb(239, 240, 234)',
            'hexadecimal' => '#EFF0EA',
            'imagen' => null,
        ],
        [
            'nombre' => 'Durazno',
            'pantone' => '14-1051 TCX',
            'rgb' => 'rgb(255, 182, 104)',
            'hexadecimal' => '#FFB668',
            'imagen' => null,
        ],
        [
            'nombre' => 'Verde Menta',
            'pantone' => '12-0225 TCX',
            'rgb' => 'rgb(183, 232, 183)',
            'hexadecimal' => '#B7E8B7',
            'imagen' => null,
        ],
        [
            'nombre' => 'Lila',
            'pantone' => '16-3923 TCX',
            'rgb' => 'rgb(157, 164, 202)',
            'hexadecimal' => '#9DA4CA',
            'imagen' => null,
        ],
        [
            'nombre' => 'Morado',
            'pantone' => '18-3840 TCX',
            'rgb' => 'rgb(99, 87, 154)',
            'hexadecimal' => '#63579A',
            'imagen' => null,
        ],
        [
            'nombre' => 'Marfil',
            'pantone' => '11-0710 TCX',
            'rgb' => 'rgb(239, 239, 184)',
            'hexadecimal' => '#EFEFB8',
            'imagen' => null,
        ],
        [
            'nombre' => 'Rosa brillante',
            'pantone' => '16-3321 TCX',
            'rgb' => 'rgb(177, 114, 165)',
            'hexadecimal' => '#B172A5',
            'imagen' => null,
        ],
        [
            'nombre' => 'Verde lima',
            'pantone' => '14-0452 TCX',
            'rgb' => 'rgb(158, 194, 44)',
            'hexadecimal' => '#9EC22C',
            'imagen' => null,
        ],
        [
            'nombre' => 'Botón de oro',
            'pantone' => '14-0758 TCX',
            'rgb' => 'rgb(224, 174, 0)',
            'hexadecimal' => '#E0AE00',
            'imagen' => null,
        ],
        [
            'nombre' => 'Rosa Caliente',
            'pantone' => '17-2034 TCX',
            'rgb' => 'rgb(201, 48, 110)',
            'hexadecimal' => '#C9306E',
            'imagen' => null,
        ],
        [
            'nombre' => 'Turquesa',
            'pantone' => '18-4330 TCX',
            'rgb' => 'rgb(0, 126, 170)',
            'hexadecimal' => '#007EAA',
            'imagen' => null,
        ],
        [
            'nombre' => 'Negro',
            'pantone' => '19-3911 TCX',
            'rgb' => 'rgb(43, 43, 43)',
            'hexadecimal' => '#2B2B2B',
            'imagen' => null,
        ],
        [
            'nombre' => 'Coral',
            'pantone' => '15-1821 TCX',
            'rgb' => 'rgb(247, 149, 155)',
            'hexadecimal' => '#F7959B',
            'imagen' => null,
        ],
    ];

    public function run(): void
    {
        Color::insert($this->colors);
    }
}
