<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            // 1. Eliminar claves foráneas para evitar conflictos de índices
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);

            // 2. Eliminar la clave primaria actual (product_id, user_id)
            $table->dropPrimary();

            // 3. Añadir la columna 'size'
            $table->string('size')->default('M')->after('user_id');

            // 4. Añadir la nueva clave primaria compuesta
            $table->primary(['product_id', 'user_id', 'size']);

            // 5. Restaurar claves foráneas
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            // 1. Eliminar la nueva clave primaria
            $table->dropPrimary();

            // 2. Eliminar la columna 'size'
            $table->dropColumn('size');

            // 3. Restaurar la clave primaria original
            $table->primary(['product_id', 'user_id']);
        });
    }
};
