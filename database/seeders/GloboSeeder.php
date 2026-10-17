<?php

namespace Database\Seeders;

use App\Models\Globo;
use Illuminate\Database\Seeder;

class GloboSeeder extends Seeder
{
    private array $balloons = [
        [
            'nombre' => 'globos de 18 cm (7")',
            'medida' => '18 cm',
            'descripcion' => 'Globo util para fisestas y eventos',
            'imagen' => 'grupo1-18cm.png',
        ],
        [
            'nombre' => 'globos de 23 cm (9")',
            'medida' => '23 cm',
            'descripcion' => 'Globo util para fisestas y eventos',
            'imagen' => 'grupo2-23cm.png',
        ],
        [
            'nombre' => 'globos de 30 cm (12")',
            'medida' => '30 cm',
            'descripcion' => 'Globo util para fisestas y eventos',
            'imagen' => 'grupo3-30cm.png',
        ],
        [
            'nombre' => 'globos de 43 cm (17")',
            'medida' => '43 cm',
            'descripcion' => 'Globo util para fisestas y eventos',
            'imagen' => 'grupo4-43cm.png',
        ],
    ];

    public function run(): void
    {
        Globo::insert($this->balloons);
    }
}
