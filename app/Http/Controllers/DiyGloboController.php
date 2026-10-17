<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiyGloboSeleccionRequest;
use App\Models\Color;
use App\Models\DiyGloboSeleccion;
use App\Models\Globo;
use Illuminate\Http\JsonResponse;

class DiyGloboController extends Controller
{
    private const FONDO = '/img/productos/arco-globossensacional.webp';

    /**
     * @var array<string, string>
     */
    private const IMAGEN_POR_MEDIDA = [
        '18 cm' => 'grupo1-18cm.png',
        '23 cm' => 'grupo2-23cm.png',
        '30 cm' => 'grupo3-30cm.png',
        '43 cm' => 'grupo4-43cm.png',
    ];

    /**
     * @var array<string, int>
     */
    private const CAPA_POR_MEDIDA = [
        '18 cm' => 1,
        '23 cm' => 2,
        '30 cm' => 3,
        '43 cm' => 4,
    ];

    public function configuracion(): JsonResponse
    {
        $globos = Globo::query()
            ->with('colores')
            ->get()
            ->sortBy(fn (Globo $globo) => [$this->capaDe($globo), $globo->id])
            ->values()
            ->map(fn (Globo $globo) => $this->presentarGlobo($globo))
            ->all();

        return response()->json([
            'fondo_url' => self::FONDO,
            'globos' => $globos,
        ]);
    }

    public function guardarSeleccion(StoreDiyGloboSeleccionRequest $request): JsonResponse
    {
        $seleccion = collect($request->validated('seleccion'))
            ->map(fn (array $item) => [
                'globo_id' => (int) $item['globo_id'],
                'color_id' => (int) $item['color_id'],
                'hexadecimal' => $this->normalizarHex($item['hexadecimal']),
            ])
            ->values()
            ->all();

        $registro = DiyGloboSeleccion::query()->create([
            'seleccion' => $seleccion,
        ]);

        return response()->json([
            'message' => 'Combinación guardada.',
            'id' => $registro->id,
            'seleccion' => $registro->seleccion,
        ], 201);
    }

    /**
     * @return array{
     *     id: int,
     *     nombre: string,
     *     medida: string,
     *     descripcion: string|null,
     *     capa: int,
     *     imagen: string,
     *     imagen_url: string|null,
     *     colores: list<array{id: int, nombre: string, hexadecimal: string}>
     * }
     */
    private function presentarGlobo(Globo $globo): array
    {
        $imagen = $this->archivoImagen($globo);
        $colores = $globo->colores
            ->map(function (Color $color) {
                $hex = $this->normalizarHex($color->hexadecimal);
                if ($hex === null) {
                    return null;
                }

                return [
                    'id' => (int) $color->id,
                    'nombre' => (string) $color->nombre,
                    'hexadecimal' => $hex,
                ];
            })
            ->filter()
            ->unique('id')
            ->values()
            ->all();

        return [
            'id' => (int) $globo->id,
            'nombre' => (string) $globo->nombre,
            'medida' => (string) $globo->medida,
            'descripcion' => $globo->descripcion !== null ? (string) $globo->descripcion : null,
            'capa' => $this->capaDe($globo),
            'imagen' => $imagen,
            'imagen_url' => $imagen !== '' ? '/img/productos/'.$imagen : null,
            'colores' => $colores,
        ];
    }

    private function archivoImagen(Globo $globo): string
    {
        $nombre = basename(str_replace('\\', '/', (string) $globo->imagen));
        if (preg_match('/^[A-Za-z0-9._-]+\.png$/', $nombre) === 1) {
            return $nombre;
        }

        return self::IMAGEN_POR_MEDIDA[$globo->medida] ?? '';
    }

    private function capaDe(Globo $globo): int
    {
        $imagen = $this->archivoImagen($globo);
        if (preg_match('/^grupo(\d+)-/', $imagen, $coincidencias) === 1) {
            return (int) $coincidencias[1];
        }

        return self::CAPA_POR_MEDIDA[$globo->medida] ?? 99;
    }

    private function normalizarHex(?string $hex): ?string
    {
        $hex = strtoupper(ltrim(trim((string) $hex), '#'));
        if (preg_match('/^[0-9A-F]{6}$/', $hex) !== 1) {
            return null;
        }

        return '#'.$hex;
    }
}
