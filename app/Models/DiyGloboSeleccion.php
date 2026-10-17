<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiyGloboSeleccion extends Model
{
    protected $table = 'diy_globo_selecciones';

    protected $fillable = [
        'seleccion',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'seleccion' => 'array',
        ];
    }
}
