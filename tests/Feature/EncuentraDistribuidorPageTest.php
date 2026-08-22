<?php

namespace Tests\Feature;

use App\Models\Distribuidor;
use App\Models\Estado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EncuentraDistribuidorPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_se_renderiza_con_estados_y_distribuidores(): void
    {
        $this->crearEstadoYDistribuidor();

        $this->get(route('encuentra-un-distribuidor'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('EncuentraDistribuidor')
                ->has('estados', 1)
                ->has('distribuidores', 1)
                ->where('distribuidores.0.empresa', 'Globos Alegría')
                ->where('distribuidores.0.estado_clave', 'PUE')
                ->where('distribuidores.0.latitude', 19.048101)
                ->missing('distribuidores.0.clave')
                ->has('states')
                ->has('catalogHint')
            );
    }

    public function test_no_incluye_distribuidores_inactivos(): void
    {
        $this->crearEstadoYDistribuidor(['activo' => 'no']);

        $this->get(route('encuentra-un-distribuidor'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('EncuentraDistribuidor')
                ->has('distribuidores', 0)
            );
    }

    public function test_clave_incorrecta_muestra_el_mensaje_de_acceso(): void
    {
        $this->crearEstadoYDistribuidor();

        $this->from(route('encuentra-un-distribuidor'))
            ->post(route('distribuidores.catalogo'), ['clave' => 'clave-invalida'])
            ->assertRedirect(route('encuentra-un-distribuidor'))
            ->assertSessionHas('catalog_error', config('globos.distributor_catalog_hint'));
    }

    public function test_clave_vacia_muestra_el_mensaje_de_acceso(): void
    {
        $this->from(route('encuentra-un-distribuidor'))
            ->post(route('distribuidores.catalogo'), ['clave' => ''])
            ->assertRedirect(route('encuentra-un-distribuidor'))
            ->assertSessionHas('catalog_error', config('globos.distributor_catalog_hint'));
    }

    public function test_clave_valida_descarga_el_catalogo(): void
    {
        $this->crearEstadoYDistribuidor(['clave' => 'globos26']);

        $relative = 'distribuidores-cat/globos-distribuidores-ex.pdf';
        $path = public_path($relative);
        $existia = is_file($path);
        $contenidoPrevio = $existia ? file_get_contents($path) : null;

        try {
            file_put_contents($path, '%PDF-1.4 test');

            $this->post(route('distribuidores.catalogo'), ['clave' => 'globos26'])
                ->assertOk()
                ->assertDownload('catalogo-distribuidores-sensacional.pdf');
        } finally {
            if ($existia && $contenidoPrevio !== null) {
                file_put_contents($path, $contenidoPrevio);
            } else {
                @unlink($path);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function crearEstadoYDistribuidor(array $overrides = []): void
    {
        Estado::query()->create([
            'clave' => '21',
            'nombre' => 'Puebla',
            'abrev' => 'Pue.',
            'activo' => 1,
            'clave_sat' => 'PUE',
        ]);

        Distribuidor::query()->create(array_merge([
            'nombre' => 'Juan',
            'apellido_paterno' => 'Pérez',
            'apellido_materno' => 'López',
            'clave' => 'globos26',
            'empresa' => 'Globos Alegría',
            'calle' => 'Av. Reforma',
            'num_exterior' => '100',
            'colonia' => 'Centro',
            'estado_clave' => 'PUE',
            'codigo_postal' => '72000',
            'email' => 'juan@example.com',
            'activo' => 'si',
            'latitude' => 19.048101,
            'longitude' => -98.202423,
        ], $overrides));
    }
}
