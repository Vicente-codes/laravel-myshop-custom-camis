<?php

namespace Tests\Feature;

use Tests\TestCase;

class BrandAssetsTest extends TestCase
{
    public function test_contact_page_uses_public_brand_assets(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk();
        $response->assertSee(asset('images/cc5c.png'), false);
        $response->assertSee(asset('images/ccfav.png'), false);
    }

    public function test_login_page_uses_guest_brand_assets(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee(asset('images/cc5b.png'), false);
        $response->assertSee(asset('images/ccfav.png'), false);
    }

    public function test_brand_asset_files_exist(): void
    {
        $this->assertFileExists(public_path('images/cc5c.png'));
        $this->assertFileExists(public_path('images/cc5b.png'));
        $this->assertFileExists(public_path('images/ccfav.png'));
    }
}
