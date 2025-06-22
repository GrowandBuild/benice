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
        $colorAttribute = Attribute::updateOrCreate(
            ['slug' => Str::slug('Cor')],
            ['name' => 'Cor']
        );

        $colors = ['Preto', 'Azul', 'Vermelho', 'Verde', 'Rosa', 'Roxo', 'Laranja', 'Amarelo'];
        foreach ($colors as $color) {
            AttributeValue::updateOrCreate(
                [
                    'attribute_id' => $colorAttribute->id,
                    'value' => $color
                ],
                [
                    'attribute_id' => $colorAttribute->id,
                    'value' => $color
                ]
            );
        }

        // Criar atributo Tamanho
        $sizeAttribute = Attribute::updateOrCreate(
            ['slug' => Str::slug('Tamanho')],
            ['name' => 'Tamanho']
        );

        $sizes = ['P', 'M', 'G', 'GG'];
        foreach ($sizes as $size) {
            AttributeValue::updateOrCreate(
                [
                    'attribute_id' => $sizeAttribute->id,
                    'value' => $size
                ],
                [
                    'attribute_id' => $sizeAttribute->id,
                    'value' => $size
                ]
            );
        }
    }
}
