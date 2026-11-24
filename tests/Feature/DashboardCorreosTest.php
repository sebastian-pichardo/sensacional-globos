<?php

namespace Tests\Feature;

use App\Models\ClientePotencial;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardCorreosTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_registered_emails(): void
    {
        $this->get(route('dashboard.catalogos'))->assertRedirect(route('login'));
        $this->get(route('dashboard.catalogos.pdf'))->assertRedirect(route('login'));
        $this->get(route('dashboard.newsletter'))->assertRedirect(route('login'));
        $this->get(route('dashboard.newsletter.pdf'))->assertRedirect(route('login'));
    }

    public function test_dashboard_lists_catalog_emails_and_exports_pdf(): void
    {
        $user = User::factory()->create();

        $temporada = ClientePotencial::create([
            'email' => 'temporada@example.com',
            'validado' => 'pendiente',
            'medio' => 'catalogo-temporada',
        ]);
        $temporada->forceFill(['created_at' => now()->subHour()])->save();

        ClientePotencial::create([
            'email' => 'general@example.com',
            'validado' => 'pendiente',
            'medio' => 'catalogo-general',
        ]);

        ClientePotencial::create([
            'email' => 'otro@example.com',
            'validado' => 'pendiente',
            'medio' => 'contacto',
        ]);

        $borrado = ClientePotencial::create([
            'email' => 'borrado@example.com',
            'validado' => 'pendiente',
            'medio' => 'catalogo-general',
        ]);
        $borrado->delete();

        $this->actingAs($user)
            ->get(route('dashboard.catalogos'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Correos')
                ->where('titulo', 'Descarga de catálogos')
                ->has('registros', 2)
                ->where('registros.0.email', 'general@example.com')
                ->where('registros.0.catalogo', 'Catálogo general')
                ->where('registros.1.email', 'temporada@example.com')
                ->where('registros.1.catalogo', 'Catálogo de temporada'));

        $pdf = $this->actingAs($user)->get(route('dashboard.catalogos.pdf'));

        $pdf->assertOk();
        $pdf->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString(
            'correos-descarga-catalogos.pdf',
            (string) $pdf->headers->get('content-disposition'),
        );
        $this->assertStringStartsWith('%PDF', $pdf->getContent());
    }

    public function test_dashboard_lists_newsletter_emails_and_exports_pdf(): void
    {
        $user = User::factory()->create();

        $antiguo = NewsletterSubscriber::create([
            'email' => 'antiguo@example.com',
        ]);
        $antiguo->forceFill(['created_at' => now()->subDay()])->save();

        NewsletterSubscriber::create([
            'email' => 'reciente@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.newsletter'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard/Correos')
                ->where('titulo', 'Newsletter')
                ->has('registros', 2)
                ->where('registros.0.email', 'reciente@example.com')
                ->where('registros.1.email', 'antiguo@example.com')
                ->missing('registros.0.catalogo'));

        $pdf = $this->actingAs($user)->get(route('dashboard.newsletter.pdf'));

        $pdf->assertOk();
        $pdf->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString(
            'correos-newsletter.pdf',
            (string) $pdf->headers->get('content-disposition'),
        );
        $this->assertStringStartsWith('%PDF', $pdf->getContent());
    }
}
