@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-500 to-yellow-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">✨ Gestão de Produtos</h1>
                    <p class="text-amber-100 text-lg">Gerencie seus produtos com elegância</p>
                </div>
                <a href="{{ route('dashboard.products.create') }}" 
                   class="group relative inline-flex items-center px-8 py-4 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white font-semibold text-lg transition-all duration-300 hover:bg-opacity-30 hover:scale-105 hover:shadow-xl">
                    <span class="mr-2 text-2xl">✨</span>
                    Novo Produto
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-yellow-400 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        @if(session('success'))
            <div class="mb-8 p-6 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl shadow-lg text-white text-center">
                <div class="flex items-center justify-center">
                    <span class="text-3xl mr-3">🎉</span>
                    <span class="text-xl font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Total de Produtos</p>
                        <p class="text-3xl font-bold">{{ $products->total() }}</p>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Em Estoque</p>
                        <p class="text-3xl font-bold">{{ $products->where('stock', '>', 0)->count() }}</p>
                    </div>
                    <div class="text-4xl">✅</div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-purple-400 to-pink-500 rounded-2xl p-6 text-white shadow-lg transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Categorias</p>
                        <p class="text-3xl font-bold">{{ \App\Models\Category::count() }}</p>
                    </div>
                    <div class="text-4xl">🏷️</div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-amber-100">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-b border-amber-200">
                <h2 class="text-2xl font-bold text-amber-800">📋 Lista de Produtos</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-amber-100 to-orange-100">
                        <tr>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">ID</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Produto</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Categoria</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Preço</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Estoque</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Status</th>
                            <th class="px-8 py-4 text-left text-amber-800 font-semibold text-lg">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100">
                        @foreach($products as $product)
                        <tr class="hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-all duration-300 group">
                            <td class="px-8 py-6">
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm font-medium">#{{ $product->id }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    @if($product->featuredImage)
                                        <img src="{{ $product->featuredImage->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-xl border-2 border-amber-200 mr-4">
                                    @elseif($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-xl border-2 border-amber-200 mr-4">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-lg mr-4">
                                            {{ strtoupper(substr($product->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 text-lg">{{ $product->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($product->category)
                                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                                        🏷️ {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm">Sem categoria</span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-right">
                                    <p class="font-bold text-2xl text-green-600">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                                    @if($product->original_price && $product->original_price > $product->price)
                                        <p class="text-gray-400 text-sm line-through">R$ {{ number_format($product->original_price, 2, ',', '.') }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @if($product->stock > 10)
                                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                                        ✅ {{ $product->stock }} unidades
                                    </span>
                                @elseif($product->stock > 0)
                                    <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                                        ⚠️ {{ $product->stock }} unidades
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-medium">
                                        ❌ Esgotado
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                @if($product->stock > 0)
                                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                                        🟢 Disponível
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-medium">
                                        🔴 Indisponível
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('dashboard.products.edit', $product) }}" 
                                       class="group relative inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                                        <span class="mr-2">✏️</span>
                                        Editar
                                    </a>
                                    <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="group relative inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg"
                                                onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                            <span class="mr-2">🗑️</span>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6 border-t border-amber-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom pagination styles */
    .pagination {
        @apply flex justify-center space-x-2;
    }
    
    .pagination > * {
        @apply px-4 py-2 rounded-lg font-medium transition-all duration-300;
    }
    
    .pagination .page-link {
        @apply bg-white text-amber-700 border border-amber-200 hover:bg-amber-50 hover:border-amber-300;
    }
    
    .pagination .page-item.active .page-link {
        @apply bg-gradient-to-r from-amber-500 to-orange-500 text-white border-amber-500;
    }
    
    .pagination .page-item.disabled .page-link {
        @apply bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed;
    }
</style>
@endsection 