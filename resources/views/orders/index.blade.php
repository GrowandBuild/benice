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
                        <span class="text-[#D4AF37] font-medium">Meus Pedidos</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#D4AF37] to-[#B8941F] px-6 lg:px-8 py-6 lg:py-8">
                <h1 class="text-2xl lg:text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-shopping-bag text-white mr-3 lg:mr-4 text-2xl lg:text-3xl"></i> 
                    Meus Pedidos
                </h1>
            </div>

            <div class="p-6 lg:p-8">
                @if($orders->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($orders as $order)
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                            <!-- Order Header -->
                            <div class="bg-gray-50 px-4 lg:px-6 py-4 border-b border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-sm text-gray-600">
                                            <span class="font-semibold">Pedido #{{ $order->id }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            @switch($order->status)
                                                @case('pending')
                                                    Pendente
                                                    @break
                                                @case('processing')
                                                    Processando
                                                    @break
                                                @case('completed')
                                                    Concluído
                                                    @break
                                                @case('cancelled')
                                                    Cancelado
                                                    @break
                                                @default
                                                    {{ ucfirst($order->status) }}
                                            @endswitch
                                        </span>
                                        <span class="text-lg font-bold text-[#D4AF37]">
                                            R$ {{ number_format($order->total, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="p-4 lg:p-6">
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($item->product && $item->product->variants && $item->product->variants->first() && $item->product->variants->first()->image_url)
                                                <img src="{{ $item->product->variants->first()->image_url }}" alt="{{ $item->product->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <img src="https://via.placeholder.com/64x64/f3f4f6/9ca3af?text=P" alt="Produto" class="w-16 h-16 rounded-lg object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 text-sm lg:text-base">
                                                {{ $item->product->name ?? 'Produto não encontrado' }}
                                            </h3>
                                            <div class="text-sm text-gray-500">
                                                Quantidade: {{ $item->quantity }}
                                            </div>
                                            @if($item->variant && $item->variant->attributeValues)
                                                <div class="text-xs text-gray-400 mt-1">
                                                    @foreach($item->variant->attributeValues as $value)
                                                        {{ $value->attribute->name }}: {{ $value->value }}@if(!$loop->last), @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-[#D4AF37]">
                                                R$ {{ number_format($item->price, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Order Actions -->
                                <div class="mt-6 pt-4 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="text-sm text-gray-600">
                                        <span class="font-semibold">{{ $order->items->count() }}</span> item{{ $order->items->count() > 1 ? 's' : '' }}
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-lg font-semibold text-sm transition-all duration-300">
                                            <i class="fas fa-eye mr-2"></i>
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12 lg:py-16">
                        <div class="text-6xl lg:text-8xl text-gray-300 mb-6">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h2 class="text-xl lg:text-2xl font-bold text-gray-800 mb-3">Você ainda não fez nenhum pedido</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Explore nossos produtos e faça sua primeira compra!</p>
                        <a href="{{ url('/') }}" class="inline-flex items-center px-6 lg:px-8 py-3 lg:py-4 bg-[#D4AF37] hover:bg-[#B8941F] text-white rounded-full font-semibold text-base lg:text-lg transition-all duration-300">
                            <span class="mr-2">✨</span> Ver Produtos
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 