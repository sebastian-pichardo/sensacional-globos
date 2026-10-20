<?php

namespace Tests\Feature;

use App\Models\ClientePotencial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonalCatalogDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guarda_el_correo_y_descarga_el_catalogo_de_temporada(): void
    {
        $relative = 'catalogo/2026/catalogo-temporada-test.pdf';
        $path = public_path($relative);
        config(['globos.seasonal_catalog_path' => $relative]);

        try {
            file_put_contents($path, '%PDF-1.4 test');

            $this->post(route('catalogo.solicitar'), [
                'email' => 'Fiesta@Empresa.com',
                'catalogo' => 'temporada',
            ])
                ->assertOk()
                ->assertDownload('catalogo-de-temporada-2026.pdf');

            $this->assertDatabaseHas('clientes_potenciales', [
                'email' => 'fiesta@empresa.com',
                'medio' => 'catalogo-temporada',
                'validado' => 'pendiente',
            ]);
        } finally {
            @unlink($path);
        }
    }

    public function test_el_mismo_correo_no_se_duplica(): void
    {
        $relative = 'catalogo/2026/catalogo-temporada-test.pdf';
        $path = public_path($relative);
        config(['globos.seasonal_catalog_path' => $relative]);

        try {
            file_put_contents($path, '%PDF-1.4 test');

            $this->post(route('catalogo.solicitar'), [
                'email' => 'fiesta@empresa.com',
                'catalogo' => 'temporada',
            ])->assertOk();
            $this->post(route('catalogo.solicitar'), [
                'email' => 'fiesta@empresa.com',
                'catalogo' => 'temporada',
            ])->assertOk();

            $this->assertSame(1, ClientePotencial::query()->count());
        } finally {
            @unlink($path);
        }
    }

    public function test_sin_correo_no_guarda_ni_descarga(): void
    {
        $this->from(route('home'))
            ->post(route('catalogo.solicitar'), ['email' => '', 'catalogo' => 'temporada'])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors('email');

        $this->assertSame(0, ClientePotencial::query()->count());
    }
}
