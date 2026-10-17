<?php

namespace App\Http\Requests;

use App\Models\Color;
use App\Models\GloboTieneColor;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiyGloboSeleccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'seleccion' => ['required', 'array', 'min:1', 'max:4'],
            'seleccion.*.globo_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('globos', 'id')->whereNull('deleted_at'),
            ],
            'seleccion.*.color_id' => [
                'required',
                'integer',
                Rule::exists('colores', 'id')->whereNull('deleted_at'),
            ],
            'seleccion.*.hexadecimal' => ['required', 'string', 'regex:/^#[0-9A-F]{6}$/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'seleccion' => 'selección',
            'seleccion.*.globo_id' => 'globo',
            'seleccion.*.color_id' => 'color',
            'seleccion.*.hexadecimal' => 'código de color',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'seleccion.required' => 'Selecciona al menos un color.',
            'seleccion.array' => 'La selección no tiene un formato válido.',
            'seleccion.min' => 'Selecciona al menos un color.',
            'seleccion.max' => 'Solo puedes guardar hasta 4 colores.',
            'seleccion.*.globo_id.required' => 'Falta el globo de la selección.',
            'seleccion.*.globo_id.distinct' => 'Hay una medida repetida en la selección.',
            'seleccion.*.globo_id.exists' => 'Uno de los globos ya no está disponible.',
            'seleccion.*.color_id.required' => 'Falta el color de la selección.',
            'seleccion.*.color_id.exists' => 'Uno de los colores ya no está disponible.',
            'seleccion.*.hexadecimal.required' => 'Falta el código de color.',
            'seleccion.*.hexadecimal.regex' => 'El código de color no es válido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $seleccion = $this->input('seleccion');
        if (! is_array($seleccion)) {
            return;
        }

        $normalizada = [];
        foreach ($seleccion as $item) {
            if (! is_array($item)) {
                $normalizada[] = $item;

                continue;
            }

            if (isset($item['hexadecimal']) && is_string($item['hexadecimal'])) {
                $hex = strtoupper(ltrim(trim($item['hexadecimal']), '#'));
                $item['hexadecimal'] = '#'.$hex;
            }

            $normalizada[] = $item;
        }

        $this->merge([
            'seleccion' => $normalizada,
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $seleccion = $this->input('seleccion');
            if (! is_array($seleccion) || $validator->errors()->isNotEmpty()) {
                return;
            }

            $globoIds = collect($seleccion)->pluck('globo_id')->filter()->all();
            $colorIds = collect($seleccion)->pluck('color_id')->filter()->all();

            $pares = GloboTieneColor::query()
                ->whereIn('globo_id', $globoIds)
                ->whereIn('color_id', $colorIds)
                ->get(['globo_id', 'color_id'])
                ->mapWithKeys(fn (GloboTieneColor $relacion) => [
                    $relacion->globo_id.'-'.$relacion->color_id => true,
                ]);

            $colores = Color::query()
                ->whereIn('id', $colorIds)
                ->get()
                ->keyBy('id');

            foreach ($seleccion as $index => $item) {
                if (! is_array($item)) {
                    continue;
                }

                $clave = ($item['globo_id'] ?? '').'-'.($item['color_id'] ?? '');
                if (! $pares->has($clave)) {
                    $validator->errors()->add(
                        "seleccion.$index.color_id",
                        'Este color no está disponible para ese globo.',
                    );

                    continue;
                }

                $color = $colores->get($item['color_id'] ?? null);
                $hexCatalogo = $this->normalizarHex($color?->hexadecimal);
                if ($hexCatalogo === null || $hexCatalogo !== ($item['hexadecimal'] ?? null)) {
                    $validator->errors()->add(
                        "seleccion.$index.hexadecimal",
                        'El color no coincide con el catálogo.',
                    );
                }
            }
        });
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
