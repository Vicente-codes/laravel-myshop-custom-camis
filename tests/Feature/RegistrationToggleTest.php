<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationToggleTest extends TestCase
{
    public function test_registration_is_disabled_when_configured(): void
    {
        config(['demo.registration_enabled' => false]);

        $this->get('/register')->assertNotFound();

        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();

        $this->get('/login')
            ->assertOk()
            ->assertDontSee('Not registered?');

        $this->get('/contact')
            ->assertOk()
            ->assertDontSee(route('register'), false);
    }

    public function test_registration_is_enabled_when_configured(): void
    {
        config(['demo.registration_enabled' => true]);

        $this->get('/register')->assertOk();

        $this->get('/login')
            ->assertOk()
            ->assertSee('Not registered?');

        $this->get('/contact')
            ->assertOk()
            ->assertSee(route('register'), false);
    }
}
