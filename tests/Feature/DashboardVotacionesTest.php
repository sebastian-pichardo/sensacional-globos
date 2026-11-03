<?php

namespace Tests\Feature;

use App\Models\Promocion;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardVotacionesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_see_voting_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_dashboard_shows_empty_voting_board(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('votaciones.boletas', 0)
                ->where('votaciones.lider', null)
                ->has('votaciones.participantes', 4)
                ->where('votaciones.participantes.0.puntos', 0)
                ->has('votaciones.correos', 0));
    }

    public function test_dashboard_ranks_participants_by_points_and_first_place(): void
    {
        $user = User::factory()->create();

        $this->registrarBoleta(
            'descartada@example.com',
            'arco_halloween',
            'monstruo_frankie',
            'hola_frankie',
            now()->subDays(2),
        );
        Promocion::query()->where('email', 'descartada@example.com')->delete();

        $this->registrarBoleta(
            'luis@example.com',
            'los_villanos',
            'monstruo_frankie',
            'hola_frankie',
            now()->subHours(2),
        );
        $this->registrarBoleta(
            'ana@example.com',
            'los_villanos',
            'hola_frankie',
            'arco_halloween',
            now()->subHour(),
        );
        $this->registrarBoleta(
            'sofia@example.com',
            'hola_frankie',
            'arco_halloween',
            'monstruo_frankie',
            now(),
        );

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('votaciones.boletas', 3)
                ->where('votaciones.lider', 'Los villanos')
                ->where('votaciones.participantes.0.clave', 'los_villanos')
                ->where('votaciones.participantes.0.primero', 2)
                ->where('votaciones.participantes.0.puntos', 6)
                ->where('votaciones.participantes.0.posicion', 1)
                ->where('votaciones.participantes.1.clave', 'hola_frankie')
                ->where('votaciones.participantes.1.primero', 1)
                ->where('votaciones.participantes.1.segundo', 1)
                ->where('votaciones.participantes.1.tercero', 1)
                ->where('votaciones.participantes.1.puntos', 6)
                ->where('votaciones.participantes.2.clave', 'arco_halloween')
                ->where('votaciones.participantes.2.puntos', 3)
                ->where('votaciones.participantes.3.clave', 'monstruo_frankie')
                ->where('votaciones.participantes.3.puntos', 3)
                ->where('votaciones.participantes.3.posicion', 3)
                ->has('votaciones.correos', 3)
                ->where('votaciones.correos.0.email', 'sofia@example.com')
                ->where('votaciones.correos.0.primero', 'Hola frankie')
                ->where('votaciones.correos.1.email', 'ana@example.com')
                ->where('votaciones.correos.2.email', 'luis@example.com')
                ->where('votaciones.correos.2.primero', 'Los villanos'));
    }

    public function test_guest_cannot_delete_votes(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->delete(route('dashboard.votaciones.destroy'), [
            'email' => 'ana@example.com',
        ])->assertRedirect(route('login'));

        $this->delete(route('dashboard.votaciones.destroy-all'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_delete_one_ballot(): void
    {
        $user = User::factory()->create();

        $this->registrarBoleta(
            'ana@example.com',
            'los_villanos',
            'hola_frankie',
            'arco_halloween',
            now()->subHour(),
        );
        $this->registrarBoleta(
            'sofia@example.com',
            'hola_frankie',
            'arco_halloween',
            'monstruo_frankie',
            now(),
        );

        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->actingAs($user)
            ->from(route('dashboard'))
            ->delete(route('dashboard.votaciones.destroy'), [
                'email' => 'ANA@example.com',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('promociones', [
            'email' => 'ana@example.com',
            'lugar' => 'primero',
        ]);
        $this->assertDatabaseHas('promociones', [
            'email' => 'sofia@example.com',
            'deleted_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertInertia(fn (Assert $page) => $page
                ->where('votaciones.boletas', 1)
                ->where('votaciones.lider', 'Hola frankie')
                ->has('votaciones.correos', 1)
                ->where('votaciones.correos.0.email', 'sofia@example.com'));
    }

    public function test_authenticated_user_can_delete_every_ballot(): void
    {
        $user = User::factory()->create();

        $this->registrarBoleta(
            'ana@example.com',
            'los_villanos',
            'hola_frankie',
            'arco_halloween',
            now(),
        );

        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->actingAs($user)
            ->from(route('dashboard'))
            ->delete(route('dashboard.votaciones.destroy-all'))
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success');

        $this->assertSame(0, Promocion::query()->count());
        $this->assertSame(3, Promocion::withTrashed()->count());
    }

    public function test_deleting_an_unknown_email_does_not_remove_votes(): void
    {
        $user = User::factory()->create();

        $this->registrarBoleta(
            'ana@example.com',
            'los_villanos',
            'hola_frankie',
            'arco_halloween',
            now(),
        );

        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->actingAs($user)
            ->from(route('dashboard'))
            ->delete(route('dashboard.votaciones.destroy'), [
                'email' => 'nadie@example.com',
            ])
            ->assertRedirect(route('dashboard'))
            ->assertSessionHasErrors('votaciones');

        $this->assertSame(3, Promocion::query()->count());
    }

    private function registrarBoleta(
        string $email,
        string $primero,
        string $segundo,
        string $tercero,
        Carbon $cuando,
    ): void {
        foreach ([
            'primero' => $primero,
            'segundo' => $segundo,
            'tercero' => $tercero,
        ] as $lugar => $participante) {
            Promocion::query()->create([
                'email' => $email,
                'participante' => $participante,
                'lugar' => $lugar,
            ]);
        }

        Promocion::query()->where('email', $email)->update([
            'created_at' => $cuando,
            'updated_at' => $cuando,
        ]);
    }
}
