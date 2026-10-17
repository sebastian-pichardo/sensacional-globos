<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    protected $table = 'colores';

    protected $fillable = [
        'nombre',
        'pantone',
        'rgb',
        'hexadecimal',
        'imagen',
    ];

    public function globos(): BelongsToMany
    {
        return $this->belongsToMany(Globo::class, 'globo_tiene_colores', 'color_id', 'globo_id')
            ->using(GloboTieneColor::class)
            ->withPivot(['globo_imagen', 'color', 'color_imagen'])
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }
}
