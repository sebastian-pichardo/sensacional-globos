<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Globo extends Model
{
    use SoftDeletes;

    protected $table = 'globos';

    protected $fillable = [
        'nombre',
        'medida',
        'descripcion',
        'imagen',
    ];

    public function tieneColores(): HasMany
    {
        return $this->hasMany(GloboTieneColor::class, 'globo_id');
    }

    public function colores(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'globo_tiene_colores', 'globo_id', 'color_id')
            ->using(GloboTieneColor::class)
            ->withPivot(['globo_imagen', 'color', 'color_imagen'])
            ->withTimestamps()
            ->wherePivotNull('deleted_at')
            ->orderBy('colores.id');
    }
}
