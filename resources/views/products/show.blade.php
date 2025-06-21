@extends('layouts.home')

@section('content')
<main class="bg-gray-50 min-h-screen">
    <div x-data="productVariantSelector()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm sm:text-base" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="text-gray-700 hover:text-[#D4AF37] inline-flex items-center">
                            <i class="fas fa-home mr-2"></i> Início
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                            <a href="#" class="text-gray-700 hover:text-[#D4AF37]">Produtos</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                            <span class="text-[#D4AF37] font-medium truncate max-w-[150px] sm:max-w-none">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Product Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-x-12">
                <!-- Product Image -->
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                        <img :src="selectedVariant.image_url" alt="{{ $product->name }}" class="w-full h-80 md:h-[500px] object-cover transition-all duration-300" id="main-image">
                    </div>
                    
                    <!-- Thumbnails - Mobile: horizontal scroll, Desktop: grid -->
                    <div class="lg:grid lg:grid-cols-5 lg:gap-3">
                        <div class="flex space-x-2 lg:space-x-0 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0">
                         <template x-for="variant in variants" :key="variant.id">
                            <img :src="variant.image_url" 
                                 alt="{{ $product->name }}" 
                                     class="w-16 h-16 lg:w-20 lg:h-20 flex-shrink-0 object-cover rounded-lg cursor-pointer border-2 hover:border-[#D4AF37] transition-all duration-300"
                                     :class="{ 'border-[#D4AF37] shadow-md': selectedVariant.id === variant.id, 'border-gray-200': selectedVariant.id !== variant.id }"
                                 @click="changeVariantById(variant.id)">
                        </template>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="space-y-6 pb-20 lg:pb-0">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h1>
                        <p class="text-gray-600 mb-4 text-sm md:text-base leading-relaxed">{{ $product->description }}</p>
                        
                        <div class="mb-6">
                            <span class="price text-3xl md:text-4xl font-bold text-[#D4AF37]" x-text="formatPrice(selectedVariant.price)"></span>
                        </div>
                    </div>

                    <!-- Attribute Selectors -->
                    <div class="space-y-5">
                        <template x-for="(attribute, attrIndex) in attributes" :key="attribute.id">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-800 mb-3" x-text="attribute.name + ':'"></h3>
                                <div class="flex items-center space-x-3 flex-wrap">
                                    <template x-for="value in attribute.values" :key="value.id">
                                        <div>
                                            <!-- Color Swatch Button -->
                                            <template x-if="attribute.name.toLowerCase() === 'cor'">
                                                <button
                                                    @click="selectOption(attribute.id, value.id)"
                                                    :disabled="!isOptionAvailable(attribute.id, value.id)"
                                                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg p-0.5 transition-all duration-200"
                                                    :class="{
                                                        'border-2 border-[#D4AF37] scale-110 shadow-lg': selectedOptions[attribute.id] == value.id,
                                                        'border border-gray-300 hover:scale-105 hover:shadow-md': selectedOptions[attribute.id] != value.id,
                                                        'opacity-50 cursor-not-allowed': !isOptionAvailable(attribute.id, value.id)
                                                    }">
                                                    <span class="w-full h-full rounded-md inline-block" :style="{ backgroundColor: colorMap[value.name.toLowerCase()] || value.name }"></span>
                                                </button>
                                            </template>
                                
                                            <!-- Text-based Button -->
                                            <template x-if="attribute.name.toLowerCase() !== 'cor'">
                                        <button
                                            @click="selectOption(attribute.id, value.id)"
                                                    :disabled="!isOptionAvailable(attribute.id, value.id)"
                                                    class="min-w-[44px] h-11 sm:min-w-[48px] sm:h-12 px-3 sm:px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200"
                                            :class="{
                                                        'border-[#D4AF37] bg-[#D4AF37] text-white scale-105 shadow-lg': selectedOptions[attribute.id] == value.id,
                                                        'border-gray-300 bg-white hover:border-[#D4AF37] hover:bg-gray-50': selectedOptions[attribute.id] != value.id,
                                                'opacity-50 cursor-not-allowed': !isOptionAvailable(attribute.id, value.id)
                                                    }">
                                            <span x-text="value.name"></span>
                                        </button>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Stock Info -->
                     <div class="text-sm">
                        <template x-if="selectedVariant.stock > 0 && selectedVariant.stock <= 10">
                            <p class="text-yellow-600 font-semibold flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Restam apenas <span x-text="selectedVariant.stock"></span> unidades!
                            </p>
                        </template>
                        <template x-if="selectedVariant.stock > 10">
                            <p class="text-green-600 font-semibold flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Em estoque
                            </p>
                        </template>
                        <template x-if="selectedVariant.stock <= 0">
                            <p class="text-red-600 font-semibold flex items-center">
                                <i class="fas fa-times-circle mr-2"></i>
                                Esgotado
                            </p>
                        </template>
                    </div>

                    <!-- Actions - Hidden on mobile (will be in sticky bar) -->
                    <div class="hidden lg:block">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="variant_id" :value="selectedVariant.id">
                            
                            <div class="flex items-center gap-4">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium text-gray-700">Qtd:</label>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" @click="quantity > 1 ? quantity-- : 1" class="px-3 py-2 text-gray-600 hover:bg-gray-200 rounded-l-lg transition-colors duration-200">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" name="quantity" x-model="quantity" min="1" :max="selectedVariant.stock" class="w-12 text-center border-l border-r border-gray-300 focus:ring-0 focus:border-gray-300">
                                        <button type="button" @click="quantity < selectedVariant.stock ? quantity++ : selectedVariant.stock" class="px-3 py-2 text-gray-600 hover:bg-gray-200 rounded-r-lg transition-colors duration-200">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" 
                                        class="flex-grow btn-primary flex items-center justify-center text-base py-3 px-6"
                                        :disabled="selectedVariant.stock <= 0 || !selectedVariant.id">
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    <span x-show="selectedVariant.stock > 0">Adicionar ao Carrinho</span>
                                    <span x-show="selectedVariant.stock <= 0">Esgotado</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Action Bar - Mobile Only -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
            <div class="px-4 py-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                    <input type="hidden" name="variant_id" :value="selectedVariant.id">
                    
                    <div class="flex items-center gap-3">
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Qtd:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" @click="quantity > 1 ? quantity-- : 1" class="px-3 py-2 text-gray-600 hover:bg-gray-200 rounded-l-lg transition-colors duration-200">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="quantity" x-model="quantity" min="1" :max="selectedVariant.stock" class="w-12 text-center border-l border-r border-gray-300 focus:ring-0 focus:border-gray-300">
                                <button type="button" @click="quantity < selectedVariant.stock ? quantity++ : selectedVariant.stock" class="px-3 py-2 text-gray-600 hover:bg-gray-200 rounded-r-lg transition-colors duration-200">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                            <button type="submit" 
                                class="flex-grow btn-primary flex items-center justify-center text-base py-3 px-4"
                                    :disabled="selectedVariant.stock <= 0 || !selectedVariant.id">
                                <i class="fas fa-cart-plus mr-2"></i>
                                <span x-show="selectedVariant.stock > 0">Adicionar ao Carrinho</span>
                                <span x-show="selectedVariant.stock <= 0">Esgotado</span>
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function productVariantSelector() {
        return {
            variants: @json($variants),
            attributes: @json($attributes),
            colorMap: @json($colorMap ?? []),
            selectedOptions: {},
            selectedVariant: {},
            quantity: 1,

            init() {
                if (this.variants.length > 0) {
                    // Try to find a variant that is in stock
                    let firstAvailableVariant = this.variants.find(v => v.stock > 0);
                    if (!firstAvailableVariant) {
                        firstAvailableVariant = this.variants[0];
                    }
                    this.selectedVariant = firstAvailableVariant;
                    this.selectedOptions = { ...firstAvailableVariant.options };
                    }
                this.quantity = 1;
            },

            selectOption(attributeId, valueId) {
                const newOptions = { ...this.selectedOptions, [attributeId]: valueId };
                this.selectedOptions = newOptions;
                this.updateSelectedVariant(attributeId);
            },

            updateSelectedVariant(lastChangedAttrId = null) {
                // 1. Try for a perfect match
                let perfectMatch = this.variants.find(variant =>
                    Object.keys(this.selectedOptions).every(attrId =>
                        variant.options[attrId] === this.selectedOptions[attrId]
                    )
                );
                
                if (perfectMatch) {
                    this.selectedVariant = perfectMatch;
                    if (this.quantity > this.selectedVariant.stock) {
                        this.quantity = this.selectedVariant.stock > 0 ? this.selectedVariant.stock : 1;
                    }
                    if (this.selectedVariant.stock === 0) {
                        this.quantity = 1;
                    }
                    return;
                }

                // 2. If no perfect match, find a fallback based on the last clicked attribute
                if (lastChangedAttrId) {
                    const lastChangedValueId = this.selectedOptions[lastChangedAttrId];
                    let bestFallback = this.variants.find(v => v.options[lastChangedAttrId] === lastChangedValueId && v.stock > 0);
                    // If no in-stock fallback, just find any
                    if (!bestFallback) {
                        bestFallback = this.variants.find(v => v.options[lastChangedAttrId] === lastChangedValueId);
                    }

                    if (bestFallback) {
                        this.selectedVariant = bestFallback;
                        this.selectedOptions = { ...bestFallback.options };
                        this.quantity = this.selectedVariant.stock > 0 ? 1 : 0;
                        return;
                    }
                }
                
                // 3. Absolute fallback to the very first variant
                this.selectedVariant = this.variants[0] || {};
                if(this.selectedVariant.options) {
                    this.selectedOptions = { ...this.selectedVariant.options };
                }
                this.quantity = this.selectedVariant.stock > 0 ? 1 : 0;
            },
            
            isOptionAvailable(attributeIdToTest, valueIdToTest) {
                // An option is available if at least one variant exists with that option.
                // This is a simpler check to avoid disabling too aggressively.
                return this.variants.some(variant => variant.options[attributeIdToTest] === valueIdToTest);
            },

            changeVariantById(variantId) {
                let foundVariant = this.variants.find(v => v.id === variantId);
                if (foundVariant) {
                    this.selectedVariant = foundVariant;
                    this.selectedOptions = { ...foundVariant.options };
                    this.quantity = this.selectedVariant.stock > 0 ? 1 : 0;
                }
            },

            formatPrice(price) {
                if (price === undefined || price === null) return 'R$ --,--';
                return `R$ ${parseFloat(price).toFixed(2).replace('.', ',')}`;
            }
        }
    }
</script>
@endpush