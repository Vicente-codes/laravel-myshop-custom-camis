<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DemoSeedDataTest extends TestCase
{
    use RefreshDatabase;

    private function seedDemoData(): void
    {
        $this->app['env'] = 'production';
        config([
            'demo.allow_seed' => true,
            'demo.admin_password' => str_repeat('a', 16),
            'demo.customer_password' => str_repeat('b', 16),
        ]);

        $exitCode = $this->artisan('db:seed', ['--force' => true])->run();

        $this->assertSame(0, $exitCode);
    }

    public function test_demo_seeding_populates_sizes_offers_and_catalog_images(): void
    {
        $this->seedDemoData();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('offers', 5);
        $this->assertDatabaseCount('products', 12);

        $this->assertSame(100, Offer::findOrFail(1)->min_quantity);

        foreach ([2, 3, 4, 5] as $offerId) {
            $this->assertSame(1, Offer::findOrFail($offerId)->min_quantity);
        }

        foreach (Product::all() as $product) {
            $this->assertSame(['S', 'M', 'L', 'XL'], $product->sizes);
            $this->assertStringStartsWith('catalogo/', $product->image);
            $this->assertFileExists(public_path('images/'.$product->image));
        }
    }

    public function test_final_price_applies_volume_offer_from_minimum_quantity(): void
    {
        $this->seedDemoData();

        $product = Product::where('offer_id', 1)->orderBy('id')->firstOrFail();
        $price = (float) $product->price;

        $this->assertEquals(20, $product->offer->discount_percentage);

        $product->quantity = 1;
        $this->assertEquals($price, $product->final_price);

        $product->quantity = 99;
        $this->assertEquals($price, $product->final_price);

        $product->quantity = 100;
        $this->assertEquals(round($price * 0.8, 2), $product->final_price);
    }

    public function test_demo_seeding_twice_does_not_duplicate_records(): void
    {
        $this->seedDemoData();
        $productUserCount = DB::table('product_user')->count();

        $this->assertGreaterThan(0, $productUserCount);

        $this->seedDemoData();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('offers', 5);
        $this->assertDatabaseCount('products', 12);
        $this->assertDatabaseCount('product_user', $productUserCount);
    }
}
