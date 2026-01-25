<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SizeAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_sizes_are_auto_assigned_on_creation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Camisetas',
            'description' => 'Camisetas de prueba',
            'slug' => 'camisetas'
        ]);

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Camiseta Test Tallas',
            'description' => 'Descripción de prueba',
            'price' => 19.99,
            'category_id' => $category->id,
            'image' => null, // Opcional
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Camiseta Test Tallas',
        ]);

        $product = Product::where('name', 'Camiseta Test Tallas')->first();
        
        $this->assertNotNull($product->sizes);
        $this->assertEquals(['S', 'M', 'L', 'XL'], $product->sizes);
    }
}
