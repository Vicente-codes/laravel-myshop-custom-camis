<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * MODELO: Product
     * 
     * El modelo más importante de la tienda.
     * Representa un producto con todos sus detalles.
     * Corresponde a la tabla 'products' en la base de datos.
     * Migración relacionada: database/migrations/*_create_products_table.php
     */

    /**
     * CAMPOS ASIGNABLES
     * 
     * Campos que pueden ser asignados masivamente:
     * - name: Nombre del producto
     * - description: Descripción detallada
     * - price: Precio en euros
     * - category_id: Categoría a la que pertenece
     * - offer_id: Oferta aplicada (puede ser null)
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'offer_id',
    ];

    /**
     * CONVERSIÓN DE TIPOS
     * 
     * El campo price se almacena en la BD como DECIMAL(8,2).
     * Estos casts lo convierten automáticamente a float en PHP.
     * 
     * Sin casts: price sería string "19.99"
     * Con casts: price es float 19.99 (se puede hacer matemáticas)
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * RELACIÓN: Un producto pertenece a UNA categoría
     * 
     * Tipo de relación: BelongsTo (Inversa de HasMany)
     * 
     * Métodos disponibles:
     * - $product->category = Obtiene la categoría
     * - $product->category->name = Obtiene el nombre de la categoría
     * 
     * El campo category_id en la tabla products referencia la tabla categories
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RELACIÓN: Un producto puede tener UNA oferta O NINGUNA
     * 
     * Tipo de relación: BelongsTo (Inversa de HasMany)
     * Nota: Esta relación es NULLABLE (offer_id puede ser NULL)
     * 
     * Métodos disponibles:
     * - $product->offer = Obtiene la oferta (o NULL si no tiene)
     * - $product->offer->discount_percentage = Obtiene el porcentaje
     * - if ($product->offer) { ... } = Verificar si tiene oferta
     * 
     * El campo offer_id en la tabla products referencia la tabla offers
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * RELACIÓN: Un producto puede estar en MUCHOS carritos
     * 
     * Tipo de relación: Many-to-Many (N:M) a través de tabla pivot
     * 
     * Métodos disponibles:
     * - $product->users = Obtiene los usuarios que tienen este producto
     * - $product->users()->count() = Cantidad de usuarios
     * 
     * La tabla product_user es la tabla pivot que conecta productos y usuarios
     * withPivot('quantity') expone la cantidad de la tabla pivot
     * withTimestamps() expone los timestamps (cuándo se añadió)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * ACCESSOR: final_price
     * 
     * Un accessor calcula un valor derivado automáticamente.
     * NO se almacena en la base de datos, se calcula cada vez que se accede.
     * 
     * ¿Por qué es importante?
     * - En PUD2 calculabas el precio con descuento EN LAS VISTAS (¡malo!)
     * - En P3 lo calculamos UNA VEZ en el modelo (¡bien!)
     * - Las vistas solo muestran el resultado
     * 
     * Uso:
     * - $product->final_price = Obtiene el precio final con descuento aplicado
     * 
     * Lógica:
     * 1. Si el producto tiene oferta (offer !== null):
     *    - Calcula: descuento = precio * (porcentaje / 100)
     *    - Retorna: precio - descuento
     * 2. Si NO tiene oferta:
     *    - Retorna: precio original
     * 
     * Ejemplo:
     * - Producto: precio = 100€, oferta = 20%
     * - Descuento = 100 * (20 / 100) = 20€
     * - final_price = 100 - 20 = 80€
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Si el producto tiene oferta, aplicar descuento
                if ($this->offer && $this->offer->discount_percentage > 0) {
                    // Calcular el monto del descuento
                    $discount = $this->price * ($this->offer->discount_percentage / 100);
                    
                    // Retornar el precio final redondeado a 2 decimales
                    return round($this->price - $discount, 2);
                }
                
                // Si no tiene oferta, retornar el precio original
                return $this->price;
            }
        );
    }
}
