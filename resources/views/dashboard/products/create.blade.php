@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-500 to-yellow-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">✨ Criar Novo Produto</h1>
                    <p class="text-amber-100 text-lg">Adicione um novo produto ao seu catálogo</p>
                </div>
                <a href="{{ route('dashboard.products.index') }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2">←</span>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-200">
                <h2 class="text-2xl font-bold text-amber-800">📝 Formulário do Produto</h2>
            </div>
            
            <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Nome do Produto -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-lg font-semibold text-amber-800 mb-3">
                            <span class="mr-2">🏷️</span>Nome do Produto
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-6 py-4 border-2 border-amber-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50"
                               placeholder="Digite o nome do produto">
                        @error('name')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-lg font-semibold text-amber-800 mb-3">
                            <span class="mr-2">📝</span>Descrição do Produto
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full px-6 py-4 border-2 border-amber-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50"
                                  placeholder="Descreva as características e benefícios do produto...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria -->
                    <div>
                        <label for="category_id" class="block text-lg font-semibold text-amber-800 mb-3">
                            <span class="mr-2">📂</span>Categoria
                        </label>
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-6 py-4 border-2 border-amber-200 rounded-2xl text-lg focus:border-amber-500 focus:ring-4 focus:ring-amber-100 transition-all duration-300 bg-gradient-to-r from-amber-50 to-orange-50">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <div class="mt-12" x-data="productVariationsManager({ attributes: {{ json_encode($attributes) }} })">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-200 rounded-t-2xl">
                        <h3 class="text-2xl font-bold text-amber-800 flex items-center">
                            <span class="mr-3">🎨</span>Variações do Produto
                        </h3>
                        <p class="text-amber-700 mt-2">Gerencie as diferentes versões do seu produto (cores, tamanhos, etc.)</p>
                    </div>

                    <div class="p-8">
                        <!-- Seleção de Atributos -->
                        <div class="mb-8">
                            <h4 class="text-lg font-semibold text-amber-800 mb-4">📋 Selecionar Atributos para Variações</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($attributes as $attribute)
                                <div class="bg-white rounded-xl p-6 border-2 border-amber-200 shadow-lg">
                                    <label class="flex items-center mb-4">
                                        <input type="checkbox" 
                                               x-model="selectedAttributes" 
                                               value="{{ $attribute->id }}"
                                               @change="generateVariations()"
                                               class="mr-3 w-5 h-5 text-amber-500 border-amber-300 rounded focus:ring-amber-500">
                                        <span class="font-semibold text-amber-800">{{ $attribute->name }}</span>
                                    </label>
                                    
                                    <div x-show="selectedAttributes.includes('{{ $attribute->id }}')" class="space-y-2">
                                        @foreach($attribute->values as $value)
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="selectedValues[{{ $attribute->id }}]" 
                                                   value="{{ $value->id }}"
                                                   @change="generateVariations()"
                                                   class="mr-2 w-4 h-4 text-amber-500 border-amber-300 rounded focus:ring-amber-500">
                                            <span class="text-sm text-gray-700">{{ $value->value }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Lista de Variações -->
                        <div x-show="variations.length > 0" class="border-t border-amber-200 pt-8">
                            <h4 class="text-xl font-bold text-amber-800 mb-6">📦 Variações Geradas</h4>
                            <div class="space-y-6">
                                <template x-for="(variation, index) in variations" :key="index">
                                    <div class="bg-white rounded-2xl p-6 border-2 border-amber-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h5 class="font-semibold text-amber-800 text-lg" x-text="getVariationName(variation)"></h5>
                                            </div>
                                            <button type="button" 
                                                    @click="removeVariation(index)"
                                                    class="text-red-500 hover:text-red-700 font-semibold">
                                                🗑️ Remover
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                            <!-- SKU -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">SKU</label>
                                                <input type="text" 
                                                       x-model="variation.sku"
                                                       :name="'variations[' + index + '][sku]'"
                                                       class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
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
                                                       class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                                       placeholder="0,00">
                                            </div>

                                            <!-- Estoque -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">Estoque</label>
                                                <input type="number" 
                                                       x-model="variation.stock"
                                                       :name="'variations[' + index + '][stock]'"
                                                       min="0"
                                                       class="w-full px-4 py-2 border-2 border-amber-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-100"
                                                       placeholder="0">
                                            </div>

                                            <!-- Imagem -->
                                            <div>
                                                <label class="block text-sm font-semibold text-amber-800 mb-2">Imagem</label>
                                                <input type="file" 
                                                       :name="'variations[' + index + '][image]'"
                                                       accept="image/*"
                                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 transition-colors duration-200">
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

                <div class="mt-12 pt-8 border-t-2 border-amber-200 flex justify-end">
                    <button type="submit" 
                            class="px-10 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold rounded-2xl text-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        💾 Criar Produto
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
            variations: [],

            init() {
                this.allAttributes.forEach(attr => {
                    this.selectedValues[attr.id] = [];
                });
            },

            generateVariations() {
                const selectedAttrs = this.selectedAttributes.map(id => this.allAttributes.find(a => a.id == id));
                if (selectedAttrs.length === 0) {
                    this.variations = [];
                    return;
                };

                const valueSets = selectedAttrs.map(attr => this.selectedValues[attr.id] || []);

                if (valueSets.some(set => set.length === 0)) {
                     this.variations = [];
                    return;
                }

                const combinations = this.getCombinations(valueSets);
                
                this.variations = combinations.map(combo => {
                    let attribute_values = {};
                    combo.forEach((valueId, index) => {
                        const attrId = selectedAttrs[index].id;
                        attribute_values[attrId] = parseInt(valueId);
                    });
                    
                    return {
                        sku: '',
                        price: '',
                        stock: '',
                        attribute_values: attribute_values
                    };
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
            }
        }
    }
</script>
@endpush
@endsection 