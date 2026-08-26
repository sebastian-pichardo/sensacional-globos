<?php

namespace Tests\Feature;

use App\Mail\NewsletterSubscriptionMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_newsletter_subscription_is_stored_and_notifies_globos_mail_send(): void
    {
        Mail::fake();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->from(route('home'))
            ->post(route('newsletter.store'), [
                'email' => 'Nuevo@Example.com',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', '¡Gracias por registrarte!');

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'nuevo@example.com',
        ]);

        Mail::assertSent(NewsletterSubscriptionMail::class, function (NewsletterSubscriptionMail $mail) {
            return $mail->subscriberEmail === 'nuevo@example.com'
                && $mail->hasTo('destino@example.com');
        });
    }

    public function test_newsletter_rejects_duplicate_email(): void
    {
        Mail::fake();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        NewsletterSubscriber::create([
            'email' => 'ya@example.com',
        ]);

        $this->from(route('home'))
            ->post(route('newsletter.store'), [
                'email' => 'ya@example.com',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors([
                'email' => 'Este correo electrónico ya está registrado.',
            ]);

        $this->assertSame(1, NewsletterSubscriber::query()->count());
        Mail::assertNothingSent();
    }
}
