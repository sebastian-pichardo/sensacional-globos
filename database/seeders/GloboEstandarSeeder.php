<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GloboEstandar;

class GloboEstandarSeeder extends Seeder
{
    private array $balloons = [
        ['nombre' => 'ROJO', 'color' => '#DC143C', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'VERDE', 'color' => '#00FA9A', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'AZUL', 'color' => '#0000CD', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'AZUL MARINO', 'color' => '#000080', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'CAFE', 'color' => '#8B4513', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'VIOLETA', 'color' => '#9400D3', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'ROSA', 'color' => '#EE82EE', 'ruta_img' => null,  'activo' => 'si'],
    ];

    public function run(): void
    {
        GloboEstandar::insert($this->balloons);
    }
}
