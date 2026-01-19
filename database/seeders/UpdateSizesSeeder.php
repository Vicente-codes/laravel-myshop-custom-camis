<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignamos las tallas estándar a TODOS los productos
        $sizes = json_encode(['S', 'M', 'L', 'XL']);
        
        DB::table('products')->update([
            'sizes' => $sizes
        ]);

        $this->command->info('Todas los productos han sido actualizados con tallas S, M, L, XL.');
    }
}
