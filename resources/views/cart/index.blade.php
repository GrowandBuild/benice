@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 lg:py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 lg:px-8 py-6 lg:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
                    <span class="mr-3 text-3xl lg:text-4xl">🛒</span> Seu Carrinho
                </h1>
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 lg:px-6 py-2 lg:py-3 bg-gray-100 hover:bg-gray-200 rounded-full font-semibold transition-all duration-300 text-sm lg:text-base">
                    <span class="mr-2">←</span> Continuar Comprando
                </a>
            </div>

            @if($cartItems->isNotEmpty())
            @php
                $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                $shipping = $subtotal > 200 ? 0 : 25.00; // Frete grátis acima de R$200
                $total = $subtotal + $shipping;
            @endphp
            
            <div class="p-6 lg:p-8 pb-32 lg:pb-8">
                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b-2">
                            <tr>
                                <th class="py-4 px-4 font-semibold text-lg">Produto</th>
                                <th class="py-4 px-4 font-semibold text-lg">Preço</th>
                                <th class="py-4 px-4 font-semibold text-lg">Quantidade</th>
                                <th class="py-4 px-4 font-semibold text-lg">Subtotal</th>
                                <th class="py-4 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($cartItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-300">
                                <td class="py-4 px-4 flex items-center">
                                    @if($item->variant && $item->variant->image_url)
                                        <img src="{{ $item->variant->image_url }}" alt="{{ $item->variant->product->name ?? 'Produto' }}" class="w-16 h-16 rounded-xl object-cover mr-4 border">
                                    @else
                                        <img src="https://via.placeholder.com/60x60" alt="Produto" class="w-16 h-16 rounded-xl object-cover mr-4 border">
                                    @endif
                                    <div>
                                        <div class="font-bold text-lg">{{ $item->variant->product->name ?? 'Produto não encontrado' }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($item->variant && $item->variant->attributeValues)
                                                @foreach($item->variant->attributeValues as $value)
                                                    {{ $value->attribute->name }}: {{ $value->value }}@if(!$loop->last), @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-semibold text-lg">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->variant->stock ?? 999 }}" class="w-16 px-3 py-2 border-2 rounded-lg text-lg focus:border-gray-500 focus:ring-gray-200 transition-all duration-300">
                                        <button type="submit" class="px-3 py-2 bg-gray-800 hover:bg-black text-white rounded-lg font-semibold transition-all duration-300">Atualizar</button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 font-bold text-lg">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-semibold">Remover</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="lg:hidden space-y-4">
                    @foreach($cartItems as $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex items-start space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                @if($item->variant && $item->variant->image_url)
                                    <img src="{{ $item->variant->image_url }}" alt="{{ $item->variant->product->name ?? 'Produto' }}" class="w-20 h-20 rounded-lg object-cover">
                                @else
                                    <img src="https://via.placeholder.com/80x80" alt="Produto" class="w-20 h-20 rounded-lg object-cover">
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 text-base mb-1">{{ $item->variant->product->name ?? 'Produto não encontrado' }}</h3>
                                <div class="text-sm text-gray-500 mb-2">
                                    @if($item->variant && $item->variant->attributeValues)
                                        @foreach($item->variant->attributeValues as $value)
                                            {{ $value->attribute->name }}: {{ $value->value }}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                </div>
                                
                                <!-- Price and Quantity Controls -->
                                <div class="flex items-center justify-between">
                                    <div class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($item->price, 2, ',', '.') }}</div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button type="button" onclick="updateQuantity(this, -1)" class="px-2 py-1 text-gray-600 hover:bg-gray-200 rounded-l-lg transition-colors duration-200">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->variant->stock ?? 999 }}" class="w-12 text-center border-l border-r border-gray-300 focus:ring-0 focus:border-gray-300 text-sm">
                                                <button type="button" onclick="updateQuantity(this, 1)" class="px-2 py-1 text-gray-600 hover:bg-gray-200 rounded-r-lg transition-colors duration-200">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </div>
                                            <button type="submit" class="px-3 py-1 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-lg font-medium text-sm transition-all duration-300">✓</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Subtotal and Remove -->
                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                    <div class="text-sm text-gray-600">
                                        Subtotal: <span class="font-semibold">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
                                    </div>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center">
                                            <i class="fas fa-trash mr-1"></i> Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Desktop Order Summary -->
                <div class="hidden lg:block mt-10 flex flex-col md:flex-row md:justify-between md:items-start gap-8">
                    <div class="flex-1"></div>
                    <div class="bg-gray-50 border-2 border-dashed rounded-2xl p-8 shadow-lg w-full md:w-96">
                        <h2 class="text-xl font-bold mb-4 flex items-center"><span class="mr-2">📋</span> Resumo do Pedido</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frete</span>
                                <span class="font-semibold">
                                    @if($shipping == 0)
                                        <span class="text-green-600">Grátis</span>
                                    @else
                                        R$ {{ number_format($shipping, 2, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            <div class="border-t pt-3 flex justify-between">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center px-6 py-4 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-bold text-lg transition-all duration-300 mt-6">
                            Finalizar Compra
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="p-8 lg:p-16 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold mb-2">Seu carrinho está vazio</h2>
                <p class="mb-6 text-gray-600">Adicione produtos para começar sua jornada de hidratação personalizada!</p>
                <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-4 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-semibold text-lg transition-all duration-300">
                    <span class="mr-2">✨</span> Ver Produtos
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Mobile Sticky Order Summary -->
    @if($cartItems->isNotEmpty())
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="px-4 py-4">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm text-gray-600">
                    <span class="font-semibold">{{ $cartItems->count() }}</span> item{{ $cartItems->count() > 1 ? 's' : '' }}
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Total</div>
                    <div class="text-lg font-bold text-[#D4AF37]">R$ {{ number_format($total, 2, ',', '.') }}</div>
                </div>
            </div>
            <a href="{{ route('checkout.index') }}" class="block w-full text-center px-6 py-3 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-bold text-lg transition-all duration-300">
                Finalizar Compra
            </a>
        </div>
    </div>
    @endif
</div>

<script>
function updateQuantity(button, change) {
    const input = button.parentElement.querySelector('input');
    const currentValue = parseInt(input.value);
    const maxValue = parseInt(input.max);
    const minValue = parseInt(input.min);
    
    let newValue = currentValue + change;
    if (newValue >= minValue && newValue <= maxValue) {
        input.value = newValue;
    }
}
</script>
@endsection 