<?php

namespace Tests\Feature;

use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Ana Pérez',
            'email' => 'ana@example.com',
            'phone' => '5512345678',
            'company' => 'Globos del Centro',
            'state' => 'Puebla',
            'message' => 'Quiero información de mayoreo y envíos a todo México.',
        ], $overrides);
    }

    public function test_contact_message_is_stored_and_notifies_globos_mail_send(): void
    {
        Mail::fake();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $this->from(route('home'))
            ->post(route('contacto.store'), $this->payload())
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', '¡Gracias por registrarte! Recibimos tu mensaje y nos pondremos en contacto.');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'ana@example.com',
            'name' => 'Ana Pérez',
        ]);

        Mail::assertSent(ContactMessageMail::class, function (ContactMessageMail $mail) {
            return $mail->contactMessage->email === 'ana@example.com'
                && $mail->hasTo('destino@example.com');
        });
    }

    public function test_contact_form_rejects_duplicate_email(): void
    {
        Mail::fake();
        $this->withoutMiddleware(ValidateCsrfToken::class);

        ContactMessage::create($this->payload());

        $this->from(route('home'))
            ->post(route('contacto.store'), $this->payload([
                'name' => 'Ana Otra',
                'message' => 'Segundo intento con el mismo correo.',
            ]))
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors([
                'email' => 'Este correo electrónico ya está registrado.',
            ]);

        $this->assertSame(1, ContactMessage::query()->count());
        Mail::assertNothingSent();
    }
}
