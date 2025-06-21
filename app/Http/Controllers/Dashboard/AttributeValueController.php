<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attribute_values')->where(function ($query) use ($attribute) {
                    return $query->where('attribute_id', $attribute->id);
                }),
            ],
        ]);

        $attribute->values()->create([
            'value' => $validated['value'],
            'slug' => Str::slug($validated['value']),
        ]);

        return back()->with('success', 'Valor adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute, AttributeValue $value)
    {
        // Certificar que o valor pertence ao atributo, por segurança
        if ($value->attribute_id !== $attribute->id) {
            return back()->with('error', 'Operação não permitida.');
        }

        $value->delete();

        return back()->with('success', 'Valor removido com sucesso!');
    }
}
