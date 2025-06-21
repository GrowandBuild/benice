<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('dashboard.products.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'variations' => 'sometimes|array',
            'variations.*.sku' => 'nullable|string|max:255|unique:product_variants,sku',
            'variations.*.price' => 'required|numeric|min:0',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variations.*.attribute_values' => 'required|array',
        ]);
        
        // Criar o produto principal
        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'price' => 0, 
            'stock' => 0, 
        ]);

        // Processar variações
        if (isset($validated['variations'])) {
            foreach ($validated['variations'] as $variationData) {
                $imagePath = null;
                if (isset($variationData['image']) && $variationData['image']->isValid()) {
                    $imagePath = $variationData['image']->store('product-variants', 'public');
                }

                $variant = $product->variants()->create([
                    'sku' => $variationData['sku'],
                    'price' => $variationData['price'],
                    'stock' => $variationData['stock'],
                    'image' => $imagePath,
                ]);

                $variant->attributeValues()->attach($variationData['attribute_values']);
            }
        }

        return redirect()->route('dashboard.products.index')->with('success', 'Produto criado com sucesso! ✨');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'category', 
            'variants.attributeValues.attribute',
            'variants.product' 
        ]);

        $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'image_url' => $variant->image_url, 
                'options' => $variant->attributeValues->pluck('id', 'attribute_id')->toArray(),
            ];
        });

        $attributes = $product->variants
            ->pluck('attributeValues')
            ->flatten()
            ->unique('id')
            ->groupBy('attribute_id')
            ->map(function ($values) {
                $attribute = $values->first()->attribute;
                
                $colorMap = [
                    'preto' => '#000000', 'branco' => '#FFFFFF', 'cinza' => '#808080',
                    'vermelho' => '#FF0000', 'azul' => '#0000FF', 'verde' => '#008000',
                    'amarelo' => '#FFFF00', 'laranja' => '#FFA500', 'roxo' => '#800080',
                    'rosa' => '#FFC0CB', 'marrom' => '#A52A2A', 'dourado' => '#FFD700',
                    'prata' => '#C0C0C0'
                ];

                return [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'values' => $values->map(function ($value) use ($attribute, $colorMap) {
                        $colorValue = strtolower($value->value);
                        $isColorAttr = strtolower($attribute->name) === 'cor';

                        return [
                            'id' => $value->id,
                            'name' => $isColorAttr ? ($colorMap[$colorValue] ?? $colorValue) : $value->value,
                        ];
                    })->values()->all(),
                ];
            })
            ->values();
        
        return view('products.show', compact('product', 'variants', 'attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        $product->load(['variants.attributeValues.attribute']);

        return view('dashboard.products.edit', compact('product', 'categories', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'variations' => 'sometimes|array',
            'variations.*.id' => 'nullable|exists:product_variants,id',
            'variations.*.price' => 'required|numeric|min:0',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variations.*.attribute_values' => 'required|array',
        ];

        if ($request->has('variations')) {
            foreach ($request->input('variations') as $index => $variation) {
                $variantId = $variation['id'] ?? 'NULL';
                $rules["variations.{$index}.sku"] = 'nullable|string|max:255|unique:product_variants,sku,' . $variantId . ',id';
            }
        }

        $validated = $request->validate($rules);

        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);

        $incomingVariantIds = [];

        if (isset($validated['variations'])) {
            foreach ($validated['variations'] as $variationData) {
                $variantId = $variationData['id'] ?? null;
                
                $dataToUpdate = [
                    'sku' => $variationData['sku'],
                    'price' => $variationData['price'],
                    'stock' => $variationData['stock'],
                ];

                if (isset($variationData['image']) && $variationData['image']->isValid()) {
                    $dataToUpdate['image'] = $variationData['image']->store('product-variants', 'public');
                }

                $variant = $product->variants()->updateOrCreate(['id' => $variantId], $dataToUpdate);
                
                $variant->attributeValues()->sync($variationData['attribute_values']);

                $incomingVariantIds[] = $variant->id;
            }
        }

        // Deletar variações que foram removidas
        $product->variants()->whereNotIn('id', $incomingVariantIds)->delete();

        return redirect()->route('dashboard.products.edit', $product)->with('success', 'Produto e variações atualizados com sucesso! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('success', 'Produto removido com sucesso!');
    }
}
