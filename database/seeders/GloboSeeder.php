<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Globo;

class GloboSeeder extends Seeder
{
    private array $balloons = [

    ];
    public function run(): void
    {
        Globo::insert($this->balloons);
    }
}
