<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_shows_image_when_present()
    {
        // 1. Create a product with an image
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'image' => 'products/test-image.jpg',
            'name' => 'Test Product'
        ]);

        // 2. Visit the product detail page
        $response = $this->get(route('products.show', $product->id));

        // 3. Assert the image tag is present with correct src
        $response->assertStatus(200);
        $response->assertSee('storage/products/test-image.jpg');
        $response->assertSee('alt="Test Product"', false);
    }

    public function test_product_detail_shows_emoji_when_image_missing()
    {
        // 1. Create a product without an image
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'image' => null,
        ]);

        // 2. Visit the product detail page
        $response = $this->get(route('products.show', $product->id));

        // 3. Assert the emoji is present
        $response->assertStatus(200);
        $response->assertSee('👕');
        $response->assertDontSee('<img', false);
    }
}
