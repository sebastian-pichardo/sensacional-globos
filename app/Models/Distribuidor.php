<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Throwable;

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
        'latitude',
        'longitude',
        'activo',
    ];

    protected $hidden = [
        'clave',
        'rfc',
    ];

    protected $casts = [
        'clave' => 'encrypted',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected $attributes = [
        'activo' => 'si',
    ];

    /**
     * @return BelongsTo<Estado, $this>
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_clave', 'clave_sat');
    }

    public function direccion(): string
    {
        $linea = trim(implode(' ', array_filter([
            $this->calle,
            $this->num_exterior,
            $this->num_interior ? 'Int. '.$this->num_interior : null,
        ])));

        return implode(', ', array_filter([
            $linea !== '' ? $linea : null,
            $this->colonia,
            $this->codigo_postal ? 'C.P. '.$this->codigo_postal : null,
        ]));
    }

    public function tieneUbicacion(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    public static function claveEsValida(string $clave): bool
    {
        if ($clave === '') {
            return false;
        }

        return static::query()
            ->where('activo', 'si')
            ->get()
            ->contains(function (self $distribuidor) use ($clave) {
                try {
                    return hash_equals((string) $distribuidor->clave, $clave);
                } catch (Throwable) {
                    return false;
                }
            });
    }
}
