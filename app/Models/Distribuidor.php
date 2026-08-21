<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribuidor extends Model
{
    use SoftDeletes;

    protected $table = 'distribuidores';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'whatsapp',
        'clave',
        'empresa',
        'rfc',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'estado_clave',
        'codigo_postal',
        'email',
        'activo',
    ];

    protected $casts = [
        'clave' => 'encrypted',
    ];

    protected $attributes = [
        'activo' => 'si',
    ];
}
