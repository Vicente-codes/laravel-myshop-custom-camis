<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class CartSizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_add_same_product_with_different_sizes()
    {
        // 1. Crear producto con tallas manualmente
        $category = Category::create(['name' => 'Camisetas', 'slug' => 'camisetas']);
        
        $product = new Product();
        $product->name = 'Camiseta Test';
        $product->description = 'Desc';
        $product->price = 10.00;
        $product->category_id = $category->id;
        $product->sizes = ['S', 'M', 'L'];
        $product->image = 'test.jpg';
        $product->save();

        // 2. Añadir Talla M
        $this->post(route('cart.store'), [
            'product_id' => $product->id,
            'size' => 'M'
        ])->assertRedirect(); 

        // 3. Añadir Talla L
        $this->post(route('cart.store'), [
            'product_id' => $product->id,
            'size' => 'L'
        ])->assertRedirect();

        // 4. Verificar sesión
        $cart = session('cart');
        
        $this->assertCount(2, $cart, 'El carrito debería tener 2 items (M y L)');
        $this->assertTrue(isset($cart[$product->id . '_M']));
        $this->assertTrue(isset($cart[$product->id . '_L']));
        $this->assertEquals('M', $cart[$product->id . '_M']['size']);
        $this->assertEquals('L', $cart[$product->id . '_L']['size']);
    }

    public function test_cart_index_displays_sizes()
    {
        // 1. Crear producto manual
        $category = Category::create(['name' => 'Camisetas 2', 'slug' => 'camisetas-2']);
        
        $product = new Product();
        $product->name = 'Camiseta Test 2';
        $product->description = 'Desc';
        $product->price = 20.00;
        $product->category_id = $category->id;
        $product->sizes = ['S', 'M', 'L', 'XL'];
        $product->image = 'test.jpg';
        $product->save();

        // 2. Simular carrito con tallas
        $cart = [
            $product->id . '_XL' => [
                'product_id' => $product->id,
                'quantity' => 1,
                'size' => 'XL'
            ]
        ];
        session()->put('cart', $cart);

        // 3. Visitar carrito
        $response = $this->get(route('cart.index'));
        
        $response->assertStatus(200);
        $response->assertSee('XL'); // Verificar que se muestra la talla
    }
}
