<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\GloboModa;

class GloboModaSeeder extends Seeder
{
    private array $balloons = [
        ['nombre' => 'VERDE', 'color' => '#00FF7F', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'TOMATEL', 'color' => '#FF6347', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'PINK', 'color' => '#FF1493', 'ruta_img' => null,  'activo' => 'si'],
        ['nombre' => 'SALMON', 'color' => '#40E0D0', 'ruta_img' => null,  'activo' => 'si'],
    ];

    public function run(): void
    {
        GloboModa::insert($this->balloons);
    }
}
