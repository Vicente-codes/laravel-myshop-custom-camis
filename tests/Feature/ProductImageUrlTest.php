<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductImageUrlTest extends TestCase
{
    public function test_image_url_returns_null_when_image_is_empty(): void
    {
        $product = new Product(['image' => null]);
        $this->assertNull($product->image_url);

        $product->image = '';
        $this->assertNull($product->image_url);
    }

    public function test_image_url_returns_external_url_unchanged(): void
    {
        $product = new Product(['image' => 'https://cdn.example.com/camiseta.jpg']);
        $this->assertSame('https://cdn.example.com/camiseta.jpg', $product->image_url);
    }

    public function test_image_url_returns_storage_url_for_products_prefix(): void
    {
        $product = new Product(['image' => 'products/camiseta.jpg']);
        $this->assertSame(asset('storage/products/camiseta.jpg'), $product->image_url);
    }

    public function test_image_url_returns_images_url_for_other_paths(): void
    {
        $product = new Product(['image' => 'catalogo/camiseta-basica-blanca.webp']);
        $this->assertSame(asset('images/catalogo/camiseta-basica-blanca.webp'), $product->image_url);

        $product->image = 'camisetas-basicas.jpg';
        $this->assertSame(asset('images/camisetas-basicas.jpg'), $product->image_url);
    }
}
