<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    /**
     * MODELO: Offer
     * 
     * Representa una oferta especial con descuento.
     * Corresponde a la tabla 'offers' en la base de datos.
     * Migración relacionada: database/migrations/*_create_offers_table.php
     */

    /**
     * CAMPOS ASIGNABLES
     * 
     * Campos que pueden ser asignados masivamente:
     * - name: Nombre de la oferta (ej: "Descuento por Volumen")
     * - slug: URL-friendly (ej: "descuento-volumen")
     * - discount_percentage: Porcentaje (ej: 20)
     * - description: Descripción de la oferta
     */
    protected $fillable = [
        'name',
        'slug',
        'discount_percentage',
        'description',
        'min_quantity',
    ];

    /**
     * RELACIÓN: Una oferta se aplica a MUCHOS productos
     * 
     * Tipo de relación: HasMany (1:N)
     * 
     * Métodos disponibles:
     * - $offer->products = Obtiene todos los productos con esta oferta
     * - $offer->products()->count() = Cantidad de productos
     * - $offer->products()->update(['discount_percentage' => 25]) = Cambiar descuento
     * 
     * En la tabla products hay un campo offer_id que referencia esta oferta.
     * IMPORTANTE: Un producto puede tener como máximo UNA oferta.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
