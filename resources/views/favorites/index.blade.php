@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 lg:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm sm:text-base" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-[#D4AF37] inline-flex items-center">
                        <i class="fas fa-home mr-2"></i> Início
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-1 sm:mx-2"></i>
                        <span class="text-[#D4AF37] font-medium">Meus Favoritos</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#D4AF37] to-[#B8941F] px-6 lg:px-8 py-6 lg:py-8">
                <h1 class="text-2xl lg:text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-heart text-white mr-3 lg:mr-4 text-2xl lg:text-3xl"></i> 
                    Meus Favoritos
                </h1>
            </div>

            <div class="p-6 lg:p-8">
                @if($favoriteProducts->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
                        @foreach($favoriteProducts as $favorite)
                            @php $product = $favorite->product; @endphp
                            @if($product)
                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group">
                                <div class="relative">
                                    <a href="{{ route('products.show', $product) }}" class="block">
                                        @if($product->variants && $product->variants->first() && $product->variants->first()->image_url)
                                            <img src="{{ $product->variants->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-48 lg:h-52 object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <img src="https://via.placeholder.com/400x300/f3f4f6/9ca3af?text=Produto" alt="{{ $product->name }}" class="w-full h-48 lg:h-52 object-cover group-hover:scale-105 transition-transform duration-300">
                                        @endif
                                    </a>
                                    
                                    <!-- Remove from favorites button -->
                                    <form action="{{ route('favorites.remove', $product) }}" method="POST" class="absolute top-3 right-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 lg:w-10 lg:h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all duration-200">
                                            <i class="fas fa-heart text-red-500 text-sm lg:text-base"></i>
                                        </button>
                                    </form>

                                    <!-- Quick add to cart button -->
                                    <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-[#D4AF37] hover:bg-[#B8941F] text-white py-2 px-4 rounded-lg font-semibold text-sm transition-all duration-300 flex items-center justify-center">
                                                <i class="fas fa-cart-plus mr-2"></i>
                                                Adicionar ao Carrinho
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="p-4">
                                    <a href="{{ route('products.show', $product) }}" class="block hover:text-[#D4AF37] transition-colors duration-200">
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 text-sm lg:text-base">{{ $product->name }}</h3>
                                    </a>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="text-lg font-bold text-[#D4AF37]">
                                            @if($product->variants && $product->variants->first())
                                                R$ {{ number_format($product->variants->first()->price, 2, ',', '.') }}
                                            @else
                                                R$ {{ number_format($product->price ?? 0, 2, ',', '.') }}
                                            @endif
                                        </div>
                                        
                                        <!-- Stock indicator -->
                                        <div class="text-xs text-gray-500">
                                            @if($product->variants && $product->variants->first())
                                                @if($product->variants->first()->stock > 0)
                                                    <span class="text-green-600 font-medium">Em estoque</span>
                                                @else
                                                    <span class="text-red-600 font-medium">Esgotado</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 lg:py-16">
                        <div class="text-6xl lg:text-8xl text-gray-300 mb-6">
                            <i class="fas fa-heart-broken"></i>
                        </div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-3">Sua lista de favoritos está vazia</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Explore nossos produtos e clique no ícone de coração para salvar seus itens preferidos!</p>
                        <a href="{{ url('/') }}" class="inline-flex items-center px-6 lg:px-8 py-3 lg:py-4 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-semibold text-base lg:text-lg transition-all duration-300">
                            <span class="mr-2">✨</span> Ver Produtos
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 