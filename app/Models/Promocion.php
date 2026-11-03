<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Promocion extends Model
{
    use SoftDeletes;

    protected $table = 'promociones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'participante',
        'lugar',
    ];

    /**
     * Decoraciones de Globoween 2 y el valor de cada lugar en el marcador.
     *
     * @var array<string, array{nombre: string, imagen: string}>
     */
    public const PARTICIPANTES = [
        'los_villanos' => [
            'nombre' => 'Los villanos',
            'imagen' => '/img/productos/concurso-octubre1-globossensacional-2026.webp',
        ],
        'hola_frankie' => [
            'nombre' => 'Hola frankie',
            'imagen' => '/img/productos/concurso-octubre2-globossensacional-2026.webp',
        ],
        'arco_halloween' => [
            'nombre' => 'Arco de halloween',
            'imagen' => '/img/productos/concurso-octubre3-globossensacional-2026.webp',
        ],
        'monstruo_frankie' => [
            'nombre' => 'Monstruo frankie',
            'imagen' => '/img/productos/concurso-octubre4-globossensacional-2026.webp',
        ],
    ];

    public const PUNTOS = [
        'primero' => 3,
        'segundo' => 2,
        'tercero' => 1,
    ];

    /**
     * @return list<string>
     */
    public static function claves(): array
    {
        return array_keys(self::PARTICIPANTES);
    }

    /**
     * Marcador de la promoción: boletas, puntos por decoración y últimas boletas.
     *
     * @return array{
     *     boletas: int,
     *     lider: ?string,
     *     puntuacion: array{primero: int, segundo: int, tercero: int},
     *     participantes: list<array<string, mixed>>,
     *     correos: list<array<string, mixed>>
     * }
     */
    public static function resumenVotacion(): array
    {
        $conteos = static::query()
            ->selectRaw('participante, lugar, COUNT(*) as total')
            ->groupBy('participante', 'lugar')
            ->get();

        $matriz = [];
        foreach (self::claves() as $clave) {
            $matriz[$clave] = [
                'primero' => 0,
                'segundo' => 0,
                'tercero' => 0,
            ];
        }

        foreach ($conteos as $fila) {
            if (! isset($matriz[$fila->participante][$fila->lugar])) {
                continue;
            }

            $matriz[$fila->participante][$fila->lugar] = (int) $fila->total;
        }

        $boletas = (int) static::query()->distinct()->count('email');

        $participantes = [];
        foreach (self::PARTICIPANTES as $clave => $meta) {
            $primero = $matriz[$clave]['primero'];
            $segundo = $matriz[$clave]['segundo'];
            $tercero = $matriz[$clave]['tercero'];

            $participantes[] = [
                'clave' => $clave,
                'nombre' => $meta['nombre'],
                'imagen' => $meta['imagen'],
                'primero' => $primero,
                'segundo' => $segundo,
                'tercero' => $tercero,
                'puntos' => ($primero * self::PUNTOS['primero'])
                    + ($segundo * self::PUNTOS['segundo'])
                    + ($tercero * self::PUNTOS['tercero']),
            ];
        }

        usort($participantes, function (array $a, array $b): int {
            return [
                $b['puntos'],
                $b['primero'],
                $b['segundo'],
                $b['tercero'],
                $a['nombre'],
            ] <=> [
                $a['puntos'],
                $a['primero'],
                $a['segundo'],
                $a['tercero'],
                $b['nombre'],
            ];
        });

        $posicion = 0;
        $firmaAnterior = null;
        foreach ($participantes as $indice => &$participante) {
            $firma = [
                $participante['puntos'],
                $participante['primero'],
                $participante['segundo'],
                $participante['tercero'],
            ];

            if ($firma !== $firmaAnterior) {
                $posicion = $indice + 1;
                $firmaAnterior = $firma;
            }

            $participante['posicion'] = $posicion;
        }
        unset($participante);

        return [
            'boletas' => $boletas,
            'lider' => $boletas > 0 ? $participantes[0]['nombre'] : null,
            'puntuacion' => self::PUNTOS,
            'participantes' => $participantes,
            'correos' => self::boletasRegistradas(),
        ];
    }

    /**
     * @return list<array{email: string, votado_en: ?string, primero: string, segundo: string, tercero: string}>
     */
    private static function boletasRegistradas(): array
    {
        $encabezados = static::query()
            ->select('email')
            ->selectRaw('MAX(created_at) as votado_en')
            ->groupBy('email')
            ->orderByDesc('votado_en')
            ->get();

        if ($encabezados->isEmpty()) {
            return [];
        }

        $detalles = static::query()
            ->whereIn('email', $encabezados->pluck('email'))
            ->get()
            ->groupBy('email');

        return $encabezados->map(function ($encabezado) use ($detalles) {
            $porLugar = $detalles->get($encabezado->email, collect())->keyBy('lugar');
            $votadoEn = $encabezado->votado_en
                ? Carbon::parse($encabezado->votado_en)->toIso8601String()
                : null;

            return [
                'email' => $encabezado->email,
                'votado_en' => $votadoEn,
                'primero' => self::nombreDe($porLugar->get('primero')?->participante),
                'segundo' => self::nombreDe($porLugar->get('segundo')?->participante),
                'tercero' => self::nombreDe($porLugar->get('tercero')?->participante),
            ];
        })->all();
    }

    private static function nombreDe(?string $clave): string
    {
        if ($clave === null || ! isset(self::PARTICIPANTES[$clave])) {
            return '—';
        }

        return self::PARTICIPANTES[$clave]['nombre'];
    }
}
