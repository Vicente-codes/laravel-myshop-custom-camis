<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class DemoSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_production_seeding_is_skipped_without_allow_demo_seed(): void
    {
        $this->app['env'] = 'production';
        config(['demo.allow_seed' => false]);

        $exitCode = $this->artisan('db:seed', ['--force' => true])->run();

        $this->assertSame(0, $exitCode);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('categories', 0);
        $this->assertDatabaseCount('offers', 0);
        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('product_user', 0);
    }

    public function test_production_demo_seeding_aborts_with_short_passwords(): void
    {
        $this->app['env'] = 'production';
        config([
            'demo.allow_seed' => true,
            'demo.admin_password' => str_repeat('x', 11),
            'demo.customer_password' => str_repeat('y', 11),
        ]);

        $exception = null;

        try {
            $this->artisan('db:seed', ['--force' => true])->run();
        } catch (RuntimeException $caught) {
            $exception = $caught;
        }

        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertStringContainsString('DEMO_ADMIN_PASSWORD', $exception->getMessage());
        $this->assertStringContainsString('DEMO_CUSTOMER_PASSWORD', $exception->getMessage());
        $this->assertStringNotContainsString(str_repeat('x', 11), $exception->getMessage());
        $this->assertStringNotContainsString(str_repeat('y', 11), $exception->getMessage());

        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('categories', 0);
        $this->assertDatabaseCount('offers', 0);
        $this->assertDatabaseCount('products', 0);
        $this->assertDatabaseCount('product_user', 0);
    }
}
