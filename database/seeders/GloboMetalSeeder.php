<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GloboMetal;

class GloboMetalSeeder extends Seeder
{
    private array $balloons = [
        ['nombre' => 'SILVER', 'color' => '#778899', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'ROJO METAL', 'color' => '#FF0000', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'TE', 'color' => '#008080', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'TURQUESA', 'color' => '#40E0D0', 'ruta_img' => null,  'activo' => 'si'],
    ];
    public function run(): void
    {
        GloboMetal::insert($this->balloons);
    }
}
