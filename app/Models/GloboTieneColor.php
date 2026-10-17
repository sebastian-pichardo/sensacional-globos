<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class GloboTieneColor extends Pivot
{
    use SoftDeletes;

    public $incrementing = true;

    protected $table = 'globo_tiene_colores';

    protected $fillable = [
        'globo_id',
        'color_id',
        'globo_imagen',
        'color',
        'color_imagen',
    ];

    public function globo(): BelongsTo
    {
        return $this->belongsTo(Globo::class, 'globo_id');
    }

    public function colorCatalogo(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
}
