<?php

namespace Tests\Feature;

use App\Models\DecoratorApplication;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InspiratePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_inspirate_page_is_rendered(): void
    {
        $this->get(route('inspirate'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Inspirate'));
    }

    public function test_decorator_application_can_be_stored(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $payload = [
            'name' => 'Ana Decoradora',
            'whatsapp' => '5512345678',
            'email' => 'ana@example.com',
            'motivation' => 'Me apasiona crear instalaciones con globos que sorprendan a todos.',
            'social_networks' => '@anadecora',
            'city_or_state' => 'Jalisco',
            'accept_promotions' => true,
        ];

        $this->post(route('inspirate.store'), $payload)
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('decorator_applications', [
            'email' => 'ana@example.com',
            'name' => 'Ana Decoradora',
            'accept_promotions' => 1,
        ]);

        $this->assertSame(1, DecoratorApplication::query()->count());
    }

    public function test_decorator_application_requires_core_fields(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->from(route('inspirate'))
            ->post(route('inspirate.store'), [])
            ->assertRedirect(route('inspirate'))
            ->assertSessionHasErrors(['name', 'whatsapp', 'email', 'motivation', 'city_or_state']);
    }
}
