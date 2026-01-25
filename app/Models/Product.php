<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * MODELO: Product
     * Representa un producto de la tienda.
     * Relacionado con la tabla 'products'.
     */

    /**
     * CAMPOS ASIGNABLES
     * Campos permitidos para asignación masiva.
     */
    protected $fillable = [
        'name',
        'description',
        'image',   // Añadido desde la nueva propuesta
        'price',
        'sizes',   // Añadido tamaños
        'category_id',
        'offer_id',
    ];

    /**
     * CONVERSIÓN DE TIPOS
     * Convierte price a decimal con 2 decimales y sizes a array.
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2', // Convierte el campo price en un decimal con 2 decimales al leerlo o guardarlo.
            'sizes' => 'array',
            // Convierte automáticamente el JSON almacenado en la BD en un array de PHP. 
            // Ejemplo: ["S","M","L"] en la BD → ['S','M','L'] en PHP. 
            // Al guardar, Laravel convierte el array de vuelta a JSON sin que tengas que hacerlo manualmente.
        ];
    }

    /**
    * ACCESSOR: final_price
    * Calcula el precio final aplicando descuento si existe oferta y se cumplen las condiciones.
    * Permite acceder a $product->final_price como si fuera un atributo normal del modelo.
    */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            // Definimos la lógica del "get", es decir, qué pasa cuando leemos $product->final_price
            get: function () {
                // 1. Comprobamos si el producto tiene una oferta asociada 
                // y si el porcentaje de descuento es mayor que 0.
                if ($this->offer && $this->offer->discount_percentage > 0) {

                    // 2. Determinar la cantidad del producto que se está considerando. 
                    // - Usamos $this->quantity si ha sido inyectado (por ejemplo, desde el CartController). 
                    // - Si no existe, asumimos 1 por defecto.
                    $quantity = $this->quantity ?? 1;

                    // 3. Obtener la cantidad mínima necesaria para que se aplique la oferta. 
                    // - Si la oferta no define min_quantity, asumimos 1 como mínimo.
                    $minQuantity = $this->offer->min_quantity ?? 1;

                    // 4. Comprobar si la cantidad del producto cumple el mínimo requerido por la oferta.
                    if ($quantity >= $minQuantity) {
                        $discount = $this->price * ($this->offer->discount_percentage / 100);// 5. Calcular el importe del descuento:
                        return round($this->price - $discount, 2);// 6. Devolver el precio final redondeado a 2 decimales
                    }
                }
                // 7. Si no hay oferta, el descuento es 0 o no se cumple el mínimo de cantidad, 
                // devolvemos el precio original sin modificar.
                return $this->price;
            },
        );
    }

    /**
     * RELACIÓN: Un producto pertenece a UNA categoría.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * RELACIÓN: Un producto puede tener UNA oferta o ninguna.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * RELACIÓN: Un producto puede estar en MUCHOS carritos.
     * Tabla pivot con cantidad y timestamps.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
