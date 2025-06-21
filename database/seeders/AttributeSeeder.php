<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar atributo Cor
        $colorAttribute = Attribute::create([
            'name' => 'Cor',
            'slug' => Str::slug('Cor'),
        ]);

        $colors = ['Preto', 'Azul', 'Vermelho', 'Verde', 'Rosa', 'Roxo', 'Laranja', 'Amarelo'];
        foreach ($colors as $color) {
            AttributeValue::create([
                'attribute_id' => $colorAttribute->id,
                'value' => $color,
            ]);
        }

        // Criar atributo Tamanho
        $sizeAttribute = Attribute::create([
            'name' => 'Tamanho',
            'slug' => Str::slug('Tamanho'),
        ]);

        $sizes = ['P', 'M', 'G', 'GG'];
        foreach ($sizes as $size) {
            AttributeValue::create([
                'attribute_id' => $sizeAttribute->id,
                'value' => $size,
            ]);
        }
    }
}
