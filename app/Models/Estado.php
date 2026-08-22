<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'clave',
        'nombre',
        'abrev',
        'activo',
        'clave_sat',
    ];

    /**
     * @return HasMany<Distribuidor, $this>
     */
    public function distribuidores(): HasMany
    {
        return $this->hasMany(Distribuidor::class, 'estado_clave', 'clave_sat');
    }
}
