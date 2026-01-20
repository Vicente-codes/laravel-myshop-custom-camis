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
     * Convierte price a decimal con 2 decimales.
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sizes' => 'array',
        ];
    }

    /**
     * ACCESSOR: final_price
     * Calcula el precio final aplicando descuento si existe oferta.
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->offer && $this->offer->discount_percentage > 0) {
                    // Verificamos si la cantidad del producto cumple el mínimo de la oferta
                    // Usamos $this->quantity (inyectado por CartController) o 1 por defecto
                    $quantity = $this->quantity ?? 1;
                    $minQuantity = $this->offer->min_quantity ?? 1;

                    if ($quantity >= $minQuantity) {
                        $discount = $this->price * ($this->offer->discount_percentage / 100);
                        return round($this->price - $discount, 2);
                    }
                }
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
