<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\ContactFormMail;

class ContactFormTest extends TestCase
{
    public function test_contact_page_is_accessible()
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Contacta con Nosotros');
    }

    public function test_contact_form_validation()
    {
        $response = $this->post(route('contact.store'), []);
        
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_sends_email_and_redirects()
    {
        Mail::fake();

        $data = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'subject' => 'General',
            'message' => 'Este es un mensaje de prueba con más de 10 caracteres.',
        ];

        $response = $this->post(route('contact.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(ContactFormMail::class, function ($mail) use ($data) {
            return $mail->hasTo('admin@customcamis.com') &&
                   $mail->data['name'] === $data['name'] &&
                   $mail->data['message'] === $data['message'];
        });
    }
}
