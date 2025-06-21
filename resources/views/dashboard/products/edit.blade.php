@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-500 to-yellow-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-1 sm:mb-2">✏️ Editar Produto</h1>
                    <p class="text-amber-100 text-base sm:text-lg">Atualize as informações do produto</p>
                </div>
                <a href="{{ route('dashboard.products.index') }}" 
                   class="group self-start sm:self-center relative inline-flex items-center px-5 py-2 sm:px-6 sm:py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2">←</span>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 sm:px-8 py-5 sm:py-6 border-b border-amber-200">
                <h2 class="text-xl sm:text-2xl font-bold text-amber-800 truncate">📝 Editar: {{ $product->name }}</h2>
            </div>
            
            <form action="{{ route('dashboard.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <!-- Nome do Produto -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-base sm:text-lg font-semibold text-amber-800 mb-2 sm:mb-3">
                            <span class="mr-2">🏷️</span>Nome do Produto
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}"
                               class="w-full px-4 py-3 md:px-6 md:py-4 border-2 border-amber-200 rounded-xl md:rounded-2xl text-base sm:text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50"
                               placeholder="Digite o nome do produto">
                        @error('name')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-base sm:text-lg font-semibold text-amber-800 mb-2 sm:mb-3">
                            <span class="mr-2">📝</span>Descrição
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 md:px-6 md:py-4 border-2 border-amber-200 rounded-xl md:rounded-2xl text-base sm:text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50"
                                  placeholder="Descreva o produto...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria -->
                    <div>
                        <label for="category_id" class="block text-base sm:text-lg font-semibold text-amber-800 mb-2 sm:mb-3">
                            <span class="mr-2">📂</span>Categoria
                        </label>
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-4 py-3 md:px-6 md:py-4 border-2 border-amber-200 rounded-xl md:rounded-2xl text-base sm:text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sistema de Variações -->
                <div class="mt-12" x-data="productVariationsManager({
                        attributes: {{ json_encode($attributes) }},
                        initialVariations: {{ json_encode($product->variants->map(function($v) {
                            return [
                                'id' => $v->id,
                                'sku' => $v->sku,
                                'price' => $v->price,
                                'stock' => $v->stock,
                                'image_url' => $v->image_url,
                                'attribute_values' => $v->attributeValues->pluck('id', 'attribute_id')->toArray()
                            ];
                        })) }}
                    })">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 sm:px-8 py-5 sm:py-6 border-b border-amber-200 rounded-t-xl sm:rounded-t-2xl">
                        <h3 class="text-xl sm:text-2xl font-bold text-amber-800 flex items-center">
                            <span class="mr-3">🎨</span>Variações do Produto
                        </h3>
                        <p class="text-amber-700 mt-1 sm:mt-2 text-sm sm:text-base">Gerencie as diferentes versões do seu produto (cores, tamanhos, etc.)</p>
                    </div>

                    <div class="p-6 sm:p-8">
                        <!-- Seleção de Atributos -->
                        <div class="mb-8">
                            <h4 class="text-base sm:text-lg font-semibold text-amber-800 mb-4">📋 Selecionar Atributos para Variações</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                                @foreach($attributes as $attribute)
                                <div class="bg-white rounded-xl p-4 sm:p-6 border-2 border-amber-200 shadow-lg">
                                    <label class="flex items-center mb-4">
                                        <input type="checkbox" 
                                               x-model="selectedAttributes" 
                                               value="{{ $attribute->id }}"
                                               class="mr-3 w-5 h-5 text-amber-500 border-amber-300 rounded focus:ring-amber-500">
                                        <span class="font-semibold text-amber-800">{{ $attribute->name }}</span>
                                    </label>
                                    
                                    <div x-show="selectedAttributes.includes('{{ $attribute->id }}')" class="space-y-2">
                                        @foreach($attribute->values as $value)
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="selectedValues[{{ $attribute->id }}]" 
                                                   value="{{ $value->id }}"
                                                   class="mr-2 w-4 h-4 text-amber-500 border-amber-300 rounded focus:ring-amber-500">
                                            <span class="text-sm text-gray-700">{{ $value->value }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gerar Variações -->
                        <div class="mb-8" x-show="hasSelectedAttributes">
                            <button type="button" 
                                    @click="generateVariations()"
                                    class="px-6 py-3 sm:px-8 sm:py-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl text-base sm:text-lg">
                                ➕ Adicionar Novas Combinações
                            </button>
                            <p class="text-sm text-gray-600 mt-2">Adiciona as combinações que ainda não existem na lista abaixo.</p>
                        </div>

                        <!-- Lista de Variações -->
                        <div x-show="variations.length > 0" class="border-t border-amber-200 pt-8">
                            <h4 class="text-lg sm:text-xl font-bold text-amber-800 mb-6">📦 Variações Geradas</h4>
                            <div class="space-y-6">
                                <template x-for="(variation, index) in variations" :key="variation.id || 'new-' + index">
                                    <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2 border-amber-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                        <input type="hidden" :name="'variations[' + index + '][id]'" :value="variation.id">
                                        
                                        <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-4 gap-2">
                                            <div>
                                                <h5 class="font-semibold text-amber-800 text-base sm:text-lg" x-text="getVariationName(variation)"></h5>
                                                <p class="text-sm text-gray-600" x-text="getVariationDescription(variation)"></p>
                                            </div>
                                            <button type="button" 
                                                    @click="removeVariation(index)"
                                                    class="self-end sm:self-center text-red-500 hover:text-red-700 font-semibold text-sm">
                                                🗑️ Remover
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                            <!-- SKU -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">SKU</label>
                                                <input type="text" 
                                                       x-model="variation.sku"
                                                       :name="'variations[' + index + '][sku]'"
                                                       class="w-full px-3 py-2 text-sm sm:px-4 sm:py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                                       placeholder="SKU único">
                                            </div>

                                            <!-- Preço -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">Preço (R$)</label>
                                                <input type="number" 
                                                       x-model="variation.price"
                                                       :name="'variations[' + index + '][price]'"
                                                       step="0.01"
                                                       min="0"
                                                       class="w-full px-3 py-2 text-sm sm:px-4 sm:py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                                       placeholder="0,00">
                                            </div>

                                            <!-- Estoque -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">Estoque</label>
                                                <input type="number" 
                                                       x-model="variation.stock"
                                                       :name="'variations[' + index + '][stock]'"
                                                       min="0"
                                                       class="w-full px-3 py-2 text-sm sm:px-4 sm:py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                                       placeholder="0">
                                            </div>

                                            <!-- Imagem -->
                                            <div class="col-span-2 lg:col-span-1">
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">Imagem</label>
                                                <div class="flex items-center gap-4">
                                                <input type="file" 
                                                       :name="'variations[' + index + '][image]'"
                                                       accept="image/*"
                                                        class="w-full text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-colors duration-200">
                                                    
                                                    <template x-if="variation.image_url">
                                                        <img :src="variation.image_url" class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-lg shadow-md flex-shrink-0">
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Atributos da Variação -->
                                        <div class="mt-4">
                                            <label class="block text-sm font-semibold text-amber-800 mb-2">Atributos:</label>
                                            <div class="flex flex-wrap gap-2">
                                                <template x-for="(valueId, attrId) in variation.attribute_values" :key="attrId">
                                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-medium" 
                                                          x-text="getAttributeValueName(attrId, valueId)"></span>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Campos ocultos para os atributos -->
                                        <template x-for="(valueId, attrId) in variation.attribute_values" :key="'hidden-' + attrId">
                                            <input type="hidden" 
                                                   :name="'variations[' + index + '][attribute_values][' + attrId + ']'"
                                                   :value="valueId">
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="mt-8 sm:mt-12 pt-6 sm:pt-8 border-t-2 border-amber-200 flex justify-end">
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 sm:px-10 sm:py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-xl sm:rounded-2xl text-base sm:text-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        💾 Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function productVariationsManager(config) {
    return {
            allAttributes: config.attributes || [],
        selectedAttributes: [],
        selectedValues: {},
            variations: config.initialVariations || [],
        
        init() {
                // Pre-selecionar atributos e valores com base nas variações existentes
                this.variations.forEach(variation => {
                    Object.keys(variation.attribute_values).forEach(attrId => {
                        if (!this.selectedAttributes.includes(attrId)) {
                            this.selectedAttributes.push(attrId);
                        }
                        if (!this.selectedValues[attrId]) {
                            this.selectedValues[attrId] = [];
                        }
                        if (!this.selectedValues[attrId].includes(variation.attribute_values[attrId].toString())) {
                             this.selectedValues[attrId].push(variation.attribute_values[attrId].toString());
                        }
                    });
                });
        },

        get hasSelectedAttributes() {
            return this.selectedAttributes.length > 0;
        },

        generateVariations() {
                const selectedAttrs = this.selectedAttributes.map(id => this.allAttributes.find(a => a.id == id));
                if (selectedAttrs.length === 0) return;

                const valueSets = selectedAttrs.map(attr => {
                    return this.selectedValues[attr.id] || [];
                });

                if (valueSets.some(set => set.length === 0)) {
                    alert('Por favor, selecione pelo menos um valor para cada atributo escolhido para gerar novas combinações.');
                    return;
                }
            
                const combinations = this.getCombinations(valueSets);
            
                combinations.forEach(combo => {
                    let attribute_values = {};
                    combo.forEach((valueId, index) => {
                        const attrId = selectedAttrs[index].id;
                        attribute_values[attrId] = parseInt(valueId);
                    });
                    
                    const alreadyExists = this.variations.some(v => 
                        JSON.stringify(v.attribute_values) === JSON.stringify(attribute_values)
                    );

                    if (!alreadyExists) {
                this.variations.push({
                            id: null,
                    sku: '',
                    price: '',
                    stock: '',
                            image_url: null,
                            attribute_values: attribute_values
                });
                    }
            });
        },

            getCombinations(arrays) {
                if (arrays.length === 0) return [[]];
                let result = [];
                const recurse = (arr, i) => {
                    for (let j = 0, l = arrays[i].length; j < l; j++) {
                        let a = arr.slice(0);
                        a.push(arrays[i][j]);
                        if (i === arrays.length - 1) {
                            result.push(a);
                        } else {
                            recurse(a, i + 1);
                        }
                    }
                }
                recurse([], 0);
            return result;
        },

            removeVariation(index) {
                this.variations.splice(index, 1);
        },

        getAttributeValueName(attrId, valueId) {
                const attr = this.allAttributes.find(a => a.id == attrId);
                if (!attr) return '';
            const value = attr.values.find(v => v.id == valueId);
                return value ? value.value : '';
        },

            getVariationName(variation) {
                return Object.entries(variation.attribute_values)
                    .map(([attrId, valueId]) => this.getAttributeValueName(attrId, valueId))
                    .join(' / ');
            },
            
            getVariationDescription(variation) {
                 return Object.entries(variation.attribute_values)
                    .map(([attrId, valueId]) => {
                        const attr = this.allAttributes.find(a => a.id == attrId);
                        return `${attr ? attr.name : 'Atributo'}: ${this.getAttributeValueName(attrId, valueId)}`;
                    })
                    .join(', ');
        }
    }
}
</script>
@endpush
@endsection 