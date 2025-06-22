@extends('layouts.home')

@section('content')
<div class="bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gray-900 flex items-center min-h-[70vh] md:min-h-screen">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('deusabanner.png') }}" alt="Deusa" class="w-full h-full object-cover opacity-50 md:opacity-60">
        </div>
        <div class="absolute inset-0 bg-black/30 md:bg-black/40 z-10"></div>
        <div class="relative z-20 text-center text-white max-w-4xl mx-auto p-4 md:p-8">
            <h1 class="text-5xl sm:text-6xl lg:text-8xl font-extrabold tracking-tighter leading-tight mb-6" style="font-family: 'Trajan Pro', serif; text-shadow: 3px 3px 12px rgba(0,0,0,0.7);">
                <span class="egyptian-gold-shine bg-clip-text text-transparent">BE NICE</span>
            </h1>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-light mb-8 text-amber-100 tracking-widest" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">
                HYDRATE
            </h2>
            <div class="mt-8 md:mt-12">
                <a href="#products" class="btn-primary text-lg md:text-xl px-10 py-4 md:px-12 md:py-5 shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                    Explore Nossas Garrafas
                </a>
            </div>
        </div>
    </div>

    <!-- Brand Description Section -->
    <div class="bg-gradient-to-br from-amber-50 to-orange-50 py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-lg md:text-xl lg:text-2xl text-gray-700 leading-relaxed font-medium">
                Sua dose diária de inspiração e hidratação, com um toque de personalidade gravado a laser.
            </p>
        </div>
    </div>

    <!-- Category Quick-Nav -->
    @if($categories->isNotEmpty())
    <div class="bg-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 md:gap-6 text-center">
                @php
                    $icons = ['fa-wine-bottle', 'fa-heartbeat', 'fa-gift', 'fa-headset'];
                @endphp
                @foreach($categories as $index => $category)
                <a href="#" class="group">
                    <div class="flex flex-col items-center p-4 md:p-6 rounded-xl hover:bg-amber-50 transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-amber-100 to-orange-200 rounded-full mb-3 group-hover:scale-110 transition-transform duration-300">
                           <i class="fas {{ $icons[$index % count($icons)] }} text-2xl md:text-3xl text-amber-700"></i>
                        </div>
                        <h3 class="font-semibold text-sm md:text-base text-gray-700 group-hover:text-amber-800">{{ $category->name }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    <div id="products" class="py-12 md:py-20 egyptian-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-12">
                <h2 class="text-2xl md:text-4xl font-bold text-[#8B4513]">Nossos Produtos</h2>
                <p class="mt-2 text-md md:text-lg text-[#A0522D]">Descubra a combinação perfeita de estilo e funcionalidade.</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($products as $product)
                @php
                    $firstVariant = $product->variants->first();
                    $totalStock = $product->variants->sum('stock');
                @endphp
                <a href="{{ route('products.show', $product) }}" class="product-card bg-white rounded-lg shadow-md overflow-hidden border border-amber-100/50 flex flex-col group">
                    <div class="relative overflow-hidden">
                        @if($firstVariant && $firstVariant->image_url)
                            <img src="{{ $firstVariant->image_url }}" alt="{{ $product->name }}" class="w-full h-48 sm:h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 sm:h-64 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-camera text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        @if($totalStock <= 0)
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                <span class="text-white font-bold text-sm tracking-widest">ESGOTADO</span>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="w-8 h-8 bg-white/80 rounded-full flex items-center justify-center shadow-md hover:bg-white hover:scale-110 transition-transform duration-200">
                                <i class="far fa-heart text-gray-700"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <h4 class="font-semibold text-sm sm:text-base mb-2 text-[#8B4513] truncate group-hover:text-amber-600" title="{{ $product->name }}">{{ $product->name }}</h4>
                        <div class="mt-auto pt-2">
                            @if($firstVariant)
                                <span class="price text-lg sm:text-xl">R$ {{ number_format($firstVariant->price, 2, ',', '.') }}</span>
                            @else
                                <span class="text-gray-500 text-sm">Ver opções</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- How it works -->
    <div class="py-12 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 md:mb-12">
                <h2 class="text-2xl md:text-4xl font-bold text-[#8B4513]">Como Funciona</h2>
                <p class="mt-2 text-md md:text-lg text-[#A0522D]">Personalize sua garrafa em 3 passos simples.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 text-center space-y-10 md:space-y-0">
                <div class="flex flex-col items-center">
                    <div class="egyptian-gold text-white w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg transform hover:scale-110 transition-transform duration-300">1</div>
                    <h3 class="text-lg sm:text-xl font-semibold text-[#8B4513] mb-2">Escolha seu Modelo</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Navegue por nossa coleção e encontre a garrafa que mais combina com você.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="egyptian-gold text-white w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg transform hover:scale-110 transition-transform duration-300">2</div>
                    <h3 class="text-lg sm:text-xl font-semibold text-[#8B4513] mb-2">Personalize com Laser</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Adicione seu nome, uma frase ou um ícone. A gravação a laser garante um acabamento perfeito e duradouro.</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="egyptian-gold text-white w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center text-3xl font-bold mb-4 shadow-lg transform hover:scale-110 transition-transform duration-300">3</div>
                    <h3 class="text-lg sm:text-xl font-semibold text-[#8B4513] mb-2">Receba em Casa</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Finalize seu pedido e aguarde sua BE NICE exclusiva chegar no conforto da sua casa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 