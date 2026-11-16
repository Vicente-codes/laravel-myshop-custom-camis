<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactThrottleTest extends TestCase
{
    public function test_contact_form_is_limited_to_ten_requests_per_minute_per_ip(): void
    {
        Mail::fake();

        $data = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'subject' => 'General',
            'message' => 'Este es un mensaje de prueba con más de 10 caracteres.',
        ];

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('contact.store'), $data)->assertRedirect();
        }

        $this->post(route('contact.store'), $data)->assertStatus(429);

        $this->withServerVariables(['REMOTE_ADDR' => '10.10.10.10'])
            ->post(route('contact.store'), $data)
            ->assertRedirect();
    }
}
