<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDecoratorApplicationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'motivation' => ['required', 'string', 'max:2000'],
            'social_networks' => ['nullable', 'string', 'max:500'],
            'city_or_state' => ['required', 'string', 'max:120'],
            'accept_promotions' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'whatsapp' => 'WhatsApp',
            'email' => 'correo electrónico',
            'motivation' => 'motivo',
            'social_networks' => 'redes sociales',
            'city_or_state' => 'ciudad o estado',
            'accept_promotions' => 'aceptación de información promocional',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'accept_promotions' => $this->boolean('accept_promotions'),
        ]);
    }
}
