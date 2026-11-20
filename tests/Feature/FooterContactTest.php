<?php

namespace Tests\Feature;

use Tests\TestCase;

class FooterContactTest extends TestCase
{
    public function test_footer_uses_example_contact_email_and_hides_invented_domain(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk();
        $response->assertSee('contacto@example.com');
        $response->assertDontSee('customcamis.com');
    }
}
