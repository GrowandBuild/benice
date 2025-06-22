<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desativa a checagem de chaves estrangeiras para permitir o truncate
        Schema::disableForeignKeyConstraints();

        // Limpa a tabela de produtos antes de popular
        Product::truncate();

        // Reativa a checagem de chaves estrangeiras
        Schema::enableForeignKeyConstraints();

        $categories = Category::all();

        $sampleImages = [
            'https://images.unsplash.com/photo-1571747239032-34c3e86bb5f7?q=80&w=1887&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1999&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=2070&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?q=80&w=1780&auto=format&fit=crop',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $name = 'Produto de Exemplo ' . $i;
            $slug = Str::slug($name);
            
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'description' => 'Esta é uma descrição de exemplo para o produto ' . $i . '. O produto é de alta qualidade e perfeito para suas necessidades.',
                    'price' => rand(20, 200) + (rand(0, 99) / 100), // Preço entre 20.00 e 200.99
                    'original_price' => rand(250, 400),
                    'stock' => rand(0, 100),
                    'category_id' => $categories->isNotEmpty() ? $categories->random()->id : null,
                    'image' => $sampleImages[array_rand($sampleImages)],
                ]
            );
        }
    }
}
