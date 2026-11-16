<?php

namespace Tests\Feature;

use Tests\TestCase;

class NoindexTest extends TestCase
{
    public function test_noindex_header_and_meta_are_added_when_enabled(): void
    {
        config(['demo.noindex' => true]);

        $login = $this->get('/login');
        $login->assertOk();
        $login->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $login->assertSee('<meta name="robots" content="noindex, nofollow">', false);

        $contact = $this->get('/contact');
        $contact->assertOk();
        $contact->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $contact->assertSee('<meta name="robots" content="noindex, nofollow">', false);
    }

    public function test_noindex_header_and_meta_are_absent_when_disabled(): void
    {
        config(['demo.noindex' => false]);

        $login = $this->get('/login');
        $login->assertOk();
        $login->assertHeaderMissing('X-Robots-Tag');
        $login->assertDontSee('name="robots"', false);

        $contact = $this->get('/contact');
        $contact->assertOk();
        $contact->assertHeaderMissing('X-Robots-Tag');
        $contact->assertDontSee('name="robots"', false);
    }
}
