<?php

namespace Tests\Feature;

use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactValidationTest extends TestCase
{
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'subject' => 'General',
            'message' => 'Este es un mensaje de prueba con más de 10 caracteres.',
        ], $overrides);
    }

    public function test_subject_outside_the_allowed_list_is_rejected(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), $this->validData([
            'subject' => 'Asunto inventado',
        ]));

        $response->assertSessionHasErrors('subject');
        Mail::assertNothingSent();
    }

    public function test_all_allowed_subjects_are_accepted(): void
    {
        Mail::fake();

        foreach (['General', 'Pedido', 'Diseño', 'Soporte'] as $subject) {
            $response = $this->post(route('contact.store'), $this->validData([
                'subject' => $subject,
            ]));

            $response->assertRedirect();
            $response->assertSessionHas('success');
        }

        Mail::assertSent(ContactFormMail::class, 4);
    }

    public function test_message_longer_than_2000_characters_is_rejected(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), $this->validData([
            'message' => str_repeat('a', 2001),
        ]));

        $response->assertSessionHasErrors('message');
        Mail::assertNothingSent();
    }

    public function test_message_of_2000_characters_is_accepted(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), $this->validData([
            'message' => str_repeat('a', 2000),
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        Mail::assertSent(ContactFormMail::class);
    }

    public function test_email_is_sent_to_configured_recipient(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), $this->validData())
            ->assertRedirect()
            ->assertSessionHas('success');

        Mail::assertSent(ContactFormMail::class, function (ContactFormMail $mail) {
            return $mail->hasTo(config('demo.contact_recipient'));
        });
    }

    public function test_contact_recipient_defaults_to_example_address(): void
    {
        $this->assertSame('contacto@example.com', config('demo.contact_recipient'));
    }
}
