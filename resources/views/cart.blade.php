@extends('layouts.home')

@section('content')
<div class="min-h-screen bg-gray-100 egyptian-pattern py-12">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl border border-primary/20 overflow-hidden">
            <div class="bg-gradient-to-r from-gradient-start via-primary to-primary-light px-8 py-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <span class="mr-3 text-4xl">🛒</span> Seu Carrinho
                </h1>
                <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full text-white font-semibold hover:bg-opacity-30 transition-all duration-300">
                    <span class="mr-2">←</span> Continuar Comprando
                </a>
            </div>

            @if(count($cartItems) > 0)
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b-2 border-primary/30">
                            <tr>
                                <th class="py-4 px-4 text-secondary font-semibold text-lg">Produto</th>
                                <th class="py-4 px-4 text-secondary font-semibold text-lg">Preço</th>
                                <th class="py-4 px-4 text-secondary font-semibold text-lg">Quantidade</th>
                                <th class="py-4 px-4 text-secondary font-semibold text-lg">Subtotal</th>
                                <th class="py-4 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/20">
                            @foreach($cartItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-300">
                                <td class="py-4 px-4 flex items-center">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/60x60' }}" alt="{{ $item->product->name }}" class="w-16 h-16 rounded-xl object-cover mr-4 border border-primary/20">
                                    <div>
                                        <div class="font-bold text-lg text-secondary">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 40) }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-semibold text-primary text-lg">R$ {{ number_format($item->product->price, 2, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-3 py-2 border-2 border-primary/50 rounded-lg text-lg focus:border-primary focus:ring-primary/20 transition-all duration-300">
                                        <button type="submit" class="px-3 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition-all duration-300">Atualizar</button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 font-bold text-lg text-secondary">R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST">
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

                <!-- Resumo -->
                <div class="mt-10 flex flex-col md:flex-row md:justify-between md:items-center gap-8">
                    <div class="flex-1"></div>
                    <div class="bg-gray-50 border-2 border-dashed border-primary/40 rounded-2xl p-8 shadow-lg w-full md:w-96">
                        <h2 class="text-xl font-bold text-secondary mb-4 flex items-center"><span class="mr-2">📋</span> Resumo do Pedido</h2>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Subtotal</span>
                            <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-700">Frete</span>
                            <span class="font-semibold">R$ {{ number_format($shipping, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-lg font-bold text-secondary">Total</span>
                            <span class="text-lg font-bold text-primary">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="block w-full text-center px-6 py-4 bg-primary hover:bg-primary-dark rounded-full font-bold text-lg transition-all duration-300">Finalizar Compra</a>
                    </div>
                </div>
            </div>
            @else
            <div class="p-16 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-secondary mb-2">Seu carrinho está vazio</h2>
                <p class="text-secondary-light mb-6">Adicione produtos para começar sua jornada de hidratação personalizada!</p>
                <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-4 bg-primary hover:bg-primary-dark rounded-full font-semibold text-lg transition-all duration-300">
                    <span class="mr-2">✨</span> Ver Produtos
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 