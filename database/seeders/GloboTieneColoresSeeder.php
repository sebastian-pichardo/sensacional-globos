<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GloboTieneColor;

class GloboTieneColoresSeeder extends Seeder
{
    private array $balloons = [
        [
            'globo_id' => 1,
            'color_id' => 1,
            'color' => '13-0753 TCX',
        ],
        [
            'globo_id' => 1,
            'color_id' => 2,
            'color' => '15-1051 TCX',
        ],
        [
            'globo_id' => 1,
            'color_id' => 3,
            'color' => '15-3412 TCX',
        ],
        [
            'globo_id' => 1,
            'color_id' => 4,
            'color' => '17-1664 TCX',
        ],
        [
            'globo_id' => 2,
            'color_id' => 1,
            'color' => '13-0753 TCX',
        ],
        [
            'globo_id' => 2,
            'color_id' => 2,
            'color' => '15-1051 TCX',
        ],
        [
            'globo_id' => 2,
            'color_id' => 3,
            'color' => '15-3412 TCX',
        ],
        [
            'globo_id' => 2,
            'color_id' => 4,
            'color' => '17-1664 TCX',
        ],
        [
            'globo_id' => 3,
            'color_id' => 1,
            'color' => '13-0753 TCX',
        ],
        [
            'globo_id' => 3,
            'color_id' => 2,
            'color' => '15-1051 TCX',
        ],
        [
            'globo_id' => 3,
            'color_id' => 3,
            'color' => '15-3412 TCX',
        ]
    ];
    public function run(): void
    {
        GloboTieneColor::insert($this->balloons);
    }
}
